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

$tarefaAtribuicao = new MicroCollection();

$tarefaAtribuicao->setHandler(new A\TarefaAtribuicaoController());
$tarefaAtribuicao->setPrefix('/admin/tarefa_atribuicao');
$tarefaAtribuicao->post('/', 'create');
$tarefaAtribuicao->get('/{id}', 'show');
$tarefaAtribuicao->get('/tarefa/{id}', 'getTarefa');
$tarefaAtribuicao->get('/atuais', 'getTarefasAtuais');
$tarefaAtribuicao->get('/a_iniciar', 'getTarefasAIniciar');
$tarefaAtribuicao->get('/disponiveis_implantacao', 'getTarefasDisponiveisImplantacao');
// $tarefaAtribuicao->delete('/', 'delete');

$app->mount($tarefaAtribuicao);

/*******************************************************/

$tarefaInteracao = new MicroCollection();

$tarefaInteracao->setHandler(new A\TarefaInteracaoController());
$tarefaInteracao->setPrefix('/admin/tarefa_interacao');
$tarefaInteracao->post('/', 'create');
$tarefaInteracao->get('/{id}', 'show');
$tarefaInteracao->delete('/', 'delete');

$app->mount($tarefaInteracao);

/*******************************************************/

$erro = new MicroCollection();

$erro->setHandler(new A\ErroController());
$erro->setPrefix('/admin/erro');
$erro->post('/', 'create');
$erro->get('/{id}', 'show');
$erro->put('/fix/{id}', 'fix');
$erro->get('/', 'index');

$app->mount($erro);

/*******************************************************/

$dash = new MicroCollection();

$dash->setHandler(new A\DashGerenteController());
$dash->setPrefix('/admin/dash/gerente');

$dash->get('/tarefasAguardandoAtribuicao', 'getTarefasAguardandoAtribuicao');
$dash->get('/statusProjetos', 'getStatusProjetos');
$dash->get('/tarefasAtrasadas', 'getTarefasAtrasadas');
$dash->get('/tarefasExecussao', 'getTarefasExecussao');

$app->mount($dash);

/*******************************************************/

$impl = new MicroCollection();

$impl->setHandler(new A\ImplantacaoController());
$impl->setPrefix('/admin/implantacao');
$impl->post('/', 'create');
$impl->get('/{id}', 'show');
$impl->get('/', 'index');
$impl->get('/dash', 'getImplantacoesIniciadas');
$impl->delete('/{id}', 'delete');
$impl->put('/finish/{id}', 'finish');

$app->mount($impl);

/*******************************************************/

$gantt = new MicroCollection();

$gantt->setHandler(new A\GanttController());
$gantt->setPrefix('/admin/gantt');

$gantt->get('/tarefasGantt', 'getTarefasGantt');

$app->mount($gantt);

/*******************************************************/

$passwd = new MicroCollection();

$passwd->setHandler(new A\PasswordController());
$passwd->setPrefix('/admin/password');

$passwd->post('/change', 'change');

$app->mount($passwd);