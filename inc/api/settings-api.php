<?php

/**
 * @package PM
 */

namespace Inc\Api;

class SettingsApi {

  public $admin_pages = array();
  public $admin_subpages = array();

  /**
   * Register admin pages and sub pages
   * @return
   */
  public function register() {
    add_action('admin_menu', array($this, 'addAdminMenu'));
  }

  /**
   * Add pages to the SettingsApi
   * @return class $this instance
   */
  public function addPages($pages) {
		$this->admin_pages = $pages;
    return $this;
  }

  /**
   * Add sub pages to the SettingsApi
   * @return class $this instance
   */
  public function addSubPages($sub_pages) {
    if (empty($this->admin_pages)) {
      return $this;
    }
		$this->admin_subpages = array_merge($this->admin_subpages, $sub_pages);
    return $this;
  }

  /**
   * adding specific first subpage title 
   * this is quirk for no repeating admin page title 
   * @param string title   set title of first subpage
   * @return class $this   instance
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
      )
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
}
