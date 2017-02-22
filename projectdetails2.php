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
    <div class="row">
      <div class="col-sm-12 col-md-10">
        <div class="box-padding">
          <h2>Project Name</h2>
        </div>

      </div>
      <div class="col-sm-12 col-md-2">
        <div class="box-padding">
          <h2>User</h2>
        </div>
      </div>
    </div>

    <br /> <br />

    <div class="row" >
      <div class="col-sm-12 col-md-8">
        <img style="max-width: 100%; height: auto" src="https://ksr-ugc.imgix.net/assets/015/340/331/b7113129722cef5202fe1fa0e42b5219_original.jpg?w=1024&h=576&fit=fill&bg=000000&v=1485814892&auto=format&q=92&s=994f77beee18de747136256cb69c2f1d" alt="">
      </div>

      <div class="col-sm-12 col-md-4">
          <div class="panel panel-default" style="max-height: 100%" >
            <div class="panel-body" >

                

            </div>
          </div>

        </div>
    </div>

    <br /> <br />

    <div class="row">
      <div class="col-sm-12 col-md-12">
          <div class="panel panel-default">
            <div class="panel-body">
              <h2>Project Descriptions</h2>
            </div>
          </div>
        </div>
    </div>



    <?php
    include("footer.php");
    pg_close($dbconn);
    ?>
  </body>
  </html>
