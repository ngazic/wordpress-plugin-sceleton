<?php

namespace Inc\Base;

class BaseController {
	public $plugin_url;
	public $plugin_path;
	public $plugin;

	public function __construct() {
		$this->plugin_url = plugin_dir_url(dirname(__FILE__, 2));
		$this->plugin_path = plugin_dir_path(dirname(__FILE__, 2));
		$this->plugin = plugin_basename(dirname(__FILE__, 3)).'/pm.php';
	}
}
