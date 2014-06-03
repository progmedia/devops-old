<?php

$index = $argv[1];

// Get mapping for index
$mapping = file_get_contents('http://82.136.37.194:9200/'.$index.'/_mapping');

$mappingJson = json_decode($mapping);

// Get settings for index
$settings = file_get_contents('http://82.136.37.194:9200/'.$index.'/_settings');

$settingsJson = json_decode($settings);

$numShards = isset($settingsJson->{$index}->settings->index->number_of_shards) ? $settingsJson->{$index}->settings->index->number_of_shards : 3;
$numReplicas = isset($settingsJson->{$index}->settings->index->number_of_replicas) ? $settingsJson->{$index}->settings->index->number_of_replicas : 0;
$analysis = isset($settingsJson->{$index}->settings->index->analysis) ? $settingsJson->{$index}->settings->index->analysis : [];

//var_dump($settingsJson->{$index}->settings->index->analysis);

$output = [

        'settings' => [
            'number_of_shards'   => $numShards,
            'number_of_replicas' => $numReplicas,
            'analysis'    =>  $analysis
        ],
        'mappings' => []

];

$output['mappings'] = $mappingJson->{$index}->mappings;

file_put_contents($index.'_mapping.json', json_encode($output, JSON_PRETTY_PRINT));