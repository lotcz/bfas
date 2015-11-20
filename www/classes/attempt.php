<?php

class ClaimAttempt {

	private $db = null;

	static $max_attempts = 100;
	
	public $claim_attempt_ip = null;
	public $claim_attempt_count = 1;
	public $claim_attempt_first = null;
	public $claim_attempt_last = null;
	
	function __construct($db) {
		$this->db = $db;
	}
   		
	static function loadByIP($db, $ip) {
		$claim_attempt = new ClaimAttempt($db);
		if (isset($ip)) {
			if ($statement = $db->prepare('SELECT claim_attempt_ip, claim_attempt_count, claim_attempt_first, claim_attempt_last FROM claim_attempts WHERE claim_attempt_ip = ?')) {
				$statement->bind_param('s', $ip);
				$statement->execute();
				$statement->bind_result($claim_attempt->claim_attempt_ip, $claim_attempt->claim_attempt_count, $claim_attempt->claim_attempt_first, $claim_attempt->claim_attempt_last);
				$statement->fetch();
				$statement->close();			
			} else {
				die('ClaimAttempt db error:' . $db->error);
			}
		}
		if (isset($claim_attempt->claim_attempt_ip)) {
			return $claim_attempt;
		} else {
			return null;
		}
	}
	
	static function save($db, $ip) {		
		if ($st = $db->prepare('UPDATE claim_attempts SET claim_attempt_count = claim_attempt_count + 1, claim_attempt_last = CURRENT_TIMESTAMP WHERE claim_attempt_ip = ?')) {
			$st->bind_param('s', $ip);
			if (!$st->execute()) {
				die('ClaimAttempt update db error:' . $db->error);
			}
			if (!($st->affected_rows > 0)) {
				if ($st = $db->prepare('INSERT INTO claim_attempts (claim_attempt_ip) VALUES (?)')) {
					$st->bind_param('s', $ip);
					if (!$st->execute()) {
						die('ClaimAttempt insert db error:' . $db->error);
					}
				} else {
					die('ClaimAttempt insert db error:' . $db->error);
				}
			}
			$st->close();
		} else {
			die('ClaimAttempt update db error:' . $db->error);
		}		
	}

	static function deleteByIP($db, $ip) {
		if (isset($ip)) {
			if ($statement = $db->prepare('DELETE FROM claim_attempts WHERE claim_attempt_ip = ?')) {
				$statement->bind_param('s', $claim_attempt_ip);
				$statement->execute();				
				$statement->close();			
			} else {
				die('User db error:' . $db->error);
			}
		}
	}
	
}