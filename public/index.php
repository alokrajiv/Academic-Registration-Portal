<!DOCTYPE html>
<html lang="en" class="no-js">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
		<meta name="viewport" content="width=device-width, initial-scale=1"> 
		<title>ARCD Portal</title>
		<!--Jquery Plugin-->
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/jquery-ui.js"></script>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css">
		<!-- Optional theme -->
		<link rel="stylesheet" href="assets/css/bootstrap-theme.min.css">
		<!--Custom CSS-->
		<link rel="stylesheet" type="text/css" href="assets/css/custom.css" />
		<!-- Latest compiled and minified JavaScript -->
		<script src="assets/js/bootstrap.min.js"></script>

		 <!--Favicon-->
    	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico?" />
	</head>
	<body>
		<!-- Modal -->
		<?php include 'assets/modules/modals.php';?>
		<div class="container">
					<div class="row "  id="main-text">
							<div class="text-left col-md-1 col-sm-1 col-lg-1 col-xs-1">
								<img src="assets/img/logo.png" class="img-reponsive" alt="">
							</div>
							<div class="col-md-8 col-md-offset-1 col-xs-8 col-xs-offset-1	 col-sm-8 col-sm-offset-1 heading-welcome welcome-to h1-responsive text-center intro"  data-scroll-reveal='enter bottom and move 50px over 1s'>
					
							<h1 class="text-center">WELCOME TO</h1><br>
							<h1 class="text-center">BITS PILANI, DUBAI CAMPUS</h1><br>
							<h1 class="text-center">ARCD PORTAL</h1>

							</div>	

					</div>
					<div class="row text-center login-button ">
						<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#loginModal">Login</button>
					</div>
					<div class="footer text-right">
						
					</div>
		</div>
			<footer class="">
				
			</footer>

		<script src="assets/js/scrollReveal.js"></script>
		<script src="assets/js/custom.js"></script>
	<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js" integrity="sha256-xNjb53/rY+WmG+4L6tTl9m6PpqknWZvRt0rO1SRnJzw=" crossorigin="anonymous"></script>
	<script type="text/javascript"> 
	var $root = $('html, body');
	$('a').click(function() {
		var cache = this;
	    $('html, body').animate({ 
		}, 1000);
	    return false;
	});
	</script> 
	<!--<script>
		 $("#modal-ajax").on('click',"a[data-window='external']", function() {
            window.open($(this).attr('href')); 
            return false; 
        });
	</script> -->
	</body>
</html>