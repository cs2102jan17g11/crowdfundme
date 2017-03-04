<html>
<head>
    <?php
    include_once("env.php");
    include_once("headers.php");

    $dbconn = pg_connect(pg_connect_string)
    or die('Could not connect: ' . pg_last_error());
    include_once("sqls.php");
    ?>

    <title>Change Password</title>
</head>

<body>
<?php
include_once("navbar.php");
navbar(URL_INDEX);

if(isset($_POST['submit'])) {
    $current_password = pg_escape_string($_POST['current_password']);
    $new_password = pg_escape_string($_POST['new_password']);
    $new_passwordconfirm = pg_escape_string($_POST['new_passwordConfirm']);

    if($current_password == ""){
        $error[] = 'Current password is empty.';
    } else if((isValidPassword($_SESSION['userEmail'], $current_password)) != true) {
        $error[] = 'Current password is incorrect.';
    } else if ($current_password == $new_password && $current_password == $new_passwordconfirm) {
        $error[] = 'New and current passwords cannot be the same.';
    }

    if($new_password == ""){
        $error[] = 'New password is empty.';
    }

    if($new_password != $new_passwordconfirm){
        $error[] = 'New passwords do not match.';
    }

    if (!isset($error)) {
        $hashedpassword = password_hash($new_password, PASSWORD_BCRYPT);
        updatePassword($_SESSION['userEmail'], $hashedpassword);
        header("location: profile.php");
    }
}
?>

<div class="container">
    <h1>Change Password</h1>

    <?php
    if(isset($error)){
    ?>
    <div class="alert alert-danger">
        <strong>Unable to change password due to the follow reason(s):</strong>
        <?php
        foreach($error as $error){
            echo '<p class="bg-danger">'.$error.'</p>';
        }?>
    </div>
        <?php
    }
    ?>

    <form role="form" method="post" action="" autocomplete="off">
        <div class="form-group">
            <input type="password" name="current_password" id="current_password" class="form-control input-lg" placeholder="Current Password" tabindex="1">
        </div>
        <div class="form-group">
            <input type="password" name="new_password" id="new_password" class="form-control input-lg" placeholder="New Password" tabindex="2">
        </div>
        <div class="form-group">
            <input type="password" name="new_passwordConfirm" id="new_passwordConfirm" class="form-control input-lg" placeholder="Confirm New Password" tabindex="3">
        </div>
        <div class="row">
            <div class="col-xs-6 col-md-6"><input type="submit" name="submit" value="Change Password" class="btn btn-primary btn-block btn-lg" tabindex="6"></div>
        </div>
    </form>
</div>

<?php
include("footer.php");
pg_close($dbconn);
?>
</body>
</html>
