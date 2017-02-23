<?php
include_once("constants.php");
include_once("sqls.php");
function navbar($URL) {
?>
<nav class="navbar navbar-inverse navbar-fixed-top">
     <div class="container">
       <!-- Brand and toggle get grouped for better mobile display -->
       <div class="navbar-header">
         <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-3">
           <span class="sr-only">Toggle navigation</span>
           <span class="icon-bar"></span>
           <span class="icon-bar"></span>
           <span class="icon-bar"></span>
         </button>
         <a class="navbar-brand" href="/">Crowdfundmeeeee</a>
       </div>

       <!-- Collect the nav links, forms, and other content for toggling -->
       <div class="collapse navbar-collapse" id="navbar-collapse-3">
         <ul class="nav navbar-nav navbar-right">
           <ul class="nav navbar-nav">
             <li
               <?php echo ($URL == URL_PROJECTS_CREATE) ? 'class="active"' : ""; ?>">
               <a href="/projects/create.php">Create a Project</a>
             </li>
             <li
               <?php echo ($URL == URL_PROJECTS_VIEW) ? 'class="active"': ""; ?>"
             ><a href="/projects.php">Explore</a></li>
             <li><a href="/about.php">About</a></li>
           <li>
             <a class="btn btn-default btn-outline btn-circle collapsed"  data-toggle="collapse" href="#nav-collapse3" aria-expanded="false" aria-controls="nav-collapse3">Search</a>
           </li>
         </ul>
         <ul class="nav navbar-nav navbar-right">
             <?php
               ob_start();
               if(!isset($_SESSION)) { session_start(); }
               if(isset($_SESSION['username'])) {
                 $user = getFirstName($_SESSION['username']);
                 echo "<li><a href='#'>Hi, $user</a></li>";
                 echo "<li><a href='/logout.php'>Logout</a></li>";
               } else {
                 echo "<li><a href='/login.php'>Login</a></li>";
               }
             ?>
         </ul>
         <div class="collapse nav navbar-nav nav-collapse slide-down" id="nav-collapse3">
           <form class="navbar-form navbar-right" role="search">
             <div class="form-group">
               <input type="text" class="form-control" placeholder="Search" />
             </div>
             <button type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
           </form>
         </div>
       </div><!-- /.navbar-collapse -->
     </div><!-- /.container -->
   </nav><!-- /.navbar -->
<?php
}
?>
