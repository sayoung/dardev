<?php

/**
 * @file
 * Contains \Drupal\dardev_sliderlayer\Derivative\DardevSliderLayerBlock.
 */

namespace Drupal\dardev_sliderlayer\Plugin\Derivative;

use Drupal\Component\Plugin\Derivative\DeriverBase;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Plugin\Discovery\ContainerDeriverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides blocks which belong to Dardev SliderLayer.
 */
class DardevSliderLayerBlock extends DeriverBase {
  /**
   * {@inheritdoc}
   */
  public function getDerivativeDefinitions($base_plugin_definition) {
    if(!\Drupal::database()->schema()->tableExists('dardev_sliderlayergroups')){
      return "";
    }
    $results = \Drupal::database()->select('{dardev_sliderlayergroups}', 'd')
          ->fields('d', array('id', 'title'))
          ->execute();
    foreach ($results as $row) {
      $this->derivatives['dardev_sliderlayer_block____' . $row->id] = $base_plugin_definition;
      $this->derivatives['dardev_sliderlayer_block____' . $row->id]['admin_label'] = 'Dardev SliderLayer - ' . $row->title;
    }
    return $this->derivatives;
  }
}
