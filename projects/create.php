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
    $_SESSION['referred_from'] = "/projects/create.php";
    header("Location: /login.php");
  }

  echo isset($_POST['submit']) ? 'true' : 'false';
  echo var_dump($_POST);
  if(isset($_POST['submit'])) {
    createProject(
      $_POST['title'],
      $_SESSION['username'],
      $_POST['img_src'],
      $_POST['description'],
      $_POST['start_date'],
      $_POST['end_date'],
      $_POST['goal'],
      $_POST['raised']
    );
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
      <form method="post" action="create.php">
        <div class="form-group">
          <label>Title for your project</label>
          <input type="text" class="form-control" placeholder="Air bed for your bestfriends" name="title" value=<?php if(isset($_POST['title'])) echo $_POST['title']; ?>>
        </div>
        <div class="form-group">
          <label>Attach an image to your project!</label>
          <input class="form-control" type="textarea" placeholder="https://image.image" name="img_src" value=<?php if(isset($_POST['img_src'])) echo $_POST['img_src']; ?>>
        </div>
        <div class="form-group">
          <label>Description for your project</label>
          <input class="form-control" type="textarea" placeholder="This project will be one of the most wanted because..." name="description" value=<?php if(isset($_POST['description'])) echo $_POST['description']; ?>>
        </div>
        <div class="form-group row">
          <div class="col-md-3">
            <label>Start date!</label>
            <input class="form-control" type="date" name="start_date" value=<?php if(isset($_POST['start_date'])) echo $_POST['start_date']; ?>>
          </div>
          <div class="col-md-3">
            <label>End date!</label>
            <input class="form-control" type="date" name="end_date" value=<?php if(isset($_POST['end_date'])) echo $_POST['end_date']; ?>>
          </div>
          <div class="col-md-3">
            <label>Your Goal!</label>
            <input class="form-control" type="number" placeholder="1000" name="goal" value=<?php if(isset($_POST['goal'])) echo $_POST['goal']; ?>>
          </div>
          <div class="col-md-3">
            <label>Raised to date!</label>
            <input class="form-control" type="number" placeholder="0" name="raised" value=<?php if(isset($_POST['raised'])) echo $_POST['raised']; ?>>
          </div>
        </div>
        <button type="submit" name='submit' class="btn btn-primary">Start my project!</button>
      </form>
    </div>
</div>
<?php
  include("../footer.php");
  pg_close($dbconn);
?>
</body>
</html>
