<?php

include_once("env.php");
include_once("headers.php");

$dbconn = pg_connect(pg_connect_string)
or die('Could not connect: ' . pg_last_error());
include_once("sqls.php");

$projectid = $_GET['project'];
checkDeleteProject($projectid);

pg_close($dbconn);
?>
