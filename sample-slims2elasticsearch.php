<?php 
#$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
require "vendor/autoload.php";

$es_host = 'localhost';
$es_port = '9200';
$es_index = 'yourseindex';

$dbs = new PDO('mysql:host=localhost; dbname=yourdbname; charset=utf8mb4', 'dbuser', 'dbpassword');

$dbs->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$dbs->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

use Slims\Persneling\Bibliography\Collection as C;

$sql_biblio = 'SELECT biblio_id FROM biblio ORDER BY biblio_id ASC';
$stm_biblio = $dbs->query($sql_biblio);
$res_biblio = $stm_biblio->fetchAll(\PDO::FETCH_ASSOC);

foreach ($res_biblio as $kb => $vb) {
  echo 'biblio_id: '.$vb['biblio_id']."\n";
  $koleksi = new C;
  $data = $koleksi->collection_load($dbs, $vb['biblio_id']);
  #var_dump($data);
  $uri = 'http://'.$es_host.':'.$es_port.'/'.$es_index.'/_doc/'.$vb['biblio_id'];
  echo $uri."\n";

  $response = \Httpful\Request::put($uri)                  // Build a PUT request...
    ->sendsJson()                               // tell it we're sending (Content-Type) JSON...
    #->authenticateWith('username', 'password')  // authenticate with basic auth...
    ->body($data)             // attach a body/payload...
    ->send();

}

?>
