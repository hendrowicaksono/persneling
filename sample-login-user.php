<?php 
require "vendor/autoload.php";

$dbs = new PDO('mysql:host=localhost; dbname=yourdbname; charset=utf8mb4', 'dbuser', 'dbpassword');
$dbs->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$dbs->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

use Slims\Persneling\Membership\Member as M;
 
$login = new M;

#$item_code = '000044';
#$data = $loan->loanStatusByItem_load($dbs, $item_code);
#die('<hr />');

$memberinfo['member_id'] = '0792130162';
$memberinfo['password'] = '123456';
#$memberinfo = (object)

$data = $login->member_login($dbs, (object)$memberinfo);
#die('<hr />');

echo '<pre>';
var_dump($data);
echo '</pre>';

