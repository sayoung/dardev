<?php
namespace Drupal\dardev_sliderlayer\Form;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\Core\Form\FormInterface;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\HttpFoundation;
use Drupal\Core\Url;

class GroupClone implements FormInterface {
   /**
   * Implements \Drupal\Core\Form\FormInterface::getFormID().
   */
   public function getFormID() {
      return 'clone_form';
   }

   /**
    * Implements \Drupal\Core\Form\FormInterface::buildForm().
   */
   public function buildForm(array $form, FormStateInterface $form_state) {
      $sid = 0;
      if(\Drupal::request()->attributes->get('sid')) $sid = \Drupal::request()->attributes->get('sid');
      
      if (is_numeric($sid)) {
        $slide = \Drupal::database()->select('{dardev_sliderlayergroups}', 'd')
                 ->fields('d')
                 ->condition('id', $sid, '=')
                 ->execute()->fetchAssoc();
        } else {
            $slide = array('id' => 0, 'title' => '', 'params' => '');
        }
        $form = array();
        $form['id'] = array(
            '#type' => 'hidden',
            '#default_value' => $slide['id']
        );
        $form['title'] = array(
            '#type' => 'textfield',
            '#title' => t('Title'),
            '#default_value' => t('Clone ') . $slide['title']
        );
        $form['params'] = array(
          '#type' => 'hidden',
          '#default_value' => $slide['params']
        );
        $form['submit'] = array(
            '#type' => 'submit',
            '#value' => t('Save')
        );

      $form['actions'] = array('#type' => 'actions');
      $form['submit'] = array(
        '#type' => 'submit',
        '#value' => t('Save')
      );
    return $form;
   }

   /**
   * Implements \Drupal\Core\Form\FormInterface::validateForm().
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
      if (isset($form['values']['title']) && $form['values']['title'] === '' ) {
         $this->setFormError('title', $form_state, $this->t('Please enter title for slider.'));
       } 
   }

   /**
   * Implements \Drupal\Core\Form\FormInterface::submitForm().
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    if (is_numeric($form['id']['#value']) && $form['id']['#value'] > 0) {
      $old_id = $form['id']['#value'];
      $new_gid = $builder = \Drupal::database()->insert("dardev_sliderlayergroups")
      ->fields(array(
          'title' => $form['title']['#value'],
          'params' => $form['params']['#value']
      ))
      ->execute();
      
      $slides = dardev_sliders_by_group($old_id);

      foreach ($slides as $key => $slide) {
        $builder = \Drupal::database()->insert("dardev_sliderlayers")
        ->fields(array(
          'title'         => (isset($slide->title) && $slide->title) ? $slide->title : '',
          'group_id'      => $new_gid,
          'sort_index'    => (isset($slide->sort_index) && $slide->sort_index) ? $slide->sort_index : 1,
          'params'        => (isset($slide->params) && $slide->params) ? $slide->params : '',
          'layersparams'  => (isset($slide->layersparams) && $slide->layersparams) ? $slide->layersparams : '',
          'status'        => (isset($slide->status)) ? $slide->status : 1,
          'background_image_uri' => (isset($slide->background_image_uri) && $slide->background_image_uri) ? $slide->background_image_uri : ''
        ))
        ->execute();
      }

      \Drupal::messenger()->addMessage("Slide '{$form['title']['#value']}' has been cloned");
      \Drupal::service('plugin.manager.block')->clearCachedDefinitions();
    }
    $response = new \Symfony\Component\HttpFoundation\RedirectResponse(Url::fromRoute('dardev_sl_group.admin')->toString());
    $response->send();
   }
}