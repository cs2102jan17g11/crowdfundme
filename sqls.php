<?php
function countAllProjects() {
    $query = 'SELECT count(*) FROM projects';
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());
    $data = pg_fetch_row($result)[0];
    pg_free_result($result);
    return $data;
}

function countAllOnGoingProjects() {
    return countAllProjects();
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
    $bool = pg_num_rows($result) == 1;
    pg_free_result($result);
    echo $bool;
    return $bool;
}

/*
function getFirstName($username) {
    $query = "SELECT u.fullname FROM users u WHERE u.username = '$username'";
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());

    $data = pg_fetch_row($result)[0];
    pg_free_result($result);
    return $data;
}
*/

function getFirstName($email) {
    $query = "SELECT u.first_name FROM users u WHERE u.email = '$email'";
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());

    $data = pg_fetch_row($result)[0];
    pg_free_result($result);
    return $data;
}

function checkAccountExist($email) {
    $query = "SELECT * FROM users u WHERE u.email = '$email'";
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());

    $data = pg_fetch_row($result)[0];
    pg_free_result($result);
    return $data;
}

function createUser($email, $first_name, $last_name, $hashedpassword) {
    $query = "INSERT INTO users (email,first_name,last_name,password,role) VALUES('" . $email . "', '" . $first_name . "', '" . $last_name . "', '" . $hashedpassword . "', 'user')";
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());
}

function getUser($email) {
    $query = "SELECT u.first_name, u.last_name, u.website, u.biography FROM users u WHERE u.email = '$email'";
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());

    $data = pg_fetch_row($result);
    pg_free_result($result);
    return $data;
}

function updateProfile($email, $website, $biography) {
    $query = "UPDATE users SET website = '" . $website . "', biography = '" . $biography . "' WHERE email = '" . $email . "'";
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());
}

function isValidPassword($email, $password) {
    $query = "SELECT u.password FROM users u WHERE u.email = '". $email . "'";
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());

    $data = pg_fetch_row($result)[0];

    pg_free_result($result);
    return password_verify($password, $data);
}

function updatePassword($email, $password) {
    $query = "UPDATE users SET password = '" . $password. "' WHERE email = '" . $email . "'";
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());
}

function getUserProjects($email) {
    $query = "SELECT title, blurb, start_date, end_date, goal, raised FROM projects p WHERE p.creator = '" . $email . "' ORDER BY end_date DESC";
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());

    return $result;
}
?>