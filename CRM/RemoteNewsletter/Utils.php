<?php
/**
 * @author Klaas Eikelboom  <klaas.eikelboom@civicoop.org>
 * @date 04-Feb-2020
 * @license  AGPL-3.0
 */

class CRM_RemoteNewsletter_Utils
{
  /**
   * @param $contactId
   * @param bool $all
   * @return array|bool
   */
  public function subscriptions($contactId, $all=true){
      $groups = Civi::settings()->get('remotenewsletter_groups');
      if(!isset($groups) || empty($groups)){
        return false;
      }
      $sql = <<< SQL
      select g.id
      ,      name
      ,      title
      ,      if(isnull(cg.id),0,1) subscription
      from   civicrm_group  g
      left join civicrm_group_contact cg on (cg.group_id = g.id and cg.status='Added' and cg.contact_id=%1 )
      where g.is_active=1 and g.id in ($groups)
SQL;
      $dao=CRM_Core_DAO::executeQuery($sql,[
        1 => [$contactId,'Integer']
      ]);
      $subscriptions =[];
      while($dao->fetch()){
        if($all || $dao->subscription)
        $subscriptions[] =
          ['id' => $dao->id,
           'title' => $dao->title,
           'subscription'=>$dao->subscription
          ];
      }
      return $subscriptions;
    }

    public function generateCheckSum($contactId, $ts = null, $live=null){
      $hash = CRM_Core_DAO::getFieldValue('CRM_Contact_DAO_Contact',
        $contactId, 'hash'
      );

      if (!$hash) {
        $hash = md5(uniqid(rand(), TRUE));
        CRM_Core_DAO::setFieldValue('CRM_Contact_DAO_Contact',
          $contactId,
          'hash', $hash
        );
      }

      if (!$ts) {
        $ts = time();
      }

      if (!$live) {
        $days = Civi::settings()->get('checksum_timeout');
        $live = 24 * $days;
      }

      $cs = md5("{$hash}_{$contactId}_RemoteNewsLetter_{$live}_{$ts}");
      return  "{$cs}_{$ts}_{$live}";


    }

    public function validateCheckSum($contactId,$checkSum){
       $parts = explode('_',$checkSum);
       $calc = $this->generateCheckSum($contactId,$parts[1],$parts[2]);
       return $calc === $checkSum;
    }
}
