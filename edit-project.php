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

  // $project = getProject($_GET["projectId"]);
  $project = getProject(2);
  ?>
  <div class="container">

    <div class="row">
      <form action="projectdetails2.php" method="post">
        <div class="col-sm-12 col-md-12">
          <div class="panel panel-default">
            <div class="panel-heading">Edit Project: <?php echo $project[1] ?>
              <button type="button" class="btn btn-danger" style="float: right;">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
              </button>
            </div>
            <div class="panel-body">

              <div class="col-sm-12 col-md-8">

                <div class="form-group">
                  <label for="inputTitle">Project Title</label>
                  <input type="text" class="form-control" id="inputTitle" name="title" placeholder="Enter a project title" value="<?php echo $project[1] ?>"/>
                </div>

                <div class="form-group">
                  <label for="inputDescription">Description</label>
                  <textarea class="form-control" id="inputDescription" name="description" rows="8" placeholder="Enter a project description" ><?php echo $project[4] ?></textarea>
                </div>

                <div class="form-group">
                  <label for="inputImageUrl">Project Image</label>
                  <input type="file" hidden id="inputImageUrl" name="imageUrl">
                </br>
                <img src="<?php echo $img;?>" width=auto height=auto/>
              </div>

            </div>

          </div>
        </div>

      </div>
      <div class="col-sm-12 col-md-12">

        <?php
        getProjectRewards($project[0]);
        ?>

      </div>
      <div class="col-sm-12 col-md-8">

        <button type="submit" class="btn btn-success" name="formUpdate">Submit
          <?php
            updateProject($project[0],$title,$description,$imageUrl);
            echo $project[0];
                        echo $title;
                                    echo $description;
                                                echo $imageUrl;
          ?></button>
        <button type="submit" class="btn btn-default" name="formCancel">Cancel</button>

      </div>
    </form>
  </div>

</div>


<?php
include("footer.php");
pg_close($dbconn);
?>
</body>
</html>
