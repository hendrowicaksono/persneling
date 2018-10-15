<?php
namespace Slims\Persneling\Membership\Models;
use Slims\Persneling\Masterfile\Models\Membershiptype as Membershiptype;
#use Slims\Persneling\Masterfile\Models\Publisher as Publisher;
#use Slims\Persneling\Masterfile\Models\Place as Place;
#use Slims\Persneling\Masterfile\Models\Author as Author;
#use Slims\Persneling\Masterfile\Models\Subject as Subject;
#use Slims\Persneling\Bibliography\Models\Item as Item;

class Member
{

  public function __construct()
  {
  }

  public function member_save($dbs, $mem)
  {
    $member_type = new Membershiptype;
    $_member_type_id = $member_type->getmembTypeIdByName($dbs, $mem->member_type_name);
    #$publisher = new Publisher;
    #$_publisher_id = $publisher->fgetPublisherIdByName($dbs, $col->publisher_name);
    #$place = new Place;
    #$_place_id = $place->fgetPlaceIdByName($dbs, $col->place);
    /**
    $is_new = TRUE;
    if ((!empty($mem->member_id)) OR (isset($mem->member_id))) {
      if ($this->member_load($dbs, $mem->member_id)) {
        #echo 'data sudah ada';die();
        $is_new = FALSE;
        $_member_id = $mem->member_id;
      } else {
        #echo 'data belum ada';die();
        $is_new = TRUE;
        $_member_id = NULL;
      }
    } else {
      $is_new = TRUE;
      $_member_id = NULL;
    }
    **/
    $s_mem = 'REPLACE INTO member (
      member_id,
      member_name,
      member_type_id,
      gender,
      birth_date,
      member_address,
      member_mail_address,
      member_email,
      postal_code,
      inst_name,
      is_new,
      member_image,
      pin,
      member_phone,
      member_fax,
      member_since_date,
      register_date,
      expire_date,
      member_notes,
      is_pending,
      input_date,
      last_update
      ) VALUES (
      \''.addslashes($mem->member_id).'\',
      \''.addslashes($mem->member_name).'\',
      \''.addslashes($_member_type_id).'\',
      \''.addslashes($mem->gender).'\',
      \''.addslashes($mem->birth_date).'\',
      \''.addslashes($mem->member_address).'\',
      \''.addslashes($mem->member_mail_address).'\',
      \''.addslashes($mem->member_email).'\',
      \''.addslashes($mem->postal_code).'\',
      \''.addslashes($mem->inst_name).'\',
      \''.addslashes($mem->is_new).'\',
      \''.addslashes($mem->member_image).'\',
      \''.addslashes($mem->pin).'\',
      \''.addslashes($mem->member_phone).'\',
      \''.addslashes($mem->member_fax).'\',
      \''.addslashes($mem->member_since_date).'\',
      \''.addslashes($mem->register_date).'\',
      \''.addslashes($mem->expire_date).'\',
      \''.addslashes($mem->member_notes).'\',
      \''.addslashes($mem->is_pending).'\',
      \''.addslashes($mem->input_date).'\',
      \''.addslashes($mem->last_update).'\'
      )
    ';
    $q_mem = $dbs->query($s_mem);
    #$member_id = $dbs->lastInsertId();

