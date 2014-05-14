<?php 
  
  if(!empty($tournament['name']))
  {
      $title = $tournament['name'];
  }
  else
  {
      $title = "";
  } 

?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="<?php echo asset('css/bootstrap.min.css') ?> ">
        <style>
            body {
                padding-top: 50px;
                padding-bottom: 20px;
            }
        </style>

        <link rel="stylesheet" href="<?php echo asset('css/bootstrap-theme.min.css') ?>">
        <link rel="stylesheet" href="<?php echo asset('css/main.css') ?>">

        <script src="<?php echo asset('js/vendor/modernizr-2.6.2-respond-1.1.0.min.js') ?>"></script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>

          <a class="navbar-brand" href="#"></a>
        </div>
       
      </div>
    </div>


    <div class="container">
      <!-- Example row of columns -->
      <h1>Tournament: <?php echo $title ?></h1>
      <div class="row">
          <div class="col-md-4">
          <h2>Players</h2>
              <div id="playerChart">
                  <?php
                      $i = 1;
                      echo "<table class='table'>";
                      echo "<thead><tr><th>Name</th><th>Score</th><th>Place</th></tr></thead>";
                      foreach($players as $item)
                      {
                          echo "<tr>";
                          // echo "<td>".$i."</td>";
                          echo "<td>".$item['name']."</td>";
                          echo "<td>".$item['score']."</td>";
                          echo "<td>".$item['place']."</td>";
                          echo "</tr>";
                          // $i++;
                      }
                      echo "</table>";
                  ?>
              </div>
          </div>
          <div class="row">
            <div class="col-md-4">
                 <h2>Information</h2>
                 <h4>Live URL:</h4> Coming soon <br />
            </div>
      </div>
      <hr>

      <footer>
        <p>&copy; Company 2014</p>
      </footer>
    </div> <!-- /container -->        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.0.min.js"><\/script>')</script>

        <script src="<?php echo asset('js/vendor/bootstrap.min.js') ?>"></script>

        <script src="<?php echo asset('js/tournament.js') ?>"></script>

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='//www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-XXXXX-X');ga('send','pageview');
        </script>
    </body>
</html>