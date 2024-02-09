(function ($, Drupal) {
  Drupal.behaviors.myModuleFormPopup = {
    attach: function (context, settings) {
      // Bind a submit event to your form
      $('form', context).once('myModuleFormPopup').on('submit', function (e) {
        // Prevent the form from submitting normally
        e.preventDefault();
        
        var $form = $(this);

        // Perform the AJAX request
        $.ajax({
          url: $form.attr('action'),
          type: 'post',
          data: $form.serialize(),
          success: function (response) {
            // Show your popup here with the response message
            // This assumes response is a plain message string
            alert(response);
          },
          error: function () {
            // Handle any errors here
            alert('An error occurred while submitting the form.');
          }
        });
      });
    }
  };
})(jQuery, Drupal);
