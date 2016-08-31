<?php

/**
 * @file
 * Contains \Drupal\nikolai_tatianenko_lesson8\Service\Lesson8Service.
 */

namespace Drupal\nikolai_tatianenko_lesson8\Services;

class Lesson8Service {


  protected $loggerFactory;


  public function __construct($logger) {
    $this->loggerFactory = $logger;
  }

  /**
   * {@inheritdoc}
   */
  public function logToOtherChannels($message) {
    // Send notice.
    $this->loggerFactory->get('nikolai-tatianenko_lesson8')->notice($message);

    // Send Error.
    $this->loggerFactory->get('nikolai-tatianenko_lesson8')->error($message);
  }
}