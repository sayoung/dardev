<?php 
if(!class_exists('element_drv_code')):
   class element_drv_code{
     
      public function render_form(){
         $fields = array(
            'type'      => 'gsc_code',
            'title'  => t('Code'), 
            'fields' => array(
               array(
                  'id'     => 'content',
                  'type'      => 'textarea',
                  'title'  => t('Content'),
               ),
            ),                                       
         );
         return $fields;
      } 
      
      public function render_content( $attr = array(), $content = '' ) {
         extract(dardev_merge_atts(array(
            'content'           => '',
         ), $attr));

         $output  = '<pre>';
            $output .= $content;
         $output .= '</pre>'."\n";
         return $output;
      }

   }
endif;

