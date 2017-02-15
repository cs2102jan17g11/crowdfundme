<html>
<head>
<?php
    
    include_once("../env.php");
    include_once("../headers.php");
    include_once("../constants.php");
    $dbconn = pg_connect(pg_connect_string)
        or die('Could not connect: ' . pg_last_error());
    include_once("../sqls.php");
?>
<?php
  ob_start();
  session_start();
  if(!isset($_SESSION['username'])) {
    echo 'You are not logged in, redirecting you to login.';
    $_SESSION['referred_from'] = "/projects/create.php";
    header("Refresh: 2; url=/login.php");
  }
?>



    <title>Create | Projects</title>
</head>

<body>
<?php
  include_once("../navbar.php");
  navbar(URL_PROJECTS_CREATE);
?>

<div class="container">
    <h1>We have <?php countAllProjects() ?> projects!</h1>
    <div class="row">
      <form>
      </form>
    </div>
</div>
<?php
  include("../footer.php");
  pg_close($dbconn);
?>
</body>
</html>
