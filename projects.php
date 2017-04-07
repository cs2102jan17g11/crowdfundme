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
?>
<div class="splash explore">
  <div class="splash-opacity">
    <div class="container">
    <div class="row">
      <div class="col-md-4 pull-right">
        <br  />
        <h1>Fund the greatest projects, ever.</h1>
        <br /><br />
        <hr class="half-rule"/>
        <br />
        <h4>
          Funding has never been this adventurous. Select from over <span class="red"><?php echo countAllProjects(); ?></span> ongoing projects.
          <br />
          <br />
          Projects like these could never have been realized without someone like you. Fund it. Help it. Realize it. You have the power.
        </h4>
      </div>
    </div>
    </div>
  </div>
</div>
<div class="container">
    <br />
    <h1>Our Projects</h1>
    <div class="row">
      <?php getProjectNames() ?>
    </div>
</div>
<?php
  include("footer.php");
  pg_close($dbconn);
?>
</body>
</html>
