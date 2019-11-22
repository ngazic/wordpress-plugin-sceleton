<?php
/**
 * @package PM
 */
namespace Inc\Api\Callbacks;
use Inc\Base\BaseController;

/**
 * Provides callbacks for Admin pages and subpages
 */
class AdminCallbacks extends BaseController {

  public function adminDashboard() {
    require_once "$this->plugin_path/templates/admin.php";
  }
  
  public function adminCpt() {
    require_once "$this->plugin_path/templates/cpt.php";
  }
  
  public function adminTaxonomies() {
    require_once "$this->plugin_path/templates/taxonomy.php";

  }
  public function adminWidget() {
    require_once "$this->plugin_path/templates/widget.php";
  }
  public function adminGallery() {
    require_once "$this->plugin_path/templates/gallery.php";
  }

}