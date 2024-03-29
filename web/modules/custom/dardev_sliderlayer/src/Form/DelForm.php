<?php
namespace Drupal\dardev_sliderlayer\Form;
use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

class DelForm extends ConfirmFormBase  {
   /**
   * The ID of the item to delete.
   *
   * @var string
   */
    protected $sid;

    protected $gid;

    protected $action;
   /**
   * Implements \Drupal\Core\Form\FormInterface::getFormID().
   */
   public function getFormID() {
      return 'del_form';
   }
  
  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    if($this->action == 'slider'){
      return t('Do you want to delete Slider #%id?', array('%id' => $this->sid));
    }
    if($this->action == 'group'){
      return t('Do you want to delete Group Slider #%id?', array('%id' => $this->gid));
    }
  }

  /**
   * {@inheritdoc}
   */
    public function getCancelUrl() {
      if($this->action == 'slider'){
        return new Url('dardev_sl_sliders.admin.list', array('gid'=>$this->gid));
      }else{
        return new Url('dardev_sl_group.admin');
      }
  }

  /**
   * {@inheritdoc}
   */
    public function getDescription() {
    return t('Only do this if you are sure!');
  }

  /**
   * {@inheritdoc}
   */
    public function getConfirmText() {
    return t('Delete it!');
  }

  /**
   * {@inheritdoc}
   */
    public function getCancelText() {
    return t('Cancel');
  }

  /**
   * {@inheritdoc}
   *
   * @param int $id
   *   (optional) The ID of the item to be deleted.
   */
  public function buildForm(array $form, FormStateInterface $form_state, $sid = 0, $gid = 0, $action='') {
    $this->sid = $sid;
    $this->gid = $gid;
    $this->action = $action;
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $sid = $this->sid;
    $gid = $this->gid;
    $action = $this->action;
    if($action=='group'){
      
      \Drupal::database()->delete('dardev_sliderlayergroups')
        ->condition('id', $gid)
        ->execute();

      \Drupal::database()->delete('dardev_sliderlayers')
        ->condition('group_id', $gid)
        ->execute(); 

      \Drupal::service('plugin.manager.block')->clearCachedDefinitions();
      \Drupal::messenger()->addMessage("SliderLayer Group '#{$gid}' has been deleted");
      $response = new \Symfony\Component\HttpFoundation\RedirectResponse(Url::fromRoute('dardev_sl_group.admin')->toString());
      $response->send();
    }

    if($action=='slider'){
      
      \Drupal::database()->delete('dardev_sliderlayers')
        ->condition('id', $sid)
        ->execute(); 

      \Drupal::service('plugin.manager.block')->clearCachedDefinitions();
      \Drupal::messenger()->addMessage("SliderLayer item '#{$sid}' has been deleted");
      $response = new \Symfony\Component\HttpFoundation\RedirectResponse(Url::fromRoute('dardev_sl_sliders.admin.list', array('gid' => $gid))->toString());
      $response->send();  

    }

  }
}