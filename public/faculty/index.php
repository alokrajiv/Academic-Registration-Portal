<?php
session_start();
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="utf-8">

	    <meta name="viewport" content="width=device-width, initial-scale=1.0">

	    <title>ERP-Dashboard</title>
	    
		<!-- Custom Css -->
	    <link rel="stylesheet" type="text/css" href="../assets/css/dashboard.css">

	    <!-- Latest compiled and minified CSS -->
	    <link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.6/simplex/bootstrap.min.css" rel="stylesheet" integrity="sha384-/Ib5WUYOh/fqe9wT9MDBX+VgUWQuUf8oDH3yuR9Kr+6Y5ejq92KR8LEuCbRiGZpG" crossorigin="anonymous">
	    <!--Jquery Plugin-->    
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	    
	    <!-- Latest compiled and minified JavaScript -->
	    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	    <script src="../assets/js/dashboard.js"></script>

	     <!--Favicon-->
    	<link rel="shortcut icon" type="image/x-icon" href="../favicon.ico?" />
    </head>
    <body>


	        <nav class="navbar navbar-default navbar-static-top">
	    <div class="container-fluid">
	        <!-- Brand and toggle get grouped for better mobile display -->
	        <div class="navbar-header">
	            <button type="button" class="navbar-toggle navbar-toggle-sidebar collapsed">
	            MENU
	            </button>
	            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
	                <span class="sr-only">Toggle navigation</span>
	                <span class="icon-bar"></span>
	                <span class="icon-bar"></span>
	                <span class="icon-bar"></span>
	            </button>
	            <a class="navbar-brand" href="#">
	                <img src="../assets/img/bitslogo1.png" alt="" class="img-responsive navbar-brand-logo" style="display: inline;">
                	BITS Pilani
	            </a>
	        </div>

	        <!-- Collect the nav links, forms, and other content for toggling -->
	        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">      
	            <!--<form class="navbar-form navbar-left" method="GET" role="search">
	                <div class="form-group">
	                    <input type="text" name="q" class="form-control" placeholder="Search">
	                </div>
	                <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i></button>
	            </form>-->
	            <ul class="nav navbar-nav navbar-right">
	                <li><a href="http://www.pingpong-labs.com" target="_blank">Visit Site</a></li>
	                <li class="dropdown ">
	                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
	                        <?=ucwords(strtolower($_SESSION['user_data']['full_name']))?>
	                        <span class="caret"></span></a>
	                        <ul class="dropdown-menu" role="menu">
	                            <li class="dropdown-header">SETTINGS</li>
	                            <li class=""><a href="#">Other Link</a></li>
	                            <li class=""><a href="#">Other Link</a></li>
	                            <li class=""><a href="#">Other Link</a></li>
	                            <li class="divider"></li>
	                            <li><a href="/login/logout.php">Logout</a></li>
	                        </ul>
	                    </li>
	                </ul>
	            </div><!-- /.navbar-collapse -->
	        </div><!-- /.container-fluid -->
	    </nav>      <div class="container-fluid main-container">
	        <div class="col-md-2 sidebar">
	            <div class="row">
	    <!-- uncomment code for absolute positioning tweek see top comment in css -->
	    <div class="absolute-wrapper"> </div>
	    <!-- Menu -->
	    <div class="side-menu">
	        <nav class="navbar navbar-default" role="navigation">
	            <!-- Main Menu -->
	            <div class="side-menu-container">
	                <ul class="nav navbar-nav">
	                    <li class="active" id="dashboard"><a href="#"><span class="glyphicon glyphicon-dashboard"></span> Dashboard</a></li>
	                    <li id="upload-attendance"><a  href="#"><span class="glyphicon glyphicon-user"></span>Upload Attendance</a></li>
	                    <li><a href="viewclients.php"><span class="glyphicon glyphicon-cloud"></span> Existing Customers</a></li>

	                    <!-- Dropdown-->
	                    <li class="panel panel-default" id="dropdown">
	                        <a data-toggle="collapse" href="#dropdown-lvl1">
	                            <span class="glyphicon glyphicon-user"></span> Sub Level <span class="caret"></span>
	                        </a>

	                        <!-- Dropdown level 1 -->
	                        <div id="dropdown-lvl1" class="panel-collapse collapse">
	                            <div class="panel-body">
	                                <ul class="nav navbar-nav">
	                                    <li><a href="#">Link</a></li>
	                                    <li><a href="#">Link</a></li>
	                                    <li><a href="#">Link</a></li>

	                                    <!-- Dropdown level 2 -->
	                                    <li class="panel panel-default" id="dropdown">
	                                        <a data-toggle="collapse" href="#dropdown-lvl2">
	                                            <span class="glyphicon glyphicon-off"></span> Sub Level <span class="caret"></span>
	                                        </a>
	                                        <div id="dropdown-lvl2" class="panel-collapse collapse">
	                                            <div class="panel-body">
	                                                <ul class="nav navbar-nav">
	                                                    <li><a href="#">Link</a></li>
	                                                    <li><a href="#">Link</a></li>
	                                                    <li><a href="#">Link</a></li>
	                                                </ul>
	                                            </div>
	                                        </div>
	                                    </li>
	                                </ul>
	                            </div>
	                        </div>
	                    </li>

	                    <li><a href="#"><span class="glyphicon glyphicon-signal"></span> Link</a></li>

	                </ul>
	            </div><!-- /.navbar-collapse -->
	        </nav>

	    </div>
	</div>          </div>
	        <div class="col-md-10 content">
	              <div class="panel panel-default">
	    <div class="panel-heading">
	        Welcome <?= ucwords(strtolower($_SESSION['user_data']['full_name']))?>
	    </div>
	    <div class="panel-body" id="dashboard-div">
	        <div id="dashboard-data">
	             Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	        </div>
	    </div>
	</div>
	        </div>
	        <!--<footer class="pull-left footer">
	            <p class="col-md-12">
	                <hr class="divider">
	                Copyright &COPY; 2015 <a href="http://www.pingpong-labs.com">Gravitano</a>
	            </p>
	        </footer>-->
	    </div>
    </body>
    <script>
    	 $('#upload-attendance').click(function(){
    	 		$('#upload-attendance').addClass('active');
                $('#dashboard').removeClass('active');
                $('#dashboard-div').load('attendance/ #faculty-upload');
            });
    	 $('#dashboard').click(function(){
                $('#dashboard-div').load('# #dashboard-data');
                $('#dashboard').addClass('active');
                $('#upload-attendance').removeClass('active');
            });
    </script>
</html>
