<?php

namespace Drupal\dardev_newsletter\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\dardev_newsletter\Helper\Helper;


use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\InvokeCommand;
use Drupal\Core\Ajax\OpenModalDialogCommand;
use Drupal\Core\Ajax\HtmlCommand;

/**
 * Class MarieForm.
 *
 * @package Drupal\dardev_newsletter\Form
 */
class NewsletterForm extends FormBase {


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'dardev_newsletter';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['email'] = array(
      '#type' => 'textfield',
      '#required' => TRUE,
      '#attributes' => array('class' => array('form-control mx-sm-3', ''), 'placeholder' => t('Adresse email')),
    );
    $form['submit'] = array(
      '#type' => 'submit',
      '#attributes' => array('class' => array('theme-btn btn-style-one')),
      '#value' => t('S\'inscrire'),
      '#suffix' => '</div>', 
      '#ajax' => [
        'callback' => [$this, 'form_ajax_submit'],
        'method' => 'replace',
        'effect' => 'fade'
      ],
    );
    $form['#attached']['library'][] = 'core/drupal.dialog.ajax';
    return $form;
  }

  /**
    * {@inheritdoc}
    */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $email_validator = \Drupal::service('email.validator');
    assert($email_validator instanceof \Egulias\EmailValidator\EmailValidator);
        if (!$email_validator->isValid($form_state
    ->getValue('email'))) {
    $form_state
      ->setErrorByName('email', $this
      ->t('That e-mail address is not valid.'));
  }

        /* $name = $form_state->getValue('candidate_name');
          if(preg_match('/[^A-Za-z]/', $name)) {
             $form_state->setErrorByName('candidate_name', $this->t('your name must in characters without space'));
          }
*/

    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {

  }

  /**
   * {@inheritdoc}
   */
public function form_ajax_submit(array &$form, FormStateInterface $form_state) {
  // Retrieve the logger service.
  $logger = \Drupal::logger('dardev_newsletter');

  $field = $form_state->getValues();
  $email = $field['email'];

  $ajax_response = new AjaxResponse();

  $fields  = [
    'email' => $email,
  ];
  $msg = "";

  try {
    $user = Helper::checkEmail($email);

    if (empty($email)) {
      $msg = "<span class=\"error\">Merci de remplire le champs avec votre adresse E-mail.</span>";
      $logger->notice('The email field was empty.');
    } elseif (!$user) {
      if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $query = \Drupal::database();
        $query->insert('dardev_newsletter_emails')
               ->fields($fields)
               ->execute();
        $msg = "<span class=\"success\">Votre adresse a été enregistrée.</span>";
        $logger->notice('Newsletter subscription successful for email: @email', ['@email' => $email]);
      } else {
        $msg = "<span class=\"error\">L'adresse email '" . $email . "' est invalide.</span>";
        $logger->warning('Invalid email address submitted: @email', ['@email' => $email]);
      }
    } else {
      $msg = "<span class=\"error\">L'adresse email '" . $email . "' existe déjà.</span>";
      $logger->notice('Duplicate email address submission: @email', ['@email' => $email]);
    }
  } catch (\Exception $e) {
    $msg = "<span class=\"error\">Une erreur s'est produite lors de l'enregistrement de l'adresse e-mail.</span>";
    $logger->error('Error in form_ajax_submit: @message', ['@message' => $e->getMessage()]);
  }

  $ajax_response->addCommand(new OpenModalDialogCommand(t('Newsletter'), $msg, ['width' => '400']));
  ob_end_clean();
  return $ajax_response;
}


}
