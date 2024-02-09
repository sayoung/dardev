<?php

namespace Drupal\dardev_newsletter\Helper;
use Drupal\Core\Database\Database;

Class Helper{
    
  const SETTINGS = 'newsletter.settings';
  
  public static function checkEmail($email){
    $conn = Database::getConnection();
    $record = array();
    $query = $conn->select('dardev_newsletter_emails', 'm')
        ->condition('email', $email)
        ->fields('m');
    return $query->execute()->fetchAssoc();
  }

  public static function listEmails(){
    $query = \Drupal::database()->select('dardev_newsletter_emails', 'm');
    $query->fields('m', ['id', 'email']);
    return $query->execute()->fetchAll();
  }

}
