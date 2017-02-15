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
  navbar(URL_INDEX);
?>

<div class="splash">
  <h1>Create Amazing <span style="color:red">Projects</span></h1>
</div>
<div class="container">
    <div class="row">
      
      <div class="col-md-6 col-md-offset-3">
        <h1>We have <?php countAllProjects() ?> projects!</h1>
        <p>Click on projects to see them!<p>
      </div>
    </div>
</div>
<?php
  include("footer.php");
  pg_close($dbconn);
?>
</body>
</html>
