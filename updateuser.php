<html>
<head>
    <?php
    include_once("env.php");
    include_once("headers.php");

    $dbconn = pg_connect(pg_connect_string)
    or die('Could not connect: ' . pg_last_error());
    include_once("sqls.php");
    ?>

    <title>Update User</title>
</head>

<body>
<?php
include_once("navbar.php");
navbar(URL_VIEW_USERS);

if(isset($_POST['submit'])) {
    $website = pg_escape_string($_POST['website']);
    $biography = pg_escape_string($_POST['biography']);

    if ($website != "" && filter_var($website, FILTER_VALIDATE_URL) === FALSE) {
        $error[] = 'Website is not a valid URL.';
    }

    if(strlen($biography) > 300){
        $error[] = 'Biography exceeds 300 characters.';
    }

    if (!isset($error)) {
        updateProfile($_GET['email'], $website, $biography);
        header("location: viewuser.php?email=" . $_GET['email']);
    }
}
?>

<div class="container">
    <h1>Update User</h1>

    <?php
    if(isset($error)){
        foreach($error as $error){?>
            <div class="alert alert-danger">
            <strong>Unable to update profile due to the follow reason(s):</strong>
            <?php
            echo '<p class="bg-danger">'.$error.'</p>';
        }?>
        </div>
        <?php
    }

    $user = getUser($_GET['email']);
    ?>

    <form role="form" method="post" action="" autocomplete="off">
        <div class="form-group">
            <input type="text" name="website" id="website" class="form-control input-lg" placeholder="website" value="<?php if(isset($error)){ echo $_POST['website']; } else if($user[2]!="") { echo $user[2]; } ?>" tabindex="1">
        </div>
        <div class="form-group">
            <input type="text" name="biography" id="biography" class="form-control input-lg" placeholder="biography" value="<?php if(isset($error)){ echo $_POST['biography']; } else if($user[3]!="") { echo $user[3]; } ?>" tabindex="2">
        </div>
        <div class="row">
            <div class="col-xs-6 col-md-6"><input type="submit" name="submit" value="Update" class="btn btn-primary btn-block btn-lg" tabindex="6"></div>
        </div>
    </form>
</div>

<?php
include("footer.php");
pg_close($dbconn);
?>
</body>
</html>
