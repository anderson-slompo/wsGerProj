<?php

use Phalcon\Mvc\Micro\Collection as MicroCollection;
use wsGerProj\Controllers\Admin as A;

/*******************************************************/

$auth = new MicroCollection();

$auth->setHandler(new A\AuthController());
$auth->setPrefix('/admin/auth');
$auth->post('/', 'login', 'login');
$auth->get('/{token}', 'checkToken', 'checkToken');

$app->mount($auth);
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

/*******************************************************/
$projeto = new MicroCollection();

$projeto->setHandler(new A\ProjetosController());
$projeto->setPrefix('/admin/projetos');
$projeto->get('/', 'index');
$projeto->get('/{id}', 'show');
$projeto->post('/', 'create');
$projeto->put('/{id}', 'update');
$projeto->delete('/{id}', 'delete');

$app->mount($projeto);

/*******************************************************/
$departamento = new MicroCollection();

$departamento->setHandler(new A\DepartamentosController());
$departamento->setPrefix('/admin/departamentos');
$departamento->get('/', 'index');
$departamento->get('/{id}', 'show');

$app->mount($departamento);

/*******************************************************/
$projetoAnexos = new MicroCollection();

$projetoAnexos->setHandler(new A\ProjetoAnexosController());
$projetoAnexos->setPrefix('/admin/projeto_anexos');
$projetoAnexos->post('/', 'create');
$projetoAnexos->get('/{id}', 'show');
$projetoAnexos->delete('/', 'delete');

$app->mount($projetoAnexos);

/*******************************************************/
$download = new MicroCollection();
$download->setHandler(new wsGerProj\Controllers\DownloadController());
$download->setPrefix('/download');
$download->get('/{id}', 'download', 'download');

$app->mount($download);

/*******************************************************/
$tarefa = new MicroCollection();

$tarefa->setHandler(new A\TarefasController());
$tarefa->setPrefix('/admin/tarefas');
$tarefa->get('/', 'index');
$tarefa->get('/{id}', 'show');
$tarefa->post('/', 'create');
$tarefa->put('/{id}', 'update');
$tarefa->delete('/{id}', 'delete');

$tarefa->get('/tipos', 'getTipos');
$tarefa->get('/status', 'getStatus');

$tarefa->get('/tipos/{id}', 'getTipoID');
$tarefa->get('/status/{id}', 'getStatusID');

$app->mount($tarefa);

/*******************************************************/

$tarefaAnexos = new MicroCollection();

$tarefaAnexos->setHandler(new A\TarefaAnexosController());
$tarefaAnexos->setPrefix('/admin/tarefa_anexos');
$tarefaAnexos->post('/', 'create');
$tarefaAnexos->get('/{id}', 'show');
$tarefaAnexos->delete('/', 'delete');

$app->mount($tarefaAnexos);

/*******************************************************/
