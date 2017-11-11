<?php

namespace wsGerProj\Controllers\Admin;

use wsGerProj\Controllers\RestController,
    wsGerProj\Controllers\ControllerBase,
    wsGerProj\Http\GetResponse,
    wsGerProj\Http\DefaultParams,
    wsGerProj\Http\PostResponse,
    wsGerProj\Http\StatusCodes,
    wsGerProj\Models\Tarefa,
    wsGerProj\Models\TarefaInteracao,
    wsGerProj\Models\Funcionario,
    wsGerProj\Models\Departamento,
    wsGerProj\Models\TarefaAtribuicao,
    wsGerProj\Models\Erro;

class TarefaInteracaoController extends ControllerBase implements RestController {
    public function index(){

    }
    
    public function show($id){
        
    }

    public function create(){
        $this->db->begin();
        
        $interacao = $this->createInteracaoFromJsonRawData();

        $id = $interacao->getId();
        $this->db->commit();
        return PostResponse::createResponse(PostResponse::STATUS_OK, ['message' => "Interação armazenada com sucesso.", 'id' => $id]);
    }

    public function update($id){
        throw new \Exception("Metodo nao implementado", StatusCodes::NAO_ENCONTRADO);
    }

    public function delete($id){
        
    }

    public function createInteracaoFromJsonRawData(){
        
        $dataPost = $this->request->getJsonRawBody();
        $user = $this->getDI()->get('currentUser');
        
        if($dataPost->fase == TarefaAtribuicao::FASE_RETORNO_TESTES 
            && isset($dataPost->fixed_errors)){
                foreach((array)$dataPost->fixed_errors as $id => $status){
                    if($status){
                        $erro = Erro::findFirst($id);
                        $erro->setCorrigido('t');
                        $erro->setIdFuncionarioFix($user->funcionario_id);
                        $erro->save();
                    }
                }
            }
        $interacao = new TarefaInteracao();
        $interacao->setConclusao($dataPost->conclusao);
        $interacao->setDataHora(date('Y-m-d H:i:s'));
        $interacao->setFase($dataPost->fase);
        $interacao->setIdFuncionario($dataPost->id_funcionario);
        $interacao->setIdTarefa($dataPost->id_tarefa);
        $interacao->setObservacao($dataPost->observacao);
        
        if ($interacao->validation() && $interacao->save()) {
            return $interacao;
        } else {
            $this->db->rollback();
            throw new \Exception(PostResponse::createModelErrorMessages($interacao), StatusCodes::ERRO_CLI);
        }
    }
}