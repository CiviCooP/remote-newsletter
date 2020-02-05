<?php
/**
 * @author Klaas Eikelboom  <klaas.eikelboom@civicoop.org>
 * @date 05-Feb-2020
 * @license  AGPL-3.0
 */

use CRM_RemoteNewsletter_ExtensionUtil as E;

/**
 * Remotenewsletter.Validatechecksum API specification (optional)
 * This is used for documentation and validation.
 *
 * @param array $spec description of fields supported by this API call
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/api-architecture/
 */
function _civicrm_api3_remotenewsletter_Validatechecksum_spec(&$spec) {
  $spec['contact_id'] = [
    'api.required' => 1,
    'type' => CRM_Utils_Type::T_INT,
    'description' => 'Contact ID'
  ];
  $spec['checksum'] = [
    'api.required' => 1,
    'type' => CRM_Utils_Type::T_STRING,
    'description' => 'CheckSum'
  ];
}

/**
 * Remotenewsletter.Validatechecksum API
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
function civicrm_api3_remotenewsletter_Validatechecksum($params) {
   $result = CRM_Contact_BAO_Contact_Utils::validChecksum(
     $params['contact_id'],
     $params['checksum']
   );
   $values['valid'] = $result?1:0;
   return civicrm_api3_create_success($values, $params, 'Remotenewsletter', 'Subscribe');
}
