<?php
	
	global $db;
	
	if (isset($_POST['user_id'])) {
		// save user values
		if ($_POST['user_id'] > 0) {
			$user = User::LoadById($db, $_POST['user_id']);
		} else {
			$user = new User($db);
		}
		$user->user_login = $_POST['user_login'];
		$user->user_email = $_POST['user_email'];
		if (isset($_POST['user_password']) and strlen($_POST['user_password']) > 0) {
			$user->user_password_hash = Authentication::hashPassword($_POST['user_password']);
		}
		$user->save();
		redirect('/users');
	} elseif (isset($path[1]) && $path[1] == 'edit') {
		// load for edit
		$user = User::LoadById($db, $path[2]);
	} elseif (isset($path[1]) && $path[1] == 'delete') {
		User::deleteById($db, $path[2]);
		redirect('/users');
	} else {
		// new user
		$user = new User($db);
		$user->user_id = 0;
	}