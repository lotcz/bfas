<?php

class VoucherClaim {
	
	private $db = null;
	
	private $cookie_name = 'voucher_code';
	
	public $voucher = null;
	
	function __construct($auth_db) {
		$this->db = $auth_db;
		$this->checkVoucher();
	}
   
	public function hasVoucher() {
		return isset($this->voucher);
	}

	public function checkVoucher() {
		$this->voucher = null;
		
		if (isset($_COOKIE[$this->cookie_name])) {
			$token_value = $_COOKIE[$this->cookie_name];
		}
		
		if (isset($token_value)) {
			$this->voucher = Voucher::loadByCode($this->db, $token_value);
		}
	}
	
	public function checkVoucherCode($voucher_code) {
		$this->voucher = null;		
		
		if (isset($voucher_code)) {
			$this->voucher = Voucher::loadByCode($this->db, $voucher_code);
			if (isset($this->voucher)) {
				setcookie($this->cookie_name, $this->voucher->voucher_code, time()+60*60*24*30); // set cookie expire in 30 days
				$this->voucher->voucher_used = time();
				$this->voucher->save();
			}
		}
	}
	
	public function forgetVoucher() {
		$this->voucher = null;
		
		if (isset($_COOKIE[$this->cookie_name])) {
			$token_value = $_COOKIE[$this->cookie_name];
			unset($_COOKIE[$this->cookie_name]);
			setcookie($this->cookie_name, '', time()-3600);
		}		
	}
		
}