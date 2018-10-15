<?php
namespace Slims\Persneling\Masterfile\Models;

class Language
{
  public $language_id = NULL;
  public $language_name = NULL;
  #public $coll = array();
  #public $language = array ();
  #protected $language_id = NULL;

  public function __construct()
  {
    #$this->coll['title'] = NULL;
    #echo 'Slims\Bibliography\Collection()';
  }

  public function set_languageId($value)
  {
    $this->language_id = $value;
  }

  public function set_languageName($value)
  {
    $this->language_name = $value;
  }

  public static function tereak()
  {
    return 'EHLOOOO';
    #die('hmmmm');
  }

  public function get_languageId()
  {
    return $this->language_id;
  }

  public function get_languageName()
  {
    return $this->language_name;
  }


  public function testing()
  {
    return TRUE;
  }

  public function countLanguage($dbs, $query = NULL)
  {
    $base = 'SELECT COUNT(*) FROM mst_language';
    $sql = $base.' '.$query;
    $stm = $dbs->query($sql);
    $res = $stm->fetch(\PDO::FETCH_ASSOC);
    foreach ($res as $key => $value) {
      $counter = $value;
    }
    if ($counter > 0) {
      return $counter;
    } else {
      return FALSE;
    }
  }

  public function showLanguageList($dbs, $query = NULL)
  {
    $base = 'SELECT * FROM mst_language';
    $sql = $base.' '.$query;
    $stm = $dbs->query($sql);
    $res = $stm->fetchAll(\PDO::FETCH_ASSOC);
    return $res;
  }


  public function createLanguage($dbs, $language_name)
  {
    $language_name = addslashes($language_name);
    $is_exist = $this->countLanguage($dbs, 'WHERE language_name=\''.$language_name.'\'');
    if (!$is_exist) {
      $language_id = substr($language_name, 0, 1);
      $language_id .= substr($language_name, 3, 1);
      $language_id = strtolower($language_id);
      $s_slanguage = 'INSERT INTO mst_language (language_id,language_name) VALUES (\''.$language_id.'\',\''.$language_name.'\')';
      $q_slanguage = $dbs->query($s_slanguage);
      #$language_id = $dbs->lastInsertId();
      return $language_id;
    } else {
      return FALSE;
    }
  }

  public function getLanguageIdByName($dbs, $language_name)
  {
    $language_name = addslashes($language_name);
    $sql = 'SELECT * FROM mst_language WHERE language_name=\''.$language_name.'\'';
    $stm = $dbs->query($sql);
    $res = $stm->fetch(\PDO::FETCH_ASSOC);
    if (empty($res)) {
      return FALSE;
    } else {
      return $res['language_id'];
    }
  }

  public function fgetLanguageIdByName($dbs, $language_name)
  {
    $language_name = addslashes($language_name);
    $sql = 'SELECT * FROM mst_language WHERE language_name=\''.$language_name.'\'';
    $stm = $dbs->query($sql);
    $res = $stm->fetch(\PDO::FETCH_ASSOC);
    if (empty($res)) {
      #return FALSE;
      return $this->createLanguage($dbs, $language_name);
    } else {
      return $res['language_id'];
    }
  }


}
