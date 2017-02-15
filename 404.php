<html>
<?php
    include_once("env.php");
    include_once("headers.php");
    $dbconn = pg_connect(pg_connect_string)
        or die('Could not connect: ' . pg_last_error());

?>
<body>
<div class="container">
<?php
    include_once("navbar.php");
    navbar("");
?>
    <h1 class="jumbotron">
    OPPPS THIS PAGE DOESN'T EXIST
    <br/>
    SAD CATZ.
    </h1>
    <img src="https://s-media-cache-ak0.pinimg.com/736x/07/c3/45/07c345d0eca11d0bc97c894751ba1b46.jpg" />
</div>
<?php
  include("footer.php");
  pg_close($dbconn);
?>
</body>
</html>