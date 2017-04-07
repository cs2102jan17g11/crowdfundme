<html>
<head>
  <?php
  include_once("env.php");
  include_once("headers.php");

  $dbconn = pg_connect(pg_connect_string)
  or die('Could not connect: ' . pg_last_error());
  include_once("sqls.php");
  ?>
  <title>Explore | Projects</title>
</head>

<body>
  <?php
  include_once("navbar.php");
  navbar(URL_PROJECTS_VIEW);
  $reward = getReward($_GET['reward']);

  if(isset($_POST['formUpdate'])) {
    $title = pg_escape_string($_POST['title']);
    $description = pg_escape_string($_POST['description']);
    $quantity = pg_escape_string($_POST['quantity']);
    $pledge = pg_escape_string($_POST['pledge']);

    if ($title == "") {
      $error[] = 'Please enter a title!';
    }

    if ($description == "") {
      $error[] = 'Please enter a reward description!';
    }

    if (!isset($error)) {
      updateReward($reward[0], $title, $description);
      header("location: edit-project.php?project=$reward[5]");
    }
  }else if(isset($_POST['formDelete'])){
    $variable = checkDeleteReward($reward[0]);
    if($variable==true){
      deleteReward($reward[0]);
      header("location: edit-project.php?project=$reward[5]");
    }else{
      $error[] = 'You cant remove this reward which has been bidded';
    }
  }

  ?>

  <div class="container" style="padding-top: 20px">

    <div class="row">
      <form role="form" method="post" action="" >
        <div class="col-sm-12 col-md-12">
          <div class="panel panel-default" valign="middle">
            <div class="panel-heading"><b>Edit Reward</b>
              <?php
              if(isset($error)){?>
                <div class="alert alert-danger">
                  <strong>Unable to update reward due to the follow reason(s):</strong>
                  <?php foreach($error as $error){?>
                    <?php
                    echo '<p class="bg-danger">'.$error.'</p>';
                  }?>
                </div>
                <?php
              }
              ?>
            </div>

            <div class="panel-body">

              <div class="col-sm-12 col-md-8">

                <div class="form-group">
                  <label for="inputTitle">Reward title :</label>
                  <input type="text" class="form-control" id="inputTitle" name="title" placeholder="Enter a reward title" value="<?php echo $reward[1] ?>"/>
                </div>

                <div class="form-group">
                  <label for="inputDescription">Description :</label>
                  <textarea class="form-control" id="inputDescription" name="description" rows="8" placeholder="Enter a reward description" ><?php echo $reward[3] ?></textarea>
                </div>

                <div class="form-group">
                  <label for="inputQuantity">Quantity :</label>
                  <div><?php echo $reward[4] ?></div>
                </div>

                <div class="form-group">
                  <label for="inputPledge">Pledge amount :</label>
                  <div><?php echo $reward[2] ?></div>
                </div>

              </div>

            </div>
          </div>

        </div>
        <div>
        </div>
        <div class="col-sm-12 col-md-12">
          <button type="submit" class="btn btn-success" name="formUpdate">Update</button>
          <a href="edit-project.php?project=<?php echo $reward[5] ?>" class="btn btn-default" style="margin-left: 20px">Cancel</a>
          <button type="submit" class="btn btn-danger" name="formDelete" style="float: right;">Delete</button>
        </div>
      </form>
    </div>

  </div>


  <?php
  pg_close($dbconn);
  ?>
</body>
</html>
