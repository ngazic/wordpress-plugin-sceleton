<?php
/**
 * @package  PM
 */
namespace Inc\Base;

use Inc\Base\BaseController;
use Inc\Api\Widgets\CptCallbacks;

/**
 * Controler for Widgets
 */
class WidgetController extends BaseController {
  
  public $media_widget;

  /**
   * Register Widgets
   * @return
   */
  public function register() {
    if (!$this->activated('media_widget')) {
      return;
    }

    $this->media_widget = new MediaWidget();
    $this->media_widget->register();
  }
}