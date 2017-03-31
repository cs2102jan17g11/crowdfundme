<?php
/* CAT:Bar Chart */

/* pChart library inclusions */
include("pChart2.1.4/class/pData.class.php");
include("pChart2.1.4/class/pDraw.class.php");
include("pChart2.1.4/class/pImage.class.php");

include_once("env.php");

$dbconn = pg_connect(pg_connect_string)
or die('Could not connect: ' . pg_last_error());
include_once("sqls.php");

$project = getProject($_GET['project']);
$now = new \DateTime('now');
$currentMonth = $now->format('m');
$currentYear = $now->format('Y');
$arrayMonth = array();
$arrayCount = array();
$arrayTotal = array();

for ($x = 0; $x <= 6; $x++) {
  if($currentMonth==01){
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
    if($currentMonth==02){
      $arrayMonth[] = "Feb {$currentYear}";
    }else if($currentMonth==03){
      $arrayMonth[] = "Mar {$currentYear}";
    }else if($currentMonth==04){
      $arrayMonth[] = "Apr {$currentYear}";
    }else if($currentMonth==05){
      $arrayMonth[] = "May {$currentYear}";
    }else if($currentMonth==06){
      $arrayMonth[] = "Jun {$currentYear}";
    }else if($currentMonth==07){
      $arrayMonth[] = "Jul {$currentYear}";
    }else if($currentMonth==08){
      $arrayMonth[] = "Aug {$currentYear}";
    }else if($currentMonth==09){
      $arrayMonth[] = "Sep {$currentYear}";
    }else if($currentMonth==10){
      $arrayMonth[] = "Oct {$currentYear}";
    }else if($currentMonth==11){
      $arrayMonth[] = "Nov {$currentYear}";
    }else{
      $arrayMonth[] = "Dec {$currentYear}";
    }
    $currentMonth = $currentMonth - 1;
  }
}
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

/* Add a border to the picture */
$myPicture->drawRectangle(0,0,699,369,array("R"=>0,"G"=>0,"B"=>0));

/* Write the chart title */
$myPicture->setFontProperties(array("FontName"=>"pChart2.1.4/fonts/Forgotte.ttf","FontSize"=>11));
$myPicture->drawText(100,30,"Number of Funders",array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE));

/* Draw the scale and the 1st chart */
$myPicture->setGraphArea(60,60,680,300);
$myPicture->drawFilledRectangle(60,60,680,300,array("R"=>255,"G"=>255,"B"=>255,"Surrounding"=>-200,"Alpha"=>10));
$myPicture->drawScale(array("DrawSubTicks"=>TRUE));
$myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
$myPicture->setFontProperties(array("FontName"=>"pChart2.1.4/fonts/Forgotte.ttf","FontSize"=>6));
$myPicture->drawLineChart(array("DisplayValues"=>TRUE,"DisplayColor"=>DISPLAY_AUTO));
$myPicture->setShadow(FALSE);

/* Render the picture (choose the best way) */
$myPicture->Render("img/funding-linechart.png");
?>
