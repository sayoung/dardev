<?php

namespace Drupal\dardev_newsletter\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Url;
use Drupal\Core\Link;
/**
 * Class DisplayTableController.
 *
 * @package Drupal\dardev_newsletter\Controller
 */
class DisplayTableController extends ControllerBase {


  public function getContent() {
    // First we'll tell the user what's going on. This content can be found
    // in the twig template file: templates/description.html.twig.
    // @todo: Set up links to create nodes and point to devel module.
    $build = [
      'description' => [
        '#theme' => 'dardev_newsletter_description',
        '#description' => 'foo',
        '#attributes' => [],
      ],
    ];
    return $build;
  }

  /**
   * Display.
   *
   * @return string
   *   Return Hello string.
   */
  public function display() {
    /**return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: display with parameter(s): $name'),
    ];*/

    //create table header
    $header_table = array(
      'id' => t('ID'),
      'email' => t('Email'),
    );

//select records from table
    $query = \Drupal::database()->select('dardev_newsletter_emails', 'm');
      $query->fields('m', ['id','email']);
      $query->orderBy('id', 'desc');
      $results = $query->execute()->fetchAll();
        $rows=array();
    foreach($results as $data){
        $delete = Url::fromUserInput('/admin/config/dardev_newsletter/delete/'.$data->id);
        //$edit   = Url::fromUserInput('/backoffice/dardev_newsletter/form/dardev_newsletter?num='.$data->id);

      //print the data from table
             $rows[] = array(
                'id' =>$data->id,
                'email' => $data->email,

                Link::fromTextAndUrl('Delete', $delete),
                 //\Drupal::l('Edit', $edit),
            );

    }
    //display data in site
    $form['table'] = [
            '#type' => 'table',
            '#header' => $header_table,
            '#rows' => $rows,
            '#empty' => t('No emails found'),
        ];
//        echo '<pre>';print_r($form['table']);exit;
        return $form;

  }

}
