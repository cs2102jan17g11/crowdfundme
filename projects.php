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
    <h1>We have <?php echo countAllProjects(); ?> ongoing projects!</h1>
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
