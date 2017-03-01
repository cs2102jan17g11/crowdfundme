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
?>

<div class="container">
    <h1>Log in</h1>

    <!-- <div class="row"> -->
        <div>
            <?php
                if(isset($_SESSION['referred_from'])) {
                    echo '<div class="text-center">Seems like you need to login to view that page!</div><br/>';
                }
            ?>
            <!-- <div class="panel panel-default"> -->
                <?php
                if(isset($_SESSION['userEmail'])) {
                    echo 'Hi, ' . $_SESSION['userEmail'] . 'Already logged in.';
                    header("Refresh: 1; url=/");
                } else {
                ?>

                <!-- <div class="panel-body"> -->
                    <form method="post" action="/dologin.php">
                        <div class="form-group">
                            <input class="form-control input-lg" type="text" name="userEmail" placeholder="Email Address" />
                        </div>
                        <div class="form-group">
                            <input class="form-control input-lg" type="text" name="userPass" placeholder="Password" />
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-md-6">
                                <input type="submit" name="submit" class="btn btn-primary btn-block btn-lg">
                            </div>
                        </div>
                    </form>
                <!-- </div> -->
            <!-- </div> -->
        <!-- </div> -->
    </div>
</div>
<?php
} // close off the php-else
pg_close($dbconn);
?>
</html>
