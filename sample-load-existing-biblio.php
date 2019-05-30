<?php 
use Slims\Persneling\Bibliography\Collection as C;

if (!isset($_GET['biblio_id'])) {
  $response = array();
  $response['status'] = 'error';
  $response['message'] = 'biblio_id must be set.';
  $data_json = json_encode($response, JSON_PRETTY_PRINT);
  header("Content-type:application/json");
  print_r ($data_json);
} else {
  if (!is_numeric($_GET['biblio_id'])) {
    $response = array();
    $response['status'] = 'error';
    $response['message'] = 'biblio_id must be numeric.';
    $data_json = json_encode($response, JSON_PRETTY_PRINT);
    header("Content-type:application/json");
    print_r ($data_json);
  } else {

    require "vendor/autoload.php";

    #$dbs = new PDO('mysql:host=localhost; dbname=dbname; charset=utf8mb4', 'dbusername', 'dbpassword');
    #$dbs = new PDO('mysql:host=localhost; dbname=demo2_slims8akasia; charset=utf8mb4', 'root', 's0beautifulday');
    #$dbs = new PDO('mysql:host=localhost; dbname=library_ipc; charset=utf8mb4', 'root', 's0beautifulday');
    $dbs = new PDO('mysql:host=172.17.0.3; dbname=senayandb; charset=utf8mb4', 'root', 'mypassword');
    $dbs->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbs->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    #use Slims\Persneling\Bibliography\Collection as C;
 
    $koleksi = new C;

    $biblio_id = $_GET['biblio_id'];
    #$biblio_id = '843';
    $data = $koleksi->collection_load($dbs, $biblio_id);

    #echo '<pre>';
    #var_dump($data);
    #echo '</pre>';

    #$data_json = json_encode($data);
    header("Content-type:application/json");
    $data_json = json_encode($data, JSON_PRETTY_PRINT);
    print_r ($data_json);

    #file_put_contents('data/' .$json_data['id']. '.json', json_encode($json_data, JSON_PRETTY_PRINT));
    #file_put_contents('data/ujicoba.json', $data_json);
  }
}