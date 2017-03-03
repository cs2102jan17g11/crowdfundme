<html>
<head>
  <?php
  include_once("env.php");
  include_once("headers.php");

  $dbconn = pg_connect(pg_connect_string)
  or die('Could not connect: ' . pg_last_error());
  include_once("sqls.php");
  include_once("util.php");
  ?>
  <title>Explore | Projects</title>
</head>

<body>

  <?php
  include_once("navbar.php");
  navbar(URL_PROJECTS_VIEW);

  $project = getProject($_GET['project']);

  ?>

  <div class="container">

    <div class="box-padding">
      <h1><?php echo $project[1]?></h1>
      <h4><i>by <a><?php echo $project[2] ?></a></i></h4>
    </div>

    <br />

    <div class="row" >
      <div class="col-sm-12 col-md-8">
        <img style="max-width: 100%; height: auto" src="<?php echo $project[3] ?>" alt="">
      </div>

      <div class="col-sm-12 col-md-4">
        <div class="panel panel-default" style="max-height: 100%" >
          <div class="panel-body" >

            <div class="progress">
              <div class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo calculatePercantage($project[8], $project[7])?>%">
              </div>
            </div>

            <div class="content-padding">

              <div class="red"><h2><b>$<?php echo $project[8] ?></b></h2></div>
              <div>pledged of $<?php echo $project[7] ?> goal</div>


              <div><h3>0</h3></div>
              <div>backers</div>


              <div><h3><?php echo dateDifference($project[6]) ?></h3></div>
              <div>Days Left (<?php echo $project[6] ?>)</div>

            </div>

            <br />

          </div>
        </div>

          <a href="edit-project.php?project=<?php echo $project[0] ?>"><button class="btn btn-warning btn-lg btn-block">Edit my project</button></a>

      </div>
    </div>

    <br /> <br />

    <div class="row">
      <div class="col-sm-12 col-md-12">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="content-padding">
              <h3>Project Description</h3>
              <br />
              <p><?php echo $project[4] ?></p>
              <br /><br />
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>



  <?php
  include("footer.php");
  pg_close($dbconn);
  ?>
</body>
</html>
