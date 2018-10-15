<?php 
require "vendor/autoload.php";

#$dbs = new PDO('mysql:host=localhost; dbname=dbname; charset=utf8mb4', 'dbusername', 'dbpassword');
#$dbs = new PDO('mysql:host=localhost; dbname=demo2_slims8akasia; charset=utf8mb4', 'root', 's0beautifulday');
#$dbs = new PDO('mysql:host=localhost; dbname=library_ipc; charset=utf8mb4', 'root', 's0beautifulday');
$dbs = new PDO('mysql:host=172.17.0.2; dbname=demo_slims8; charset=utf8mb4', 'root', 'mypassword');
$dbs->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$dbs->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

use Slims\Persneling\Bibliography\Collection as C;
 
$koleksi = new C;

$biblio_id = '1';
#$biblio_id = '843';
$data = $koleksi->collection_load($dbs, $biblio_id);

#echo '<pre>';
#var_dump($data);
#echo '</pre>';

#$data_json = json_encode($data);
$data_json = json_encode($data, JSON_PRETTY_PRINT);
print_r ($data_json);

#file_put_contents('data/' .$json_data['id']. '.json', json_encode($json_data, JSON_PRETTY_PRINT));
file_put_contents('data/ujicoba.json', $data_json);