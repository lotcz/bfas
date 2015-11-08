<?php

class Authentication {
	
	private $db = null;
	
	private $cookie_name = "session_token";
	
	public $user = null;
	
	function __construct($auth_db) {
		$this->db = $auth_db;
		$this->checkAuthentication();
	}
   
	public function isAuth() {
		return isset($this->user);
	}
	
	public function login($login, $password) {
		
		if (isset($_COOKIE[$this->cookie_name])) {
			$this->logout();
		}
		
		if ($statement = $this->db->prepare("SELECT * FROM users WHERE email = ? AND password = ?")) {
			$statement->bind_param('ss', $login, $password);
			$statement->execute();
			$result = $statement->get_result();
			
			// success - create a session
			if ($row = $result->fetch_assoc()) {
				$this->user = $row;
				$token = $this->generateToken();
				$expires = time()+60*60*24*30; //30 days
				if ($st = $this->db->prepare("INSERT INTO user_sessions (session_token, user_id, session_expires) VALUES (?,?,?)")) {
					$st->bind_param('sis', $token, $this->user['id'], date('Y-m-d G:i:s', $expires));
					if (!$st->execute()) {
						die("Session db error:" . $this->db->error);
					}
					$st->close();
					setcookie($this->cookie_name, $token, $expires); 
				} else {
					die("Session db error:" . $this->db->error);
				}				
			}
			
			$statement->close();		
		} else {
			die("Login db error:" . $this->db->error);
		}
	}
	
	public function checkAuthentication() {
		$this->user = null;
		
		if (isset($_COOKIE[$this->cookie_name])) {
			$token_value = $_COOKIE[$this->cookie_name];
		}
		
		if (isset($token_value)) {
			$statement = $this->db->prepare("SELECT user_id FROM user_sessions WHERE session_token = ?");
			$statement->bind_param('s', $token_value);
			$statement->execute();
			$statement->bind_result($id);
			$statement->fetch();
			$statement->close();
			if ($st = $this->db->prepare("SELECT * FROM users WHERE id = ?")) {
				$st->bind_param('i',$id);
				$st->execute();
				$result = $st->get_result();
				if ($row = $result->fetch_assoc()) {
					$this->user = $row;
				}
				$st->close();
			} else {
				die("Login db error:" . $this->db->error);
			}
		}
	}
	
	public function logout() {
		$this->user = null;
		
		if (isset($_COOKIE[$this->cookie_name])) {
			$token_value = $_COOKIE[$this->cookie_name];
			unset($_COOKIE[$this->cookie_name]);
			setcookie($this->cookie_name, "", time()-3600);
		}
		
		if (isset($token_value)) {
			$statement = $this->db->prepare("DELETE FROM user_sessions WHERE session_token = ?");
			$statement->bind_param('s', $token_value);
			$statement->execute();			
			$statement->close();			
		}
	}
	
	private function generateToken() {
		$s = "";
		for ($i = 0; $i < 50; $i++) {
			$s .= chr(rand(97,122));
		}
		return $s;
	}
}