<?php

use Phalcon\Mvc\Micro\Collection as MicroCollection;
use wsGerProj\Controllers\Admin as A;

$clientes = new MicroCollection();

$clientes->setHandler(new A\ClienteController());
$clientes->setPrefix('/clientes');
$clientes->get('/', 'index');
$clientes->get('/{id}', 'index');
$clientes->post('/', 'create');
$clientes->put('/', 'update');
$clientes->delete('/', 'delete');

$app->mount($clientes);

