<?php

use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\Unicode;
use Drupal\Core\Url;
use Drupal\Core\Menu\MenuLinkInterface;
use Drupal\Component\Plugin\Exception\PluginNotFoundException;

function dardev_theme_preprocess_menu__main(&$variables) {
  $variables['attributes']['class'][] = 'clearfix';

  foreach ($variables['items'] as &$item) {
   $menu_link_attributes = _dardev_theme_attributes_get_attributes($item['original_link']);

      if (count($menu_link_attributes)) {
        $url_attributes = $item['url']->getOption('attributes') ?: [];
        $attributes = array_merge($url_attributes, $menu_link_attributes);

        $item['url']->setOption('attributes', $attributes);
        $item['drv_block_content'] = '';
        $item['attributes']['drv_class'] = (isset($attributes['drv_class']) && $attributes['drv_class']) ? trim($attributes['drv_class']): '';
        $item['attributes']['drv_icon'] = (isset($attributes['drv_icon']) && $attributes['drv_icon']) ? trim($attributes['drv_icon']): '';
        $item['attributes']['drv_layout'] = (isset($attributes['drv_layout']) && $attributes['drv_layout']) ? $attributes['drv_layout']: '';
        $item['attributes']['drv_layout_columns'] = (isset($attributes['drv_layout_columns']) && $attributes['drv_layout_columns']) ? $attributes['drv_layout_columns']: 4;
        $item['attributes']['drv_block'] = (isset($attributes['drv_block']) && $attributes['drv_block']) ? $attributes['drv_block']: '';
        if(isset($attributes['drv_layout']) && $attributes['drv_layout']=='menu-block'){
          $item['drv_block_content'] = dardev_theme_render_block($attributes['drv_block']);
        }
     }
   }
}

function _dardev_theme_attributes_get_attributes(MenuLinkInterface $menu_link_content_plugin) {
  $attributes = [];
  try {
    $plugin_id = $menu_link_content_plugin->getPluginId();
  }
  catch (PluginNotFoundException $e) {
    return $attributes;
  }
  if (strpos($plugin_id, ':') === FALSE) {
    return $attributes;
  }
  list($entity_type, $uuid) = explode(':', $plugin_id, 2);

  if ($entity_type == 'menu_link_content') {
    $entity = \Drupal::entityTypeManager()->getStorage('menu_link_content')->loadByProperties(['uuid' => $uuid]);
    if (count($entity)) {
      $entity_values = array_values($entity)[0];
      $options = $entity_values->link->first()->options;
      $attributes = isset($options['attributes']) ? $options['attributes'] : [];
    }
  }
  return $attributes;
}