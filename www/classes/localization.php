<?php 

class Localization {
	
	function __construct($dir, $lang) {
		$lang = strtolower(substr($lang,0,2));		
		$file = $dir . $lang . '.php';
		
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