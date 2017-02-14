<?php
    ob_start();
    session_start();
    if(isset($_SESSION['user'])) {
        echo 'Hi, ' . $_SESSION['user'] . 'Logging you out';
        unset($_SESSION['user']);
        session_unset();
        session_destroy();
    } else {
        // go to index, if not logged-in
        header("Location: index.php");
    }
    
?>

