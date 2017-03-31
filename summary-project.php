<html>
<head>
  <?php
  include_once("env.php");
  include_once("headers.php");

  $dbconn = pg_connect(pg_connect_string)
  or die('Could not connect: ' . pg_last_error());
  include_once("sqls.php");
  include_once("util.php");

  ?>
  <title>Explore | Projects</title>
</head>

<body>

  <?php
  include_once("navbar.php");
  navbar(URL_PROJECTS_VIEW);

  $project = getProject($_GET['project']);
  $projectBackers = getProjectBackers($_GET['project']);
  $topFunders = getTopFunderByProject($_GET['project']);

  /* CAT:Bar Chart */

  /* pChart library inclusions */
  include("pChart2.1.4/class/pData.class.php");
  include("pChart2.1.4/class/pDraw.class.php");
  include("pChart2.1.4/class/pImage.class.php");

  include_once("env.php");

  $dbconn = pg_connect(pg_connect_string)
  or die('Could not connect: ' . pg_last_error());
  include_once("sqls.php");

  //$project = getProject($_GET['project']);
  $now = new \DateTime('now');
  $currentMonth = $now->format('m');
  $currentYear = $now->format('Y');
  $arrayMonth = array();
  $arrayCount = array();
  $arrayTotal = array();

  for ($x = 0; $x <= 12; $x++) {
    if($currentMonth==1){
      $fundingCount = getFundingCountByMonth($project[0],$currentYear,$currentMonth);
      $fundingTotal = getFundingTotalByMonth($project[0],$currentYear,$currentMonth);
      $arrayCount[] = $fundingCount[0];
      $arrayTotal[] = $fundingTotal[0];
      $arrayMonth[] = "Jan {$currentYear}";
      $currentMonth = 12;
      $currentYear = $currentYear - 1;
    }else{
      $fundingCount = getFundingCountByMonth($project[0],$currentYear,$currentMonth);
      $fundingTotal = getFundingTotalByMonth($project[0],$currentYear,$currentMonth);
      $arrayCount[] = $fundingCount[0];
      $arrayTotal[] = $fundingTotal[0];
      if($currentMonth==2){
        $arrayMonth[] = "Feb {$currentYear}";
      }else if($currentMonth==3){
        $arrayMonth[] = "Mar {$currentYear}";
      }else if($currentMonth==4){
        $arrayMonth[] = "Apr {$currentYear}";
      }else if($currentMonth==5){
        $arrayMonth[] = "May {$currentYear}";
      }else if($currentMonth==6){
        $arrayMonth[] = "Jun {$currentYear}";
      }else if($currentMonth==7){
        $arrayMonth[] = "Jul {$currentYear}";
      }else if($currentMonth==8){
        $arrayMonth[] = "Aug {$currentYear}";
      }else if($currentMonth==9){
        $arrayMonth[] = "Sep {$currentYear}";
      }else if($currentMonth==10){
        $arrayMonth[] = "Oct {$currentYear}";
      }else if($currentMonth==11){
        $arrayMonth[] = "Nov {$currentYear}";
      }else if($currentMonth==12){
        $arrayMonth[] = "Dec {$currentYear}";
      }
      $currentMonth = $currentMonth - 1;
    }
  }

  /* Create and populate the pData object */
  $MyData = new pData();
  $MyData->loadPalette("pChart2.1.4/palettes/blind.color",TRUE);
  $MyData->addPoints($arrayTotal,"Amount");
  $MyData->addPoints($arrayMonth,"Months");
  $MyData->setSerieDescription("Months","Month");
  $MyData->setAbscissa("Months");

  /* Create the pChart object */
  $myPicture = new pImage(700,370,$MyData);

  /* Set the default font */
  $myPicture->setFontProperties(array("FontName"=>"pChart2.1.4/fonts/Forgotte.ttf","FontSize"=>13,"R"=>110,"G"=>110,"B"=>110));

  /* Write the chart title */
  $myPicture->setFontProperties(array("FontName"=>"pChart2.1.4/fonts/Forgotte.ttf","FontSize"=>11));
  $myPicture->drawText(100,30,"Funding Summary",array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE));

  /* Set the graphical area  */
  $myPicture->setGraphArea(60,60,680,300);

  /* Draw the scale  */
  $AxisBoundaries = array(0=>array("Min"=>0,"Max"=>$project[8]+1000));
  $myPicture->drawScale(array("InnerTickWidth"=>0,"OuterTickWidth"=>0,"Mode"=>SCALE_MODE_MANUAL,"ManualScale"=>$AxisBoundaries,"DrawXLines"=>FALSE,"GridR"=>0,"GridG"=>0,"GridB"=>0,"GridTicks"=>0,"GridAlpha"=>30,"AxisAlpha"=>0));

  /* Turn on shadow computing */
  $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));

  /* Draw the chart */
  $settings = array("DisplayValues"=>TRUE,"DisplayColor"=>DISPLAY_AUTO,"Rounded"=>TRUE,"Surrounding"=>60);
  $myPicture->drawBarChart($settings);

  /* Render the picture (choose the best way) */
  //$myPicture->autoOutput("pictures/example.drawBarChart.span.png");
  //$myPicture->autoOutput("img/funding-barchart.png");
  $myPicture->Render("img/funding-barchart.png");

  $filename = 'img/funding-barchart.png';
  $filemtime = filemtime($filename);

  // include ("funding-barchart.php?project=$project[0]");
  // exec("funding-barchart.php?project=$project[0]");
  // $execute = `funding-barchart.php?project=$project[0]`;
  // echo $execute;

  /* CAT:Line chart */
  /* Create and populate the pData object */
  $MyData = new pData();
  $MyData->addPoints($arrayCount,"Funders Count");
  $MyData->setAxisName(0,"No. of Funders");
  $MyData->addPoints($arrayMonth,"Labels");
  $MyData->setSerieDescription("Labels","Months");
  $MyData->setAbscissa("Labels");
  $MyData->setPalette("Funders Count",array("R"=>55,"G"=>91,"B"=>127));

  /* Create the pChart object */
  $myPicture = new pImage(700,370,$MyData);

  /* Draw the background */
  $Settings = array("R"=>255, "G"=>255, "B"=>255, "Dash"=>3, "DashR"=>255, "DashG"=>255, "DashB"=>255);
  $myPicture->drawFilledRectangle(0,0,700,370,$Settings);

  /* Overlay with a gradient */
  $Settings = array("StartR"=>255, "StartG"=>255, "StartB"=>255, "EndR"=>255, "EndG"=>255, "EndB"=>255, "Alpha"=>50);
  $myPicture->drawGradientArea(0,0,700,370,DIRECTION_VERTICAL,$Settings);

  /* Write the chart title */
  $myPicture->setFontProperties(array("FontName"=>"pChart2.1.4/fonts/Forgotte.ttf","FontSize"=>11));
  $myPicture->drawText(100,30,"Number of Funders",array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE));

  /* Draw the scale and the 1st chart */
  $myPicture->setGraphArea(60,60,680,300);
  $myPicture->drawFilledRectangle(60,60,680,300,array("R"=>255,"G"=>255,"B"=>255,"Surrounding"=>-200,"Alpha"=>10));
  $myPicture->drawScale(array("DrawSubTicks"=>TRUE));
  $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
  $myPicture->setFontProperties(array("FontName"=>"pChart2.1.4/fonts/Forgotte.ttf","FontSize"=>15));
  $myPicture->drawLineChart(array("DisplayValues"=>TRUE,"DisplayColor"=>DISPLAY_AUTO));
  $myPicture->setShadow(FALSE);

  /* Render the picture (choose the best way) */
  $myPicture->Render("img/funding-linechart.png");

  $filename2 = 'img/funding-linechart.png';
  $filemtime2 = filemtime($filename);
  ?>

  <div class="container">

    <div class="box-padding">
      <h1><?php echo $project[1]?> Funding Analysis</h1>
      <h4><i>by <a><?php echo $project[2] ?></a></i></h4>
    </div>

    <br />

    <div class="row" >
      <div class="col-sm-12 col-md-8">
        <div class="panel panel-default" style="max-height: 100%" >
          <img style="max-width: 100%; height: auto" src="<?php echo $filename ?>?<?php echo $filemtime ?>" alt="">
        </div>
      </div>

      <div class="col-sm-12 col-md-4">
        <div class="panel panel-default" style="max-height: 100%" >
          <div class="panel-body" >

            <div class="progress">
              <div class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo calculatePercantage($project[8], $project[7])?>%">
              </div>
            </div>

            <div class="content-padding">

              <div class="red"><h1><b>$<?php echo $project[8] ?></b></h1></div>
              <div>pledged of $<?php echo $project[7] ?> goal</div>

              <div><h3><?php echo $projectBackers[0] ?></h3></div>
              <div>backers</div>

              <div><h3><?php echo dateDifference($project[6]) ?></h3></div>
              <div>Days Left (<?php echo $project[6] ?>)</div>
            </div>
            <br />
          </div>
        </div>
      </div>
    </div>
    <div class="row" >
      <div class="col-sm-12 col-md-8">
        <div class="panel panel-default" style="max-height: 100%" >
          <img style="max-width: 100%; height: auto" src="<?php echo $filename2 ?>?<?php echo $filemtime2 ?>" alt="">
        </div>
      </div>

      <div class="col-sm-12 col-md-4">
        <div class="panel panel-default" style="max-height: 100%" >
          <div class="panel-body" >


            <div class="black"><h3><b>Top 5 Funders</b></h3></div>
            <div width:360px>
              <table class="table">
                <thead class="thead-default">
                  <tr>
                    <th>Rank</th>
                    <th>Username</th>
                    <th>Funded</th>
                  </tr>
                </thead>
                <tbody style="font-size: 12px">
                  <?php
                  while ($row = pg_fetch_row($topFunders)) { ?>
                    <tr>
                      <td><?php echo $row[2] ?></a></td>
                      <td style="word-wrap: break-word;min-width: 160px;max-width: 100px;"><?php echo $row[0] ?></td>
                      <td>$<?php echo $row[1] ?></td>
                    </tr>
                    <?php }
                    ?>
                  </tbody>
                </table>
              </div>
              <br />
            </div>
          </div>
        </div>
      </div>


      <br /> <br />

    </div>



    <?php
    include("footer.php");
    pg_close($dbconn);
    ?>
  </body>
  </html>
