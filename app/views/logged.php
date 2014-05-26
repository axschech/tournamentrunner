<?php
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

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <style>
            body {
                padding-top: 50px;
                padding-bottom: 20px;
            }
            h4
            {
              margin:0px;
            }
        </style>
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/main.css">

        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
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
          <a class="navbar-brand" href="#"><?=$user['name']?></a>
        </div>
       <div class="navbar-collapse collapse">
          <form action="logout" method="POST" class="navbar-form navbar-right" role="form">
            
            <button type="submit" class="btn btn-success">Log Out</button>
          </form>
        </div><!--/.navbar-collapse -->
      </div>
    </div>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    

    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
          <div class="col-md-4">
               <h2> Current Tournaments </h2>
                <div id="currentTournaments">
                <?php
                    $i = 1;
                    foreach(json_decode($tournaments,true) as $item)
                    {
                        echo "<div class='col-md-10'><h4>".$i.". <a href='tournament/".$item['id']."'>".$item['name']."</a><button type='button' onClick='henh(".$item['id'].")' class='btn btn-xs pull-right'><span class='glyphicon glyphicon-remove'></span></button></h4></div>";
                        $i++;
                    }
                ?>
                </div>
          </div>
          <div class="col-md-6">
              <div id="beforeTournament">
                 <h2><a id="new" href="#"> Create a new tournament </a></h2>
              </div>
              <div id="newTournament" style="display:none">
                <h2> Create a tournament </h2>
                <form class="form-horizontal" id="tournament_form" role="form" action="register" method="POST">
                <h3> Name your tournament </h3>
                  <div class="form-group">
                      <label for="name" class="col-md-3 control-label">Name</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" id="title" name="title" placeholder="A title for your tournament">
                      </div>
                    </div>
                <h3> Add Players </h3>
                  <div class="form-group">
                    <label for="name" class="col-md-3 control-label">Name</label>
                    <div class="col-md-6">
                      <input type="text" class="form-control" id="playerName" name="playerName" placeholder="Player Name">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-10">
                       <button type="button" id="goTournament" class="btn btn-default btn-success pull-left" style="display:none">Ready!</button>
                       <span id='add_alert' class="text-danger"></span>
                       <button type="button" id="addPlayer" class="btn btn-default pull-right">Add Player</button>
                    </div>
                  </div>
                </form>
              </div>
          </div>
          <div class="col-md-2">
              <div id="playerList" style="display:none">
                <h2>Player List</h2>
                <div id="listOfPlayers">
                </div>
              </div>
          </div>
      </div>
      <hr>

      <footer>
        <p>&copy; Company 2014</p>
      </footer>
    </div> <!-- /container -->        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.0.min.js"><\/script>')</script>

        <script src="js/vendor/bootstrap.min.js"></script>

        <script src="js/logged.js"></script>

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
