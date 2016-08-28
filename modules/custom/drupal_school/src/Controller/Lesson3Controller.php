<?php

/**
 * @file
 * Contains \Drupal\frontend_api_example\Controller\FrontendApiExamplePageController.
 */

namespace Drupal\drupal_school\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Controller routines for page example routes.
 */
class Lesson3Controller extends ControllerBase {
  /**
   * Provide list of currencies.
   *
   * @return array
   */
  public function currencies() {
    return array(
      '#type' => 'currency_element',
    );
  }
}