<?php
include_once("../util.php");

function cardHtml($project_id) {
  $result = pg_query_params('
      SELECT p.project_id, p.title, p.description, u.first_name, p.img_src, project_progress(p.project_id), p.end_date, p.raised
      FROM projects p INNER JOIN users u ON p.creator = u.email
      WHERE p.project_id = $1', array($project_id)) or die('Query failed: ' . pg_last_error());

  $data = pg_fetch_row($result);
  pg_free_result($result);

  $query = "SELECT COUNT(*)
              FROM fundings f, rewards r, projects p
              WHERE r.reward_id = f.reward_id 
              AND p.project_id = r.project_id
              AND p.project_id = '" . $project_id . "' 
              GROUP BY p.project_id";
              // use GROUP BY to get count = 0 when no matching case
  $result = pg_query($query) or die('Query failed: ' . pg_last_error());

  $backers = pg_fetch_row($result)[0];
  pg_free_result($result);

  $backers = '<span style="color: red;" class="glyphicon glyphicon-heart"></span> ' . $backers;

  $date = dateDifference($data[6]);
  $date = $date == 0 ? 'Funded!' : $date;

  $raised = '$' . number_format($data[7], 0, '', ',');

  echo '<div class="col-md-4">
          <div>
            <a href="projectdetails.php?project=' . $data[0] . '">
              <img src="' .$data[4] . '" style="max-width:100%;" />
            </a>
          </div>
          <div class="panel panel-default card">
            <div class="panel-body card-content" style="padding: 0 20px">
              <a href="projectdetails.php?project=' . $data[0] . '">
                <h3>' . $data[1] . '</h3>
              </a>
              <p>
                by <a>' . $data[3] . '</a>
              </p>
              <br />
                
              <p class="small ellipsis">
                ' . $data[2] . '
              </p>
            </div>
            <div class="panel-footer">
              <div class="progress">
                <div class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width:' . $data[5] * 100 . '%">
                </div>
              </div>
            </div>
            <div class="panel-footer">
              <table class="table">
                <thead class="small">
                  <tr>
                    <th>
                      Backers
                    </th>
                    <th>Funded</th>
                    <th>Days to go</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>' . $backers . '</td>
                    <td>' . $raised . '</td>
                    <td>' . $date . '</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>';

}
?>