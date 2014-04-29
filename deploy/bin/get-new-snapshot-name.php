<?php

$json = file_get_contents('http://82.136.37.194:9200/_snapshot/migrations/_all');
$data = json_decode($json);

if (count($data->snapshots) === 0) {
    echo 'snapshot_1';
} else {
    $latest = end($data->snapshots)->snapshot;
    $num = (int) substr($latest, 9);
    echo 'snapshot_'.($num+1);
}
