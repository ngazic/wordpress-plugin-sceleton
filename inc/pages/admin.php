<?php
/**
 * @package PM
 */
namespace Inc\Pages;

use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\Callbacks\ManagerCallbacks;
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

    $this->callbacks = new AdminCallbacks();
    $this->callbacks_mgr = new ManagerCallbacks();

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
        'callback' => array($this->callbacks, 'adminDashboard'),
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
        'callback' => array($this->callbacks, 'adminCpt'),
      ),
      array(
        'parent_slug' => 'pm_plugin',
        'page_title' => 'Custom Taxonomies',
        'menu_title' => 'Taxonomies',
        'capability' => 'manage_options',
        'menu_slug' => 'pm_taxonomies',
        'callback' => array($this->callbacks, 'adminTaxonomy'),
      ),
      array(
        'parent_slug' => 'pm_plugin',
        'page_title' => 'Custom Widgets',
        'menu_title' => 'Widgets',
        'capability' => 'manage_options',
        'menu_slug' => 'pm_widgets',
        'callback' => array($this->callbacks, 'adminWidget'),
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
        'option_name' => 'cpt_manager',
        'callback' => array($this->callbacks_mgr, 'checkboxSanitize'),
      ),
      array(
        'option_group' => 'pm_plugin_settings',
        'option_name' => 'taxonomy_manager',
        'callback' => array($this->callbacks_mgr, 'checkboxSanitize'),
      ),
      array(
        'option_group' => 'pm_plugin_settings',
        'option_name' => 'media_widget',
        'callback' => array($this->callbacks_mgr, 'checkboxSanitize'),
      ),
      array(
        'option_group' => 'pm_plugin_settings',
        'option_name' => 'gallery_manager',
        'callback' => array($this->callbacks_mgr, 'checkboxSanitize'),
      ),
      array(
        'option_group' => 'pm_plugin_settings',
        'option_name' => 'testimonial_manager',
        'callback' => array($this->callbacks_mgr, 'checkboxSanitize'),
      ),
      array(
        'option_group' => 'pm_plugin_settings',
        'option_name' => 'templates_manager',
        'callback' => array($this->callbacks_mgr, 'checkboxSanitize'),
      ),
      array(
        'option_group' => 'pm_plugin_settings',
        'option_name' => 'login_manager',
        'callback' => array($this->callbacks_mgr, 'checkboxSanitize'),
      ),
      array(
        'option_group' => 'pm_plugin_settings',
        'option_name' => 'membership_manager',
        'callback' => array($this->callbacks_mgr, 'checkboxSanitize'),
      ),
      array(
        'option_group' => 'pm_plugin_settings',
        'option_name' => 'chat_manager',
        'callback' => array($this->callbacks_mgr, 'checkboxSanitize'),
      )
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
    $fields = array(
      array(
        'id' => 'cpt_manager',
        'title' => 'Activate CPT Manager',
        'callback' => array($this->callbacks_mgr, 'checkboxField'),
        'page' => 'pm_plugin',
        'section' => 'pm_admin_index',
        'args' => array(
          'label_for' => 'cpt_manager',
          'class' => 'ui-toggle',
        )
      ),
      array(
        'id' => 'taxonomy_manager',
        'title' => 'Activate Taxonomy Manager',
        'callback' => array($this->callbacks_mgr, 'checkboxField'),
        'page' => 'pm_plugin',
        'section' => 'pm_admin_index',
        'args' => array(
          'label_for' => 'taxonomy_manager',
          'class' => 'ui-toggle',
        )
      ),
      array(
        'id' => 'media_widget',
        'title' => 'Activate Media Widget',
        'callback' => array($this->callbacks_mgr, 'checkboxField'),
        'page' => 'pm_plugin',
        'section' => 'pm_admin_index',
        'args' => array(
          'label_for' => 'media_widget',
          'class' => 'ui-toggle',
        )
      ),
      array(
        'id' => 'gallery_manager',
        'title' => 'Activate Gallery Manager',
        'callback' => array($this->callbacks_mgr, 'checkboxField'),
        'page' => 'pm_plugin',
        'section' => 'pm_admin_index',
        'args' => array(
          'label_for' => 'gallery_manager',
          'class' => 'ui-toggle',
        )
      ),
      array(
        'id' => 'testimonial_manager',
        'title' => 'Activate Testimonial Manager',
        'callback' => array($this->callbacks_mgr, 'checkboxField'),
        'page' => 'pm_plugin',
        'section' => 'pm_admin_index',
        'args' => array(
          'label_for' => 'testimonial_manager',
          'class' => 'ui-toggle',
        )
      ),
      array(
        'id' => 'templates_manager',
        'title' => 'Activate Templates Manager',
        'callback' => array($this->callbacks_mgr, 'checkboxField'),
        'page' => 'pm_plugin',
        'section' => 'pm_admin_index',
        'args' => array(
          'label_for' => 'templates_manager',
          'class' => 'ui-toggle',
        )
      ),
      array(
        'id' => 'login_manager',
        'title' => 'Activate Ajax Login/Signup',
        'callback' => array($this->callbacks_mgr, 'checkboxField'),
        'page' => 'pm_plugin',
        'section' => 'pm_admin_index',
        'args' => array(
          'label_for' => 'login_manager',
          'class' => 'ui-toggle',
        )
      ),
      array(
        'id' => 'membership_manager',
        'title' => 'Activate Membership Manager',
        'callback' => array($this->callbacks_mgr, 'checkboxField'),
        'page' => 'pm_plugin',
        'section' => 'pm_admin_index',
        'args' => array(
          'label_for' => 'membership_manager',
          'class' => 'ui-toggle',
        )
      ),
      array(
        'id' => 'chat_manager',
        'title' => 'Activate Chat Manager',
        'callback' => array($this->callbacks_mgr, 'checkboxField'),
        'page' => 'pm_plugin',
        'section' => 'pm_admin_index',
        'args' => array(
          'label_for' => 'chat_manager',
          'class' => 'ui-toggle',
        )
      )
    );
    $this->settings->setFields($fields);
  }
}