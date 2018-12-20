<?php
$inst_name = 'kemdikbud';
$unit_name = 'perpustakaan_pusat';
$coll_name = 'opac';

require "vendor/autoload.php";

#$dbs = new PDO('mysql:host=172.17.0.3; dbname=slims_uin_maliki; charset=utf8mb4', 'root', 'mypassword');
$dbs = new PDO('mysql:host=172.17.0.2; dbname=slims8_akasia_dev_85; charset=utf8mb4', 'root', 'mypassword');
$dbs->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$dbs->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

use Slims\Persneling\Bibliography\Collection as C;

$sql_biblio = 'SELECT biblio_id FROM biblio ORDER BY biblio_id ASC';
$stm_biblio = $dbs->query($sql_biblio);
$res_biblio = $stm_biblio->fetchAll(\PDO::FETCH_ASSOC);

foreach ($res_biblio as $kb => $vb) {
  echo 'biblio_id: '.$vb['biblio_id']."\n";
  $data = null;
  $data = array();
  $koleksi = new C;
  $data = $koleksi->collection_load($dbs, $vb['biblio_id']);
  $data->inst_name = $inst_name;
  $data->unit_name = $unit_name;
  $data->coll_name = $coll_name;
  #$data->id = $inst_name.'-'.$unit_name.'-'.$coll_name.'-'.$vb['biblio_id'];
  $data->id = $vb['biblio_id'];
  $data->_id = $data->id;

  #die('disini');
  $data_json = json_encode($data, JSON_PRETTY_PRINT);
  echo $data->id."\n";
  #echo ($data_json)."\n";
  file_put_contents('data/'.$data->id.'.json', $data_json);

  /** solr specific json
  $rekap_json = '{"add":{"doc":'.$data_json.',"commitWithin":5000,"overwrite":true}}';
  #$rekap_json = json_encode($rekap);
  #echo ($rekap_json)."\n";
  file_put_contents('data/rekap_'.$data->id.'.json', $rekap_json);
  **/
  /**
  ##### UPLOAD TO SOLR #####
  $_url = 'http://172.17.0.4:8983/solr/slims/update';
  $ch = curl_init($_url);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($ch, CURLOPT_POSTFIELDS, $rekap_json);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($rekap_json))
  );
  curl_exec($ch);
  **/

}

?>
