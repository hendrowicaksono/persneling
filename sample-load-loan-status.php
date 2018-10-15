<?php 
require "vendor/autoload.php";

#$dbs = new PDO('mysql:host=localhost; dbname=dbname; charset=utf8mb4', 'dbusername', 'dbpassword');
#$dbs = new PDO('mysql:host=localhost; dbname=demo2_slims8akasia; charset=utf8mb4', 'root', 's0beautifulday');
$dbs = new PDO('mysql:host=localhost; dbname=library_ipc; charset=utf8mb4', 'root', 's0beautifulday');
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

