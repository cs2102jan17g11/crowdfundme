<html>
<head>
    <?php
    include_once("env.php");
    include_once("headers.php");

    $dbconn = pg_connect(pg_connect_string)
    or die('Could not connect: ' . pg_last_error());
    include_once("sqls.php");
    ?>

    <title>View User</title>
</head>

<body>
<?php
include_once("navbar.php");
navbar(URL_VIEW_USERS);
?>

<div class="container">
    <h1>View User</h1>

    <center>
        <?php
        $user = getUser($_GET['email']);
        $projects = getUserProjects($_GET['email']);
        $fundings = getUserFundings($_GET['email']);
        ?>

        <h3>
            <b><?php echo $user[0] ?> <?php echo $user[1] ?> </b>
        </h3>

        <span class="badge">
        <?php if(pg_num_rows($projects) > 0) {echo pg_num_rows($projects); } else { echo "0"; }?>
    </span> Projects
        <span class="badge">
        <?php if(pg_num_rows($fundings) > 0) {echo pg_num_rows($fundings); } else { echo "0"; }  ?>
    </span> Fundings
        <br>

        <?php if ($user[2] != "") { ?>
            <a href="""><?php echo $user[2]; ?></a><br>
        <?php   }
        ?>
        <?php if ($user[3] != "") { ?>
            <?php echo $user[3]; ?><br>
        <?php }
        ?>
        <br>

        <a href="updateuser.php?email=<?php echo $_GET['email'] ?>" class="btn btn-primary" role="button">Update Profile</a>
        <a href="changeuserpassword.php?email=<?php echo $_GET['email'] ?>" class="btn btn-primary" role="button">Change Password</a>

        <?php if(pg_num_rows($projects) > 0 || pg_num_rows($fundings) > 0) { ?>
            <a href="#" class="btn btn-primary disabled" role="button">Delete User</a>
        <?php } else { ?>
            <a href="viewallusers.php?delete=<?php echo $_GET['email']?>" class="btn btn-primary" role="button">Delete User</a>
        <?php } ?>


    </center>

    <br>

    <?php if(pg_num_rows($projects) > 0) { ?>
        <h4><b>Projects</b></h4>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Project</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Goal</th>
                <th>Raised</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($row = pg_fetch_row($projects)) { ?>
                <tr>
                    <td><a href="projectdetails.php?project=<?php echo $row[0] ?>"><?php echo $row[1] ?></a></td>
                    <td><?php echo date('d M Y', strtotime($row[2])) ?></td>
                    <td><?php echo date('d M Y', strtotime($row[3])) ?></td>
                    <td>$ <?php echo number_format($row[4],0, '.', ',') ?></td>
                    <td>$ <?php echo number_format($row[5],0, '.', ',') ?></td>
                </tr>
            <?php }
            ?>
            </tbody>
        </table>
    <?php } ?>

    <?php if(pg_num_rows($fundings) > 0) { ?>
        <h4><b>Fundings</b></h4>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Project</th>
                <th>Funding Date</th>
                <th>Amount</th>
                <th>Reward</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($row = pg_fetch_row($fundings)) { ?>
                <tr>
                    <td><a href="projectdetails.php?project=<?php echo $row[0] ?>"><?php echo $row[1] ?></a></td>
                    <td><?php echo date('d M Y', strtotime($row[2])) ?></td>
                    <td>$ <?php echo number_format($row[3],0, '.', ',') ?></td>
                    <td><?php echo $row[4] ?></td>
                </tr>
            <?php }
            ?>
            </tbody>
        </table>
    <?php }  ?>
</div>

<?php
include("footer.php");
pg_close($dbconn);
?>
</body>
</html>
