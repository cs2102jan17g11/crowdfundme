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
  <div class="container">
    <div class="row">
      <div class="col-sm-12 col-md-4 col-lg-5">
        <h1>Hello, world!</h1>
        <p>...</p>
      </div>

      <div class="col-sm-12 col-md-8 col-lg-7">
        <h1>User</h1>
      </div>

    </div>

  </div>
  <?php
  include("footer.php");
  pg_close($dbconn);
  ?>
</body>
</html>
