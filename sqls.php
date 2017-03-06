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
    $query = 'SELECT p.project_id, p.title, p.description, u.first_name, p.img_src FROM projects p, users u WHERE p.creator = u.email';
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());

    while($row = pg_fetch_row($result)) {
        echo '<div class="col-md-4">';
        echo '<img src="' .$row[4] . '" style="max-width:100%;" />';
        echo '<div class="panel panel-default"> <div class="panel-body" style="padding: 0 20px">';
        echo '<h3><a href="projectdetails.php?project=' . $row[0] . '">' . $row[1] . '</a></h3>';
        echo '<div>by <a>' . $row[3] . '</a></div>';
        echo '<br /><br />';
        echo '<div class="small ellipsis">' . $row[2] . '</div>';
        echo '<br /><br />';
        echo '<div class="progress"><div class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width:' . 70 . '%"></div></div>';
        echo '<br />';
        echo '</div></div>';
        echo '</div>';
    }
    pg_free_result($result);
}

function isValidUser($username) {
  $query = "SELECT u.email FROM users u WHERE u.email = '$username'";
  $result = pg_query($query) or die('Query failed: ' . pg_last_error());
  $bool = pg_num_rows($result) == 1;
  pg_free_result($result);
  return $bool;
}

function getProject($projectId){
  $query = "SELECT * FROM projects p WHERE p.project_id='$projectId'";
  $result = pg_query($query) or die('Query failed: ' . pg_last_error());

  $data = pg_fetch_row($result);
  pg_free_result($result);
  return $data;
}

function getProjectRewards($projectId){
  $query = "SELECT r.reward_id, r.title, r.pledge, r.description, r.quantity 
            FROM rewards r, projects p 
            WHERE r.project_id = p.project_id 
            AND p.project_id='$projectId'
            ORDER BY r.quantity DESC";
  $result = pg_query($query) or die('Query failed: ' . pg_last_error());
  return $result;
}

function updateProject($projectId,$title,$description,$img_src){
  $query = "UPDATE projects SET title = '$title', description = '$description', img_src = '$img_src' WHERE project_id = $projectId;";
  $result = pg_query($query) or die('Query failed: ' . pg_last_error());
  echo '<script>location.replace("projectdetails.php?project=' . $projectId . '");</script>';
  pg_free_result($result);
}

function checkDeleteProject($projectId){
  $query = "SELECT EXISTS(SELECT 1 FROM projects WHERE project_id=$projectId AND raised>0);";
  $result = pg_query($query) or die('Query failed: ' . pg_last_error());
  $row = pg_fetch_array($result);
  if($row[0] == true){
    echo "You can't remove a project which has been bidded!";
  }else{
    deleteProject($projectId);
  }
}

function deleteProject($projectId){
  $query = "DELETE FROM projects where project_id=$projectId";
  $result = pg_query($query) or die('Query failed: ' . pg_last_error());
  echo '<script>location.replace("projects.php");</script>';
}


function createProject($title, $creator, $img_src, $description, $start_date, $end_date, $goal, $raised) {
    $start_date = $start_date == '' ? NULL : $start_date;
    $end_date = $end_date == '' ? NULL : $end_date;
    $goal = intval($goal);
    $raised = intval($raised);
    $params = array($title, $creator, $img_src, $description, $start_date, $end_date, $goal, $raised);
    $result = pg_query_params('INSERT INTO Projects VALUES(DEFAULT, $1, $2, $3, $4, $5, $6, $7, $8) RETURNING project_id', $params) or die('Query failed: ' . pg_last_error());;
    if(!$result) {
        echo 'Error in ' . pg_result_error(pg_get_result());
    } else {
        $data = pg_fetch_row($result)[0];
        pg_free_result($result);
        return $data;
    }
}

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
    $query = "INSERT INTO users 
            (email,first_name,last_name,password,role) 
            VALUES('" . $email . "', '" . $first_name . "', '" . $last_name . "', '" . $hashedpassword . "', 'user')";
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
    $query = "UPDATE users 
            SET website = '" . $website . "', biography = '" . $biography . "' 
            WHERE email = '" . $email . "'";
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());
}

function isValidPassword($email, $password) {
    $query = "SELECT u.password 
              FROM users u 
              WHERE u.email = '". $email . "'";
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());

    $data = pg_fetch_row($result)[0];

    pg_free_result($result);
    return password_verify($password, $data);
}

function updatePassword($email, $password) {
    $query = "UPDATE users 
              SET password = '" . $password . "' 
              WHERE email = '" . $email . "'";
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());
}

function getUserProjects($email) {
    $query = "SELECT p.project_id, p.title, p.start_date, p.end_date, p.goal, p.raised 
              FROM projects p 
              WHERE p.creator = '" . $email . "' 
              ORDER BY p.end_date DESC";
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());

    return $result;
}

function getUserFundings($email) {
    $query = "SELECT p.project_id, p.title, f.funding_datetime, f.amount, r.title
              FROM fundings f, rewards r, projects p
              WHERE r.reward_id = f.reward_id 
              AND p.project_id = r.project_id
              AND f.email = '" . $email . "' 
              ORDER BY f.funding_datetime DESC";
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());

    return $result;
}

function selectReward($project_id, $time, $pledge, $email, $reward_id) {
    $query = "UPDATE rewards 
              SET quantity = (quantity - 1) 
              WHERE reward_id = '" . $reward_id . "'";
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());

    $query = "UPDATE projects
              SET raised = (raised + $pledge) 
              WHERE project_id = '" . $project_id . "'";
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());

    $query = "INSERT INTO fundings
            VALUES(DEFAULT, '" . $time . "', '" . $pledge . "', '" . $email . "', '" . $reward_id . "')";
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());
}

function cleanInputString($str) {
  return htmlspecialchars(strip_tags(trim($str)));
}
?>
