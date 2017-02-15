<?php
ob_start();
session_start();
if(isset($_SESSION['username'])) {
    echo 'Hi, ' . $_SESSION['username'] . 'Already logged in.';
    header("Refresh: 1; url=/");
} else {
?>

<?php
    if(isset($_SESSION['referred_from'])) {
        echo 'Seems like you need to login to view that page!';
    }
?>
<form method="post" action="/dologin.php">
    <input type="text" name="username"/>
    <button>Submit</button>
</form>
<?php
} // close off the php-else
?>

