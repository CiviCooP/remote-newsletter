<?php
/**
 * @author Klaas Eikelboom  <klaas.eikelboom@civicoop.org>
 * @date 05-Feb-2020
 * @license  AGPL-3.0
 */

use CRM_RemoteNewsletter_ExtensionUtil as E;

/**
 * Remotenewsletter.Subscribe API specification (optional)
 * This is used for documentation and validation.
 *
 * @param array $spec description of fields supported by this API call
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/api-architecture/
 */
function _civicrm_api3_remotenewsletter_Subscribe_spec(&$spec) {
  $spec['first_name'] = [
     'api.required' => 1,
     'type' => CRM_Utils_Type::T_STRING,
     'description' => 'First name of the subscriber'
    ];
  $spec['last_name'] = [
    'api.required' => 1,
    'type' => CRM_Utils_Type::T_STRING,
    'description' => 'Last name of the subscriber'
  ];
  $spec['email'] = [
    'api.required' => 1,
    'type' => CRM_Utils_Type::T_STRING,
    'description' => 'Email of the subscriber'
  ];
  $spec['language'] = [
    'api.required' => 1,
    'type' => CRM_Utils_Type::T_STRING,
    'description' => 'Language of the subscriber'
  ];
  $spec['list'] = [
    'api.required' => 0,
    'type' => CRM_Utils_Type::T_STRING,
    'description' => 'List of email ids',
  ];
}

/**
 * Remotenewsletter.Subscribe API
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
function civicrm_api3_remotenewsletter_Subscribe($params) {
    $apiParams = [
      'contact_type' => 'Individual',
      'first_name' => $params['first_name'],
      'last_name' => $params['last_name'],
      'email' => $params['email'],
      'prefered_language'=> $params['language']
    ];
    $matches = civicrm_api3('Contact','duplicatecheck',[
       'match'=>$params,
       'dedupe_rule_id' => Civi::settings()->get('remotenewsletter_dedupe_id')
    ]);

    if(isset($matches['id'])){
       $contactId = $matches['id'];
    } else {
      $contact = civicrm_api3('Contact','create',$apiParams);
      $contactId=$contact['id'];
    }

    foreach($params['subscription'] as $groupId){
      if($groupId) {
        civicrm_api3('GroupContact', 'create', [
          'contact_id' => $contactId,
          'group_id' => $groupId
        ]);
      }
    }

    civicrm_api3('Email', 'Send', [
    'contact_id' => $contactId,
    'template_id' =>Civi::settings()->get('remotenewsletter_subscribe_template_id'),
    ]);

    $result=[];
    return civicrm_api3_create_success($result, $params, 'Remotenewsletter', 'Subscribe');
}
