<?php
/**
 * @package PM
 */
namespace Inc\Api\Callbacks;

/**
 * Provides callbacks for cpt manager
 */
class CptCallbacks {

  /**
   * Sanitizes the input value for every field of
   * option group pm_plugin_settings
   * @param array $input  value of field
   * @return array $output sanitized value of option pm_plugin_cpt
   */
  public function cptSanitize($input) {
    // return filter_var($input, FILTER_SANITIZE_NUMBER_INT);
    //return (isset($input) ? true : false);
    $output = get_option('pm_plugin_cpt');
		foreach ($output as $key => $value ) {
      if($input['post_type'] === $key) {
        $output[$key] = $input;
      } else {
        $output[$key] = $input;
      }
		}
		return $output;
  }

  public function cptSectionManager() {
    echo 'PM plugin Custom Post Types';
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
    echo '<input type="checkbox" id="' . $name .'" name="' .$option_name.'[' .$name . ']"  class="' . $classes . '" ' . ($checkbox[$name] ? 'checked' : '') . '><label for="' . $name . '"><div></div></label></div>';
  }

}