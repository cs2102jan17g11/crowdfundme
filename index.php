<html>
<head>
<?php
    
    include_once("./env.php");
    include_once("./headers.php");
    
    $dbconn = pg_connect(pg_connect_string)
        or die('Could not connect: ' . pg_last_error());
    include_once("./sqls.php");

?>
    <title>Explore | Projects</title>
</head>

<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/">Crowdfundme</a>
    </div>
    <div id="navbar" class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li><a href="/projects/create.php">Create a Project</a></li>
        <li><a href="/projects.php">Explore</a></li>
        <li><a href="/about.php">About</a></li>
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</nav>

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
  include("./footer.php");
  pg_close($dbconn);
?>
</body>
</html>
