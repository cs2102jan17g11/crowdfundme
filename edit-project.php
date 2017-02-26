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
  ?>

  <div class="container" style="padding-top: 20px">

    <div class="row">
      <form action="do-update-project.php?project=' <?php echo $project[0] ?> '" method="post">
        <div class="col-sm-12 col-md-12">
          <div class="panel panel-default">
            <div class="panel-heading"><b>Edit Project</b>
              <a href="delete_confirm_project.php?project=<?php echo $project[0] ?>" style="float: right;">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
              </a>
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
                  <input type="file" hidden id="inputImageUrl" name="imageUrl">
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
        <div style="margin-left: 45px"><label for="rewards">Rewards :</label></div>
        <?php
        getProjectRewards($project[0]);
        ?>
      </div>
      <div class="col-sm-12 col-md-12">
        <button type="submit" class="btn btn-success" name="formUpdate">Submit</button>
        <a href="myprojectdetails.php?project=<?php echo $project[0] ?>" class="btn btn-default" style="margin-left: 20px">Cancel</a>
      </div>
    </form>
  </div>

</div>


<?php
pg_close($dbconn);
?>
</body>
</html>
