<html>
<head>
    <?php
    include_once("env.php");
    include_once("headers.php");

    $dbconn = pg_connect(pg_connect_string)
    or die('Could not connect: ' . pg_last_error());
    include_once("sqls.php");
    ?>

    <title>Create Rewards</title>
</head>

<body>
<?php
    include_once("navbar.php");
    navbar(URL_INDEX);
    $project = $_GET['project'];
    echo $project;
?>


<?php
    include("footer.php");
    pg_close($dbconn);
?>
</body>
</html>