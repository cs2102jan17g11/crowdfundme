<html>
<head>
    <?php
    include_once("env.php");
    include_once("headers.php");

    $dbconn = pg_connect(pg_connect_string)
    or die('Could not connect: ' . pg_last_error());
    include_once("sqls.php");
    ?>

    <title>Create Rewards</title>
</head>

<body>
<?php
    include_once("navbar.php");
    navbar(URL_INDEX);
    $project_id = $_GET['project'];
    $project = getProject($project_id);
    $project_title = $project[1];

    if(isset($_POST['submit'])) {
        $title = pg_escape_string($_POST['title']);
        $descrip = pg_escape_string($_POST['description']);
        $quantity = pg_escape_string($_POST['quantity']);
        $pledge = pg_escape_string($_POST['pledge']);
        $isPledgeWithoutRewards = isset($_POST['isPledgeWithoutRewards']);

        createReward($project_id, $title, $descrip, $pledge, $quantity, $isPledgeWithoutRewards);

        header("location: edit-project.php?project=" . $project_id);
    }
?>

<div class="container">
    <div class="row">
    <h2>
        Rewards Creation
    </h2>

    <form method="post" action="">
        <div class="form-group">
            <label>Project</label>
            <input class="form-control" type="text" value="<?php echo $project_title; ?>" disabled/>
        </div>
        <div class="form-group">
          <label>Title for your reward</label>
          <input type="text" class="form-control" placeholder="Majestic funder of the greatest honor" name="title" required value=<?php if(isset($_POST['title'])) echo $_POST['title']; ?>>
        </div>

        <div class="form-group">
            <label>Description for your reward</label>
            <input class="form-control" type="text" placeholder="Your choice of lovable colors" name="description" required value=<?php if(isset($_POST['description'])) echo $_POST['description']; ?>>
        </div>
        
        <div class="checkbox">
            <label><input onclick="hideRewardsGroup(this)" type="checkbox" name="isPledgeWithoutRewards" value="">Allow pledging without rewards</label>
        </div>
        <script>
            // called by checkbox for pledging
            function hideRewardsGroup(chckbx) {
                allowRewardsElements = document.getElementById("allow_rewards");
                inputElements = allowRewardsElements.getElementsByTagName("input");
                if(chckbx.checked == true) {
                    allowRewardsElements.setAttribute('hidden', true);
                    for(i = 0; i < inputElements.length; i++) {
                        inputElements[i].removeAttribute('required');
                    }
                } else {
                    allowRewardsElements.removeAttribute('hidden');
                    for(i = 0; i < inputElements.length; i++) {
                        inputElements[i].setAttribute('required', true);
                    }
                }
            }
        </script>
        <div class="form-group row" id="allow_rewards">
            <div class="col-md-3">
                <label>Pledge amount</label>
                <input class="form-control" type="number" placeholder="42" name="pledge" min="1" required>
                </div>
            <div class="col-md-3">
                <label>Quantity</label>
                <input class="form-control" type="number" name="quantity" placeholder="10" min="1" required>
            </div>
        </div>
        <button type="submit" name='submit' class="btn btn-primary">Start my project!</button>
      </form>
    </div>
    <br />
</div>


<?php
    include("footer.php");
    pg_close($dbconn);
?>
</body>
</html>