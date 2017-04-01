<html>
<head>
  <?php

  include_once("env.php");
  include_once("headers.php");

  $dbconn = pg_connect(pg_connect_string)
  or die('Could not connect: ' . pg_last_error());
  include_once("sqls.php");
  include_once("sql_functions/index_page/carousel.php");
  include_once("sql_functions/shared_html_rendering.php");

  ?>
  <title>Explore | Projects</title>
</head>

<body class="index-body">
  <?php
  include_once("navbar.php");
  navbar(URL_INDEX);
  ?>

  <div class="splash">
    <div class="splash-opacity">
      <div class="container">
      <div class="row">
        <div class="col-md-4 pull-right">
          <br  />
          <h1>Explore the greatest projects, ever.</h1>
          <br /><br />
          <hr class="half-rule"/>
          <br /><br />
          <h4>
            This platform has provided access to some of the greatest ideas and innovations the world has imagined.
            To date, We have over <span class="red"><?php echo countAllProjects() ?></span> projects, click on explore to see them.
          </h4>
        </div>
      </div>
      </div>
    </div>
  </div>

  <div class="container">
  <div class="col-md-12">
    <div class="top-picks">
      <h1>Our Top Picks</h1>

      <div id="mCarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner" role="listbox">
          
          <!-- Carousel indicators -->
          <ol class="carousel-indicators">
            <li data-target="#mCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#mCarousel" data-slide-to="1"></li>
            <li data-target="#mCarousel" data-slide-to="2"></li>
          </ol>

          <!-- load top trending projects into top -->
          <?php $top = selectTopTrendingProjects(3); ?>
          
          <!-- Main item -->
          <div class="item active">
            <?php carouselHtml($top[0]); ?>
          </div>

          <div class="item"> 
            <?php carouselHtml($top[1]); ?>
          </div>

          <div class="item"> 
            <?php carouselHtml($top[2]); ?>
          </div>

          <!-- Carousel controls -->
          <a class="left carousel-control" href="#mCarousel" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="right carousel-control" href="#mCarousel" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div>
    </div>
  </div>
  </div>
  <hr />

  <div class="container">
  <div class="col-md-12">

    <h1>Our Popular Picks</h1>

          <!-- load top backed projects into top -->
          <?php $pop = selectTopBackedProjects(3); ?>

          <?php cardHtml($pop[0]); ?>
          <?php cardHtml($pop[1]); ?>
          <?php cardHtml($pop[2]); ?>

  </div>
  </div>
  <?php
  include("footer.php");
  pg_close($dbconn);
  ?>
</body>
</html>
