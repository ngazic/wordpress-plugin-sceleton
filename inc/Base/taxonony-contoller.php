<?php
/**
 * @package  PM
 */
namespace Inc\Base;

use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\TaxonomyCallbacks;
use Inc\Api\Callbacks\AdminCallbacks;

/**
 * Controler for CPT
 */
class TaxonomyController extends BaseController {
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
    if (!$this->activated('taxonomy_manager')) {
      return;
    }

    $this->settings = new SettingsApi();
    $this->callbacks = new AdminCallbacks();
    $this->tax_callbacks = new TaxonomyCallbacks();
    $this->setSubpages();
    $this->setSettings();
    $this->setSections();
    $this->setFields();
    $this->settings->addSubPages($this->subpages)->register();
    $this->storeCustomTaxonomies();

    if ( ! empty( $this->taxonomies ) ) {
			add_action( 'init', array( $this, 'registerCustomTaxonomy' ));
		}
  }

  /**
   * create CPT admin subpage
   * @return
   */
  public function setSubpages() {
    $this->subpages = array(
      array(
        'parent_slug' => 'pm_plugin',
        'page_title' => 'Taxonomies',
        'menu_title' => 'Taxonimies',
        'capability' => 'manage_options',
        'menu_slug' => 'pm_taxonomies',
        'callback' => array($this->callbacks, 'adminTaxonomies'),
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
        'option_group' => 'pm_plugin_taxonomies_settings',
        'option_name' => 'pm_plugin_taxonomy',
        'callback' => array($this->tax_callbacks, 'taxonomySanitize'),
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
        'id' => 'pm_taxonomies_index',
        'title' => 'Taxonomy Manager',
        'callback' => array($this->tax_callbacks, 'taxonomySectionManager'),
        'page' => 'pm_taxonomies',
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
        'id' => 'taxonomy',
        'title' => "Custom Taxonomy ID",
        'callback' => array($this->tax_callbacks, 'textField'),
        'page' => 'pm_taxonomies',
        'section' => 'pm_taxonomies_index',
        'args' => array(
          'option_name' => 'pm_plugin_taxonomy',
          'label_for' => 'taxonomy',
          'placeholder' => 'e.g. genre',
          'array' => 'taxonomy',
        ),
      ),
      array(
        'id' => 'singular_name',
        'title' => "Singular Name",
        'callback' => array($this->tax_callbacks, 'textField'),
        'page' => 'pm_taxonomies',
        'section' => 'pm_taxonomies_index',
        'args' => array(
          'option_name' => 'pm_plugin_taxonomy',
          'label_for' => 'singular_name',
          'placeholder' => 'e.g. Genre',
          'array' => 'taxonomy',
        ),
      ),
      array(
        'id' => 'hierarchical',
        'title' => "Hierarchical",
        'callback' => array($this->tax_callbacks, 'checkboxField'),
        'page' => 'pm_taxonomies',
        'section' => 'pm_taxonomies_index',
        'args' => array(
          'option_name' => 'pm_plugin_taxonomy',
          'label_for' => 'hierarchical',
          'class' => 'ui-toggle',
          'array' => 'taxonomy',
        ),
      ),
      array(
        'id' => 'objects',
        'title' => "Post Types",
        'callback' => array($this->tax_callbacks, 'checkboxPostTypesField'),
        'page' => 'pm_taxonomies',
        'section' => 'pm_taxonomies_index',
        'args' => array(
          'option_name' => 'pm_plugin_taxonomy',
          'label_for' => 'objects',
          'class' => 'ui-toggle',
          'array' => 'taxonomy',
        ),
      )
    );

    $this->settings->setFields($fields);
  }

  /**
   * Store Custom taxonomies into array property of
   * TaxonomyController class instance
   * @return void
   */
 public function storeCustomTaxonomies() {
   $options = get_option('pm_plugin_taxonomy') ?: array();
   foreach($options as $option) {
    $labels = array(
      'name' => $option['singular_name'],
      'singular_name' => $option['singular_name'],
      'search_items' => 'Search '.$option['singular_name'],
      'all_items' => 'All '.$option['singular_name'],
      'parent_item' => 'Parent '. $option['singular_name'],
      'parent_item_colon' => 'Parent '.$option['singular_name'].':',
      'edit_item' => 'Edit '.$option['singular_name'],
      'update_item' => 'Update '.$option['singular_name'],
      'add_new_item' => 'Add New '.$option['singular_name'],
      'new_item_name' => 'New '.$option['singular_name'].'Name',
      'menu_name' => $option['singular_name']
    );
    
    $this->taxonomies[] = array(
      'hierarchical' => isset($option['hierarchical']) ? true : false,
      'labels' => $labels,
      'show_ui' => true,
      'show_admin_column' => true,
      'query_var' => true,
      'rewrite' => array( 'slug' => $option['taxonomy'] ),
      'objects' => isset($option['objects']) ? $option['objects'] : null
    );
   }
 }

/**
 * register custom taxonomies stored in taxonomy property
 * @return void
 */
 public function registerCustomTaxonomy() {
		foreach ($this->taxonomies as $taxonomy) {
			$objects = isset($taxonomy['objects']) ? array_keys($taxonomy['objects']) : null;
			register_taxonomy( $taxonomy['rewrite']['slug'], $objects, $taxonomy );
		}
	}
}