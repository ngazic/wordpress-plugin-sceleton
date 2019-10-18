<?php
/**
 * 
 * @package PM
 */
namespace Inc\Base;
use \Inc\Base\BaseController;

class SettingsLinks extends BaseController {

	public function register() {
		add_filter( "plugin_action_links_$this->plugin", array( $this, 'settings_link' ) );
	}

	/**
	 * 
	 * Adds custom settings link for our plugin
	 *
	 * @param  array $links  settings links of plugin
	 * @return array $links	 settings links of plugin
	 */
	public function settings_link( $links ) {
		$settings_link = '<a href="admin.php?page=pm">Settings</a>';
		array_push( $links, $settings_link );
		return $links;
	}
}