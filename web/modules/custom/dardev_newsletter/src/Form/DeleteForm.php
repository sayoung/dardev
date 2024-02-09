<?php

namespace Drupal\dardev_newsletter\Form;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

class DeleteForm extends ConfirmFormBase {

  public $cid;

  public function getFormId() {
    return 'delete_form';
  }

  public function getQuestion() {
    return $this->t('Do you want to delete %cid?', ['%cid' => $this->cid]);
  }

  public function getCancelUrl() {
    return new Url('dardev_newsletter.display_table_controller_display');
  }

  public function getDescription() {
    return $this->t('Only do this if you are sure!');
  }

  public function getConfirmText() {
    return $this->t('Delete it!');
  }

  public function getCancelText() {
    return $this->t('Cancel');
  }

  public function buildForm(array $form, FormStateInterface $form_state, $cid = NULL) {
    $this->cid = $cid; // Ensure property name consistency
    return parent::buildForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    \Drupal::database()->delete('dardev_newsletter_emails')
      ->condition('id', $this->cid)
      ->execute();
    
    $this->messenger()->addMessage($this->t('Successfully deleted.'));
    $form_state->setRedirect('dardev_newsletter.display_table_controller_display');
  }
}
