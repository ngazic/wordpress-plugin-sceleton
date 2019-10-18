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

if (file_exists(dirname(__FILE__) . '/inc/includes.php')) {
  require_once dirname(__FILE__) . '/inc/includes.php';
  if (class_exists('Inc\Includes')) {
    Inc\Includes::includeAllFiles();
  }
}

/**
 * there are 3 steps of plugin:
 *ACTIVATION
 *DEACTIVATION
 *UNINSTALL
 */
/**
 * The code that runs during plugin activation
 */
function activate_pm_plugin() {
  Inc\Base\Activate::activate();
}
register_activation_hook(__FILE__, 'activate_pm_plugin');

/**
 * The code that runs during plugin deactivation
 */
function deactivate_pm_plugin() {
  Inc\Base\Deactivate::deactivate();
}
register_deactivation_hook(__FILE__, 'deactivate_pm_plugin');

//UNINSTALLING HOOK can be via using function or using uninstall.php file
//we will do it using uninstall.php file

/*
 *============================================
 * Initialize all the core classes of plugin
 *============================================
 */
if (class_exists('Inc\Init')) {
  Inc\Init::registerServices();
}
