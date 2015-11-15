<?php

class Voucher {
	
	private $db = null;

	public $voucher_id = null;
	public $voucher_code = null;
	public $voucher_customer_email = null;
	public $voucher_customer_name = null;
	public $voucher_created = null;
	public $voucher_used = null;
	
	function __construct($db) {
		$this->db = $db;
	}
   		
	static function loadById($db, $voucher_id) {
		$voucher = new Voucher($db);
		if (isset($voucher_id)) {
			if ($statement = $db->prepare('SELECT voucher_id, voucher_code, voucher_customer_email, voucher_customer_name, voucher_created, voucher_used FROM vouchers WHERE voucher_id = ?')) {
				$statement->bind_param('i', $voucher_id);
				$statement->execute();
				$statement->bind_result($voucher->voucher_id, $voucher->voucher_code, $voucher->voucher_customer_email, $voucher->voucher_customer_name, $voucher->voucher_created, $voucher->voucher_used);
				$statement->fetch();
				$statement->close();			
			} else {
				die('Voucher db error:' . $this->db->error);
			}
		}
		if (isset($voucher->voucher_code)) {
			return $voucher;
		} else {
			return null;
		}
	}
	
	static function loadByCode($db, $voucher_code) {
		$voucher = new Voucher($db);
		if (isset($voucher_code)) {
			if ($statement = $db->prepare('SELECT voucher_id, voucher_code, voucher_customer_email, voucher_customer_name, voucher_created, voucher_used FROM vouchers WHERE voucher_code = ?')) {
				$statement->bind_param('s', $voucher_code);
				$statement->execute();
				$statement->bind_result($voucher->voucher_id, $voucher->voucher_code, $voucher->voucher_customer_email, $voucher->voucher_customer_name, $voucher->voucher_created, $voucher->voucher_used);
				$statement->fetch();
				$statement->close();			
			} else {
				die('Voucher db error:' . $this->db->error);
			}
		}
		if (isset($voucher->voucher_code)) {
			return $voucher;
		} else {
			return null;
		}
	}
	
	public function save() {
		if (isset($this->voucher_id)) {
			if ($st = $this->db->prepare('UPDATE vouchers SET voucher_customer_email = ?, voucher_customer_name = ?, voucher_used = ? WHERE voucher_id = ?')) {
				$st->bind_param('ssss', $this->voucher_customer_email, $this->voucher_customer_name, mysqlTimestamp($this->voucher_used), $this->voucher_id);
				if (!$st->execute()) {
					die('Voucher db error:' . $this->db->error);
				}
				$st->close();
			} else {
				die('Voucher db error:' . $this->db->error);
			}			
		} else {
			if ($st = $this->db->prepare('INSERT INTO vouchers (voucher_code) VALUES (?)')) {
				$st->bind_param('s', $this->voucher_code);
				if (!$st->execute()) {
					die('Voucher db error:' . $this->db->error);
				} else {
					$this->voucher_id = $this->db->insert_id;
				}
				$st->close();
			} else {
				die('Voucher db error:' . $this->db->error);
			}
		}
	}

	static function deleteById($db, $voucher_id) {
		if (isset($voucher_id)) {
			if ($statement = $db->prepare('DELETE FROM vouchers WHERE voucher_id = ?')) {
				$statement->bind_param('i', $voucher_id);
				$statement->execute();				
				$statement->close();			
			} else {
				die('Voucher db error:' . $this->db->error);
			}
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