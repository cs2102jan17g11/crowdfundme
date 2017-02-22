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
      <div class="col-sm-12 col-md-8">

        <div class="panel panel-default">
          <div class="panel-heading">Edit Project: Project Name</div>
          <div class="panel-body">

            <form>
              <div class="col-sm-12 col-md-8">

                <div class="form-group">
                  <label for="inputTitle">Project Title</label>
                  <input type="title" class="form-control" id="inputTitle" placeholder="Enter project title">
                </div>

                <div class="form-group">
                  <label for="projectDescription">Description</label>
                  <textarea class="form-control" id="projectDescription" rows="5"></textarea>
                </div>

                <div class="form-group">
                  <label for="imageUrl">Project Image</label>
                  <input type="file" hidden id="imageUrl">
                </div>

              </div>
            </form>

          </div>
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
