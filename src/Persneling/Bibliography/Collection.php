<?php
namespace Slims\Persneling\Bibliography;
use Slims\Persneling\Bibliography\Models\Collection as MC;

class Collection
{
  #public $is_newcoll = TRUE;
  public $cid = NULL;
  public $coll = array();

  public function __construct()
  {
    #$this->coll['title'] = NULL;
    #echo 'Slims\Bibliography\Collection()';
  }

  protected function set_cid($cid = NULL)
  {
    if (is_null($cid)) {
      $this->cid = NULL;
    } else {
      $this->cid = (int) $cid;
    }
  }

  protected function get_cid()
  {
    return $this->cid;
  }

  protected function set_newColl()
  {
    $this->set_title();
    $this->set_sor();
    $this->set_gmdName();
    $this->set_edition();
    $this->set_isbnIssn();
  }

  protected function get_newColl()
  {
    return (object) $this->coll;
  }

  protected function set_title($title=NULL)
  {
    $this->coll['title'] = $title;
  }

  protected function set_sor($sor=NULL)
  {
    $this->coll['sor'] = $sor;
  }

  protected function set_gmdName($gmd_name=NULL)
  {
    $this->coll['gmd_name'] = $gmd_name;
  }

  protected function set_edition($edition=NULL)
  {
    $this->coll['edition'] = $edition;
  }

  protected function set_isbnIssn($isbn_issn=NULL)
  {
    $this->coll['isbn_issn'] = $isbn_issn;
  }

  #protected function newCollection()
  #{
  #  $this->setTitle();
  #}

  #protected function setIs_newcoll($cid)
  #{
  #  if (!is_null($cid)) {
  #    if (is_numeric($cid)) {
  #      $this->is_newcoll = FALSE;
  #    } else {
  #      $this->is_newcoll = TRUE;
  #    }
  #  } else {
  #    $this->is_newcoll = TRUE;
  #  }
  #}

  #protected function getIs_newcoll()
  #{
  #  return $this->is_newcoll;
  #}


  public function collection_load($cid = NULL)
  {
    $this->set_cid($cid);
    #$this->setIs_newcoll($cid);
    #$this->setTitle($cid);
    #$this->getIs_newcoll();
    if (is_null($this->get_cid())) {
      #echo 'Buku baru';
      $this->set_newColl();
      return $this->get_newColl();
    } else {
      echo 'Edit Buku';
    }
  }

  public function collection_save($dbs, $coll)
  {
    $mc = new MC;
    $mc->collection_save($dbs, $coll);
  }


}
