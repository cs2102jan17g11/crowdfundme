<?php
function selectTopTrendingProjects($limit) {
  $result = pg_query_params('
    SELECT p.project_id, funding_percent(p.project_id) AS pp 
    FROM projects p 
    WHERE funding_percent(p.project_id) IS NOT NULL 
    ORDER BY pp DESC limit $1', array($limit)) or die('Query failed: ' . pg_last_error());

  $arr = pg_fetch_all($result);

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
          <div class="col-xs-6">
            <a href="projectdetails.php?project=' . $project_id . '">
              <img src="' . $data[2] .'" style="max-width: 100%">
            </a>
          </div>
          <div class="col-xs-6">
            <a href="projectdetails.php?project=' . $project_id . '">
              <h3>' . $data[0] .'</h3>
            </a>  
            <p>' . $data[3] . '</p>
          </div>
        </div>';
  pg_free_result($result);
}

?>