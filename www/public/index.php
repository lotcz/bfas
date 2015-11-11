<?php

	require_once '../tokens.php';
	require_once '../auth.php';
	require_once '../voucher.php';
	require_once '../claim.php';
	
	$base_url = "http://bfts.loc";
	
	function redirect($url, $statusCode = 303) {
		global $base_url;
		header('Location: ' . $base_url . $url, true, $statusCode);
		die();
	}
		
	$db = new mysqli('localhost', 'root', '', 'bfts');
	
	$message = "";

	if ($db->connect_errno > 0) {
		$page = 'error.php';
		$message = "Database connection error:" . $db->error_message;
	} else {	
		$auth = new Authentication($db);
		$claim = new VoucherClaim($db);
		
		if (isset($_GET['path'])) {
			$path = Tokens::trimSlashes(strtolower($_GET['path']));
		} else {
			$path = '';
		}
				
		// select page to display
		switch ($path) {
			case 'download' :
				// voucher claim request
				if (isset($_POST['voucher_code'])) { 
					if (strtolower($_POST['voucher_code']) == 'ting') {
						redirect('/admin');
					}
					$claim->checkVoucherCode($_POST['voucher_code']);
					if (!$claim->hasVoucher()) {						
						$message = "Sorry, we do not recognize this voucher code. Try again or contact TiNG guys if you think your voucher code is correct.";
					}
				}
				if ($claim->hasVoucher()) {
					$page = "download.php";
				} else {
					$page = "front.php";
				}				
				break;
			case 'admin' :
				// login request
				if (isset($_POST['login'])) { 
					$auth->login($_POST['login'], $_POST['password']);
					if (!$auth->isAuth()) {
						$message = "Login incorrect!";
					}
				}
				if ($auth->isAuth()) {
					$page = "admin.php";
				} else {				
					$page = "login.php";
				}
				break;
			case 'voucher' :				
				if ($auth->isAuth()) {
					$page = "create.php";
				} else {				
					$page = "login.php";
				}
				break;
			case 'logout' :
				// logout request
				$auth->logout();
				redirect('/');
				break;
			default :
				if ($auth->isAuth()) {
					$page = "admin.php";
				} else {
					if ($claim->hasVoucher()) {
						$page = "download.php";
					} else {
						$page = "front.php";
					}					
				}
		}
		
	}	
	
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

		<title>Born For A Storm</title>

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
							<h1 class="masthead-brand">Born For A Storm</h1>
							<nav>
								<ul class="nav masthead-nav">
									<li class="active"><a href="http://tingband.com" target="_blank">tingband.com</a></li>
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

					<div class="mastfoot">
						<div class="inner">
							<p>This website was created for TiNG guys with love by <b><span style="color:purple">K</span><span style="color:red">a</span><span style="color:violet">r</span><span style="color:yellow">e</span><span style="color:green">l</span></b>.</p>
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
<?php
	$db->close();
?>