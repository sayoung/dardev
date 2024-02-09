<?php 
if(!class_exists('element_drv_accordion')):
   class element_drv_accordion{
      public function render_form(){
         $fields = array(
            'type'      => 'element_drv_accordion',
            'title'  => t('Accordion'), 
            'fields' => array(
               array(
                  'id'     => 'title',
                  'type'      => 'text',
                  'title'  => t('Title'),
                  'admin'     => true
               ),
               array(
                  'id'        => 'style',
                  'type'      => 'select',
                  'title'     => t('Style'),
                  'options'   => array( 
                     'skin-white'         => 'Background White',
                     'skin-dark'          => 'Background Dark',
                     'skin-white-border'  => 'Background White Border',
                  ),
               ),
               array(
                  'id'        => 'animate',
                  'type'      => 'select',
                  'title'     => t('Animation'),
                  'desc'      => t('Entrance animation for element'),
                  'options'   => dardev_content_builder_animate(),
                  'class'     => 'width-1-2'
               ), 
               array(
                  'id'        => 'animate_delay',
                  'type'      => 'select',
                  'title'     => t('Animation Delay'),
                  'options'   => dardev_content_builder_delay_wow(),
                  'desc'      => '0 = default',
                  'class'     => 'width-1-2'
               ), 
               array(
                  'id'     => 'el_class',
                  'type'      => 'text',
                  'title'  => t('Extra class name'),
                  'desc'      => t('Style particular content element differently - add a class name and refer to it in custom CSS.'),
               ),
            ),                                           
         );
         for($i=1; $i<=10; $i++){
            $fields['fields'][] = array(
               'id'     => "info_{$i}",
               'type'   => 'info',
               'desc'   => "Information for item {$i}"
            );
            $fields['fields'][] = array(
               'id'        => "title_{$i}",
               'type'      => 'text',
               'title'     => t("Title {$i}")
            );
            $fields['fields'][] = array(
               'id'           => "content_{$i}",
               'type'         => 'textarea',
               'title'        => t("Content {$i}")
            );
         }
      return $fields;
      }

      public static function render_content( $attr = array(), $content = '' ){
         $default = array(
            'title'           => '',
            'style'           => '',
            'animate'         => '',
            'animate_delay'   => '',
            'el_class'        => ''
         );
         for($i=1; $i<=10; $i++){
            $default["title_{$i}"] = '';
            $default["content_{$i}"] = '';
         }
         extract(dardev_merge_atts($default, $attr));
         
         $_id = 'accordion-' . dardev_content_builder_makeid();
         $classes = $style;
         
         if($el_class) $classes .= ' ' . $el_class;

         if($animate) $classes .= ' wow ' . $animate; 
         ob_start();
         ?>
<dl class="accordion <?php print $el_class ?>">
                                   
                                   <?php for($i=1; $i<=10; $i++){ ?>
                                   <?php 
                                      $title = "title_{$i}";
                                      $content = "content_{$i}";
                                   ?>
                                   <?php if($$title){ ?>		   
                                                     <dt>
                                                         <a href="#"> <?php print $$title ?></a>
                                                     </dt>
                                                     <dd>
                                               <?php print $$content ?>                                       
                                            </dd>
                                                     
                                                     
                                                     <?php } ?>   
                                <?php } ?>  
                                                 </dl>  
         <?php  return ob_get_clean() ?>
      <?php    
      }
   }

endif;