<?php
include_once("constants.php");
include_once("sqls.php");
function navbar($URL) {
?>
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/">Crowdfundmeeeee</a>
    </div>
    <div id="navbar" class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li
          <?php echo ($URL == URL_PROJECTS_CREATE) ? 'class="active"' : ""; ?>"
        >
          <a href="/projects/create.php">Create a Project</a>
        </li>
        <li
          <?php echo ($URL == URL_PROJECTS_VIEW) ? 'class="active"': ""; ?>"
        ><a href="/projects.php">Explore</a></li>
        <li><a href="/about.php">About</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
          <?php
            ob_start();
            if(!isset($_SESSION)) { session_start(); }
            if(isset($_SESSION['userEmail'])) { //email is being used as user identifier
              $user = getFirstName($_SESSION['userEmail']);
              echo "<li><a href='#'>Hi, $user</a></li>";
              echo "<li><a class='btn btn-default btn-outline btn-circle collapsed' href='/logout.php'>Logout</a></li>";
            } else {
              echo "<li><a class='btn btn-default btn-outline btn-circle collapsed' href='/login.php'>Login / Sign Up</a></li>";
            }
          ?>
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</nav>
<?php
}
?>
