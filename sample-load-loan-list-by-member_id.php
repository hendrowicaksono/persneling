<?php 
require "vendor/autoload.php";

$dbs = new PDO('mysql:host=localhost; dbname=yourdbname; charset=utf8mb4', 'dbuser', 'dbpassword');
$dbs->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$dbs->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

use Slims\Persneling\Circulation\Loan as L;
 
$loan = new L;

#$item_code = '000044';
#$data = $loan->loanStatusByItem_load($dbs, $item_code);
#die('<hr />');

$member_id = '0792130162';
#die('hmm');
$data = $loan->onLoanListByMemberId_load($dbs, $member_id);
#die('<hr />');

echo '<pre>';
var_dump($data);
echo '</pre>';

