<?php
/**
 * @package  PM
 */
namespace Inc\Base;
use \Inc\Base\BaseController;

class EnqueueScriptsAndStyles extends BaseController {

  function register() {
		add_action('admin_enqueue_scripts', array($this, 'enqueue'));
	}

	function enqueue() {
		//enqueue all scripts and styles
		wp_enqueue_script('myPluginScript', $this->plugin_url.'src/js/pmscript.js', true);
		wp_enqueue_style('myPluginStyle', $this->plugin_url.'src/css/pmstyle.css');
	}
}