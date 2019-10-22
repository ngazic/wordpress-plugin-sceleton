<?php
/**
 * @package PM
 */
namespace Inc\Pages;
use Inc\Base\BaseController;
use Inc\Api\SettingsApi;

class AdminPages extends BaseController {
  public $settings;
  public $pages = array();
  public $subPages = array();

  /**
   * Register all admin pages and sub pages
   * using SettingsApi class instance
   * @return
   */
  public function register() {
    $this->settings = new SettingsApi();
    $this->setPages();
    $this->setSubPages();

    $this->settings->addPages($this->pages)->withSubpage('Dashboard')->addSubPages($this->subPages)->register();
  }

  /**
   * populates property pages with values
   * @return
   */
  public function setPages() {
    $this->pages = array(
      array(
        'page_title' => 'PM Plugin',
        'menu_title' => 'PM',
        'capability' => 'manage_options',
        'menu_slug' => 'pm_plugin',
        'callback' => function () {echo '<h1>pm Plugin</h1>';},
        'icon_url' => 'dashicons-store',
        'position' => 110,
      )
    );
   
  }

  /**
   * populates property subPages with values
   * @return
   */
  public function setSubPages() {
    $this->subPages = array(
      array(
        'parent_slug' => 'pm_plugin',
        'page_title' => 'Custom Post Types',
        'menu_title' => 'CPT',
        'capability' => 'manage_options',
        'menu_slug' => 'pm_cpt',
        'callback' => function () {echo "this is custom post type subpage";},
      ),
      array(
        'parent_slug' => 'pm_plugin',
        'page_title' => 'Custom Taxonomies',
        'menu_title' => 'Taxonomies',
        'capability' => 'manage_options',
        'menu_slug' => 'pm_taxonomies',
        'callback' => function () {echo '<h1>Taxonomies Manager</h1>';},
      ),
      array(
        'parent_slug' => 'pm_plugin',
        'page_title' => 'Custom Widgets',
        'menu_title' => 'Widgets',
        'capability' => 'manage_options',
        'menu_slug' => 'pm_widgets',
        'callback' => function () {echo '<h1>Widgets Manager</h1>';},
      ),
    );
  }
}