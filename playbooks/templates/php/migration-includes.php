<?php

$migrationDatabases = [
    'elasticsearch_host' =>  '{{ fastcgi_param_elastic_host }}',
    'elasticsearch_port' =>  {{ fastcgi_param_elastic_port }},
    'neo4j_host'    =>  '{{ fastcgi_param_neo_host }}',
    'neo4j_port'    =>  {{ fastcgi_param_neo_port }},
    'redis_host'    =>  '{{ fastcgi_param_cache_host }}',
    'redis_port'    =>  {{ fastcgi_param_cache_port }}
];
