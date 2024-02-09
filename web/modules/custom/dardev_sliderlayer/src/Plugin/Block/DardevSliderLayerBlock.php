<?php

/**
 * @file
 * Contains \Drupal\dardev_sliderlayer\Plugin\Block\DardevSliderLayerBlock.
 */

namespace Drupal\dardev_sliderlayer\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides blocks which belong to Dardev Slider.
 *
 *
 * @Block(
 *   id = "dardev_sliderlayer_block",
 *   admin_label = @Translation("Dardev SliderLayer"),
 *   category = @Translation("Dardev Slider"),
 *   deriver = "Drupal\dardev_sliderlayer\Plugin\Derivative\DardevSliderLayerBlock",
 * )
 *
 */

class DardevSliderLayerBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $sid = $this->getDerivativeId();

     $block = array();
      if (str_replace('dardev_sliderlayer_block____', '', $sid) != $sid) {
        $sid = str_replace('dardev_sliderlayer_block____', '', $sid);

        $content_block = dardev_sliderlayer_block_content($sid);
        
        if(!$content_block) $content_block =  'No block builder selected';
        $block = array(
          '#theme' => 'block-slider',
          '#content' => $content_block,
          '#cache' => array('max-age' => 0)
        );
      }

      return $block;
  }


  /**
   *  Default cache is disabled. 
   * 
   * @param array $form
   * @param \Drupal\dardev_sliderlayer\Plugin\Block\FormStateInterface $form_state
   * @return 
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $rebuild_form = parent::buildConfigurationForm($form, $form_state);
    return $rebuild_form;
  }

}
