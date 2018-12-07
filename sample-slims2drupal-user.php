<?php 
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
require "vendor/autoload.php";

$dbs = new PDO('mysql:host=localhost; dbname=yourslimsdb; charset=utf8mb4', 'dbuser', 'dbpassword');
$dbs->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$dbs->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

use Slims\Persneling\Membership\Member as M;
 
$login = new M;

$memberinfo['member_id'] = '0792130162';
$memberinfo['password'] = '12345678';

$data = $login->member_login($dbs, (object)$memberinfo);
#die('<hr />');

#echo '<pre>';
#var_dump($data);
#echo '</pre>';

if ($data) {
  #echo 'login benar';
  #var_dump($data->member_id);
  # import Drupal Environment
  define ('DRUPAL_ROOT', '/var/www/html/lifewithslims/poc');
  require_once DRUPAL_ROOT.'/includes/bootstrap.inc';
  drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
  require_once DRUPAL_ROOT.'/includes/password.inc';
  $query = db_query("SELECT uid, name FROM {users} WHERE name=:name", array(':name' => $memberinfo['member_id']));
  $records = $query->fetchAll();
  if (empty($records)) {
    echo 'user belum ada';

    //This will generate a random password, you could set your own here
    #$password = user_password(8);
    #$password = 'ngadimin';

    //set up the user fields
    $fields = array(
      'name' => $memberinfo['member_id'],
      'mail' => $data->member_email,
      'pass' => $memberinfo['password'],
      'status' => 1,
      #'init' => 'email address',
      'roles' => array(
      #DRUPAL_AUTHENTICATED_RID => '5',
        '5' => '5',
      ),
    );
    $fields['field_usr_fullname']['und'][0]['value'] = $data->member_name;
    //the first parameter is left blank so a new user is created
    $account = user_save(NULL, $fields);


  } else {
    echo 'user sudah ada';
    var_dump($records[0]->uid);
    $user = user_load($records[0]->uid);
    #var_dump($user);
    #$user = (array) $user;
    $user->pass = user_hash_password($memberinfo['password']);
    $user->field_usr_fullname['und'][0]['value'] = $data->member_name;
    #$user = (object) $user;
    $account = user_save($user);

  }


} else {
  echo 'login salah';
}

