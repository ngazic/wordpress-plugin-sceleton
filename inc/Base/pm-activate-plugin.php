<?php
/**
 * @package  PM
 */
namespace Inc\Base;

class Activate {
	public static function activate() {
		flush_rewrite_rules();

		/**
		 * Fix for first time activation of plugin
		 */
		
		if ( get_option( 'pm_plugin' ) ) {
			return;
		}
		$default = array();
		update_option( 'pm_plugin', $default );
	}
}