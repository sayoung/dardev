<?php

/**
 * @file
 * Contains \Drupal\dardev_sliderlayer\Controller\GroupSliderController.
 */

namespace Drupal\dardev_sliderlayer\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;
use Drupal\Core\Url;

class GroupSliderController extends ControllerBase {

  public function dardev_sl_group_list(){
  
    if(!\Drupal::database()->schema()->tableExists('dardev_sliderlayergroups')){
      return "";
    }

    $header = array( 'ID', 'Name', 'Action');
    
    $results = \Drupal::database()->select('{dardev_sliderlayergroups}', 'd')
            ->fields('d', array('id', 'title'))
            ->execute();
    $rows = array();

    foreach ($results as $row) {

      $tmp =  array();
      $tmp[] = $row->id;
      $tmp[] = $row->title;
      $tmp[] = t('<a href="@link_1">Edit Name</a> | <a href="@link_2">List Silders</a> | <a href="@link_3">Config General</a> | <a href="@link_5">Clone</a> | <a href="@link_6">Export</a> | <a href="@link_7">Import</a> | <a href="@link_4">Delete</a>', array(
            '@link_1' => Url::fromRoute('dardev_sl_group.admin.add', array('sid' => $row->id))->toString(),
            '@link_2' => Url::fromRoute('dardev_sl_sliders.admin.list', array('gid' => $row->id))->toString(),
            '@link_3' => Url::fromRoute('dardev_sl_group.admin.config', array('gid' => $row->id))->toString(),
            '@link_5' => Url::fromRoute('dardev_sl_group.admin.clone', array('sid' => $row->id))->toString(),
            '@link_6' => Url::fromRoute('dardev_sl_group.admin.export', array('gid' => $row->id))->toString(),
            '@link_7' => Url::fromRoute('dardev_sl_group.admin.import', array('gid' => $row->id))->toString(),
            '@link_4' => Url::fromRoute('dardev_sl_group.admin.delete', array('gid' => $row->id, 'sid' => '0', 'action' => 'group'))->toString()
        ));
      $rows[] = $tmp;
    }
    return array(
      '#theme' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#empty' => t('No Slider available. <a href="@link">Add Slider</a>.', array('@link' => Url::fromRoute('dardev_sl_group.admin.add', array('sid'=>0))->toString())),
    );
  }

  public function dardev_sl_group_config($gid){
    global $base_url;
    $page['#attached']['library'][] = 'dardev_sliderlayer/dardev_sliderlayer.assets.config_global';
    $slideshow = getSliderGroup($gid);
    $settings = ((isset($slideshow->params) && $slideshow->params) ? json_decode(base64_decode($slideshow->params)):'{}');
    
    $save_url = Url::fromRoute('dardev_sl_group.admin.config_save', array(), array('absolute' => FALSE))->toString();
    $page['#attached']['drupalSettings']['dardev_sliderlayer']['base_url'] = $base_url;
    $page['#attached']['drupalSettings']['dardev_sliderlayer']['save_url'] = $save_url;
    $page['#attached']['drupalSettings']['dardev_sliderlayer']['settings'] = $settings;

    ob_start();
    include GAV_SLIDERLAYER_PATH . '/templates/backend/global.php';
    $content = ob_get_clean();
    $page['admin-global'] = array(
      '#theme' => 'admin-global',
      '#content' => $content
    );
    return $page;
  }

  public function dardev_sl_group_config_save(){
    header('Content-type: application/json');
    $gid = $_REQUEST['gid'];
    $settings = $_REQUEST['settings'];
    
    $builder = \Drupal::database()->update("dardev_sliderlayergroups")->fields(array(
        'params'  => $settings,
    ))->condition('id', $gid, '=')->execute();
    $result = array(
      'data' => 'update saved'
    );
    
    // Clear all cache
    \Drupal::service('plugin.manager.block')->clearCachedDefinitions();     
    $module_handler = \Drupal::moduleHandler();
    $module_handler->invokeAll('rebuild');

    \Drupal::messenger()->addMessage("Group Slider has been updated");
    print json_encode($result);
    exit(0);
  }

  public function dardev_sl_group_export($gid){
    $data = dardev_sliderlayer_export($gid);
    //print"<pre>"; print_r(json_decode(base64_decode($data)));die();

    $title = 'sliderlayer_' . date('Y_m_d_h_i_s'); 
    header("Content-Type: text/txt");
    header("Content-Disposition: attachment; filename={$title}.txt");
    //header("Content-Length: " . strlen($data));
    print $data;
    exit;
  }
}
