<html>
<head>
    <?php
    include_once("env.php");
    include_once("headers.php");

    $dbconn = pg_connect(pg_connect_string)
    or die('Could not connect: ' . pg_last_error());
    include_once("sqls.php");
    ?>

    <title>View All Users</title>
</head>

<body>
<?php
include_once("navbar.php");
navbar(URL_VIEW_USERS);

if(isset($_GET['delete'])) {
    $projects = getUserProjects($_GET['delete']);
    $fundings = getUserFundings($_GET['delete']);

    if (pg_num_rows($projects) > 0) {
        $error[] = 'User has created projects.';
    }

    if (pg_num_rows($fundings) > 0) {
        $error[] = 'User has funded projects.';
    }

    if (!isset($error)) {
        deleteUser($_GET['delete']);
        header("location: viewallusers.php");
    }
}
?>


<div class="container">
    <h1>View All Users</h1>

    <?php
    if(isset($error)){ ?>
        <div class="alert alert-danger">
            <strong>Unable to delete user (<?php echo $_GET['delete'] ?>) due to the follow reason(s):</strong>
            <?php foreach($error as $error){?>
                <?php echo '<p class="bg-danger">'.$error.'</p>';
            }?>
        </div>
        <?php } ?>

    <?php
    $users = getAllUsers($_SESSION['userEmail'], 'admin');
    $rowCount = 1;
    ?>

    <?php if(pg_num_rows($users) > 0) { ?>
        <h4><b>Admins</b></h4>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>No.</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($row = pg_fetch_row($users)) { ?>
                <tr>
                    <td><?php echo $rowCount ?></td>
                    <td><?php echo $row[0] ?></td>
                    <td><?php echo $row[1] ?></td>
                    <td><?php echo $row[2] ?></td>
                    <td><a href="viewuser.php?email=<?php echo $row[2] ?>" class="btn btn-default" role="button">View</a>
                        <a href="updateuser.php?email=<?php echo $row[2] ?>" class="btn btn-default" role="button">Update</a>
                        <a href="viewallusers.php?delete=<?php echo $row[2] ?>" class="btn btn-default" role="button">Delete</a></td>
                </tr>
                <?php
                $rowCount = $rowCount + 1; }
            ?>
            </tbody>
        </table>
    <?php } ?>

        <?php
            $users = getAllUsers($_SESSION['userEmail'], 'user');
            $rowCount = 1;
        ?>

    <?php if(pg_num_rows($users) > 0) { ?>
        <h4><b>Users</b></h4>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>No.</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($row = pg_fetch_row($users)) { ?>
                <tr>
                    <td><?php echo $rowCount ?></td>
                    <td><?php echo $row[0] ?></td>
                    <td><?php echo $row[1] ?></td>
                    <td><?php echo $row[2] ?></td>
                    <td><a href="viewuser.php?email=<?php echo $row[2] ?>" class="btn btn-default" role="button">View</a>
                        <a href="updateuser.php?email=<?php echo $row[2] ?>" class="btn btn-default" role="button">Update</a>
                        <a href="viewallusers.php?delete=<?php echo $row[2] ?>" class="btn btn-default" role="button">Delete</a></td>
                </tr>
            <?php
            $rowCount = $rowCount + 1; }
            ?>
            </tbody>
        </table>
    <?php } ?>
</div>

<?php
include("footer.php");
pg_close($dbconn);
?>
</body>
</html>
