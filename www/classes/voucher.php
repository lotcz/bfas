<?php

class Voucher {
	
	private $db = null;

	public $voucher_code = null;
	public $customer_email = null;
	public $voucher_created = null;
	public $voucher_used = null;
	
	function __construct($db) {
		$this->db = $db;
	}
   		
	public function load($voucher_code) {
		$this->voucher_code = null;
		if (isset($voucher_code)) {
			$statement = $this->db->prepare("SELECT voucher_code, customer_email, voucher_used, voucher_used FROM vouchers WHERE voucher_code = ?");
			$statement->bind_param('s', $voucher_code);
			$statement->execute();
			$statement->bind_result($this->voucher_code, $this->customer_email, $this->voucher_created, $this->voucher_used);
			$statement->fetch();
			$statement->close();			
		}
	}
	
	static function loadByCode($db, $voucher_code) {
		$voucher = new Voucher($db);
		$voucher->load($voucher_code);
		if (isset($voucher->voucher_code)) {
			return $voucher;
		} else {
			return null;
		}
	}
	
	public function save() {
		if ($st = $this->db->prepare("INSERT INTO vouchers (voucher_code) VALUES (?)")) {
			$st->bind_param('s', $this->voucher_code);
			if (!$st->execute()) {
				die("Voucher db error:" . $this->db->error);
			}
			$st->close();
		} else {
			die("Voucher db error:" . $this->db->error);
		}
	}

	static function generateToken() {		
		$token = Tokens::generateToken(4);
		//make sure there is no zero or 'O' in the token as they might be easily misread
		while (strpos($token,'0') !== false or strpos($token,'O') !== false) {
			$token = Tokens::generateToken(4);
		}
		return $token;		
	}
	
}