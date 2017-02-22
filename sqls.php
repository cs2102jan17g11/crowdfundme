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
            echo '<div class="panel panel-default"> <div class="panel-body" style="padding: 20px">';
            echo '<h2><a>' . $row[0] . '</a></h2>';
            echo '<div ><a>' . $row[2] . '</a></div>';
            echo '<br /><br />';
            echo '<div class="small">' . $row[1] . '</div>';
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
    ?>
