<?php
/**
 * @package PM
 */
namespace Inc\Api\Callbacks;

/**
 * Provides callbacks for taxonomy manager
 */
class TaxonomyCallbacks {

  /**
   * Sanitizes the input value for every field of
   * option group pm_plugin_taxonomy
   * @param array $input  value of field
   * @return array $output sanitized value of option pm_plugin_taxonomy
   */
  public function taxonomySanitize($input) {
    error_log(json_encode($input));
    $output = get_option('pm_plugin_taxonomy')?:array();
    if(isset($_POST['remove'])) {
      unset($output[$_POST['remove']]);
      return $output;
    }
    if(count($output) == 0) {
      $output[$input['taxonomy']] = $input;
      return $output;
    }
    foreach ($output as $key => $value ) {
      if($input['taxonomy'] === $key) {
        $output[$key] = $input;
      } else {
        $output[$input['taxonomy']] = $input;
      }
    }
    return $output;
  }

  public function taxonomySectionManager() {
    echo 'Add as many taxonomies as you want';
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
    $value = '';
    if(isset($_POST['edit_post'])) {
      error_log($_POST['edit_post']);
      $value = isset($checkbox[$_POST['edit_post']][$name])? 'checked' : '';
    }
    echo '<input type="checkbox" id="' . $name .'" name="' .$option_name.'[' .$name . ']"  class="' . $classes . '" value="1" '.$value.'><label for="' . $name . '"><div></div></label></div>';
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
    $value = '';
    if(isset($_POST['edit_post'])) {
      error_log($_POST['edit_post']);
      $value = $textfield[$_POST['edit_post']][$name];
    }
    echo '<input type="text" id="' . $name .'" name="' .$option_name.'['.$name.']" placeholder="'.$placeholder.'"  value="'.$value.'">';
  }

}