    /**
    if (empty($col->authors)) {
      if (is_null($col->authors)) {
        $author = new Author;
        $author->removeRelBiblioAuthor($dbs, $biblio_id);
      }
    } else {
      #$author->fgetAuthorIdByName($dbs, $v);
      $author = new Author;
      $author->removeRelBiblioAuthor($dbs, $biblio_id);
      foreach ($col->authors as $k => $v) {
        $author = new Author;
        $author_id = $author->fgetAuthorIdByName($dbs, $v);
        if ( (empty($v['authority_level'])) OR (is_null($v['authority_level'])) ) {
          $v['authority_level'] = '1';
        }
        $author->createRelBiblioAuthor($dbs, $biblio_id, $author_id, $v['authority_level']);
      }
    }
    if (empty($col->subjects)) {
      if (is_null($col->subjects)) {
        $subject = new Subject;
        $subject->removeRelBiblioSubject($dbs, $biblio_id);
      }
    } else {
      $subject = new Subject;
      $subject->removeRelBiblioSubject($dbs, $biblio_id);
      foreach ($col->subjects as $k => $v) {
        $subject = new Subject;
        $subject_id = $subject->fgetSubjectIdByName($dbs, $v);
        $subject->createRelBiblioSubject($dbs, $biblio_id, $subject_id);
      }
    }
    if (empty($col->items)) {
      if (is_null($col->items)) {
        $item = new Item;
        $item->removeItemById($dbs, $biblio_id);
      }
    } else {
      $item = new Item;
      $item->removeItemById($dbs, $biblio_id);
      foreach ($col->items as $k => $v) {
        $item = new Item;
        $item_id = $item->fgetItemIdByItemcode($dbs, $v, $biblio_id);
      }
    }
    **/

  }

  public function member_load($dbs, $mid)
  {
    $memb = FALSE;
    $sMember = 'SELECT m.*, met.* ';
    $sMember .= 'FROM member AS m ';
    $sMember .= 'LEFT JOIN mst_member_type AS met ';
    $sMember .= 'ON m.member_type_id=met.member_type_id ';
    $sMember .= 'WHERE m.member_id=\''.$mid.'\'';
    $qMember = $dbs->query($sMember);
    if ($qMember->rowCount() > 0) {
      $rMember = $qMember->fetch(\PDO::FETCH_ASSOC);
      $memb['member_id'] = $rMember['member_id'];
      $memb['member_name'] = $rMember['member_name'];
      $memb['gender'] = $rMember['gender'];
      $memb['birth_date'] = $rMember['birth_date'];
      $memb['member_type_name'] = $rMember['member_type_name'];
      $memb['member_address'] = $rMember['member_address'];
      $memb['member_mail_address'] = $rMember['member_mail_address'];
      $memb['member_email'] = $rMember['member_email'];
      $memb['postal_code'] = $rMember['postal_code'];
      $memb['inst_name'] = $rMember['inst_name'];
      $memb['is_new'] = $rMember['is_new'];
      $memb['member_image'] = $rMember['member_image'];
      $memb['pin'] = $rMember['pin'];
      $memb['member_phone'] = $rMember['member_phone'];
      $memb['member_fax'] = $rMember['member_fax'];
      $memb['member_since_date'] = $rMember['member_since_date'];
      $memb['register_date'] = $rMember['register_date'];
      $memb['expire_date'] = $rMember['expire_date'];
      $memb['member_notes'] = $rMember['member_notes'];
      $memb['is_pending'] = $rMember['is_pending'];
      $memb['input_date'] = $rMember['input_date'];
      $memb['last_update'] = $rMember['last_update'];
    }
    return $memb;


  }


  public function member_login($dbs, $memberinfo)
  {
    #$memb = FALSE;
    $sMember = 'SELECT m.* ';
    $sMember .= 'FROM member AS m ';
    $sMember .= 'WHERE m.member_id=\''.$memberinfo->member_id.'\'';
    $qMember = $dbs->query($sMember);
    if ($qMember->rowCount() > 0) {
      $rMember = $qMember->fetch(\PDO::FETCH_ASSOC);

      if (password_verify($memberinfo->password, $rMember['mpasswd'])) {
        #echo 'Password is valid!';
        return TRUE;
      } else {
        #echo 'Invalid password.';
        return FALSE;
      }
      #die();
      /**
      $memb['member_id'] = $rMember['member_id'];
      $memb['member_name'] = $rMember['member_name'];
      $memb['gender'] = $rMember['gender'];
      $memb['birth_date'] = $rMember['birth_date'];
      $memb['member_type_name'] = $rMember['member_type_name'];
      $memb['member_address'] = $rMember['member_address'];
      $memb['member_mail_address'] = $rMember['member_mail_address'];
      $memb['member_email'] = $rMember['member_email'];
      $memb['postal_code'] = $rMember['postal_code'];
      $memb['inst_name'] = $rMember['inst_name'];
      $memb['is_new'] = $rMember['is_new'];
      $memb['member_image'] = $rMember['member_image'];
      $memb['pin'] = $rMember['pin'];
      $memb['member_phone'] = $rMember['member_phone'];
      $memb['member_fax'] = $rMember['member_fax'];
      $memb['member_since_date'] = $rMember['member_since_date'];
      $memb['register_date'] = $rMember['register_date'];
      $memb['expire_date'] = $rMember['expire_date'];
      $memb['member_notes'] = $rMember['member_notes'];
      $memb['is_pending'] = $rMember['is_pending'];
      $memb['input_date'] = $rMember['input_date'];
      $memb['last_update'] = $rMember['last_update'];
      **/
    }
    return $memb;


  }




}
