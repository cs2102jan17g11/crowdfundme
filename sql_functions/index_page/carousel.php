<?php

function selectTopBackedProjects($limit) {
  $result = pg_query_params('
    SELECT r.project_id
    FROM fundings f, rewards r 
    WHERE r.reward_id = f.reward_id 
    GROUP BY r.project_id 
    ORDER BY COUNT(*) DESC 
    LIMIT $1', array($limit)) or die('Query failed: ' . pg_last_error());

  $arr = pg_fetch_all($result);
  $prop_project_id = function($a) { // pick prop: project_id
    return $a['project_id'];
  };
  pg_free_result($result);
  return array_map($prop_project_id, $arr);
}

function selectTopTrendingProjects($limit) {
  $result = pg_query_params('
    SELECT p.project_id
    FROM projects p 
    WHERE funding_percent(p.project_id) IS NOT NULL 
    ORDER BY funding_percent(p.project_id) DESC limit $1', array($limit)) or die('Query failed: ' . pg_last_error());

  $arr = pg_fetch_all($result);
  pg_free_result($result);
  $prop_project_id = function($a) { // pick prop
    return $a['project_id'];
  };
  return array_map($prop_project_id, $arr);
}

// echos given project in bootstrap carousel's item format
function carouselHtml($project_id) {
  $result = pg_query_params("
    SELECT p.title, p.creator, p.img_src, p.description
    FROM projects p
    WHERE p.project_id = $1"
  , array($project_id)) or die('Query failed: ' . pg_last_error());

  $data = pg_fetch_row($result);

  echo '<div class="row">
          <div class="col-md-6">
            <a href="projectdetails.php?project=' . $project_id . '">
              <img src="' . $data[2] .'" style="max-width: 100%">
            </a>
          </div>
          <div class="col-md-5">
            <a href="projectdetails.php?project=' . $project_id . '">
              <h3>' . $data[0] .'</h3>
            </a>  
            <p style="height: 10rem;">' . $data[3] . '</p>
          </div>
        </div>';
  pg_free_result($result);
}

?>