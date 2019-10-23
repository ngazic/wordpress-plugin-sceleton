<?php 
namespace Inc;
final class Includes {
	
	private static $pluginPath;
	
	static function includeAllFiles() {
		self::$pluginPath = plugin_dir_path(dirname(__FILE__));

		/*
		==========================================
		Require init.php file
		==========================================
		 */
		require_once self::$pluginPath.'/inc/init.php';

		/*
		==========================================
		Require all files from inc subfolders
		==========================================
		 */
		foreach(glob(self::$pluginPath.'/inc/*/*.php') as $file) {
			require_once $file;
		}
		foreach(glob(self::$pluginPath.'/inc/*/*/*.php') as $file) {
			require_once $file;
		}

	}
}