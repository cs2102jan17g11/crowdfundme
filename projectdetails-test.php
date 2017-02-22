<html>
<head>
  <?php
  include_once("env.php");
  include_once("headers.php");

  $dbconn = pg_connect(pg_connect_string)
  or die('Could not connect: ' . pg_last_error());
  include_once("sqls.php");
  ?>
  <title>Explore | Projects</title>
</head>

<body>
  <?php
  include_once("navbar.php");
  navbar(URL_PROJECTS_VIEW);
  ?>

  <div class="container">
    <div class="row row-offcanvas row-offcanvas-right">
      <div class="col-xs-12 col-sm-9">
        <div class="jumbotron">
          <h1>
            <?php
            $query = "SELECT name FROM projects WHERE name='DBMS'";
            $result = pg_query($query) or die('Query failed: ' . pg_last_error());
            while ($row = pg_fetch_row($result)){
              echo $row[0] ;
            }
            ?>
          </h1>
          <p>
            <?php
            $query = "SELECT contents FROM projects WHERE name='DBMS'";
            $result = pg_query($query) or die('Query failed: ' . pg_last_error());
            while ($row = pg_fetch_row($result)){
              echo $row[0] ;
            }
            ?>
          </p>
        </div>
      </div>
      <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar">
        <?php
        $query = "SELECT name FROM projects";
        $result = pg_query($query) or die('Query failed: ' . pg_last_error());
        while ($row = pg_fetch_array($result)){
          echo '<a href="#" class="list-group-item">' . $row['name']. '</a>';
        }
        ?>
      </div>
      <form>
        Title: <input type="text" name="name">
        Content: <input type="text" name="contents">
        <input type="submit" name="formSubmit" value="Search" >
      </form>

      <?php
      if(isset($_GET['formSubmit']))
      {
        $query = "SELECT name, contents FROM projects WHERE name like '%".$_GET['name']."%' AND contents like '%".$_GET['contents']."%' ";
        echo "<b>SQL:   </b>".$query."<br><br>";
        $result = pg_query($query) or die('Query failed: ' . pg_last_error());
        while ($row = pg_fetch_array($result)){
          echo '<a href="#" class="list-group-item">' . $row['name']. '</a>';
        }
        pg_free_result($result);
      }
      ?>

      <form method="post">
        Title: <input type="text" name="name">
        Content: <input type="text" name="contents">
        <select name="owner"> <option value="">Select owner</option>

          <?php
          $query = 'SELECT username FROM users';
          $result = pg_query($query) or die('Query failed: ' . pg_last_error());

          while ($row = pg_fetch_array($result)){
            echo "<option value=\"".$row[0]."\">".$row[0]."</option><br>";
          }

          pg_free_result($result);
          ?>
        </select>
        <input type="submit" name="formCreate" value="Create Project" >
        <?php
        $submitbutton= $_POST['formCreate'];
        if($submitbutton){
          createProject($name,$contents,$owner);
        }
        ?>

      </form>
    </div>

  </div>
  <?php
  include("footer.php");
  pg_close($dbconn);
  ?>
</body>
</html>
