<?php
/**
 * @file
 * Contains \Drupal\theme_example\Element\MyElement.
 */

namespace Drupal\drupal_school\Element;

use Drupal\Core\Render\Element\RenderElement;
use Drupal\Core\Render\Element;
use Drupal\Core\Url;

/**
 * Provides an example element.
 *
 * @RenderElement("currency_element")
 */
class CurrencyElement extends RenderElement {
  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    $class = get_class($this);
    return [
      '#theme' => 'currency_element',
      '#label' => 'Default Label',
      '#description' => 'Default Description',
      '#pre_render' => [
        [$class, 'preRenderMyElement'],
      ],
    ];
  }

  /**
   * Prepare the render array for the template.
   */
  public static function preRenderMyElement($element) {
    if (empty($element['#currency_date'])) {
      $date = date('m/d/Y');
    }
    else {
      $date = $element['#currency_date'];
    }

    $url = Url::fromUri('http://www.nbrb.by/Services/XmlExRates.aspx', array(
      'query' => array(
        'ondate' => $date,
      ),
      'absolute' => TRUE,
    ))->toString();
    $data = simplexml_load_file($url);

    foreach ($data as $new_url) {
      $render_array[] = array(
        '#theme' => 'item_list',
        '#items' => array(
          $new_url->CharCode,
          $new_url->Rate,
          $new_url->NumCode
        ),
        '#title' => $new_url->Name,
      );
    }
    $render_array['#attached']['library'][] = 'drupal_school/drupal_school.lesson3';

    return $render_array;
  }
}