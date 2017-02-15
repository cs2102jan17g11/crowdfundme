<?php
ob_start();
session_start();
if(isset($_SESSION['username'])) {
    echo 'Hi, ' . $_SESSION['username'] . 'Already logged in.';
    header("Refresh: 1; url=/");
} else {
?>
<form method="post" action="/dologin.php">
    <input type="text" name="username"/>
    <button>Submit</button>
</form>
<?php
} // close off the php-else
?>

