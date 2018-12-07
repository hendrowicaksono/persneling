<?php
$inst_name = 'kemdikbud';
$unit_name = 'perpustakaan_pusat';
$coll_name = 'opac';

require "vendor/autoload.php";

$dbs = new PDO('mysql:host=localhost; dbname=yourslimsdb; charset=utf8mb4', 'dbusername', 'dbpassword');
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
  $data->inst_name = $inst_name;
  $data->unit_name = $unit_name;
  $data->coll_name = $coll_name;
  $data->id = $inst_name.'-'.$unit_name.'-'.$coll_name.'-'.$vb['biblio_id'];
  $data->_id = $data->id;
  #die('disini');
  $data_json = json_encode($data, JSON_PRETTY_PRINT);
  #echo ($data_json)."\n";
  echo $data->id."\n";
  file_put_contents('data/'.$data->id.'.json', $data_json);

}
