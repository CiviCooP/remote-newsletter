<?php
/**
 * @author Klaas Eikelboom  <klaas.eikelboom@civicoop.org>
 * @date 05-Feb-2020
 * @license  AGPL-3.0
 */

use CRM_RemoteNewsletter_ExtensionUtil as E;

/**
 * Remotenewsletter.Preferences API specification (optional)
 * This is used for documentation and validation.
 *
 * @param array $spec description of fields supported by this API call
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/api-architecture/
 */
function _civicrm_api3_remotenewsletter_Preferences_spec(&$spec) {
  $spec['contact_id'] = [
    'api.required' => 1,
    'type' => CRM_Utils_Type::T_INT,
    'description' => 'Preferences of the subscriber',
  ];
}

/**
 * Remotenewsletter.Preferences API
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
function civicrm_api3_remotenewsletter_Preferences($params) {

  $utils = new CRM_RemoteNewsletter_Utils();
  $result = civicrm_api3('Contact', 'getsingle', [
    'return' => ["display_name", "email"],
    'id' => $params['contact_id'],
  ]);
  $result['subscriptions'] = $utils->subscriptions($params['contact_id']);

  return civicrm_api3_create_success($result, $params, 'Remotenewsletter', 'Preferences');

}
