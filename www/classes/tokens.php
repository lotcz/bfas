<?php

class Tokens {
	
	static function generateToken($len) {
		$s = "";
		for ($i = 0; $i < $len; $i++) {
			if (rand(0,1) == 0) {
				$s .= self::getRandomNumber();
			} else {
				$s .= self::getRandomUppercase();
			}
		}
		return $s;
	}
	
	static function getRandomNumber() {
		return rand(0,9);
	}
	
	static function getRandomUppercase() {
		return strtoupper(self::getRandomLowercase());
	}
	
	static function getRandomLowercase() {
		return chr(rand(97,122));
	}
	
	// remove slashes if they are present as first or last character of the string
	static function trimSlashes($s) {
		if ($s[0] == '/') {
			$s = substr($s,1,strlen($s)-1);
		}
		if ($s[strlen($s)-1] == '/') {
			$s = substr($s,0,strlen($s)-1);
		}
		return $s;
	}
	
}