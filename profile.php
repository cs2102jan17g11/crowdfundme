<html>
<head>
    <?php
    include_once("env.php");
    include_once("headers.php");

    $dbconn = pg_connect(pg_connect_string)
    or die('Could not connect: ' . pg_last_error());
    include_once("sqls.php");
    ?>

    <title>Profile</title>
</head>

<body>
<?php
include_once("navbar.php");
navbar(URL_INDEX);
?>

<div class="container">
    <h1>Profile</h1>

    <center>
    <?php
        $user = getUser($_SESSION['userEmail']);
        $projects = getUserProjects($_SESSION['userEmail']);
    ?>

    <h4>
        <b><?php echo $user[0] ?> <?php echo $user[1] ?> </b>
    </h4>
    <span class="badge">
        <?php if(pg_num_rows($projects) > 0) {echo pg_num_rows($projects); } else { echo "0"; }?>
    </span> Projects
    <span class="badge">
        <?php /* if(pg_num_rows($fundings) > 0) {echo pg_num_rows($fundings); } else { echo "0"; } */ ?>
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
        <form role="form" method="get" action="/updateprofile.php" autocomplete="off">
            <input type="submit" name="submit" value="Update Profile" class="btn btn-primary">
        </form>

        <form role="form" method="get" action="/changepassword.php" autocomplete="off">
            <input type="submit" name="submit" value="Change Password" class="btn btn-primary">
        </form>

    </center>

    <br>

        <h4><b>Projects</b></h4>
    <?php if(pg_num_rows($projects) > 0) { ?>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Title</th>
            <th>Blurb</th>
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
            <td><a href=""><?php echo $row[0] ?></a></td>
                <td><?php echo $row[1] ?></td>
                <td><?php echo $row[2] ?></td>
                <td><?php echo $row[3] ?></td>
                <td><?php echo $row[4] ?></td>
                <td><?php echo $row[5] ?></td>
        </tr>
            <?php }
            ?>
        </tbody>
    </table>
    <?php } else { ?>
        There are no projects.
    <?php } ?>

        <h4><b>Fundings</b></h4>
    <?php if(pg_num_rows($fundings) > 0) { ?>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Project</th>
                <th>Amount</th>
                <th>Date/th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($row = pg_fetch_row($fundings)) { ?>
                <tr>
                    <td><a href=""><?php echo $row[0] ?></a></td>
                    <td><?php echo $row[1] ?></td>
                    <td><?php echo $row[2] ?></td>
                </tr>
            <?php }
            ?>
            </tbody>
        </table>
    <?php } else { ?>
        There are no fundings.
    <?php } ?>
</div>

<?php
include("footer.php");
pg_close($dbconn);
?>
</body>
</html>
