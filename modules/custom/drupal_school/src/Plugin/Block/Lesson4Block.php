<?php

/**
 * @file
 * Contains \Drupal\frontend_api_example\Plugin\Block\ExampleConfigurableTextBlock.
 */

namespace Drupal\drupal_school\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a example or render APi with block.
 * @Block(
 *   id = "drupal_school_lesson4_block",
 *   admin_label = @Translation("Title of block (drupal_school_lesson4_block)")
 * )
 */
class Lesson4Block extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build['myelement'] = array(
      '#theme' => 'frontend_api_example_block',
      '#title' => 'title text',
      '#body' => 'Body text',
    );
    $build['myelement'] = array(
      '#type' => 'frontend_api_example_block',
      '#title' => 'title text',
      '#body' => 'Body text',
    );
    $build['myelement']['#attached']['library'][] = 'drupal_school/drupal_school.lesson4';
    $build['myelement']['#attached']['drupalSettings']['drupal_school']['name'] = 'Drupal School User';
    return $build;
  }
}
