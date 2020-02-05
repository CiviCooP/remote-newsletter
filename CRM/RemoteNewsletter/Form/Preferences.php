<?php
/**
 * @author Klaas Eikelboom  <klaas.eikelboom@civicoop.org>
 * @date 05-Feb-2020
 * @license  AGPL-3.0
 */

use CRM_RemoteNewsletter_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */


class CRM_RemoteNewsletter_Form_Preferences extends CRM_Core_Form {

  const REMOTE_NEWSLETTER = 'Remote Newsletter';
  private $keys = ['remotenewsletter_groups','remotenewsletter_dedupe_id','remotenewsletter_unsubscribe_url','remotenewsletter_unsubscribe_url_text'];
  var $_group = null;

  private function groups()
  {
    $options = [];
    $result = civicrm_api3('Group', 'get', [
      'return' => ["id", "title"],
      'is_active' => 1,
      'group_type' => "Mailing List",
      'options' => ['limit' => 0],
    ]);
    foreach($result['values'] as $value){
       $options[$value['id']]=$value['title'];
    }
    return $options;
  }

  /**
   *
   */
  public function buildQuickForm() {

    $this->addEntityRef('remotenewsletter_groups', 'Groups to subscribe' ,[
      'entity' => 'group',
      'placeholder' => ts('- Select Group -'),
      'api' => [
        'params' =>  [ 'return' => ["id", "title"],
                       'is_active' => 1,
                       'group_type' => "Mailing List",
                       'options' => ['limit' => 0]
       ],
      ],
      'select' => ['minimumInputLength' => 0,
                   'multiple'=>true],
    ]);

    $this->addEntityRef('remotenewsletter_dedupe_id', 'Dedupe Rule' ,[
      'entity' => 'RuleGroup',
      'placeholder' => ts('- Select Group -'),
      'api' => [
        'params' =>  [ 'return' => ["id", "title"],
          'contact_type' => "Individual",
          'used' => 'Unsupervised',
        ],
      ],
      'select' => ['minimumInputLength' => 0]
    ]);

    $this->add('text','remotenewsletter_unsubscribe_url','Remote Newsletter URL');
    $this->add('text','remotenewsletter_unsubscribe_url_text','Remote Newsletter URL Text');

    $this->addButtons([
      [
        'type' => 'submit',
        'name' => ts('Submit'),
        'isDefault' => TRUE,
      ],
    ]);
    $this->assign('elementNames', $this->getRenderableElementNames());
    parent::buildQuickForm();
  }

  /**
   * @return array|mixed|NULL
   */
  function setDefaultValues() {
    parent::setDefaultValues();
    foreach($this->keys as $key) {
      $values[$key] = Civi::settings()->get($key);
    }
    return $values;
  }

  /**
   *
   */
  function postProcess() {
    $values = $this->exportValues();
    foreach($this->keys as $key)
    {
      Civi::settings()->set($key,$values[$key]);
    }
    parent::postProcess();
  }

  /**
   * Get the fields/elements defined in this form.
   *
   * @return array (string)
   */
  public function getRenderableElementNames() {
    // The _elements list includes some items which should not be
    // auto-rendered in the loop -- such as "qfKey" and "buttons".  These
    // items don't have labels.  We'll identify renderable by filtering on
    // the 'label'.
    $elementNames = array();
    foreach ($this->_elements as $element) {
      /** @var HTML_QuickForm_Element $element */
      $label = $element->getLabel();
      if (!empty($label)) {
        $elementNames[] = $element->getName();
      }
    }
    return $elementNames;
  }

}
