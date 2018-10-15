<?php 
require "vendor/autoload.php";

#$dbs = new PDO('mysql:host=localhost; dbname=dbname; charset=utf8mb4', 'dbusername', 'dbpassword');
$dbs = new PDO('mysql:host=localhost; dbname=demo2_slims8akasia; charset=utf8mb4', 'root', 's0beautifulday');
$dbs->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$dbs->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

use Slims\Persneling\Membership\Member as M;

$member = new M;

$member_id = '0792130162';
$data = $member->member_load($dbs, $member_id);
#$data = $member->member_load();

echo '<pre>';
var_dump($data);
echo '</pre>';

