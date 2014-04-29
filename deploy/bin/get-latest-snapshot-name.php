<?php

$json = file_get_contents('http://localhost:8082/_snapshot/migrations/_all');
$data = json_decode($json);
echo end($data->snapshots)->snapshot.PHP_EOL;
