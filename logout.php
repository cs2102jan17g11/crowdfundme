<?php
    ob_start();
    session_start();
    if(isset($_SESSION['username'])) {
        echo 'Hi, ' . $_SESSION['username'] . 'Logging you out';
        unset($_SESSION['username']);
        session_unset();
        session_destroy();
    } else {
        // go to index, if not logged-in
        header("Location: index.php");
    }
    
?>

