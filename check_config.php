<?php
require 'system/Test/bootstrap.php';
$db = \Config\Database::connect();
$results = $db->table('site_config')->get()->getResultArray();
foreach ($results as $res) {
    echo $res['config_key'] . ": " . $res['config_value'] . "\n";
}
