<?php
/**
 * @package PM
 */
namespace Inc\Api\Callbacks;
use Inc\Base\BaseController;

/**
 * Provides callbacks for settings, sections and fields
 */
class ManagerCallbacks extends BaseController {

  /**
   * Sanitizes the input value for every field of
   * option group pm_plugin_settings
   * @param $input  value of field
   */
  public function checkboxSanitize($input) {
    // return filter_var($input, FILTER_SANITIZE_NUMBER_INT);
    //return (isset($input) ? true : false);
    $output = array();
		foreach ( $this->managers as $key => $value ) {
			$output[$key] = isset( $input[$key] ) ? true : false;
		}
		return $output;
  }

  public function adminSectionManager() {
    echo 'Manage the Sections and Features of this Plugin by activating the checkboxes from the following list.';
  }

  /**
   * Callbacks for checkbox fields
   * @param array $args parameter in set_field() 
   * @return  
   */
  public function checkboxField($args) {
    $name = $args['label_for'];
    $classes = $args['class'];
    $option_name = $args['option_name'];
    $checkbox = get_option($option_name);
    echo '<input type="checkbox" id="' . $name .' name="' .$option_name.'[' .$name . ']"  class="' . $classes . '" ' . ($checkbox ? 'checked' : '') . '><label for="' . $name . '"><div></div></label></div>';
  }

}