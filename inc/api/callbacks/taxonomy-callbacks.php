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
    if(isset($_POST['edit_taxonomy'])) {
      $value = isset($checkbox[$_POST['edit_taxonomy']][$name])? 'checked' : '';
    }
    echo '<input type="checkbox" id="' . $name .'" name="' .$option_name.'[' .$name . ']"  class="' . $classes . '" value="1" '.$value.'><label for="' . $name . '"><div></div></label></div>';
  }

  /**
   * Callbacks for ui editable post types
   * checkbox fields
   * @param array $args parameter in set_field() 
   * @return  
   */
  public function checkboxPostTypesField($args) {
    $name = $args['label_for'];
    $classes = $args['class'];
    $option_name = $args['option_name'];
    $checkbox = get_option($option_name);
    $value = '';
    $output = '';
    $checked = '';
    if(isset($_POST['edit_taxonomy'])) {
      $checkbox = get_option( $option_name );
    }
    $post_types = get_post_types(array('show_ui' => true));
    foreach($post_types as $post_type) {
      if ( isset($_POST["edit_taxonomy"]) ) {
				$checked = isset($checkbox[$_POST["edit_taxonomy"]][$name][$post_type]) ?: false;
			}
     $output .= '<div class="mb-10"><input type="checkbox" class="'.$classes.'" id="'.$post_type.'" name="'.$option_name.'['.$name.']['.$post_type.']" '.($checked ? 'checked' : '').' /><label for="' . $post_type . '"><div></div></label> <strong>' . $post_type . '</strong></div>';
    }
    echo $output;
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
    if(isset($_POST['edit_taxonomy'])) {
      $value = $textfield[$_POST['edit_taxonomy']][$name];
    }
    echo '<input required type="text" id="' . $name .'" name="' .$option_name.'['.$name.']" placeholder="'.$placeholder.'"  value="'.$value.'">';
  }

}