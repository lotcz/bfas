<?php	
	
	$globals = [];
	require_once 'config.php';	
	$home_dir = $globals['home_dir'];
	$base_url = $globals['base_url'];
	
	require_once $home_dir . 'classes/functions.php';
	require_once $home_dir . 'classes/tokens.php';
	require_once $home_dir . 'classes/user.php';
	require_once $home_dir . 'classes/auth.php';
	require_once $home_dir . 'classes/voucher.php';
	require_once $home_dir . 'classes/claim.php';
	require_once $home_dir . 'classes/localization.php';
		
	$db = new mysqli($globals['db_host'], $globals['db_login'], $globals['db_password'], $globals['db_name']);
	$localization = new Localization($home_dir . 'lang/');
		
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
						$message = t('Sorry, we do not recognize this voucher code.');
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
						$message = t('Login incorrect!');
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

	$codefile_path = 'code.' . $page;	
	if (file_exists($home_dir . 'pages/' . $codefile_path)) {			
		include $home_dir . 'pages/' . $codefile_path;
	}
		
	include $home_dir . 'templates/master.php';
	
	$db->close();