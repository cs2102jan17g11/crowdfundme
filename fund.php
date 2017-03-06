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
    while($row = pg_fetch_row($projectRewards)) { ?>
    <form role="form" method="post" action="fund.php?project=<?php echo $project[0] ?>" autocomplete="off">
        <input type="hidden" name="reward_id" value="<?php echo $row[0]?>">
    <div class="panel panel-default" style="max-height: 100%" >
        <div class="panel-body" >
                <?php if($row[1] != "Make a pledge without a reward") { ?>
                    <h3><b>$ <?php echo $row[2]?></b></h3>
                    <input type="hidden" name="pledge" value="<?php echo $row[2]?>">
                    <input type="hidden" name="reward_type" value="reward">
                <?php } else { ?>
                    <input type="hidden" name="reward_type" value="noreward">
                <?php } ?>
                <h3><?php echo $row[1]?></h3>
                <?php echo $row[3]?> <br>
                <?php if($row[4] != "0") { ?>
                    Only <?php echo $row[4]?> left<br>
                <?php if($row[1] == "Make a pledge without a reward") { ?>
                        <br>
                        <div class="form-group">
                            <div class="col-xs-2">
                                <input type="text" name="pledge" id="pledge"  class="form-control" placeholder="pledge amount">
                            </div>
                        </div>
                        <br>
                        <br><input type="submit" name="submit" value="Make Pledge" class="btn btn-primary">
                    <?php }  else { ?>
                    <br><input type="submit" name="submit" value="Select Reward and Pledge" class="btn btn-primary">
                    <?php } ?>
                <?php } else {?>
                    <br><span class="label label-default">Reward no longer available</span>
                <?php } ?>
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