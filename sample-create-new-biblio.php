<?php 
require "vendor/autoload.php";

#$dbs = new PDO('mysql:host=localhost; dbname=dbname; charset=utf8mb4', 'dbusername', 'dbpassword');
$dbs = new PDO('mysql:host=localhost; dbname=demo2_slims8akasia; charset=utf8mb4', 'root', 's0beautifulday');
$dbs->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$dbs->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

use Slims\Persneling\Bibliography\Collection as C;
 
$koleksi = new C;

$data = $koleksi->collection_load();

#debug
echo '<pre>';
var_dump($data);
echo '</pre>';
die();

#$data->biblio_id = 1;
$data->title = 'PHP for librarian 7';
$data->sor = 'Hendro Wicaksono 3';
$data->gmd_name = 'Tesis';
$data->edition = '2nd ed.';
$data->isbn_issn = '123-456-789-0';
$data->publisher_name = 'Pustaka Suaka';
$data->publish_year = '2016';
$data->collation = 'xii, 500 p. ill.';
$data->series_title = 'Seri cepat kaya melalui internet';
$data->call_number = '330.05 AWK i';
$data->language_name = 'Oman';
$data->source = 'source disini';
$data->place = 'Jakarta';
$data->classification = '330.05';
$data->notes = 'Disini adalah catatan alias notes.';
$data->spec_detail_info = 'spec_detail_info disini';
$data->uid = '1';
#$data->authors = NULL;
$data->authors[0]['name'] = 'Hendro Wicaksono';
$data->authors[0]['authority_type'] = 'p';
$data->authors[0]['authority_level'] = '1';
$data->authors[1]['name'] = 'Komisi Pemberantasan Korupsi';
$data->authors[1]['authority_type'] = 'o';
$data->authors[1]['authority_level'] = '2';
$data->authors[2]['name'] = 'Konferensi Perpustakaan Digital Indonesia';
$data->authors[2]['authority_type'] = 'c';
$data->authors[2]['authority_level'] = '3';
#$data->subjects = NULL;
$data->subjects[0]['name'] = 'Fisika';
$data->subjects[1]['name'] = 'Perpustakaan';
#$data->items = NULL;
$data->items[0]['item_code'] = 'B000000011';
$data->items[0]['call_number'] = 'LEN 330 WIC h';
$data->items[0]['coll_type_name'] = 'AV';
$data->items[0]['inventory_code'] = '001/23/34';
$data->items[0]['received_date'] = '2017-05-02';
$data->items[0]['supplier_name'] = 'Gramedia Toko Buku';
$data->items[0]['order_no'] = 'order 001';
$data->items[0]['location_name'] = 'Ruang 1';
$data->items[0]['order_date'] = '2017-05-02';
$data->items[0]['item_status'] = 'Tersedia';
$data->items[0]['site'] = 'Rak 1';
$data->items[0]['source'] = 'Buy';
$data->items[0]['invoice'] = 'INV/001';
$data->items[0]['price'] = '500000';
$data->items[0]['price_currency'] = 'Rupiah';
$data->items[0]['invoice_date'] = '2017-05-02';
$data->items[0]['input_date'] = '2017-05-16 09:15:38';
$data->items[0]['last_update'] = '2017-05-16 09:15:38';
$data->items[0]['uid'] = 1;

$data->items[1]['item_code'] = 'B000000012';
$data->items[1]['call_number'] = 'REF 330 WIC h';
$data->items[1]['coll_type_name'] = 'AVR';
$data->items[1]['inventory_code'] = '001/23/35';
$data->items[1]['received_date'] = '2017-05-02';
$data->items[1]['supplier_name'] = 'Gunung Agung';
$data->items[1]['order_no'] = 'order 002';
$data->items[1]['location_name'] = 'Ruang 2';
$data->items[1]['order_date'] = '2017-05-02';
$data->items[1]['item_status'] = 'Hilang';
$data->items[1]['site'] = 'Rak 2';
$data->items[1]['source'] = 'Buy';
$data->items[1]['invoice'] = 'INV/002';
$data->items[1]['price'] = '400000';
$data->items[1]['price_currency'] = 'Dolar';
$data->items[1]['invoice_date'] = '2017-05-02';
$data->items[1]['input_date'] = '2017-05-16 09:15:38';
$data->items[1]['last_update'] = '2017-05-16 09:15:38';
$data->items[1]['uid'] = 1;

$data->items[2]['item_code'] = 'B000000013';
$data->items[2]['call_number'] = 'AVR 330 WIC h';
$data->items[2]['coll_type_name'] = 'Tandon';
$data->items[2]['inventory_code'] = '001/23/36';
$data->items[2]['received_date'] = '2017-05-02';
$data->items[2]['supplier_name'] = 'Gunung Agung';
$data->items[2]['order_no'] = 'order 003';
$data->items[2]['location_name'] = 'Ruang 3';
$data->items[2]['order_date'] = '2017-05-02';
$data->items[2]['item_status'] = 'Hilang';
$data->items[2]['site'] = 'Rak 3';
$data->items[2]['source'] = 'Buy';
$data->items[2]['invoice'] = 'INV/003';
$data->items[2]['price'] = '300000';
$data->items[2]['price_currency'] = 'Yen';
$data->items[2]['invoice_date'] = '2017-05-02';
$data->items[2]['input_date'] = '2017-05-16 09:15:38';
$data->items[2]['last_update'] = '2017-05-16 09:15:38';
$data->items[2]['uid'] = 1;

$koleksi->collection_save($dbs, $data);
