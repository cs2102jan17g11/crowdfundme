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
  $project = getProject($_GET['project']);
  $rewards = getProjectRewards($_GET['project']);
  //$mydate = date_default_timezone_get('Australia/Melbourne');
  $now = new \DateTime('now');
  $month = $now->format('m');
  $year = $now->format('Y');
  $currentMonth = date("n",strtotime($mydate));
  if(isset($_POST['formUpdate'])) {
    $title = pg_escape_string($_POST['title']);
    $description = pg_escape_string($_POST['description']);
    $blurb = pg_escape_string($_POST['imageUrl']);

    if ($title == "") {
      $error[] = 'Please enter a title!';
    }

    if ($description == "") {
      $error[] = 'Please enter a reward description!';
    }

    if (!isset($error)) {
      updateProject($project[0], $title, $description, $blurb);
      header("location: projectdetails.php?project=$project[0]");
    }
  }else if(isset($_POST['formDelete'])){
    $variable = checkDeleteProject($project[0]);
    if($variable==true){
      deleteProject($project[0]);
      header("location: profile.php");
    }else{
      $error[] = 'You cant remove this project as it has been bidded before';
    }
  }
  ?>

  <div class="container" style="padding-top: 20px">

    <div class="row">
      <form role="form" method="post" action="" >
        <div class="col-sm-12 col-md-12">
          <div class="panel panel-default" valign="middle">
            <div class="panel-heading"><b>Edit Project</b>
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
                  <label for="inputTitle">Project Title :</label>
                  <input type="text" class="form-control" id="inputTitle" name="title" placeholder="Enter a project title" value="<?php echo $project[1] ?>"/>
                </div>

                <div class="form-group">
                  <label for="inputDescription">Description :</label>
                  <textarea class="form-control" id="inputDescription" name="description" rows="8" placeholder="Enter a project description" ><?php echo $project[4] ?></textarea>
                </div>

                <div class="form-group">
                  <label for="inputImageUrl">Project Image :</label>
                  <input type="text" class="form-control" id="inputImageUrl" name="imageUrl" placeholder="Enter an image url" value="<?php echo $project[3] ?>"/>
                </br>
                <img src="<?php echo $project[3] ?>" width=auto height=auto/>
              </div>

              <div class="form-group">
                <label for="startDate">Start Date :</label>
                <div><?php echo $project[5] ?></div>
              </div>

              <div class="form-group">
                <label for="endDate">End Date :</label>
                <div><?php echo $project[6] ?></div>
              </div>

              <div class="form-group">
                <label for="fundingStatus">Funding Progress :</label>
                <div>$<?php echo $project[8] ?> / $<?php echo $project[7] ?></div>
              </div>


            </div>

          </div>
        </div>

      </div>
      <div>
        <div class="panel-body">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Reward</th>
                <th>Description</th>
                <th>Pledge</th>
                <th>Quantity Left</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if(pg_num_rows($rewards)>0){
                while ($row = pg_fetch_row($rewards)) { ?>
                  <tr>
                    <td><?php echo $row[1] ?></td>
                    <td><?php echo $row[3] ?></td>
                    <td>$ <?php echo number_format($row[2],0, '.', ',') ?> or more</td>
                    <td><?php echo $row[4] ?></td>
                    <td><a href="edit-reward.php?reward=<?php echo $row[0] ?>" class="btn btn-default" role="button">Edit</a></td>
                  </tr>
                  <?php }
                }else{
                  ?>
                  <tr>
                    <td>No Rewards found</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </td>
                  <?php }?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="col-sm-12 col-md-12">
            <button type="submit" class="btn btn-success" name="formUpdate">Update</button>
            <a href="profile.php" class="btn btn-default" style="margin-left: 20px">Cancel</a>
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
