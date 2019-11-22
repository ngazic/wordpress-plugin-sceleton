<?php
/**
 * @package  PM
 */
namespace Inc\Base;

use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;

/**
 * Controler for Gallery
 */
class GalleryController extends BaseController {
  public $settings;
  public $callbacks;
  public $tax_callbacks;

  public $subpages = array();
  public $taxonomies = array();

  /**
   * Register CPT and CPT admin subpage
   * @return
   */
  public function register() {
    if (!$this->activated('gallery_manager')) {
      return;
    }

    $this->settings = new SettingsApi();
    $this->callbacks = new AdminCallbacks();
    $this->setSubpages();
    $this->settings->addSubPages($this->subpages)->register();

  }

  /**
   * create Gallery admin subpage
   * @return void
   */
  public function setSubpages() {
    $this->subpages = array(
      array(
        'parent_slug' => 'pm_plugin',
        'page_title' => 'Gallery',
        'menu_title' => 'Gallery',
        'capability' => 'manage_options',
        'menu_slug' => 'pm_gallery',
        'callback' => array($this->callbacks, 'adminGallery'),
      ),
    );
  }
}