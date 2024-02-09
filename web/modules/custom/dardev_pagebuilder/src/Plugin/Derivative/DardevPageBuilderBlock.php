<?php

/**
 * @file
 * Contains \Drupal\dardev_pagebuilder\Derivative\DardevPageBuilderBlock.
 */

namespace Drupal\dardev_pagebuilder\Plugin\Derivative;

use Drupal\Component\Plugin\Derivative\DeriverBase;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Plugin\Discovery\ContainerDeriverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides blocks which belong to Dardev Blockbuilder.
 */
class DardevPageBuilderBlock extends DeriverBase {
  /**
   * {@inheritdoc}
   */
  public function getDerivativeDefinitions($base_plugin_definition) {
    if(\Drupal::database()->schema()->tableExists('dardev_pagebuilder')){
      $results = \Drupal::database()->select('{dardev_pagebuilder}', 'd')
            ->fields('d', array('id', 'title'))
            ->execute();

      foreach ($results as $row) {
        $this->derivatives['dardev_pagebuilder_block____' . $row->id] = $base_plugin_definition;
        $this->derivatives['dardev_pagebuilder_block____' . $row->id]['admin_label'] = 'Dardev Content Builder - ' . $row->title;
      }
    }
    return $this->derivatives;
  }
}
