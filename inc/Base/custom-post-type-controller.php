<?php
/**
 * @package  PM
 */
namespace Inc\Base;

/**
 * Controler for CPT
 */
class CustomPostTypeController extends BaseController {
  public $callbacks;
	public $subpages = array();
	
	 /**
   * Register CPT and CPT admin subpage
   * @return
   */
  public function register() {
    if (!$this->activated('cpt_manager')) {
      return;
    }

    $this->settings = new SettingsApi();
    $this->callbacks = new AdminCallbacks();
    $this->setSubpages();
    $this->settings->addSubPages($this->subpages)->register();
    add_action('init', array($this, 'activate'));
	}
	
	/**
   * create CPT admin subpage
   * @return
   */
  public function setSubpages() {
    $this->subpages = array(
      array(
        'parent_slug' => 'alecaddd_plugin',
        'page_title' => 'Custom Post Types',
        'menu_title' => 'CPT Manager',
        'capability' => 'manage_options',
        'menu_slug' => 'alecaddd_cpt',
        'callback' => array($this->callbacks, 'adminCpt'),
      ),
    );
	}
	
	/**
   * activate CPT
   * @return
   */
  public function activate() {
    register_post_type('pm_products',
      array(
        'labels' => array(
          'name' => 'Products',
          'singular_name' => 'Product',
        ),
        'public' => true,
        'has_archive' => true,
      )
    );
  }
}