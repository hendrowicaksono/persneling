<?php 
use Slims\Persneling\Circulation\Loan as L;
if (!isset($_GET['item_code'])) {
  $response = array();
  $response['status'] = 'error';
  $response['message'] = 'item_code must be set.';
  $data_json = json_encode($response, JSON_PRETTY_PRINT);
  header("HTTP/1.0 404 Not Found");
  header("Content-type:application/json");
  print_r ($data_json);
} else {

require "vendor/autoload.php";

#$dbs = new PDO('mysql:host=172.17.0.3; dbname=slims_uin_maliki; charset=utf8mb4', 'root', 'mypassword');
$dbs = new PDO('mysql:host=172.17.0.2; dbname=slims8_akasia_dev_85; charset=utf8mb4', 'root', 'mypassword');
$dbs->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$dbs->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);




$loan = new L;


#$item_code = '000044';
#$data = $loan->loanStatusByItem_load($dbs, $item_code);
#die('<hr />');


$item_code = addslashes($_GET['item_code']);
$data = $loan->loanStatusByItem_load($dbs, $item_code);
#die('<hr />');

#echo '<pre>';
#var_dump($data);
#echo '</pre>';

  $data_json = json_encode($data, JSON_PRETTY_PRINT);
  header("Content-type:application/json");
  print_r ($data_json);

}


