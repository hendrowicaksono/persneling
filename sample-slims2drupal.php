<?php 
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
require "vendor/autoload.php";

$dbs = new PDO('mysql:host=localhost; dbname=yourslimsdb; charset=utf8mb4', 'dbuser', 'dbpassword');
$dbs->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$dbs->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

# import Drupal Environment
define ('DRUPAL_ROOT', '/var/www/html/lifewithslims/poc');
require_once DRUPAL_ROOT.'/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

/**
##### Clean the taxonomies #####
#8 = authors. 9 = subjects. 5 = publisher. 6 = place. 4 = gmd.
$taxs = array ('4', '5', '6', '8', '9');
foreach ($taxs as $tax) {
  $tree = taxonomy_get_tree($tax);
  foreach($tree as $key => $val){
    taxonomy_term_delete($val->tid);
    echo $val->tid."\n";
  }
}
die('cukup');
################################
**/

use Slims\Persneling\Bibliography\Collection as C;

$sql_biblio = 'SELECT biblio_id FROM biblio ORDER BY biblio_id ASC';
$stm_biblio = $dbs->query($sql_biblio);
$res_biblio = $stm_biblio->fetchAll(\PDO::FETCH_ASSOC);

foreach ($res_biblio as $kb => $vb) {

  #if ($vb['biblio_id'] === 844) {
  #  die();
  #}

  $biblio_id = $vb['biblio_id'];
  echo 'Biblio ID: '.$biblio_id."\n";
  $query = new EntityFieldQuery();
  $query->entityCondition('entity_type', 'node')
    ->entityCondition('bundle', 'buku')
    ->propertyCondition('status', NODE_PUBLISHED)
    ->fieldCondition('field_biblio_id', 'value', $biblio_id, '=')
    ->addMetaData('account', user_load(1));
  $result = $query->execute();
  if (isset($result['node'])) {
    foreach ($result['node'] as $k => $v) {
      node_delete($v->nid);
    }
  }


  $koleksi = new C;

  $data = $koleksi->collection_load($dbs, $biblio_id);

  #echo '<pre>';
  #var_dump($data);
  #echo '</pre>';

  $node = new stdClass();
  $node->type = "buku";
  node_object_prepare($node); // Sets some defaults. Invokes hook_prepare() and hook_node_prepare().

  $node->language = LANGUAGE_NONE; // Or e.g. 'en' if locale is enabled

  #TITLE
  $node->title = $data->title;

  #SOR
  if (!empty($data->sor)) {
    $node->field_sor[$node->language][0]['value'] = $data->sor;
  }

  #BIBLIO_ID
  if (!empty($data->biblio_id)) {
    $node->field_biblio_id[$node->language][0]['value'] = $data->biblio_id;
  }

  #GMD_ID
  if (!empty($data->gmd_name)) {
    $_gmd = $data->gmd_name;
    $is_vocab_exist = FALSE;
    $rawterm = taxonomy_get_term_by_name($_gmd, 'gmd');
    if (empty($rawterm)) {
      #echo "Data belum ada\n";
      $new_term = array(
        'vid' => '4',
        'name' => $_gmd,
        'description' => $_gmd,
      );
      $new_term = (object) $new_term;
      taxonomy_term_save($new_term);
      $rawterm = taxonomy_get_term_by_name($_gmd);
      #foreach ($rawterm as $terms) {
      #  echo $terms->tid."\n";
      #  echo $terms->vid."\n";
      #}
    } else {
      #echo "Data sudah ada\n";
      foreach ($rawterm as $terms) {
        #echo $terms->tid."\n";
        #echo $terms->vid."\n";
      }
    }
    $node->field_gmd[$node->language][0]['tid'] = $terms->tid;
  }

  #EDITION
  if (!empty($data->edition)) {
    $node->field_edition[$node->language][0]['value'] = $data->edition;
  }

  #PUBLISHER_ID
  if (!empty($data->publisher_name)) {
    $_publisher = $data->publisher_name;
    $is_vocab_exist = FALSE;
    $rawterm = taxonomy_get_term_by_name($_publisher, 'publisher');
    if (empty($rawterm)) {
      #echo "Data belum ada\n";
      $new_term = array(
        'vid' => '5',
        'name' => $_publisher,
        'description' => $_publisher,
      );
      $new_term = (object) $new_term;
      taxonomy_term_save($new_term);
      $rawterm = taxonomy_get_term_by_name($_publisher, 'publisher');
      foreach ($rawterm as $terms) {
        echo $terms->tid."\n";
        echo $terms->vid."\n";
      }
    } else {
      echo "Data sudah ada\n";
      foreach ($rawterm as $terms) {
        echo $terms->tid."\n";
        echo $terms->vid."\n";
      }
    }
    $node->field_publisher[$node->language][0]['tid'] = $terms->tid;
  }

  #ISSN_ISSN
  if (!empty($data->isbn_issn)) {
    $node->field_isbn_issn[$node->language][0]['value'] = $data->isbn_issn;
  }

  #PUBLISH_YEAR
  if (!empty($data->publish_year)) {
    $node->field_publish_year[$node->language][0]['value'] = $data->publish_year;
  }

  #COLLATION
  if (!empty($data->collation)) {
    $node->field_collation[$node->language][0]['value'] = $data->collation;
  }

  #SERIES_TITLE
  if (!empty($data->series_title)) {
    $node->field_series_title[$node->language][0]['value'] = $data->series_title;
  }

  #CALL_NUMBER
  if (!empty($data->call_number)) {
    $node->field_call_number[$node->language][0]['value'] = $data->call_number;
  }

  #LANGUAGE_ID
  if (!empty($data->language_name)) {
    $_language = $data->language_name;
    $is_vocab_exist = FALSE;
    $rawterm = taxonomy_get_term_by_name($_language, 'language');
    if (empty($rawterm)) {
      #echo "Data belum ada\n";
      $new_term = array(
        'vid' => '7',
        'name' => $_language,
        'description' => $_language,
      );
      $new_term = (object) $new_term;
      taxonomy_term_save($new_term);
      $rawterm = taxonomy_get_term_by_name($_language, 'language');
      foreach ($rawterm as $terms) {
        echo $terms->tid."\n";
        echo $terms->vid."\n";
      }
    } else {
      echo "Data sudah ada\n";
      foreach ($rawterm as $terms) {
        echo $terms->tid."\n";
        echo $terms->vid."\n";
      }
    }
    $node->field_language[$node->language][0]['tid'] = $terms->tid;
  }

  #SOURCE
  if (!empty($data->source)) {
    $node->field_source[$node->language][0]['value'] = $data->source;
  }

  #PUBLISH_PLACE_ID
  if (!empty($data->place)) {
    $_place = $data->place;
    $is_vocab_exist = FALSE;
    $rawterm = taxonomy_get_term_by_name($_place, 'place');
    if (empty($rawterm)) {
      #echo "Data belum ada\n";
      $new_term = array(
        'vid' => '6',
        'name' => $_place,
        'description' => $_place,
      );
      $new_term = (object) $new_term;
      taxonomy_term_save($new_term);
      $rawterm = taxonomy_get_term_by_name($_place);
      foreach ($rawterm as $terms) {
        echo $terms->tid."\n";
        echo $terms->vid."\n";
      }
    } else {
      #echo "Data sudah ada\n";
      foreach ($rawterm as $terms) {
        echo $terms->tid."\n";
        echo $terms->vid."\n";
      }
    }
    $node->field_place[$node->language][0]['tid'] = $terms->tid;
  }

  if (!empty($data->classification)) {
    $node->field_classification[$node->language][0]['value'] = $data->classification;
  }

  if (!empty($data->notes)) {
    $node->field_notes[$node->language][0]['value'] = $data->notes;
  }

  if (!empty($data->image)) {
    $node->field_image[$node->language][0]['value'] = $data->image;
  }

  if (!empty($data->promoted)) {
    $node->field_promoted[$node->language][0]['value'] = $data->promoted;
  }

  if (!empty($data->opac_hide)) {
    $node->field_opac_hide[$node->language][0]['value'] = $data->opac_hide;
  }

  if (!empty($data->spec_detail_info)) {
    $node->field_spec_detail_info[$node->language][0]['value'] = $data->spec_detail_info;
  }

  if (!empty($data->input_date)) {
    $node->field_input_date[$node->language][0]['value'] = $data->input_date;
  }

  if (!empty($data->last_update)) {
    $node->field_last_update[$node->language][0]['value'] = $data->last_update;
  }

  ########AUTHORS###############################
  if (!empty($data->authors)) {
    foreach ($data->authors as $ka => $va) {
      $_author = $va['name'];
      $is_vocab_exist = FALSE;
      $rawterm = taxonomy_get_term_by_name($_author, 'authors');
      if (empty($rawterm)) {
        #echo "Data belum ada\n";
        $new_term = array(
          'vid' => '8',
          'name' => $_author,
          'description' => $_author,
        );
        $new_term['field_authority_type']['und'][0]['value'] = $va['authority_type'];
        $new_term['field_authority_level']['und'][0]['value'] = $va['authority_level'];
        $new_term = (object) $new_term;
        taxonomy_term_save($new_term);
        $rawterm = taxonomy_get_term_by_name($_author);
        foreach ($rawterm as $terms) {
          echo $terms->tid."\n";
          echo $terms->vid."\n";
        }
      } else {
        #echo "Data sudah ada\n";
        foreach ($rawterm as $terms) {
          echo $terms->tid."\n";
          echo $terms->vid."\n";
        }
      }
       $node->field_authors[$node->language][$ka]['tid'] = $terms->tid;
    }
  }
  ##############################################
  ########SUBJECTS###############################
  if (!empty($data->subjects)) {
    foreach ($data->subjects as $ks => $vs) {
      $_topic = $vs['name'];
      $is_vocab_exist = FALSE;
      $rawterm = taxonomy_get_term_by_name($_topic, 'subjects');
      if (empty($rawterm)) {
        #echo "Data belum ada\n";
        $new_term = array(
          'vid' => '9',
          'name' => $_topic,
          'description' => $_topic,
        );
        $new_term['field_topic_type']['und'][0]['value'] = $vs['topic_type'];
        $new_term['field_topic_level']['und'][0]['value'] = $vs['topic_level'];
        $new_term = (object) $new_term;
        taxonomy_term_save($new_term);
        $rawterm = taxonomy_get_term_by_name($_topic);
        foreach ($rawterm as $terms) {
          echo $terms->tid."\n";
          echo $terms->vid."\n";
        }
      } else {
        #echo "Data sudah ada\n";
        foreach ($rawterm as $terms) {
          echo $terms->tid."\n";
          echo $terms->vid."\n";
        }
      }
      $node->field_subjects[$node->language][$ks]['tid'] = $terms->tid;
    }
  }
  ##############################################
  $node->uid = '1';
  $node->status = 1; //(1 or 0): published or not
  $node->promote = 0; //(1 or 0): promoted to front page
  $node->comment = 0; // 0 = comments disabled, 1 = read only, 2 = read/write
  $node = node_submit($node); // Prepare node for saving
  node_save($node);

  #die('sahabat');

}

