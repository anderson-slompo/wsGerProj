<?php

defined('APP_PATH') || define('APP_PATH', realpath('.'));

return new \Phalcon\Config([

    'database' => [
        'host' => 'localhost',
        'username' => 'postgres',
        'password' => 'senha',
        'dbname' => 'promind_novo',
    	//'adapter'    =>  'Postgresql'
    ],
    'application' => [
        'modelsDir' => APP_PATH . '/models/',
        'migrationsDir' => APP_PATH . '/migrations/',
        'viewsDir' => APP_PATH . '/views/',
        'baseUri' => '/wspromind/',
    ]
]);
