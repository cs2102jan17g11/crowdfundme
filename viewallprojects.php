<html>
<head>
    <?php
    include_once("env.php");
    include_once("headers.php");

    $dbconn = pg_connect(pg_connect_string)
    or die('Could not connect: ' . pg_last_error());
    include_once("sqls.php");
    ?>

    <title>View All Projects</title>
</head>

<body>
<?php
include_once("navbar.php");
navbar(URL_VIEW_PROJECTS);
?>


<div class="container">
    <h1>View All Projects</h1>

    <?php
    $projects = getAllProjects();
    $rowCount = 1;
    ?>

    <?php if(pg_num_rows($projects) > 0) { ?>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>No.</th>
                <th>Title</th>
                <th>Creator</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($row = pg_fetch_row($projects)) { ?>
                <tr>
                    <td><?php echo $rowCount ?></td>
                    <td><?php echo $row[1] ?></td>
                    <td><?php echo $row[2] ?></td>
                    <td><a href="projectdetails.php?project=<?php echo $row[0] ?>" class="btn btn-default" role="button">View</a>
                        <a href="edit-project.php?project=<?php echo $row[0] ?>" class="btn btn-default" role="button">Update</a>
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
