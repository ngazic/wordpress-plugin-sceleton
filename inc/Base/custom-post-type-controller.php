<?php
/**
 * @package  PM
 */
namespace Inc\Base;

use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\Callbacks\CptCallbacks;
use Inc\Api\SettingsApi;
use Inc\Base\BaseController;

/**
 * Controler for CPT
 */
class CustomPostTypeController extends BaseController {
  public $settings;
  public $callbacks;
  public $cpt_callbacks;

  public $subpages = array();
  public $custom_post_types = array();

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
    $this->setFields();
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
      ),
    );
  }

  /**
   * create CPT settings using api
   * @return
   */
  public function setSettings() {
    $args = array(
      array(
        'option_group' => 'pm_plugin_cpt_settings',
        'option_name' => 'pm_plugin_cpt',
        'callback' => array($this->cpt_callbacks, 'cptSanitize'),
      ),
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
   * Adding fields to api
   * @return
   */
  public function setFields() {
    // Note: we can put any key/value in "args" key
    //'label_for' must match 'id'
    $fields = array(
      array(
        'id' => 'post_type',
        'title' =>"Custom Post Type ID",
        'callback' => array($this->cpt_callbacks, 'textField'),
        'page' => 'pm_cpt',
        'section' => 'pm_cpt_index',
        'args' => array(
          'option_name' => 'pm_plugin_cpt',
          'label_for'   => 'post_type',
          'placeholder' => 'e.g. Product',
          'array'       => 'post_type'
        )
      )
    );
    
    $this->settings->setFields($fields);
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