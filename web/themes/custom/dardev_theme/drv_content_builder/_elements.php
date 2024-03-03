<?php
function dardev_content_builder_set_elements(){
   return $shortcodes = array(
    'drv_column',
    'drv_row',
    'drv_accordion',
    'drv_chiffre_cle',
    'drv_view',
    'drv_our_service',
    'drv_our_service_style_2',
    'drv_our_service_style_3',
    'drv_element_slider',
    'drv_element_slider_multiple',
    'drv_element_progress',
    'drv_element_tabs',
    'drv_our_story',
    'drv_services_carousel',
    'drv_box_color',
    'drv_box_hover',
    'drv_button',
    'drv_call_to_action',
    'drv_carousel_content',
    'drv_chart',
    'drv_code',
    'drv_counter',
    'drv_download',
    'drv_drupal_block',
    'drv_gallery',
    'drv_gmap',
    'drv_heading',
    'drv_icon_box_classic',
    'drv_icon_box_number',
    'drv_icon_box_style',
    'drv_image',
    'drv_image_content',
    'drv_images_parallax',
    'drv_job_box',
    'drv_links',
    'drv_our_partners',
    'drv_our_team',
    'drv_pricing_item',
    'drv_progress',
    'drv_progress_work',
    'drv_progress_work_list',
    'drv_quote_text',
    'drv_socials',
    'drv_tabs',
    'drv_tabs_content',
    'drv_quotes_rotator',
    'drv_text',
    'drv_text_noeditor',
    'drv_text_rotate',
    'drv_video_box',

  );
}

function dardev_merge_atts( $pairs, $atts, $shortcode = '' ) {
    $atts = (array)$atts;
    $out = array();
    foreach($pairs as $name => $default) {
        if ( array_key_exists($name, $atts) )
            $out[$name] = $atts[$name];
        else
            $out[$name] = $default;
    }
    return $out;
}

function dardev_carousel_fields_settings(&$fields){
    $fields[] = array(
       'id'     => "carousel_settings",
       'type'   => 'info',
       'desc'   => "Carousel Settings"
    );
    $fields['fields'][] = array(
       'id'        => "col_lg",
       'type'      => 'select',
       'title'     => t("Columns for Large Screen"),
       'class'       => 'width-1-4',
       'options'   => array(
            '1'   => '1',
            '2'   => '2',
            '3'   => '3',
            '4'   => '4',
            '5'   => '5',
            '6'   => '6',
          ),
       'default'   => '4'
    );
    $fields['fields'][] = array(
       'id'        => "col_md",
       'type'      => 'select',
       'title'     => t("Columns for Medium Screen"),
       'class'       => 'width-1-4',
       'options'   => array(
            '1'   => '1',
            '2'   => '2',
            '3'   => '3',
            '4'   => '4',
            '5'   => '5',
            '6'   => '6',
          ),
       'default'   => '3'
    );
    $fields['fields'][] = array(
       'id'        => "col_sm",
       'type'      => 'select',
       'title'     => t("Columns for Small Screen"),
       'class'       => 'width-1-4',
       'options'   => array(
            '1'   => '1',
            '2'   => '2',
            '3'   => '3',
            '4'   => '4',
            '5'   => '5',
            '6'   => '6',
          ),
       'default'   => '2'
    );
    $fields['fields'][] = array(
       'id'        => "col_xs",
       'type'      => 'select',
       'title'     => t("Columns for Extra Small"),
       'class'       => 'width-1-4',
       'options'   => array(
            '1'   => '1',
            '2'   => '2',
            '3'   => '3',
            '4'   => '4',
            '5'   => '5',
            '6'   => '6',
          ),
       'default'   => '1'
    );
    $fields['fields'][] = array(
       'id'        => "auto_play",
       'type'      => 'select',
       'title'     => t("Auto Play"),
       'class'       => 'width-1-4',
       'options'   => array(
            '0'   => 'Disable',
            '1'   => 'Enable',
          ),
       'default'   => '1'
    );
    $fields['fields'][] = array(
       'id'        => "pagination",
       'type'      => 'select',
       'title'     => t("Pagination"),
       'class'       => 'width-1-4',
       'options'   => array(
            '0'   => 'Disable',
            '1'   => 'Enable',
          ),
       'default'   => '0'
    );
    $fields['fields'][] = array(
       'id'        => "navigation",
       'type'      => 'select',
       'title'     => t("Navigation"),
       'class'       => 'width-1-4',
       'options'   => array(
            '0'   => 'Disable',
            '1'   => 'Enable',
          ),
       'default'   => '0'
    );
    return $fields;
}
