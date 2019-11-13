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

    $default = array();
    if (get_option('pm_plugin')) {
      update_option('pm_plugin', $default);
    }
    if (get_option('pm_plugin_cpt')) {
      update_option('pm_plugin_cpt', $default);
    }
  }
}