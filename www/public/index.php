<?php

	require_once '../auth.php';

	$db = new mysqli('localhost', 'root', '', 'bfts');
	
	$message = "";

	if ($db->connect_errno > 0) {
		$page = 'error.php';
		$message = "Database connection error:" . $db->error_message;
	} else {
	
		$auth = new Authentication($db);		
		
		if (isset($_GET['path'])) {
			$path = strtolower($_GET['path']);
		} else {
			$path = '/';
		}
				
		if ($path == "download" && isset($_POST['login'])) { // login request			
			$auth->login($_POST['login'], $_POST['password']);
			if (!$auth->isAuth()) {
				$message = "Login incorrect!";
			}		
		} elseif ($path == 'logout') { // logout request 
			$auth->logout();
		}
		
		// select page to display
		if ($auth->isAuth()) {
			$page = "test.php";
		} else {
			$page = "login.php";			
		}
	}	

	$db->close();
	
?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

		<meta name="description" content="">
		<meta name="author" content="Karel Zavadil">
		<link rel="icon" href="favicon.ico">

		<title>Born For the Storm</title>

		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

		<!-- Custom styles for this template -->
		<link href="/style.css" rel="stylesheet">
	</head>

	<body>

		<div class="site-wrapper">
			<div class="site-wrapper-inner">
				<div class="cover-container">
				
					<div class="masthead clearfix">
						<div class="inner">
							<h3 class="masthead-brand">Born For The Storm</h3>
							<nav>
								<ul class="nav masthead-nav">
									<li class="active"><a href="#">Info</a></li>
									<?php 
										if (isset($auth) && $auth->isAuth()) { 
											echo "<li>" . $auth->user['email'] . "</li>";
											echo "<li><a href=\"logout\">Log out</a></li>";
										}
									?>
								</ul>
							</nav>
						</div>
					</div>

					<?php
						include "..\\" . $page;
					?>

					<div>
						<?php
							echo $message;
						?>
					</div>
					
					<div class="mastfoot">
						<div class="inner">
							<p>Created for your amusement by <a href="http://getbootstrap.com">Karel Zavadil</a>.</p>
						</div>
					</div>

				</div>
			</div>
		</div>

		<!-- Bootstrap core JavaScript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

	</body>
</html>