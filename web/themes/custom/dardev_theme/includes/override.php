<?php
function dardev_theme_preprocess_views_view_grid(&$variables) {
   $view = $variables['view'];
   $rows = $variables['rows'];
   $style = $view->style_plugin;
   $options = $style->options;
   $variables['drv_masonry']['class'] = '';
   $variables['drv_masonry']['class_item'] = '';
   if(strpos($options['row_class_custom'] , 'masonry') || $options['row_class_custom'] == 'masonry' ){
      $variables['drv_masonry']['class'] = 'post-masonry-style row';
      $variables['drv_masonry']['class_item'] = 'item-masory';
   }
}
