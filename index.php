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

<body class="index-body">
  <?php
  include_once("navbar.php");
  navbar(URL_INDEX);
  ?>

  <div class="splash">
    <div class="splash-opacity">

      <div class="row">

        <div class="col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-7">
          <br  />
          <h1>Explore the greatest projects, ever.</h1>
          <br /><br />
          <hr class="half-rule"/>
          <br /><br />
          <h4>This platform has provided access to some of the greatest ideas and innovations the world has imagined.
            To date, We have over <?php echo countAllProjects() ?> projects, click on explore to see them.</h4>


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
