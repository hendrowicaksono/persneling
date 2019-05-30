<?php
$inst_name = 'dikdasmen';
$unit_name = 'perpustakaan';
$coll_name = 'opac';

require "vendor/autoload.php";

#SOLR Config
$config = array(
  'endpoint' => array(
    'host' => array(
      'scheme' => 'http',
      #'host' => 'harvesterperpus-dikdasmen.kemdikbud.go.id',
      'address' => '172.17.0.4',
      #'port' => 443,
      'port' => 8983,
      'core' => 'slims',
      'path' => 'solr',
      #'username' => 'public',
      #'password' => 'monitorburam',
      #'username' => 'solr',
      #'password' => 'depokcimanggis',
    )
  )
);

$dbs = new PDO('mysql:host=172.17.0.3; dbname=senayandb; charset=utf8mb4', 'root', 'mypassword');
$dbs->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$dbs->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

use Slims\Persneling\Bibliography\Collection as C;

$sql_biblio = 'SELECT biblio_id FROM biblio ORDER BY biblio_id ASC';
$stm_biblio = $dbs->query($sql_biblio);
$res_biblio = $stm_biblio->fetchAll(\PDO::FETCH_ASSOC);

foreach ($res_biblio as $kb => $vb) {
  #echo 'biblio_id: '.$vb['biblio_id']."\n";
  $data = null;
  $data = array();
  $koleksi = new C;
  $data = $koleksi->collection_load($dbs, $vb['biblio_id']);
  $data->inst_name = $inst_name;
  $data->unit_name = $unit_name;
  $data->coll_name = $coll_name;
  $data->id = $inst_name.'-'.$unit_name.'-'.$coll_name.'-'.$vb['biblio_id'];
  #$data->id = $vb['biblio_id'];
  $data->_id = $data->id;

  echo $data->id."\n";

  $solr_path = $config['endpoint']['host']['scheme'].'://'.$config['endpoint']['host']['address'].':'.$config['endpoint']['host']['port'].'/'.$config['endpoint']['host']['path'].'/'.$config['endpoint']['host']['core'].'/update?wt=json';
  #var_dump($solr_path); die();

  if ($data->opac_hide == 0) {
    $data_json = json_encode($data, JSON_PRETTY_PRINT);
    #file_put_contents('/home/hendrowicaksono/storage/project/dikdasmen/persneling-dikdasmen/data/slims/'.$data->id.'.json', $data_json);

    #update / add data
    $data = array(
      "add" => array( 
        #"doc" => $_doc,
        "doc" => (array) $data,
        "commitWithin" => 1000,
      ),
    );

  } elseif ($data->opac_hide == 1) {
    # delete / remove data
    $data = array(
      "delete" => array( 
        "query" => 'id:'.$data->id,
        "commitWithin" => 1000,
      ),
    );

  }

  $data_string = json_encode($data);
  $ch = curl_init($solr_path);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_POST, TRUE);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
  $response = curl_exec($ch);

  #die();

}

?>
