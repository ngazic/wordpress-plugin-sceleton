<?php
/**
 * @package  PM
 */
namespace Inc\Base;

use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\CptCallbacks;
use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\Callbacks\ManagerCallbacks;

/**
 * Controler for CPT
 */
class CustomPostTypeController extends BaseController {
  public $settings;
  public $callbacks;
  public $cpt_callbacks;

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
    $this->cpt_callbacks = new CptCallbacks();
    $this->setSubpages();
    $this->setSettings();
    $this->setSections();
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
        'parent_slug' => 'pm_plugin',
        'page_title' => 'Custom Post Types',
        'menu_title' => 'CPT',
        'capability' => 'manage_options',
        'menu_slug' => 'pm_cpt',
        'callback' => array($this->callbacks, 'adminCpt'),
      )
    );
  }
  
  /**
   * create CPT settings using api
   * @return 
   */
  public function setSettings() {
    $args = array(
      array(
        'option_group' => 'pm_plugin_settings',
        'option_name' => 'pm_plugin_cpt',
        'callback' => array($this->cpt_callbacks, 'cptSanitize'),
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
        'id' => 'pm_cpt_index',
        'title' => 'CPT Manager',
        'callback' => array($this->cpt_callbacks, 'cptSectionManager'),
        'page' => 'pm_cpt',
      ),
    );
    $this->settings->setSections($args);
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