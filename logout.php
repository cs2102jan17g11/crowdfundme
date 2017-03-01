<?php
    include_once("env.php");
    include_once("sqls.php");
    ob_start();
    session_start();
    if(isset($_SESSION['userEmail'])) {

        $dbconn = pg_connect(pg_connect_string)
            or die('Could not connect: ' . pg_last_error());
        pg_close($dbconn);

        unset($_SESSION['userEmail']);
        session_unset();
        session_destroy();
        header("Refresh: 1; url=/");
    } else {
        // go to index, if not logged-in
        header("Location: index.php");
    }
    
?>

