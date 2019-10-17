<?php
/**
 * THIS METHOD IS CALLED WHEN ACTIVATING PLUGIN
 * @package  PM
 */
class PmPluginActivate
{
	public static function activate() {
		flush_rewrite_rules();
	}
}