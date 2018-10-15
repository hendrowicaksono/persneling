<?php
namespace Slims\Persneling\Circulation;
use Slims\Persneling\Circulation\Models\Loan as LO;

class Loan
{
  public $cid = NULL;
  public $coll = array();

  public function __construct()
  {
  }

  public function loanStatusByItem_load($dbs, $item_code)
  {
    $lo = new LO;
    return (object) $lo->loanStatusByItem_load($dbs, $item_code);
  }

  public function loanStatusByBiblioId_load($dbs, $biblio_id)
  {
    $lo = new LO;
    return (object) $lo->loanStatusByBiblioId_load($dbs, $biblio_id);
  }

  public function onLoanListByMemberId_load($dbs, $member_id)
  {
    #echo "mungkinkah\n";
    $lo = new LO;
    return (object) $lo->onLoanListByMemberId_load($dbs, $member_id);
  }



}
