<?php
ob_start();
session_start();
if(isset($_SESSION['user'])) {
    echo 'Hi, ' . $_SESSION['user'] . 'Already logged in';
} else {
?>
<form method="post" action="/dologin.php">
    <input type="text" name="username"/>
    <button>Submit</button>
</form>
<?php
} // close off the php-else
?>

