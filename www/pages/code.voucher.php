<?php
	
	global $db;
	
	if (isset($_POST['voucher_id'])) {
		// save voucher values
		$voucher = Voucher::LoadById($db, $_POST['voucher_id']);
		$voucher->voucher_customer_name = $_POST['customer_name'];
		$voucher->voucher_customer_email = $_POST['customer_email'];
		$voucher->save();
		redirect('/admin');
	} elseif (isset($path[1]) && $path[1] == 'edit') {
		// load for edit
		$voucher = Voucher::LoadById($db, $path[2]);
	} elseif (isset($path[1]) && $path[1] == 'delete') {
		Voucher::deleteById($db, $path[2]);
		redirect('/admin');
	} else {
		// new voucher
		$voucher = new Voucher($db);
		do {
			$voucher->voucher_code = Voucher::generateToken();	
			$exist = Voucher::loadByCode($db, $voucher->voucher_code);
		} while (isset($exist));
		
		$voucher->save();
	}