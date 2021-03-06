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
  if(!isset($_SESSION['userEmail'])) {
    $_SESSION['referred_from'] = "/projects/create.php";
    header("Location: /login.php");
  }

  if(isset($_POST['submit'])) {
    $project_id = createProject(
      $_POST['title'],
      $_SESSION['userEmail'],
      $_POST['img_src'],
      $_POST['description'],
      $_POST['start_date'],
      $_POST['end_date'],
      $_POST['goal'],
      $_POST['raised']
    );
    unset($_POST);
    header("Location: /projectdetails.php?project=$project_id");
  }
?>

    <title>Create | Projects</title>
</head>

<body>
<?php
  include_once("../navbar.php");
  navbar(URL_PROJECTS_CREATE);
?>

<div class="splash create">
    <div class="splash-opacity">
    <div class="container">
      <div class="row">
        <div class="col-md-4 pull-right">
          <br  />
          <h1>Envision the greatest projects, ever.</h1>
          <br /><br />
          <hr class="half-rule"/>
          <br /><br />
          <h4>
            Partner with amazing, innovative, and progressive funders. 
            We have <?php echo countAllOnGoingProjects() ?> ongoing projects, we <span class="red">warmly</span> welcome you to be one of them!
          </h4>
        </div>
      </div>
    </div>
    </div>
</div>

<br />

<div class="container">
    <div class="row">
      <form method="post" action="create.php">
        <div class="form-group">
          <label>Title for your project</label>
          <input type="text" class="form-control" placeholder="Air bed for your bestfriends" name="title" required value=<?php if(isset($_POST['title'])) echo $_POST['title']; ?>>
        </div>
        <div class="form-group">
          <label>Attach an image to your project!</label>
          <input class="form-control" type="textarea" placeholder="https://image.image" name="img_src" required value=<?php if(isset($_POST['img_src'])) echo $_POST['img_src']; ?>>
        </div>
        <div class="form-group">
          <label>Description for your project</label>
          <input class="form-control" type="textarea" placeholder="This project will be one of the most wanted because..." name="description" required value=<?php if(isset($_POST['description'])) echo $_POST['description']; ?>>
        </div>
        <div class="form-group row">
          <div class="col-md-3">
            <label>Start date!</label>
            <input class="form-control" type="date" name="start_date" required value=<?php if(isset($_POST['start_date'])) echo $_POST['start_date']; ?>>
          </div>
          <div class="col-md-3">
            <label>End date!</label>
            <input class="form-control" type="date" name="end_date" required value=<?php if(isset($_POST['end_date'])) echo $_POST['end_date']; ?>>
          </div>
          <div class="col-md-3">
            <label>Your Goal!</label>
            <input class="form-control" type="number" placeholder="1000" name="goal" required value=<?php if(isset($_POST['goal'])) echo $_POST['goal']; ?>>
          </div>
          <div class="col-md-3">
            <label>Raised to date!</label>
            <input class="form-control" type="number" placeholder="0" name="raised" required value=<?php if(isset($_POST['raised'])) echo $_POST['raised']; ?>>
          </div>
        </div>
        <button type="submit" name='submit' class="btn btn-primary">Start my project!</button>
      </form>
    </div>
    <br />
</div>
<?php
  include("../footer.php");
  pg_close($dbconn);
?>
</body>
</html>
