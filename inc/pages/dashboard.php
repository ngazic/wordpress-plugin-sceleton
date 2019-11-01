<?php
/**
 * @package PM
 */
namespace Inc\Pages;

use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\Callbacks\ManagerCallbacks;
use Inc\Api\SettingsApi;
use Inc\Base\BaseController;

class Dashboard extends BaseController {
  public $settings;

  public $callbacks;
  public $callbacks_mgr;

  public $pages = array();
  public $subPages = array();

  /**
   * Register admin page
   * @return
   */
  public function register() {
    $this->settings = new SettingsApi();

    $this->callbacks = new AdminCallbacks();
    $this->callbacks_mgr = new ManagerCallbacks();

    $this->setPages();
    $this->setSettings();
    $this->setSections();
    $this->setFields();

    $this->settings->addPages($this->pages)->withSubpage('Dashboard')->register();
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
        'callback' => array($this->callbacks, 'adminDashboard'),
        'icon_url' => 'dashicons-store',
        'position' => 110,
      ),
    );

  }

   // public function setSubPages() {
  //   $this->subPages = array(
  //     array(
  //       'parent_slug' => 'pm_plugin',
  //       'page_title' => 'Custom Taxonomies',
  //       'menu_title' => 'Taxonomies',
  //       'capability' => 'manage_options',
  //       'menu_slug' => 'pm_taxonomies',
  //       'callback' => array($this->callbacks, 'adminTaxonomy'),
  //     ),
  //     array(
  //       'parent_slug' => 'pm_plugin',
  //       'page_title' => 'Custom Widgets',
  //       'menu_title' => 'Widgets',
  //       'capability' => 'manage_options',
  //       'menu_slug' => 'pm_widgets',
  //       'callback' => array($this->callbacks, 'adminWidget'),
  //     ),
  //   );
  // }

  /**
   * Create dashboard settings using api
   * @return
   */
  public function setSettings() {
    $args = array(
      array(
        'option_group' => 'pm_plugin_settings',
        'option_name' => 'pm_plugin',
        'callback' => array($this->callbacks_mgr, 'checkboxSanitize'),
      )
    );
    $this->settings->setSettings($args);
  }

  /**
   * Adding dashboard sections
   * @return
   */
  public function setSections() {
    $args = array(
      array(
        'id' => 'pm_admin_index',
        'title' => 'Settings Manager',
        'callback' => array($this->callbacks_mgr, 'adminSectionManager'),
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
    // Note: we can put any key/value in "args" key
    //'label_for' must match 'id'
    $fields = array();
    
    foreach($this->managers as $id => $title) {
      $fields[] = array(
        'id' => $id,
        'title' => $title,
        'callback' => array($this->callbacks_mgr, 'checkboxField'),
        'page' => 'pm_plugin',
        'section' => 'pm_admin_index',
        'args' => array(
          'option_name' => 'pm_plugin',
          'label_for'   => $id,
          'class'       => 'ui-toggle'
        )
      );
    }
    
    $this->settings->setFields($fields);
  }
}