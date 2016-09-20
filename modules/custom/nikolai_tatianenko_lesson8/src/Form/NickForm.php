<?php

/**
 * @file
 * Contains \Drupal\nikolai_tatianenko_lesson8\Form\NickForm.
 */
namespace Drupal\nikolai_tatianenko_lesson8\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class NickForm extends FormBase {
  const CID = 'NickFormCid';

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'nikolai_tatianenko_cache_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Display cache.
    $cache = \Drupal::cache('nikolai_tatianenko_lesson8')->get(self::CID, TRUE);

    if ($cache) {
      // Check valid status.
      if ($cache->valid) {
        $cache_status = 'valid';
      }
      else {
        $cache_status = 'invalid';
      }

      drupal_set_message($this->t('Cache item: !cache - !status', array(
        '!cache' => $cache->data,
        '!status' => $cache_status,
      )));
    }
    else {
      drupal_set_message($this->t('There are no any items in cache.'));
    }

    $form['message'] = array(
      '#type' => 'textfield',
      '#required' => 1,
      '#title' => $this->t('Type a message'),
    );

    $form['actions']['#type'] = 'actions';

    $form['actions']['save_message'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Save message in log & cache'),
      '#button_type' => 'primary',
    );

    $form['actions']['invalidate_cache'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Invalidate cache'),
      '#button_type' => 'primary',
      '#limit_validation_errors' => array(),
      '#submit' => array('::InvalidateCacheMessageHandler'),
    );
    $form['actions']['delete_cache'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Delete cache'),
      '#button_type' => 'primary',
      '#limit_validation_errors' => array(),
      '#submit' => array('::DeleteCacheMessageHandler'),
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateMesssage(array &$form, FormStateInterface $form_state) {
    if ($form_state->isValueEmpty('message')) {
      $form_state->setErrorByName('name', $this->t('This field is required for button %button_name.', array(
        '%button_name' => $this->t('Save message in log & cache'),
      )));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Save message to the cache.
    \Drupal::cache('nikolai_tatianenko_lesson8')->set(self::CID, $form_state->getValue('message'));

    // Log message.
    \Drupal::service('nikolai_tatianenko_lesson8.logger')
      ->logToOtherChannels($form_state->getValue('message'));
  }

  /**
   * Invalidate Cache Message handler.
   */
  public function InvalidateCacheMessageHandler(array &$form, FormStateInterface $form_state) {

    $cache = \Drupal::cache('nikolai_tatianenko_lesson8')->get(self::CID);

    if ($cache) {
      \Drupal::cache('nikolai_tatianenko_lesson8')->invalidate(self::CID);

      // Log.
      \Drupal::service('nikolai_tatianenko_lesson8.logger')
        ->logToOtherChannels($this->t('Cache had been successfully invalidated.'));
    }
  }

  /**
   * Remove Cache message handler.
   */
  public function DeleteCacheMessageHandler(array &$form, FormStateInterface $form_state) {

    $cache = \Drupal::cache('nikolai_tatianenko_lesson8')->get(self::CID, TRUE);

    if ($cache) {
      \Drupal::cache('nikolai_tatianenko_lesson8')->delete(self::CID);

      // Log.
      \Drupal::service('nikolai_tatianenko_lesson8.logger')
        ->logToOtherChannels($this->t('Cache had been successfully deleted.'));
    }
  }
}
