<?php
namespace Slims\Persneling\Circulation\Models;
#use Slims\Persneling\Masterfile\Models\Gmd as GMD;
#use Slims\Persneling\Masterfile\Models\Publisher as Publisher;
#use Slims\Persneling\Masterfile\Models\Place as Place;
#use Slims\Persneling\Masterfile\Models\Language as Language;
#use Slims\Persneling\Masterfile\Models\Author as Author;
#use Slims\Persneling\Masterfile\Models\Subject as Subject;
#use Slims\Persneling\Bibliography\Models\Item as Item;

class Loan
{

  public function __construct()
  {
  }

  public function loanStatusByItem_load($dbs, $item_code)
  {
    $item_code = addslashes($item_code);
    $loan_status = FALSE;
    #$sLoan = 'SELECT l.*, m.member_name ';
    #$sLoan .= 'FROM loan AS l ';
    #$sLoan .= 'LEFT JOIN member AS m ON m.member_id=l.member_id ';
    #$sLoan .= "WHERE item_code='".$item_code."' AND is_lent='1' AND is_return='0' ";
    #$sLoan .= 'ORDER BY loan_id DESC LIMIT 0,1';

    #$sLoan = 'SELECT l.*, i.*, m.* ';
    $sLoan = 'SELECT l.* ';
    #$sLoan .= 'FROM loan AS l, item AS i, member AS m ';
    $sLoan .= 'FROM loan AS l ';
    #$sLoan .= 'LEFT JOIN member AS m ON m.member_id=l.member_id ';
    $sLoan .= "WHERE l.item_code='".$item_code."' AND is_lent='1' AND is_return='0' ";
    #$sLoan .= "AND l.item_code=i.item_code ";
    $sLoan .= 'ORDER BY loan_id DESC LIMIT 0,1';

    #die($sLoan);
    $qLoan = $dbs->query($sLoan);

    if ($qLoan->rowCount() > 0) {
      $rLoan = $qLoan->fetch(\PDO::FETCH_ASSOC);
      #var_dump($rLoan);die();
      $loan_status['loan_id'] = $rLoan['loan_id'];
      $loan_status['item_code'] = $rLoan['item_code'];
      $loan_status['member_id'] = $rLoan['member_id'];
      $loan_status['loan_date'] = $rLoan['loan_date'];
      $loan_status['due_date'] = $rLoan['due_date'];
      $loan_status['renewed'] = $rLoan['renewed'];
      $loan_status['is_lent'] = $rLoan['is_lent'];
      $loan_status['is_return'] = $rLoan['is_return'];
      #$loan_status['return_date'] = $rLoan['return_date'];
      #$loan_status['member_name'] = $rLoan['member_name'];

      #var_dump($loan_status);die();

    } else {
      $loan_status = array();
    }
    return $loan_status;
  }

  public function loanStatusByBiblioId_load($dbs, $biblio_id)
  {
    $loan_status = FALSE;
    #$sLoan = 'SELECT i.*, b.biblio_id, b.title, loc.location_name ';
    $sLoan = 'SELECT i.*, b.biblio_id, b.title ';
    $sLoan .= 'FROM biblio AS b, item AS i ';
    #$sLoan .= 'LEFT JOIN mst_location AS loc ON i.location_id=loc.location_id ';
    $sLoan .= "WHERE i.biblio_id=b.biblio_id AND b.biblio_id='".$biblio_id."' ";
    $sLoan .= 'ORDER BY item_code ASC';
    #$sLoan .= '';

    #die($sLoan);
    $qLoan = $dbs->query($sLoan);

    if ($qLoan->rowCount() > 0) {
      $rLoan = $qLoan->fetchAll(\PDO::FETCH_ASSOC);
      #var_dump($rLoan);die();
      foreach ($rLoan as $kr => $vr) {
        #echo $vr['item_code']."\n";
        #var_dump($this->loanStatusByItem_load($dbs, $vr['item_code']));
        $rLoan[$kr]['loan_status'] = $this->loanStatusByItem_load($dbs, $vr['item_code']);
      }
      #$loan_status['loan_id'] = $rLoan['loan_id'];
      #$loan_status['item_code'] = $rLoan['item_code'];
      #$loan_status['member_id'] = $rLoan['member_id'];
      #$loan_status['loan_date'] = $rLoan['loan_date'];
      #$loan_status['due_date'] = $rLoan['due_date'];
      #$loan_status['renewed'] = $rLoan['renewed'];
      #$loan_status['is_lent'] = $rLoan['is_lent'];
      #$loan_status['is_return'] = $rLoan['is_return'];
      #$loan_status['return_date'] = $rLoan['return_date'];
      #$loan_status['member_name'] = $rLoan['member_name'];
      $loan_status['items'] = $rLoan;
      #var_dump($loan_status);die();

    }
    return $loan_status;
  }


  public function onLoanListByMemberId_load($dbs, $member_id)
  {
    $loans = FALSE;
    #$sLoan = 'SELECT i.*, b.biblio_id, b.title, loc.location_name ';
    #$sLoan .= 'FROM biblio AS b, item AS i ';
    #$sLoan .= 'LEFT JOIN mst_location AS loc ON i.location_id=loc.location_id ';
    $sLoan = 'SELECT l.* ';
    $sLoan .= 'FROM loan AS l ';

    $sLoan .= "WHERE l.member_id='".$member_id."' AND ";
    $sLoan .= "l.is_lent='1' AND l.is_return='0' ";
    $sLoan .= 'ORDER BY l.loan_id DESC';
    #$sLoan .= '';
    #die($sLoan);

    #die($sLoan);
    $qLoan = $dbs->query($sLoan);

    if ($qLoan->rowCount() > 0) {
      $rLoan = $qLoan->fetchAll(\PDO::FETCH_ASSOC);
      #var_dump($rLoan);die();
      foreach ($rLoan as $kr => $vr) {
        #echo $vr['item_code']."\n";
        $sBiblio = 'SELECT i.item_code, b.title FROM item AS i, biblio AS b ';
        $sBiblio .= 'WHERE i.item_code=\''.$vr['item_code'].'\' AND b.biblio_id=i.biblio_id';
        #die ($sBiblio);
        $qBiblio = $dbs->query($sBiblio);
        if ($qBiblio->rowCount() > 0) {
          $rBiblio = $qBiblio->fetch(\PDO::FETCH_ASSOC);
          #var_dump($rBiblio);die();
          $rLoan[$kr]['biblio'] = $rBiblio;
        }
        #var_dump($this->loanStatusByItem_load($dbs, $vr['item_code']));
      #  $rLoan[$kr]['loans'] = $this->loanStatusByItem_load($dbs, $vr['item_code']);
      }
      #$loan_status['loan_id'] = $rLoan['loan_id'];
      #$loan_status['item_code'] = $rLoan['item_code'];
      #$loan_status['member_id'] = $rLoan['member_id'];
      #$loan_status['loan_date'] = $rLoan['loan_date'];
      #$loan_status['due_date'] = $rLoan['due_date'];
      #$loan_status['renewed'] = $rLoan['renewed'];
      #$loan_status['is_lent'] = $rLoan['is_lent'];
      #$loan_status['is_return'] = $rLoan['is_return'];
      #$loan_status['return_date'] = $rLoan['return_date'];
      #$loan_status['member_name'] = $rLoan['member_name'];
      $loans['items'] = $rLoan;
      #var_dump($loan_status);die();

    }
    return $loans;
  }



}





