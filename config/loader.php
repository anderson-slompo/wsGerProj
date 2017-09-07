<?php

/**
 * Registering an autoloader
 */
$loader = new \Phalcon\Loader();

$loader->registerDirs(
    array(
        $config->application->modelsDir
    )
)->registerNamespaces(array(
    'wsGerProj\Models' => __DIR__ . '/../models/',
    'wsGerProj\Controllers' => __DIR__ . '/../controllers/',
    'wsGerProj\Controllers\Admin' => __DIR__ . '/../controllers/admin/',
    'wsGerProj\Controllers\Aplic' => __DIR__ . '/../controllers/aplic/',
    'wsGerProj\Controllers\Desenv' => __DIR__ . '/../controllers/desenv/',
    'wsGerProj\Controllers\Testes' => __DIR__ . '/../controllers/testes/',
    'wsGerProj\Http' => __DIR__ . '/../http/',
    'wsGerProj\Config' => __DIR__ . '/../config/',
    'wsGerProj\DB' => __DIR__ . '/../DB/',
))->register();
