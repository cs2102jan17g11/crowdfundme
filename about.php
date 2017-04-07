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
    <title>About</title>
</head>

<body>

<?php
    include_once("navbar.php");
    navbar(URL_ABOUT);
?>

<div class="splash about">
    <div class="splash-opacity">
      <div class="container">
      <div class="row">
        <div class="col-md-4 pull-right">
          <br  />
          <h1>The best concepts, ever.</h1>
          <br />
          <hr class="half-rule"/>
          <br /><br />
          <h4>
            At <span class="red">Crowdfundmeeeee</span>, our mission is to empower people to unite around ideas that matter to them, and together make those ideas come to <span class="red">life</span>.<br />Every inventive idea should have its shot, and every creative entrepreneur should have their moment.
          </h4>
        </div>
      </div>
      </div>
    </div>
</div>
<br />
<div class="container">
    <div class="row" >
        <div class="col-sm-12 col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="content-padding">
                        <h3><b>Our History</b></h3><br />
                        Crowdfundmeeeee launched in April 2017 to shift the power into your hands - to empower creative,
                        entrepreneurial people everywhere to bring their ideas to life. We wanted to create a platform
                        to allow creative people to work together, because that's when amazing things happen.
                    </div>
                    <br />
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="content-padding">
                        <h3><b>Our Mission</b></h3><br />
                        We believe that anyone with creativity and passion should be empowered to seize their own success.
                        To make that happen, we’re removing the barriers that creators face in bringing their projects
                        to life and connecting entrepreneurs like you to a global audience of passionate backers.
                    </div>
                    <br />
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="content-padding">
                        <h3><b>Our Community</b></h3><br />
                        Crowdfundmeeeee aims to grow into an enormous global community built around creativity and creative
                        projects. We will connect entrepreneurs like you to a global audience of passionate backers. Everyone
                        will have control over their work and the opportunity to share it with a vibrant community of backers.
                    </div>
                    <br />
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <center>
            <h3><b>Dream it. Fund it. Make it.</b></h3>
                <h5>Crowdfundmeeeee gives you the space to work with people who know you, love you, and support you.</h5>
            </center>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <center>
                <h3><b>Frequently Asked Questions</b></h3><br>
            </center>
            <div class="row" >
            <div class="col-sm-12 col-md-6">
                        <div class="content-padding">
                            <h4><b>How do I know if my project is right?</b></h4><br />
                            No matter what you're into, we bet you'll feel right at home around here!
                            Art, architecture, technology, films, DIY - if it's a creative, entrepreneurial project
                            it’s probably a great fit. Whether you're just getting started with an idea or are
                            looking for a marketplace solution, there's a home for your project on Crowdfundmeeeee.
                        </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="content-padding">
                    <h4><b>My product was crowdfunded elsewhere, can I still use Crowdfundmeeeee?</b></h4><br />
                    Yes! As long as your product was part of a crowdfunding campaign, whether at Crowdfundmeeeee or on
                    another site, you’re eligible to use Crowdfundmeeeee and reach out to our community of passionate backers.
                </div>
            </div>
            </div>
            <br><br>
            <div class="row" >
                <div class="col-sm-12 col-md-6">
                    <div class="content-padding">
                        <h4><b>Why do people back projects?</b></h4><br />
                        Many backers are rallying around their friends' projects. Some are supporting a new effort from
                        someone they've long admired. Some are just inspired by a new idea, while others are motivated
                        to pledge by a project's rewards.
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="content-padding">
                        <h4><b>Where do backers come from?</b></h4><br />
                        The majority of initial funding usually comes from the fans and friends of each project. If they
                        like it, they'll spread the word to their friends, and so on. Press, blogs, Twitter, Facebook,
                        and Crowdfundmeeeee itself are also big sources of traffic and pledges.
                    </div>
                </div>
            </div>
            <br />
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <center>
                <h3><b>Ready to go?</b></h3>
            </center>
            <div class="row">
                <div class="col-sm-12 col-md-3"></div>
                <div class="col-sm-12 col-md-3">
                    <div class="content-padding">
                        Take the plunge and start your entrepreneurial adventure on Crowdfundmeeeee. <br><br>
                        <a href="/projects/create.php" class="btn btn-primary btn-block" role="button">Create Project</a>
                    </div>
                </div>
                <div class="col-sm-12 col-md-3">
                    <div class="content-padding">
                        Join our community of passionate backers and back and project that inspires you. <br><br>
                        <a href="/projects.php" class="btn btn-primary btn-block" role="button">Back Projects</a>
                    </div>
                </div>
                <div class="col-sm-12 col-md-3"></div>
            </div>
            <br />
        </div>
    </div>
</div>



<?php
include("footer.php");
pg_close($dbconn);
?>
</body>
</html>
