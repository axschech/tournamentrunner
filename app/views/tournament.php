<?php 
  $tournament = json_decode($tournament,true);
  if(!empty($tournament['name']))
  {
      $title = $tournament['name'];
  }
  else
  {
      $title = "";
  } 

  $user = json_decode($user,true);

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
        <link rel="stylesheet" href="<?php echo asset('css/bootstrap-notify.css') ?>">

        <script src="<?php echo asset('js/vendor/modernizr-2.6.2-respond-1.1.0.min.js') ?>"></script>
    </head>
    <body>
    <div class='notifications top-right' style="font-size:24px"></div>
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

          <a class="navbar-brand" href="<?=url('/')?>"><?=$user?> / <?=$tournament['name']?> </a>
        </div>
        <div class="navbar-collapse collapse">
          <form action="<?=url('logout')?>" method="POST" class="navbar-form navbar-right" role="form">
            
            <button type="submit" class="btn btn-success">Log Out</button>
          </form>
        </div><!--/.navbar-collapse -->
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
                      echo "<thead><tr><th>Name</th><th>Score</th><th>Place</th><th>Game</th></tr></thead>";
                      foreach(json_decode($players,true) as $item)
                      {
                          echo "<tr>";
                          // echo "<td>".$i."</td>";
                          echo "<td>".$item['name']."</td>";
                          echo "<td>".$item['score']."</td>";
                          echo "<td>".$item['place']."</td>";
                          echo "<td>".$item['game']."</td>";
                          echo "</tr>";
                          // $i++;
                      }
                      echo "</table>";
                  ?>
              </div>
          </div>
            <div class="col-md-6 col-md-offset-2">
                 <h2>Control Panel</h2>
                  <?php
                 if($tournament['active']!=1)
                 {
                  ?>
                  <div id="buttons">
                 <br /><br />
                 <button type="button" id="jumble" class="btn btn-default btn-lg">Randomize Pairings</button>
                 <br />
                 <br />
                 <button type="button" id="start" class="btn btn-default btn-lg btn-success">Start Tournament!</button> <span id="tournament_alert" class="text-danger" style="font-size:24px"></span>
                 <br />
                 <br />
                 <button type="button" id="new" class="btn btn-default btn-lg btn-warning disabled ">Next Game</button>
                 <br />
                 <br />
                  <button type="button" id="done" class="btn btn-default btn-lg btn-danger">End Tournament</button>
                  </div>
                  <?php
                  }
                  else
                  {
                  ?>
                  <div id="buttons">
                    <span id="gameNum" style="font-size:50px"> Game <?=$tournament['game']?> </span>
                     <br /><br />
                 <?php
                    if(!$tournament['roundDone'])
                    {
                 ?>
                 <button type="button" id="new" class="btn btn-default btn-lg btn-warning disabled ">Next Game</button>
                 <?php
                    }
                    else
                    {
                      ?>
                        <button type="button" id="new" class="btn btn-default btn-lg btn-warning">Next Game</button>
                      <?php
                    }
                 ?>
                 <br />
                 <br />
                  <button type="button" id="done" class="btn btn-default btn-lg btn-danger">End Tournament</button>
                  <br /><br /><br /><br /><br />
                  </div>

                  <?php
                  }
                  ?>

            </div>
            <div class="row">
              <div id="players">
              
            <?php
                echo "<div class='col-md-2'><form class='playersForm'>";

                $i = 0;
                $j = 1;
                $z = 0;

                $players = json_decode($players,true);
                
                // usort($players, function($a, $b){
                //     return ($a['order'] < $b['order']) ? -1 : 1;
                // });
                foreach($players as $item)
                {   
                    // if($z==count($players)-1)
                    // {
                    //     echo "<button type='submit' class='btn'>Submit</button></form>";
                    // }
                   
                    if($i==4)
                    {

                      echo "<button type='submit' class='btn'>Submit</button></form></div><div class='col-md-2'><form class='playersForm'>";
                      
                      $i=0;
                    }
                      echo "<div class='col-md-12'>";
                      if($i==0)
                      {
                        echo "<h4>Round ".$j."</h4>";
                        $j++;
                      }
                      
                      echo $item['name'];
                      if($item['scored']==0)
                      {
                          echo "<div class='pull-right'><input type='text' name=".$item['id']." style='width:50px' /></div>";
                      }
                      else
                      {
                          echo "<div class='pull-right'><input disabled type='text' name=".$item['id']." value='".$item['curScore']."' style='width:50px' /></div>";
                      }

                        
                      echo "</div>";
                      echo "<br />";
                      if($z==count($players)-1)
                      {
                         echo "<button type='submit' class='btn'>Submit</button></form>";
                      }
                      $i++;
                      $z++;
                      
                    
                }

            ?>
                <br />
                </div>
              </div>
            </div>
            <!-- <div class="col-md-4">
                 <h2>Information</h2>
                 <h4>Live URL:</h4> Coming soon <br />
            </div> -->
      </div>
      
      <hr>

      <footer>
        <p><a href="http://axschech.com">axschech</a> &copy; 2014</p>
      </footer>
    </div> <!-- /container -->        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.0.min.js"><\/script>')</script>

        <script src="<?php echo asset('js/vendor/bootstrap.min.js') ?>"></script>

        <script src="<?php echo asset('js/tournament.js') ?>"></script>
        <script src="<?php echo asset('js/bootstrap-notify.js') ?>"></script>

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
