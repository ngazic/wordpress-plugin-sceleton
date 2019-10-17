<?php
/*
 Plugin Name: PM Sceleton
 Plugin URI: 
 Description: Basic plugin functions for quick wordpress development
 Author: Nihad Gazic
 Version: 1.0
 Author URI: https://github.com/ngazic
 Text Domain: poslovnimediji
 */

/* 
 ==========================================
 Securing the plugin from external file access
 ==========================================
 */
if (!function_exists('add_action')) {
	die('what are You doing, You silly human');
}

/*
==============================================
Include all necessary files
==============================================
*/

if ( file_exists(dirname( __FILE__ ) . '/inc/includes.php' ) ) {
	require_once dirname( __FILE__ ) . '/inc/includes.php';
	if ( class_exists( 'Inc\Includes' ) ) {
		echo 'including all files';
		Inc\Includes::includeAllFiles();
	}
}

if ( class_exists( 'Inc\Init' ) ) {
	Inc\Init::registerServices();
}
/**
 * BAD PRACTICE IN OOP IS TO CALL FUNCTIONS IN CONSTRUCTOR, BECAUSE IT IS CALLED ON EVERY CHILD CLASS INSTANCE
 */
if (!class_exists('PmPlugin')) {

	class PmPlugin
	{

		function __construct()
		{
			add_action('init', array($this, 'custom_post_type'));
			echo dirname(__FILE__);
			echo 'PLUGIN BASENAME IS'. plugin_basename( dirname(__FILE__));
		}


		function activate()
		{
			require_once plugin_dir_path(__FILE__) . 'inc/pm-activate-plugin.php';
			PmPluginActivate::activate();
		}

		function deactivate()
		{
			echo 'the PM plugin is deactivated';
		}

		

		function custom_post_type()
		{
			register_post_type('book', ['public' => true, 'label' => 'Books']);
		}
	}

	// $pmPlugin = new PmPlugin();
	// $pmPlugin->register();

	/**
	 * there are 3 steps of plugin:
	 *ACTIVATION
	 *DEACTIVATION
	 *UNINSTALL
	 */

	//ACTIVATION OF PLUGIN:
	register_activation_hook(__FILE__, array($pmPlugin, 'activate'));

	//DEACTIVATION OF PLUGIN:
	register_deactivation_hook(__FILE__, array($pmPlugin, 'deactivate'));

	//UNINSTALLING HOOK can be via using function or using uninstall.php file
	//we will do it using uninstall.php file
}
