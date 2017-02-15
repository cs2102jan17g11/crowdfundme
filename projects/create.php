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
    <h1 class="jumbotron">Hi, <?php echo getFirstName($_SESSION['username']); ?>. <br/><small>We have <?php echo countAllOnGoingProjects() ?> ongoing projects, we <span class="red">warmly</span> welcome you to be one of them!</small></h1>
    <div class="row">
      <form>
        <div class="form-group">
          <label>Title for your project</label>
          <input type="text" class="form-control" placeholder="Air bed for your bestfriends">
        </div>
        <div class="form-group">
          <label>Description for your project</label>
          <input class="form-control" type="textarea" placeholder="This project will be one of the most wanted because...">
        </div>
        <button type="submit" class="btn btn-primary">Start my project!</button>
      </form>
    </div>
</div>
<?php
  include("../footer.php");
  pg_close($dbconn);
?>
</body>
</html>
