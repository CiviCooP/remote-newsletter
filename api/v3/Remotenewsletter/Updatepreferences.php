<?php
/**
 * @author Klaas Eikelboom  <klaas.eikelboom@civicoop.org>
 * @date 05-Feb-2020
 * @license  AGPL-3.0
 */

use CRM_RemoteNewsletter_ExtensionUtil as E;

/**
 * Remotenewsletter.Updatepreferences API specification (optional)
 * This is used for documentation and validation.
 *
 * @param array $spec description of fields supported by this API call
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/api-architecture/
 */
function _civicrm_api3_remotenewsletter_Updatepreferences_spec(&$spec) {
  $spec['contact_id'] = [
    'api.required' => 1,
    'type' => CRM_Utils_Type::T_INT,
    'description' => 'Preferences of the subscriber',
  ];
}

/**
 * Remotenewsletter.Updatepreferences API
 *
 * @param array $params
 *
 * @return array
 *   API result descriptor
 *
 * @see civicrm_api3_create_success
 *
 * @throws API_Exception
 */
function civicrm_api3_remotenewsletter_Updatepreferences($params) {

  $contactId = $params['contact_id'];
  $subscriptions = $params['subscriptions'];
  foreach($subscriptions as $subscription){
    if($subscription['subscription']){
      $result = civicrm_api3('GroupContact','create',[
         'group_id' => $subscription['group_id'],
         'contact_id' => $contactId,
         'status' => 'Added'
      ]);
    } else {
      $result = civicrm_api3('GroupContact','create',[
        'group_id' => $subscription['group_id'],
        'contact_id' => $contactId,
        'status' => 'Removed'
      ]);
    }
  }
  return civicrm_api3_create_success([], $params, 'Remotenewsletter', 'Updatepreferences');

}
