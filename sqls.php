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
    $query = 'SELECT p.project_id, p.title, p.description, u.username, p.img_src FROM projects p, users u WHERE p.creator = u.username';
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
  $query = "SELECT u.username FROM users u WHERE u.username = '$username'";
  $result = pg_query($query) or die('Query failed: ' . pg_last_error());
  $bool = pg_num_rows($result) == 1;
  pg_free_result($result);
  echo $bool;
  return $bool;
}

function getFirstName($username) {
  $query = "SELECT u.fullname FROM users u WHERE u.username = '$username'";
  $result = pg_query($query) or die('Query failed: ' . pg_last_error());

  $data = pg_fetch_row($result)[0];
  pg_free_result($result);
  return $data;
}


function getProject($projectId){
  $query = "SELECT * FROM projects p WHERE p.project_id='$projectId'";
  $result = pg_query($query) or die('Query failed: ' . pg_last_error());

  $data = pg_fetch_row($result);
  pg_free_result($result);
  return $data;
}

function getProjectRewards($projectId){
  $query = "SELECT r.reward_id, r.title, r.pledge, r.description, r.quantity FROM rewards r, projects p WHERE r.project_id = p.project_id AND p.project_id='$projectId'";
  $result = pg_query($query) or die('Query failed: ' . pg_last_error());

  while($row = pg_fetch_row($result)) {
    echo '<div class="col-md-4">';
    echo '<div class="panel panel-default"> <div class="panel-body" style="padding: 20px; background-color: #C6D5DB;">';
    echo '<h2>$' . $row[2] . ' or more</h2>';
    echo '<br />';
    echo '<div >' . $row[1] . '</div>';
    echo '<div class="small">' . $row[3] . '</div>';
    echo '<br /><br />';
    echo '</div></div>';
    echo '</div>';
  }
  pg_free_result($result);
}

function updateProject($projectId, $title, $description, $blurb){
  $query = "UPDATE projects SET title = '$title', description = '$description', blurb = '$blurb' WHERE project_id = '$projectId'";
  $result = pg_query($query) or die('Query failed: ' . pg_last_error());
  pg_free_result($result);
}

function createProject($title, $creator, $img_src, $description, $start_date, $end_date, $goal, $raised) {
  $query = "INSERT INTO Projects VALUES(DEFAULT, '$title', '$creator', '$img_src', '$description', '$start_date', '$end_date', '$goal', '$raised')";
  echo $query;
  $result = pg_query($query) or die('Query failed: ' . pg_last_error());
}
?>
