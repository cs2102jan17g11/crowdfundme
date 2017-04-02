<?php

include_once("sql_functions/shared_html_rendering.php");

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
  $query = '
  SELECT p.project_id
  FROM projects p';
  $result = pg_query($query) or die('Query failed: ' . pg_last_error());

  while($row = pg_fetch_row($result)) {
    cardHtml($row[0]);
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
  $query = "SELECT * FROM projects p WHERE p.project_id= $projectId ;";
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

function getReward($rewardId){
  $query = "SELECT * FROM rewards r WHERE r.reward_id= $rewardId ;";
  $result = pg_query($query) or die('Query failed: ' . pg_last_error());

  $data = pg_fetch_row($result);
  pg_free_result($result);
  return $data;
}

function updateProject($projectId,$title,$description,$img_src){
  if (empty($img_src)) {
    $project = getProject($projectId);
    $img_src = $project[3];
  }

  $query = "UPDATE projects SET title = '$title', description = '$description', img_src = '$img_src' WHERE project_id = $projectId";
  $result = pg_query($query) or die('Query failed: ' . pg_last_error());
  pg_free_result($result);
}

function updateReward($rewardId, $title, $description,$quantity,$pledge){
  $query = "UPDATE rewards
  SET title = '$title' , description = '$description' , quantity=$quantity, pledge=$pledge
  WHERE reward_id=$rewardId";
  $result = pg_query($query) or die('Query failed: ' . pg_last_error());
  pg_free_result($result);
}

function checkDeleteProject($projectId){
  $query = "SELECT COUNT(f.*) FROM projects p, fundings f, rewards r WHERE p.project_id=r.project_id AND r.reward_id=f.reward_id AND p.project_id=$projectId;";
  $result = pg_query($query) or die('Query failed: ' . pg_last_error());
  $row = pg_fetch_array($result);
  if($row[0] > 0){
    return false;
  }else{
    return true;
  }
}

function deleteProject($projectId){
  $query = "DELETE FROM projects where project_id=$projectId";
  $result = pg_query($query) or die('Query failed: ' . pg_last_error());
  echo '<script>location.replace("projects.php");</script>';
}

function checkDeleteReward($rewardId){
  $query = "SELECT EXISTS(SELECT 1 FROM fundings WHERE reward_id=$rewardId);";
  $result = pg_query($query) or die('Query failed: ' . pg_last_error());
  $row = pg_fetch_array($result);
  if($row[0] == t){
    return false;
  }else{
    return true;
  }
}

function deleteReward($rewardId){
  $query = "DELETE FROM rewards where reward_id=$rewardId";
  $result = pg_query($query) or die('Query failed: ' . pg_last_error());
}

function getFundingCountByMonth($projectId, $year, $month){
  $query = "SELECT COUNT(f.*)
FROM fundings f, projects p, rewards r
WHERE EXTRACT(MONTH FROM f.funding_datetime) = $month
AND EXTRACT(YEAR FROM f.funding_datetime) = $year
AND p.project_id=r.project_id
AND r.reward_id=f.reward_id
AND p.project_id=$projectId";

  $result = pg_query($query) or die('Query failed: ' . pg_last_error());
  $data = pg_fetch_row($result);
  return $data;
}

function getFundingTotalByMonth($projectId, $year, $month){
  $query = "SELECT SUM(f.amount)
FROM fundings f, projects p, rewards r
WHERE EXTRACT(MONTH FROM f.funding_datetime) = $month
AND EXTRACT(YEAR FROM f.funding_datetime) = $year
AND p.project_id=r.project_id
AND r.reward_id=f.reward_id
AND p.project_id=$projectId";

  $result = pg_query($query) or die('Query failed: ' . pg_last_error());
  $data = pg_fetch_row($result);
  return $data;
}

function getTopFunderByProject($projectId){
  $query = "SELECT f.email, SUM(f.amount),
rank() OVER (ORDER BY SUM(f.amount) DESC) AS rank
FROM projects p, fundings f, rewards r
WHERE p.project_id = r.project_id
AND r.reward_id = f.reward_id
AND p.project_id = $projectId
GROUP BY f.email
ORDER BY SUM(f.amount) DESC
LIMIT 5";
  $result = pg_query($query) or die('Query failed: ' . pg_last_error());
  return $result;
}

function createProject($title, $creator, $img_src, $description, $start_date, $end_date, $goal, $raised) {
  $start_date = $start_date == '' ? NULL : $start_date;
  $end_date = $end_date == '' ? NULL : $end_date;
  $goal = intval($goal);
  $raised = intval($raised);
  $params = array($title, $creator, $img_src, $description, $start_date, $end_date, $goal, $raised);
  $result = pg_query_params('INSERT INTO Projects VALUES(DEFAULT, $1, $2, $3, $4, $5, $6, $7, $8) RETURNING project_id', $params) or die('Query failed: ' . pg_last_error());
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

function createUser($email, $first_name, $last_name, $hashedpassword, $role) {
  $query = "INSERT INTO users
  (email,first_name,last_name,password,role)
  VALUES('" . $email . "', '" . $first_name . "', '" . $last_name . "', '" . $hashedpassword . "', '" . $role . "')";
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
  $query = "SELECT pledge FROM rewards r WHERE r.reward_id = " . $reward_id;
  $result = pg_query($query) or die('Query failed: ' . pg_last_error());
  $pledge_is_without_reward = pg_fetch_row($result)[0] == 0;

  pg_free_result($result);
  
  // shouldn't decrease quantity for rewards which are unlimited
  if($pledge_is_without_reward == false) {
    $query = "UPDATE rewards
    SET quantity = (quantity - 1)
    WHERE reward_id = '" . $reward_id . "'";
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());
  }

  $query = "UPDATE projects
  SET raised = (raised + $pledge)
  WHERE project_id = '" . $project_id . "'";
  $result = pg_query($query) or die('Query failed: ' . pg_last_error());

  $query = "INSERT INTO fundings
  VALUES(DEFAULT, '" . $time . "', '" . $pledge . "', '" . $email . "', '" . $reward_id . "')";
  $result = pg_query($query) or die('Query failed: ' . pg_last_error());
}

function getProjectBackers($project_id) {
  $query = "SELECT COUNT(*)
  FROM fundings f, rewards r, projects p
  WHERE r.reward_id = f.reward_id
  AND p.project_id = r.project_id
  AND p.project_id = '" . $project_id . "'
  GROUP BY p.project_id";
  $result = pg_query($query) or die('Query failed: ' . pg_last_error());

  $data = pg_fetch_row($result);
  pg_free_result($result);
  return $data;
}

function getAllUsers($email, $role) {
  $query = "SELECT u.first_name, u.last_name, u.email, u.role
  FROM users u
  WHERE u.email NOT IN (
    SELECT u1.email
    FROM users u1
    WHERE u1.email = '". $email . "'
    )
    AND u.role = '". $role . "'
    ORDER BY u.first_name, u.last_name";
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());

    return $result;
  }

  function deleteUser($email) {
    $query = "DELETE
    FROM users u
    WHERE u.email = '" . $email . "'";
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());
  }

  function getUserRole($email) {
    $query = "SELECT u.role
    FROM users u
    WHERE u.email = '" . $email . "'";
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());

    $data = pg_fetch_row($result);
    pg_free_result($result);
    return $data[0];
  }

  function cleanInputString($str) {
    return htmlspecialchars(strip_tags(trim($str)));
  }

  function createReward($project_id, $title, $description, $pledge, $quantity, $isPledgeWithoutRewards) {
    if($isPledgeWithoutRewards == true) {
      $pledge = 0;
      $quantity = 0;
    }

    $params = array($title, $pledge, $description, $quantity, $project_id);
    $query = "INSERT INTO rewards(reward_id, title, pledge, description, quantity, project_id) VALUES(DEFAULT, $1, $2, $3, $4, $5)"; 
    $result = pg_query_params($query, $params) or die('Query failed: ' . pg_last_error());
    pg_free_result($result);
  }
?>
