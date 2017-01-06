(function ($, Drupal) {
    Drupal.behaviors.foundation = {
        attach: function (context, settings) {
            $(document).foundation();
        }
    };
})(jQuery, Drupal);