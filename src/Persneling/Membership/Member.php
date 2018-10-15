<?php
namespace Slims\Persneling\Membership;
use Slims\Persneling\Membership\Models\Member as MM;

class Member
{
  public $mid = NULL;
  public $memb = array();

  public function __construct()
  {
  }

  protected function set_mid($mid)
  {
    #if (is_null($mid)) {
    #  $this->mid = NULL;
    #} else {
      $this->mid = $mid;
    #}
  }

  protected function get_mid()
  {
    return $this->mid;
  }

  protected function set_newMemb($member_id)
  {
    $this->set_memberId($member_id);
    $this->set_memberName();
    $this->set_gender();
    $this->set_birthDate();
    $this->set_memberTypeName();
    $this->set_memberAddress();
    $this->set_memberMailAddress();
    $this->set_memberEmail();
    $this->set_postalCode();
    $this->set_instName();
    $this->set_isNew();
    $this->set_memberImage();
    $this->set_pin();
    $this->set_memberPhone();
    $this->set_memberFax();
    $this->set_memberSinceDate();
    $this->set_registerDate();
    $this->set_expireDate();
    $this->set_memberNotes();
    $this->set_isPending();
    $this->set_inputDate();
    $this->set_lastUpdate();
  }

  protected function get_newMemb()
  {
    return (object) $this->memb;
  }

  protected function set_memberId($member_id)
  {
    $this->memb['member_id'] = $member_id;
  }

  protected function set_memberName($member_name=NULL)
  {
    $this->memb['member_name'] = $member_name;
  }

  protected function set_gender($gender=NULL)
  {
    $this->memb['gender'] = $gender;
  }

  protected function set_birthDate($birth_date=NULL)
  {
    $this->memb['birth_date'] = $birth_date;
  }

  protected function set_memberTypeName($member_type_name=NULL)
  {
    $this->memb['member_type_name'] = $member_type_name;
  }

  protected function set_memberAddress($member_address=NULL)
  {
    $this->memb['member_address'] = $member_address;
  }

  protected function set_memberMailAddress($member_mail_address=NULL)
  {
    $this->memb['member_mail_address'] = $member_mail_address;
  }

  protected function set_memberEmail($member_email=NULL)
  {
    $this->memb['member_email'] = $member_email;
  }

  protected function set_postalCode($postal_code=NULL)
  {
    $this->memb['postal_code'] = $postal_code;
  }

  protected function set_instName($inst_name=NULL)
  {
    $this->memb['inst_name'] = $inst_name;
  }

  protected function set_isNew($is_new=NULL)
  {
    $this->memb['is_new'] = $is_new;
  }

  protected function set_memberImage($member_image=NULL)
  {
    $this->memb['member_image'] = $member_image;
  }

  protected function set_pin($pin=NULL)
  {
    $this->memb['pin'] = $pin;
  }

  protected function set_memberPhone($member_phone=NULL)
  {
    $this->memb['member_phone'] = $member_phone;
  }

  protected function set_memberFax($member_fax=NULL)
  {
    $this->memb['member_fax'] = $member_fax;
  }

  protected function set_memberSinceDate($member_since_date=NULL)
  {
    $this->memb['member_since_date'] = $member_since_date;
  }

  protected function set_registerDate($register_date=NULL)
  {
    $this->memb['register_date'] = $register_date;
  }

  protected function set_expireDate($expire_date=NULL)
  {
    $this->memb['expire_date'] = $expire_date;
  }

  protected function set_memberNotes($member_notes=NULL)
  {
    $this->memb['member_notes'] = $member_notes;
  }

  protected function set_isPending($is_pending=NULL)
  {
    $this->memb['is_pending'] = $is_pending;
  }

  protected function set_inputDate($input_date=NULL)
  {
    $this->memb['input_date'] = $input_date;
  }

  protected function set_lastUpdate($last_update=NULL)
  {
    $this->memb['last_update'] = $last_update;
  }


  public function member_load($dbs = NULL, $mid)
  {
    /**
    $this->set_mid($mid);
    if (is_null($this->get_mid())) {
      $this->set_newMemb();
      return $this->get_newMemb();
    } else {
      #echo 'Edit Buku';
      $mm = new MM;
      return $mm->member_load($dbs, $mid);
    }
    **/
    $mm = new MM;
    if ($mm->member_load($dbs, $mid)) {
      return (object) $mm->member_load($dbs, $mid);

    } else {
      #$this->set_mid($mid);
      $this->set_newMemb($mid);
      return $this->get_newMemb();
  
    }


  }

  public function member_save($dbs, $memb)
  {
    $mm = new MM;
    $mm->member_save($dbs, $memb);
  }

  public function member_login($dbs, $memberinfo)
  {
    $mm = new MM;
    $login = $mm->member_login($dbs, $memberinfo);
    if ($login) {
      #return (object) $mm->member_load($dbs, $mid);
      #echo 'login betul'; die();
      return (object) $mm->member_load($dbs, $memberinfo->member_id);
    } else {
      #$this->set_mid($mid);
      #$this->set_newMemb($mid);
      #return $this->get_newMemb();
      #echo 'login sale'; die();
      return FALSE;
    }


  }




  /**
  protected function set_collInfo($dbs, $cid)
  {
    $sBiblio = 'SELECT b.*, gmd.* ';
    $sBiblio .= 'FROM biblio AS b, mst_gmd AS gmd ';
    $sBiblio .= 'WHERE b.biblio_id=\''.$cid.'\' ';
    $sBiblio .= 'AND b.gmd_id=gmd.gmd_id';
    #$qBiblio = $dbs->query($sBiblio);
    $qBiblio = $dbs->query($sBiblio);
    $rBiblio = $qBiblio->fetch(\PDO::FETCH_ASSOC);
    $this->set_biblioId($rBiblio['biblio_id']);
    $this->set_title($rBiblio['title']);
    $this->set_sor($rBiblio['sor']);
    $this->set_gmdName($rBiblio['gmd_name']);
    #return $rBiblio;
    return $this->get_newColl();
  }
  **/

}
