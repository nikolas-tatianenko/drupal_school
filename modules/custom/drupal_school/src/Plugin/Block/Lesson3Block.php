<?php

/**
 * @file
 * Contains \Drupal\frontend_api_example\Plugin\Block\ExampleConfigurableTextBlock.
 */

namespace Drupal\drupal_school\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a example or render APi with block.
 * @Block(
 *   id = "drupal_school_currency",
 *   admin_label = @Translation("Drupal 8 School currency")
 * )
 */
class Lesson3Block extends BlockBase {

  /**
   * {@inheritdoc}
   */

  public function defaultConfiguration() {
    return array(
      'currency_date' => date('m/d/Y'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {

    $form = parent::blockForm($form, $form_state);
    $form['currency_date'] = array(
      '#type' => 'date',
      '#title' => $this->t('Currency date'),
      '#description' => $this->t('Please set currency date.'),
      '#date_date_format' => 'm/d/Y',
      //'#default_value' => $this->configuration['currency_date']

    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    // Set currency.
    $this->configuration['currency_date'] = $form_state->getValue('currency_date');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    return array(
      '#type' => 'currency_element',
      '#currency_date' => $this->configuration['currency_date'],
    );
  }

}
