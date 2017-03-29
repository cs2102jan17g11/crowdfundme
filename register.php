<html>
<head>
    <?php
    include_once("env.php");
    include_once("headers.php");

    $dbconn = pg_connect(pg_connect_string)
    or die('Could not connect: ' . pg_last_error());
    include_once("sqls.php");
    ?>

    <title>Register</title>
</head>

<body>
    <?php
    include_once("navbar.php");
    navbar(URL_INDEX);

    if(isset($_POST['submit'])) {
        $email = pg_escape_string($_POST['email']);
        $first_name = pg_escape_string($_POST['firstname']);
        $last_name = pg_escape_string($_POST['lastname']);
        $password = pg_escape_string($_POST['password']);
        $passwordconfirm = pg_escape_string($_POST['passwordConfirm']);

        if($first_name == ""){
            $error[] = 'First name is empty.';
        } else if(strlen($first_name) < 3){
            $error[] = 'First name is too short.';
        }

        if($last_name == ""){
            $error[] = 'Last name is empty.';
        } else if(strlen($last_name) < 2){
            $error[] = 'Last name is too short.';
        }

        if($email == ""){
            $error[] = 'Email is empty.';
        } else if(checkAccountExist($email)) {
            $error[] = 'Account has already been created for the email address.';
        }

        if($password == ""){
            $error[] = 'Password is empty.';
        }

        if($password != $passwordconfirm){
            $error[] = 'Passwords do not match.';
        }

        if (!isset($error)) {
            $hashedpassword = password_hash($password, PASSWORD_BCRYPT);

            createUser($email, $first_name, $last_name, $hashedpassword, 'user');

            $_SESSION['userEmail'] = $email;
            $_SESSION['userRole'] = 'user';
            header("location: profile.php");
        }
    }
?>

<div class="container">
    <h1>Register</h1>

    <?php
        if(isset($error)){ ?>
            <div class="alert alert-danger">
            <strong>Unable to register due to the follow reason(s):</strong><br>
                <?php
            foreach($error as $error){
                echo $error.'<br>';
            } ?>
            </div>
    <?php
        }
    ?>


    <form role="form" method="post" action="" autocomplete="off">
        <div class="form-group">
            <input type="text" name="firstname" id="firstname" class="form-control input-lg" placeholder="First Name" value="<?php if(isset($error)){ echo $_POST['firstname']; } ?>" tabindex="1">
        </div>
        <div class="form-group">
            <input type="text" name="lastname" id="lastname" class="form-control input-lg" placeholder="Last Name" value="<?php if(isset($error)){ echo $_POST['lastname']; } ?>" tabindex="2">
        </div>
        <div class="form-group">
            <input type="email" name="email" id="email" class="form-control input-lg" placeholder="Email Address" value="<?php if(isset($error)){ echo $_POST['email']; } ?>" tabindex="3">
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" tabindex="4">
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <input type="password" name="passwordConfirm" id="passwordConfirm" class="form-control input-lg" placeholder="Confirm Password" tabindex="5">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-md-6"><input type="submit" name="submit" value="Register" class="btn btn-primary btn-block btn-lg" tabindex="6"></div>
        </div>
    </form>
</div>

<?php
include("footer.php");
pg_close($dbconn);
?>
</body>
</html>
