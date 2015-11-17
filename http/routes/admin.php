<?php

use Phalcon\Mvc\Micro\Collection as MicroCollection;
use wsGerProj\Controllers\Admin as A;

/*******************************************************/
$clientes = new MicroCollection();

$clientes->setHandler(new A\ClienteController());
$clientes->setPrefix('/admin/clientes');
$clientes->get('/', 'index');
$clientes->get('/{id}', 'show');
$clientes->post('/', 'create');
$clientes->put('/{id}', 'update');
$clientes->delete('/{id}', 'delete');

$app->mount($clientes);

/*******************************************************/
$funcionarios = new MicroCollection();

$funcionarios->setHandler(new A\FuncionarioController());
$funcionarios->setPrefix('/admin/funcionarios');
$funcionarios->get('/', 'index');
$funcionarios->get('/{id}', 'show');
$funcionarios->post('/', 'create');
$funcionarios->put('/{id}', 'update');
$funcionarios->delete('/{id}', 'delete');

$app->mount($funcionarios);

/*******************************************************/
$tipoEndereco = new MicroCollection();

$tipoEndereco->setHandler(new A\TipoEnderecoController());
$tipoEndereco->setPrefix('/admin/tipo_endereco');
$tipoEndereco->get('/', 'index');
$tipoEndereco->get('/{id}', 'show');

$app->mount($tipoEndereco);

/*******************************************************/
$tipoContato = new MicroCollection();

$tipoContato->setHandler(new A\TipoContatoController());
$tipoContato->setPrefix('/admin/tipo_contato');
$tipoContato->get('/', 'index');
$tipoContato->get('/{id}', 'show');

$app->mount($tipoContato);

/*******************************************************/
$depFuncionarios = new MicroCollection();

$depFuncionarios->setHandler(new A\DepartamentoFuncionarioController());
$depFuncionarios->setPrefix('/admin/departamento_funcionarios');
$depFuncionarios->get('/', 'index');
$depFuncionarios->get('/{id}', 'show');
$depFuncionarios->post('/', 'create');
$depFuncionarios->put('/{id}', 'update');
$depFuncionarios->delete('/{id}', 'delete');

$app->mount($depFuncionarios);
