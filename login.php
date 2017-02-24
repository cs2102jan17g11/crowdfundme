<html>
<head>
<?php
    include_once("headers.php");

    ob_start();
    session_start();
?>
    <title>Login</title>
</head>

<body>
<?php
  include_once("navbar.php");
  navbar(URL_INDEX);
?>

<div class="container">
    <div class="row">
        <br/>
        <div class="col-md-4 col-md-offset-4">
            <?php
                if(isset($_SESSION['referred_from'])) {
                    echo '<div class="text-center">Seems like you need to login to view that page!</div><br/>';
                }
            ?>
            <div class="text-center"><h1>Log in</h1></div>
            <div class="panel panel-default">
                <?php
                if(isset($_SESSION['userEmail'])) {
                    echo 'Hi, ' . $_SESSION['userEmail'] . 'Already logged in.';
                    header("Refresh: 1; url=/");
                } else {
                ?>

                <div class="panel-body">
                    <form method="post" action="/dologin.php">
                        <div class="form-group">
                            <input class="form-control" type="text" name="userEmail" placeholder="Email" />
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="text" name="userPass" placeholder="Password" />
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
} // close off the php-else
?>
</html>
