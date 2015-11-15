<?php	
		
	require_once '../classes/tokens.php';
	require_once '../classes/user.php';
	require_once '../classes/auth.php';
	require_once '../classes/voucher.php';
	require_once '../classes/claim.php';
	require_once '../classes/localization.php';
	
	require_once '../classes/global.php';
	
	$base_url = 'http://bfas.loc';
	$db = new mysqli('localhost', 'root', '', 'bfts');
	$localization = new Localization('../lang/', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
		
	$template = 'default.php';
	$page = 'front.php';
	$message = '';

	if ($db->connect_errno > 0) {
		$page = 'error.php';
		$message = 'Database connection error:' . $db->error_message;
	} else {
		$auth = new Authentication($db);
		$claim = new VoucherClaim($db);

		if (isset($_GET['path'])) {
			$path = explode('/',trimSlashes(strtolower($_GET['path'])));
		} else {
			$path = [''];
		}

		// select page to display
		switch ($path[0]) {
			case 'download' :
				// voucher claim request
				if (isset($_POST['voucher_code'])) { 
					if (strtolower($_POST['voucher_code']) == 'ting') {
						redirect('/admin');
					}
					$claim->checkVoucherCode($_POST['voucher_code']);
					if (!$claim->hasVoucher()) {						
						$message = 'Sorry, we do not recognize this voucher code. Try again or contact TiNG guys if you think your voucher code is correct.';
					}
				}
				if ($claim->hasVoucher()) {
					$template = 'scroll.php';
					$page = 'bfas.php';
				}				
				break;
			case 'admin' :
				// login request
				if (isset($_POST['login'])) { 
					$auth->login($_POST['login'], $_POST['password']);
					if (!$auth->isAuth()) {
						$message = 'Login incorrect!';
					}
				}
				if ($auth->isAuth()) {
					$template = 'scroll.php';
					$page = 'admin.php';
				} else {				
					$page = 'login.php';
				}
				break;
			case 'voucher' :				
				if ($auth->isAuth()) {
					$page = 'voucher.php';
				} else {				
					$page = 'login.php';
				}
				break;
			case 'user' :				
				if ($auth->isAuth()) {
					$page = 'user.php';
				} else {				
					$page = 'login.php';
				}
				break;
			case 'users' :				
				if ($auth->isAuth()) {
					$template = 'scroll.php';
					$page = 'users.php';
				} else {				
					$page = 'login.php';
				}
				break;
			case 'logout' :
				$auth->logout();
				redirect('/');
				break;
			case 'forget' :
				$claim->forgetVoucher();
				redirect('/');
				break;
			default :
				if ($auth->isAuth()) {
					$template = 'scroll.php';
					$page = 'admin.php';
				} elseif ($claim->hasVoucher()) {
					$template = 'scroll.php';
					$page = 'bfas.php';					
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
		
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>

	<body>

		<?php
			include '../templates/' . $template;
		?>

		<!-- Bootstrap core JavaScript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

		<script src="/tools.js"></script>

	</body>
</html>
<?php
	$db->close();
?>