<?php

include_once("env.php");
include_once("headers.php");

$dbconn = pg_connect(pg_connect_string)
or die('Could not connect: ' . pg_last_error());
include_once("sqls.php");

$projectid = $_GET['project'];
$title = pg_escape_string($_POST['title']);
$description = pg_escape_string($_POST['description']);
$blurb = pg_escape_string($_POST['imageUrl']);
updateProject($projectid, $title, $description, $blurb);
pg_close($dbconn);
?>
