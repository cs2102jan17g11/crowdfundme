<?php
function countAllProjects() {
    $query = 'SELECT count(*) FROM projects';
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());
    echo pg_fetch_row($result)[0];
    pg_free_result($result);
}

function getProjectNames() {
    $query = 'SELECT p.name, p.contents, u.username FROM projects p, users u WHERE p.owner = u.username';
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());

    while($row = pg_fetch_row($result)) {
        echo '<div class="col-md-4">';
        echo '<h2>' . $row[0] . '</h2>';
        echo '<div class="small">' . $row[1] . '</div>';
        echo '<div><a>' . $row[2] . '</a></div>';
        echo '</div>';
    }
    pg_free_result($result);
}

function isValidUser($username) {
    $query = "SELECT u.username FROM users u WHERE u.username = '$username'";
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());
    // var_dump(pg_num_rows($result));
    $bool = pg_num_rows($result) == 1;
    pg_free_result($result);
    echo $bool;
    return $bool;
}
?>