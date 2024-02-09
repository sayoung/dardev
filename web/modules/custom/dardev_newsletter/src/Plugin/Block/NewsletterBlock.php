<?php

namespace Drupal\dardev_newsletter\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'NewsletterBlock' block.
 *
 * @Block(
 *  id = "dardev_newsletter_block",
 *  admin_label = @Translation(" Newsletter block"),
 * )
 */
class NewsletterBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $form = \Drupal::formBuilder()->getForm('\Drupal\dardev_newsletter\Form\NewsletterForm');
    return array(
        '#theme' => 'newsletter',
        '#form' =>  (object)array('form' => $form)
    );
  }

}
