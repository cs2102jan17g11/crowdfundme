<html>
<head>
<?php
    include_once("sqls.php");
    include_once("env.php");
    include_once("headers.php");
    $dbconn = pg_connect(pg_connect_string)
        or die('Could not connect: ' . pg_last_error());

    ob_start();
    session_start();
?>
    <title>Login</title>
</head>

<body>
<?php
  include_once("navbar.php");
  navbar(URL_INDEX);

  if(isset($_POST['submit'])) {
    $userEmail = cleanInputString($_POST['userEmail']);
    $userPass = cleanInputString($_POST['userPass']);
    $success = isValidPassword($userEmail, $userPass);

    if($success) {
        $_SESSION['userEmail'] = $userEmail;
        $_SESSION['userRole'] = getUserRole($userEmail);

        if(isset($_SESSION['referred_from'])) {
            $loc = $_SESSION['referred_from'];
            unset($_SESSION['referred_from']);
            echo "<script>location.replace('$loc');</script>";
        } else {
            echo "<script>location.replace('index.php');</script>";
        }
    } else {
        $error = true;
    }
  }
?>

<div class="container">
    <div class="row">
        <br/>
        <div class="col-md-4 col-md-offset-4">
            <div class="text-center"><h1>Log in</h1></div>
            <div class="panel panel-default">

            <?php
                if(isset($_SESSION['referred_from'])) {
                    echo '<div class="alert alert-warning"><p class="bg-warning">Seems like you need to login to view that page!</p></div>';
                }
            ?>
                <?php
                if(isset($_SESSION['userEmail'])) {
                    echo 'Hi, ' . $_SESSION['userEmail'] . 'Already logged in.';
                    header("Refresh: 1; url=/");
                } else { 
                    if(isset($error)) {
                        echo '<div class="alert alert-danger"><p class="bg-danger">Wrong Credentials</p></div>';
                    }
                ?>

                <div class="panel-body">
                    <form method="post" action="login.php">
                        <div class="form-group">
                            <input class="form-control" type="text" name="userEmail" placeholder="Email" required/>
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="text" name="userPass" placeholder="Password" required/>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
} // close off the php-else
pg_close($dbconn);
?>
</html>
0
