<?php

/**
 * @file
 * Contains \Drupal\frontend_api_example\Controller\FrontendApiExamplePageController.
 */

namespace Drupal\drupal_school\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Routing\TrustedRedirectResponse;


/**
 * Controller routines for page example routes.
 */
class Lesson4Controller extends ControllerBase {

  /**
   * Constructs a page with descriptive content.
   *
   * Our router maps this method to the path 'school/frontend_api_example'.
   */
  public function description() {
    // Make our links. First the simple page.
    $simple_url = Url::fromRoute('frontend_api_example_simple');
    $frontend_api_example_simple_link = $this->l($this->t('simple page'), $simple_url);
    // Now the arguments page.
    $arguments_url = Url::fromRoute('frontend_api_example_arguments', array(
      'first' => '42',
      'second' => '101'
    ));

    $frontend_api_example_arguments_link = $this->l($this->t('arguments page'), $arguments_url);


    $frontend_api_example_simple_routing_link = $this->l($this->t('Simple Routing'), Url::fromRoute('frontend_api_example.response'));
    $frontend_api_example_simple_routing_json_link = $this->l($this->t('Routing Json '), Url::fromRoute('frontend_api_example.response_json'));
    $frontend_api_example_simple_routing_redirect_link = $this->l($this->t('Routing Redirect'), Url::fromRoute('frontend_api_example.response_redirect'));
    // Now the arguments page.

    // Assemble the markup.
    $build = array();
    $build[] = array(
      '#markup' => $this->t('<p>The Example page of module "Fronted Api Example" provides two pages, "simple" and "arguments".</p><p>This part is changed code from Page Example module</p><p>The @simple_link just returns a renderable array for display.</p><p>The @arguments_link takes two arguments and displays them, as in @arguments_url</p>',
        array(
          '@simple_link' => $frontend_api_example_simple_link,
          '@arguments_link' => $frontend_api_example_arguments_link,
          '@arguments_url' => $arguments_url->toString(),
        )
      ),
    );
    $build[] = array(
      '#markup' => $this->t('<p>The Rouring example module provides 3 pages, "simple", "JSON" and "Redirect".</p><p>The @routing_link just returns a route.</p><p>The @json_link resurns json array</p><p>The @redirect_link_link redirect to page</p>',
        array(
          '@routing_link' => $frontend_api_example_simple_routing_link,
          '@json_link' => $frontend_api_example_simple_routing_json_link,
          '@redirect_link_link' => $frontend_api_example_simple_routing_redirect_link,
        )
      ),
    );

    return $build;
  }

  /**
   * Simple page.
   *
   * Example was got from examples module.
   */
  public function simple() {
    $output['simple'] = array(
      '#markup' => '<p>' . $this->t('Simple text.') . '</p>',
    );
    $output['admin_filtered_string'] = array(
      '#markup' => '<em>This is filtered using the admin tag list</em>',
    );
    $output['filtered_string'] = array(
      '#markup' => '<em>This is filtered</em>',
      '#allowed_tags' => ['strong'],
    );
    $output['escaped_string'] = array(
      '#plain_text' => '<em>This is escaped</em>',
    );
    return $output;
  }

  /**
   * Example with paramaters.
   */
  public function arguments($first, $second) {
    // Make sure you don't trust the URL to be safe! Always check for exploits.
    if (!is_numeric($first) || !is_numeric($second)) {
      // We will just show a standard "access denied" page in this case.
      throw new AccessDeniedHttpException();
    }

    $list[] = $this->t("First number was @number.", array('@number' => $first));
    $list[] = $this->t("Second number was @number.", array('@number' => $second));
    $list[] = $this->t('The total was @number.', array('@number' => $first + $second));

    $render_array['frontend_api_example_arguments'] = array(
      // The theme function to apply to the #items
      '#theme' => 'item_list',
      // The list itself.
      '#items' => $list,
      '#title' => $this->t('Argument Information'),
    );
    return $render_array;
  }

  /**
   * Redirection to another site
   *
   * @return TrustedRedirectResponse
   *   Redirection to Example.com
   */
  public function responseRedirect() {
    $response = new TrustedRedirectResponse('http://example.com/');
    return $response;
  }

  public function responseJson() {
    $response = new JsonResponse();
    $response->setData(array(
      'data' => 123
    ));
    return $response;
  }

  public function checkResponse() {
    $response = new Response("Hello");
    $response->setCache(array(
      'etag' => 'abcdef',
      'last_modified' => new \DateTime(),
      'max_age' => 600,
      's_maxage' => 600,
      'private' => FALSE,
      'public' => TRUE,
    ));
    return $response;
  }
}
