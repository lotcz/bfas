<?php 

class Localization {
		
	public $lang_name = 'en';
	public $cookie_name = 'language';
	
	function __construct($dir, $lang = null) {
		if (!isset($lang)) {
			if (isset($_COOKIE[$this->cookie_name])) {
				$lang_name = $_COOKIE[$this->cookie_name];
			} else {
				$lang_name = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
				$lang_name = strtolower(substr($lang_name,0,2));
			}						
		} else {
			$lang_name = $lang;
		}		
		
		$file = $dir . $lang_name . '.php';
		
		if (file_exists($file)) {			
			require $file;
		}
	}
	
	public function translate($s) {
		global $language_data;
		if (isset($language_data) and isset($language_data[$s])) {
			return $language_data[$s];
		} else {
			return $s;
		}		
	}
	
}