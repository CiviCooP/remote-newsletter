<?php
/**
 * @author Klaas Eikelboom  <klaas.eikelboom@civicoop.org>
 * @date 05-Feb-2020
 * @license  AGPL-3.0
 */

use CRM_RemoteNewsletter_ExtensionUtil as E;

/**
 * Remotenewsletter.List API
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
function civicrm_api3_remotenewsletter_List($params) {

  $groups =  explode(',',Civi::settings()->get('remotenewsletter_groups'));
  $returnValues = civicrm_api3('Group', 'get', [
    'sequential' => 1,
    'return' => ["title", "id"],
    'id' => ['IN' => $groups],
   ])['values'];
   return civicrm_api3_create_success($returnValues, $params, 'Remotenewsletter', 'List');

}
