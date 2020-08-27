<?php

class AutoLoader {
	private static $autoloadPathArray = array (
			"",
			"includes/",
			"api/",
			"token_share_example/" 
	);
	public static function autoload($className) {
		foreach ( self::$autoloadPathArray as $path ) {
			$file = CURR_PATH . DIRECTORY_SEPARATOR . $path . $className . ".php";
			$file = str_replace ( '\\', DIRECTORY_SEPARATOR, $file );
			if (is_file ( $file )) {
				include_once $file;
				break;
			}
		}
	}
	public static function addAutoloadPath($path) {
		array_push ( self::$autoloadPathArray, $path );
	}
}
spl_autoload_register ( "AutoLoader::autoLoad" );
?>