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
   * option group pm_plugin_cpt
   * @param array $input  value of field
   * @return array $output sanitized value of option pm_plugin_cpt
   */
  public function cptSanitize($input) {
    error_log(json_encode($_POST));
    $output = get_option('pm_plugin_cpt');
    foreach ($output as $key => $value ) {
      if($input['post_type'] === $key) {
        $output[$key] = $input;
      } else {
        $output[$input['post_type']] = $input;
      }
    }
    return $output;
  }

  public function cptSectionManager() {
    echo 'Add as many custom post types as you want';
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
    echo '<input type="checkbox" id="' . $name .'" name="' .$option_name.'[' .$name . ']"  class="' . $classes . '" value="1"><label for="' . $name . '"><div></div></label></div>';
  }

  /**
   * Callbacks for text fields
   * @param array $args parameter in set_field() 
   * @return  
   */
  public function textField($args) {
    $name = $args['label_for'];
    $option_name = $args['option_name'];
    $placeholder = $args['placeholder'];
    $textfield = get_option($option_name);
    echo '<input type="text" id="' . $name .'" name="' .$option_name.'['.$name.']" placeholder="'.$placeholder.'" >';
  }

}