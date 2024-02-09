<?php

/**
 * @file
 * Contains \Drupal\dardev_pagebuilder\Plugin\Block\DardevPageBuilderBlock.
 */

namespace Drupal\dardev_pagebuilder\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Provides blocks which belong to Dardev Block Builder.
 *
 *
 * @Block(
 *   id = "dardev_pagebuilder_block",
 *   admin_label = @Translation("Dardev Block Builder"),
 *   category = @Translation("Dardev Block Builder"),
 *   deriver = "Drupal\dardev_pagebuilder\Plugin\Derivative\DardevPageBuilderBlock",
 * )
 *
 */

class DardevPageBuilderBlock extends BlockBase {

  protected $bid;

  /**
   * {@inheritdoc}
   */
  public function build() {
    $bid = $this->getDerivativeId();
    $this->bid = $bid;
     $block = array();
      if (str_replace('dardev_pagebuilder_block____', '', $bid) != $bid) {
        $bid = str_replace('dardev_pagebuilder_block____', '', $bid);
        $results = dardev_pagebuilder_load($bid);
        if(!$results) return 'No block builder selected';
        $content_block = dardev_pagebuilder_frontend($results->params);
        $user = \Drupal::currentUser();
        $url = \Drupal::request()->getRequestUri();
        $edit_url = '';
        if($user->hasPermission('administer dardev_pagebuilder')){
          $edit_url = Url::fromRoute('dardev_pagebuilder.admin.edit', array('bid' => $bid, 'destination' =>  $url))->toString();
        }
        $block = array(
          '#theme' => 'builder',
          '#content' => $content_block,
          '#edit_url' => $edit_url,
          '#cache' => array('max-age' => 0)
        );
      }

      return $block;
  }
  /**
   *  Default cache is disabled. 
   * 
   * @param array $form
   * @param \Drupal\dardev_pagebuilder\Plugin\Block\FormStateInterface $form_state
   * @return 
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $rebuild_form = parent::buildConfigurationForm($form, $form_state);
    $rebuild_form['cache']['max_age']['#default_value'] = 0;
    return $rebuild_form;
  }
}
