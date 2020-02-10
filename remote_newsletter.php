<?php
/**
 * @author Klaas Eikelboom  <klaas.eikelboom@civicoop.org>
 * @date 05-Feb-2020
 * @license  AGPL-3.0
 */

require_once 'remote_newsletter.civix.php';
use CRM_RemoteNewsletter_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function remote_newsletter_civicrm_config(&$config) {
  _remote_newsletter_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_xmlMenu
 */
function remote_newsletter_civicrm_xmlMenu(&$files) {
  _remote_newsletter_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function remote_newsletter_civicrm_install() {
  _remote_newsletter_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function remote_newsletter_civicrm_postInstall() {
  _remote_newsletter_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function remote_newsletter_civicrm_uninstall() {
  _remote_newsletter_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function remote_newsletter_civicrm_enable() {
  _remote_newsletter_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function remote_newsletter_civicrm_disable() {
  _remote_newsletter_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function remote_newsletter_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _remote_newsletter_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
 */
function remote_newsletter_civicrm_managed(&$entities) {
  _remote_newsletter_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_caseTypes
 */
function remote_newsletter_civicrm_caseTypes(&$caseTypes) {
  _remote_newsletter_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_angularModules
 */
function remote_newsletter_civicrm_angularModules(&$angularModules) {
  _remote_newsletter_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsFolders
 */
function remote_newsletter_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _remote_newsletter_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function remote_newsletter_civicrm_entityTypes(&$entityTypes) {
  _remote_newsletter_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_thems().
 */
function remote_newsletter_civicrm_themes(&$themes) {
  _remote_newsletter_civix_civicrm_themes($themes);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_preProcess
 *
function remote_newsletter_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 */
function remote_newsletter_civicrm_navigationMenu(&$menu) {

  _remote_newsletter_civix_insert_navigation_menu($menu, 'Mailings', array(
    'label' => E::ts('Remote Newsletter'),
    'name' => 'remote_newsletter_preferences',
    'url' => 'civicrm/remotenewsletter/preferences',
    'permission' => 'administer CiviCRM',
    'operator' => 'OR',
    'separator' => 2,
  ));
  _remote_newsletter_civix_navigationMenu($menu);
}

function remote_newsletter_civicrm_tokens(&$tokens) {
  $tokens['remotenewsletter'] = [
      'remotenewsletter.unsubscribe' => 'Unsubscrible link for the remote site (include checkSum)',
      'remotenewsletter.subscriptions' => 'Subscribed Newsletters (of Groups)',
  ];
}

function remote_newsletter_civicrm_tokenValues(&$values, $cids, $job = null, $tokens = array(), $context = null){
  if (array_key_exists('unsubscribe', $tokens['remotenewsletter']) || in_array('unsubscribe', $tokens['remotenewsletter'])) {
    $utils = new CRM_RemoteNewsletter_Utils();
    foreach ($cids as $cid) {
      $remoteUrl= Civi::settings()->get('remotenewsletter_unsubscribe_url').'?cid='.$cid.'&cs='.$utils->generateCheckSum($cid);
      $remoteText = Civi::settings()->get('remotenewsletter_unsubscribe_url_text');
      $values[$cid]['remotenewsletter.unsubscribe'] = "<a href='$remoteUrl'>$remoteText</a>";
    }
  };
  if (array_key_exists('subscriptions', $tokens['remotenewsletter']) || in_array('subscriptions', $tokens['remotenewsletter'])) {
    foreach ($cids as $cid) {
      $utils = new CRM_RemoteNewsletter_Utils();
      $subscriptions = $utils->subscriptions($cid,false);
      if(!empty($subscriptions)){
        $tokenValue = '<il>';
        foreach($subscriptions as $subscription){
          $tokenValue.='<li>'.$subscription['title'].'</li>';
        };
        $tokenValue .= '</il>';
        $values[$cid]['remotenewsletter.subscriptions'] = $tokenValue;
      }
    }
  };
}

function remote_newsletter_civicrm_alterAPIPermissions($entity, $action, &$params, &$permissions)
{
  if(strtolower($entity)=='remotenewsletter'){
    $params['check_permissions'] = false;
  }
}
