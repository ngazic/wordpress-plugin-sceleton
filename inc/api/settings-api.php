<?php

/**
 * @package PM
 */

namespace Inc\Api;

class SettingsApi {
  //admin pages and subpages
  public $admin_pages = array();
  public $admin_subpages = array();

  //settings, sections and fields
  public $settings = array();
  public $sections = array();
  public $fields = array();

  /**
   * Register all settings
   * @return
   */
  public function register() {
    if (!empty($this->admin_pages)) {
      add_action('admin_menu', array($this, 'addAdminMenu'));
    }

    if (!empty($this->settings)) {
			add_action('admin_init', array($this, 'registerCustomFields'));
    }
  }

  /**
   * Add pages to the SettingsApi
   * @param   array  array of all admin pages
   * @return   class SettingsApi instance
   */
  public function addPages(array $pages) {
    $this->admin_pages = $pages;
    return $this;
  }

  /**
   * Add sub pages to the SettingsApi
   * @param array $subpages     array of all admin subpages
   * @return class SettingsApi   instance
   */
  public function addSubPages(array $sub_pages) {
    if (empty($this->admin_pages)) {
      return $this;
    }
    $this->admin_subpages = array_merge($this->admin_subpages, $sub_pages);
    return $this;
  }

  /**
   * adding specific first subpage title
   * this is quirk for no repeating admin page title
   * @param string title   title of first subpage
   * @return class SettingsApi   instance
   */
  public function withSubPage(string $title = null) {
    if (empty($this->admin_pages)) {
      return $this;
    }
    $admin_page = $this->admin_pages[0];
    $this->admin_subpages = array(
      array(
        'parent_slug' => $admin_page['menu_slug'],
        'page_title' => $admin_page['page_title'],
        'menu_title' => ($title) ? $title : $admin_page['menu_title'],
        'capability' => $admin_page['capability'],
        'menu_slug' => $admin_page['menu_slug'],
        'callback' => function () {echo "this is custom first  subpage in admin menu";},
      ),
    );
    return $this;
  }

  /**
   * Add admin pages and subpages
   * to admin dashboard
   * @return
   */
  public function addAdminMenu() {

    foreach ($this->admin_pages as $page) {
      add_menu_page($page['page_title'], $page['menu_title'], $page['capability'], $page['menu_slug'], $page['callback'], $page['icon_url'], $page['position']);
    }

    foreach ($this->admin_subpages as $page) {
      add_submenu_page($page['parent_slug'], $page['page_title'], $page['menu_title'], $page['capability'], $page['menu_slug'], $page['callback']);
    }

  }

  /**
   * Add settings to the SettingApi
   * @param array $settings  all settings
   */
  public function setSettings(array $settings) {
    $this->settings = $settings;
  }

  /**
   * Add sections to the SettingApi
   * @param array $sections  all settings
   */
  public function setSections(array $sections) {
    $this->sections = $sections;
  }

  /**
   * Add fields to the SettingApi
   * @param array $fields  all settings
   */
  public function setFields(array $fields) {
    $this->fields = $fields;
  }

  /**
   * Register custom fields
   */
  public function registerCustomFields() {
    // register setting
    foreach ($this->settings as $setting) {
      register_setting($setting["option_group"], $setting["option_name"], (isset($setting["callback"]) ? $setting["callback"] : ''));
    }
    // add settings section
    foreach ($this->sections as $section) {
      add_settings_section($section["id"], $section["title"], (isset($section["callback"]) ? $section["callback"] : ''), $section["page"]);
    }
    // add settings field
    foreach ($this->fields as $field) {
      add_settings_field($field["id"], $field["title"], (isset($field["callback"]) ? $field["callback"] : ''), $field["page"], $field["section"], (isset($field["args"]) ? $field["args"] : ''));
    }
  }
}
