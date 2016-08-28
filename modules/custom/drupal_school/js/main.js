/**
 * @file
 * Simple JavaScript hello world file.
 */
(function ($, Drupal, drupalSettings) {
  "use strict";
  Drupal.behaviors.lesson4 = {
    attach: function (context, settings) {
      // Defining template.
      Drupal.theme.parametrizedExample = function (first_word, second_word) {
        var markup = '<p>Have a good day ' + first_word + ' ' + second_word + '!</p>';
        return markup;
      };
      // Sent console log with parameter.
      console.log(Drupal.t('Hello @user', {'@user': drupalSettings.frontend_api_example.name}));
      var parametrized_example = Drupal.theme('parametrizedExample', 'Dear', drupalSettings.frontend_api_example.name);
      $('.main-content', context).prepend(parametrized_example);
    }
  }
})(jQuery, Drupal, drupalSettings);
