(function ($) {
$(document).ready(function(){

   //Select IMCE file, display image demo and set val for upload input.
   var drvImceInput = window.drvImceInput = window.drvImceInput || {
     urlSendto: function(File, win) {
         var url = File.getUrl();
         var el = $('#' + win.imce.getQuery('inputId'))[0];
         win.close();
         if (el) {
           var base_path = drupalSettings.dardev_pagebuilder.base_path;
           //console.log(base_path);
           var url_new = '/' + url.replace(base_path, '');
           $(el).val(url_new);
           $(el).parents('.drv-upload-input').find('.dardev-image-demo').attr('src', url);
         }
      }
   }

})
})(jQuery);
