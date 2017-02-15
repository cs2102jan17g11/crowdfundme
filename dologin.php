<?php
include_once("sqls.php");
include_once("env.php");

$dbconn = pg_connect(pg_connect_string)
        or die('Could not connect: ' . pg_last_error());

ob_start();
session_start();

if(isset($_SESSION['username'])) {
    echo '<script>location.replace("index.php");</script>';
} else {

    $name = trim($_POST['username']);
    $name = strip_tags($name);
    $name = htmlspecialchars($name);

    $success = isValidUser($name);
    if($success) {
        $_SESSION['username'] = $name;

        if(isset($_SESSION['referred_from'])) {
            $loc = $_SESSION['referred_from'];
            unset($_SESSION['referred_from']);
            echo "<script>location.replace('$loc');</script>";
        } 

    } else {
        echo 'wrong credentials';
    }
}
pg_close($dbconn);
?>