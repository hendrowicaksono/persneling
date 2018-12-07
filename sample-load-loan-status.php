<?php 
require "vendor/autoload.php";

$dbs = new PDO('mysql:host=localhost; dbname=yourslimsdb; charset=utf8mb4', 'dbuser', 'dbpassword');
$dbs->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$dbs->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

use Slims\Persneling\Circulation\Loan as L;
 
$loan = new L;

#$item_code = '000044';
#$data = $loan->loanStatusByItem_load($dbs, $item_code);
#die('<hr />');

$biblio_id = '843';
$data = $loan->loanStatusByBiblioId_load($dbs, $biblio_id);
#die('<hr />');

echo '<pre>';
var_dump($data);
echo '</pre>';

