<?php

/**
 * @file
 * Contains \Drupal\dardev_view\Plugin\views\style\drvportfolio.
 */

namespace Drupal\dardev_view\Plugin\views\style;

use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\style\StylePluginBase;
/**
 *
 * @ingroup views_style_plugins
 *
 * @ViewsStyle(
 *   id = "drvportfolio",
 *   title = @Translation("Dardev Portfolio"),
 *   help = @Translation("Displays items as Dardev Portfolio."),
 *   theme = "views_view_drvportfolio",
 *   display_types = {"normal"}
 * )
 */
class drvportfolio extends StylePluginBase {

  /**
   * Does the style plugin allows to use style plugins.
   *
   * @var bool
   */
  protected $usesRowPlugin = TRUE;

  /**
   * Does the style plugin support custom css class for the rows.
   *
   * @var bool
   */
  protected $usesRowClass = TRUE;

  /**
   * Set default options
   */
  protected function defineOptions() {
    $options = parent::defineOptions();

    $settings = dardev_view_owl_default_settings();
    foreach ($settings as $k => $v) {
      $options[$k] = array('default' => $v);
    }
    return $options;
  }

  /**
   * Render the given style.
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);
    
    $options_tid = array('' => $this->t('- None -'));
    $field_labels = $this->displayHandler->getFieldLabels(TRUE);
    $options_tid += $field_labels;

    $options_taxonomy = array();
    $vocabularies = \Drupal\taxonomy\Entity\Vocabulary::loadMultiple();
    foreach($vocabularies as $taxonomy){
      $options_taxonomy[$taxonomy->get('vid')] = $taxonomy->get('name');
    }

    $form['taxonomy'] = array(
      '#type' => 'select',
      '#title' => $this->t('Taxonomy Filter'),
      '#default_value' => $this->options['taxonomy'],
      '#options' => $options_taxonomy,
    );

    $form['field_tid'] = array(
      '#type' => 'select',
      '#title' => $this->t('Field Term ID for content'),
      '#default_value' => isset($this->options['field_tid']) ? $this->options['field_tid'] : '',
      '#options' => $options_tid,
    );

    $form['columns'] = array(
      '#type' => 'select',
      '#title' => $this->t('Columns for items'),
      '#default_value' => isset($this->options['columns']) ? $this->options['columns'] : 3,
      '#options' => array('6'=>6, '4'=> 4, '3' => 3, '2'=>2, '1'=> 1)
    );

    $form['show_all'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Display Button "All"'),
      '#default_value' => isset($this->options['show_all']) ? $this->options['show_all'] : false,
    );

     $form['tids'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Custom taxonomy term tabs filter'),
      '#default_value' => isset($this->options['tids']) ? $this->options['tids'] : '',
      '#description' => t('List id for term show in tabs filter, eg: 1, 2, 3, 4, 5. Show all term if empty')
    );

    $form['el_class'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Extra class name'),
      '#default_value' => isset($this->options['el_class']) ? $this->options['el_class'] : ''
    );

    $form['slideset'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Use Slideset'),
      '#default_value' => isset($this->options['slideset']) ? $this->options['slideset'] : ''
    );

    $form['bootstrap_4'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Theme use Bootstrap 4'),
      '#default_value' => isset($this->options['bootstrap_4']) ? $this->options['bootstrap_4'] : ''
    );
  }
}


