<?php

use Phalcon\Mvc\Micro\Collection as MicroCollection;
use wsGerProj\Controllers\Admin as A;

$clientes = new MicroCollection();

$clientes->setHandler(new A\ClienteController());
$clientes->setPrefix('/admin/clientes');
$clientes->get('/', 'index');
$clientes->get('/{id}', 'show');
$clientes->post('/', 'create');
$clientes->put('/{id}', 'update');
$clientes->delete('/{id}', 'delete');

$app->mount($clientes);

