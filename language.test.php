<?php
$language_name = 'Indonesia';

$language_id = substr($language_name, 0, 1);
$language_id .= substr($language_name, 3, 1);
$language_id = strtolower($language_id);

echo $language_id;