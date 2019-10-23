<?php
/**
 * @package PM
 */
namespace Inc\Pages;
use Inc\Api\SettingsApi;
use Inc\Base\BaseController;

class AdminPages extends BaseController {
  public $settings;
  public $callbacks;
  public $callbacks_mgr;
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
    $this->setSettings();
    $this->setSections();
    $this->setFields();

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
      ),
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

  /**
   * Adding settings to api
   * @return
   */
  public function setSettings() {
    $args = array(
      array(
        'option_group' => 'pm_plugin_settings',
        'option_name' => 'pm_plugin',
        'callback' => array($this->callbacks_mngr, 'checkboxSanitize'),
      ),
    );
    $this->settings->setSettings($args);
  }

  /**
   * Adding sections to api
   * @return
   */
  public function setSections() {
    $args = array(
      array(
        'id' => 'pm_admin_index',
        'title' => 'Settings Manager',
        'callback' => array($this->callbacks_mngr, 'adminSectionManager'),
        'page' => 'pm_plugin',
      ),
    );
    $this->settings->setSections($args);
  }

  /**
   * Adding fields to api
   * @return
   */
  public function setFields() {
    $args = array();
    foreach ($this->managers as $key => $value) {
      $args[] = array(
        'id' => $key,
        'title' => $value,
        'callback' => array($this->callbacks_mngr, 'checkboxField'),
        'page' => 'pm_plugin',
        'section' => 'pm_admin_index',
        'args' => array(
          'option_name' => 'pm_plugin',
          'label_for' => $key,
          'class' => 'ui-toggle',
        ),
      );
    }
    $this->settings->setFields($args);
  }
}