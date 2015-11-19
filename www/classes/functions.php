<?php
	
	function redirect($url, $statusCode = 303) {
		global $base_url;
		header('Location: ' . $base_url . $url, true, $statusCode);
		die();
	}
	
	function t($s) {
		global $localization;
		return $localization->translate($s);
	}
	
	// remove slashes if they are present as first or last character of the string
	function trimSlashes($s) {
		if ($s[0] == '/') {
			$s = substr($s,1,strlen($s)-1);
		}
		if ($s[strlen($s)-1] == '/') {
			$s = substr($s,0,strlen($s)-1);
		}
		return $s;
	}
	
	function mysqlTimestamp($d) {
		if (isset($d)) {
			return date('Y-m-d G:i:s', $d);	
		} else {
			return null;
		}		
	}