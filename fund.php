<html>
<head>
    <?php
    include_once("env.php");
    include_once("headers.php");

    $dbconn = pg_connect(pg_connect_string)
    or die('Could not connect: ' . pg_last_error());
    include_once("sqls.php");
    ?>
    <title>Funding</title>
</head>

<body>

<?php
include_once("navbar.php");
navbar(URL_PROJECTS_VIEW);
$project = getProject($_GET['project']);
$projectRewards = getProjectRewards($_GET['project']);

if(isset($_POST['submit'])) {
    $pledge = pg_escape_string($_POST['pledge']);

    if((pg_escape_string($_POST['reward_type'])) == "noreward") {
        if($pledge == "") {
            $error[] = 'Please enter a pledge amount.';
        }
    }

    date_default_timezone_set('Asia/Singapore');
    $time = date("Y-m-d H:i:s");

    if (!isset($error)) {
        selectReward($project[0], $time, $pledge, $_SESSION['userEmail'], pg_escape_string($_POST['reward_id']));
        header("location: projectdetails.php?project=" . $project[0]);
    }
}
?>

<div class="container">

    <div class="box-padding">
        <h1><?php echo $project[1]?></h1>
        <h4><i>by <a><?php echo $project[2] ?></a></i></h4>
    </div>

    <br />
    <h3>Fund This Project</h3>

    <?php
    if(isset($error)){
        foreach($error as $error){?>
            <div class="alert alert-danger">
            <strong>Unable to fund project due to the follow reason(s):</strong>
            <?php
            echo '<p class="bg-danger">'.$error.'</p>';
        }?>
        </div>
        <?php
    } ?>

    <?php
    while($row = pg_fetch_row($projectRewards)) { 
        $rewards_title = $row[1];
        $rewards_pledge_amount = $row[2];
        $rewards_description = $row[3];
        $rewards_quantity = $row[4];
    ?>
    <form role="form" method="post" action="fund.php?project=<?php echo $project[0] ?>" autocomplete="off">
        <input type="hidden" name="reward_id" value="<?php echo $row[0]?>">
    <div class="panel panel-default" style="max-height: 100%" >
        <div class="panel-body">
            <div class="content-padding">
                <h2><?php echo $rewards_title; ?></h2>
                <?php if($rewards_pledge_amount > 0) { ?>
                    <h3><b>$ <?php echo $rewards_pledge_amount; ?></b></h3>
                    <input type="hidden" name="pledge"
                        value="<?php echo $rewards_pledge_amount; ?>">
                    <input type="hidden" name="reward_type" value="reward">
                <?php } else { ?>
                    <input type="hidden" name="reward_type" value="noreward">
                <?php } ?>
                
                <?php echo $rewards_description; ?>

                <br>
                
                
                <?php if($rewards_pledge_amount ==  0) { ?> 
                    <!-- Case for 0 dollar pledges -->
                    <br>
                    <div style="width:20%">
                        <input type="number" name="pledge" id="pledge"  class="form-control" min="1" placeholder="Pledge amount">
                    </div>
                    <br>
                    <input type="submit" name="submit" value="Make Pledge" class="btn btn-primary">
                <?php } else { ?> 
                    <!-- Case for > 0 dollar pledges -->
                    <?php if($rewards_quantity != 0) { ?>
                        <!-- Case where there still more quantity left -->
                        Only <?php echo $rewards_quantity; ?> left
                        <br>
                        <br>
                        <input type="submit" name="submit" value="Select Reward and Pledge" class="btn btn-primary">
                    <?php } else {?>
                        <!-- Case where there still no more left -->
                        <span class="label label-default">Reward no longer available</span>
                    <?php } ?>
                <?php } ?>
                <br />
                <br />
            </div>
        </div>
    </div>
    </form>
    <?php }
    ?>

</div>

<?php
include("footer.php");
pg_close($dbconn);
?>
</body>
</html>