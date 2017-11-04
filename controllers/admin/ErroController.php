<?php

namespace wsGerProj\Controllers\Admin;

use wsGerProj\Controllers\RestController,
    wsGerProj\Controllers\ControllerBase,
    wsGerProj\Http\GetResponse,
    wsGerProj\Http\DefaultParams,
    wsGerProj\Http\PostResponse,
    wsGerProj\Http\StatusCodes,
    wsGerProj\Models\Tarefa,
    wsGerProj\Models\Erro;

class ErroController extends ControllerBase implements RestController {
    public function index(){

    }
    
    public function show($id){
        
    }

    public function create(){
        $this->db->begin();
        
        $erro = $this->createErroFromJsonRawData();

        $id = $erro->getId();
        $this->db->commit();
        return PostResponse::createResponse(PostResponse::STATUS_OK, ['message' => "Erro reportado com sucesso.", 'id' => $id]);
    }

    public function update($id){
        
    }

    public function delete($id){
        throw new \Exception("Metodo nao implementado", StatusCodes::NAO_ENCONTRADO);
    }

    public function createErroFromJsonRawData(){
        
        $dataPost = $this->request->getJsonRawBody();

        $user = $this->getDI()->get('currentUser');
        
        $erro = new Erro();
        $erro->setCorrigido(false);
        $erro->setDescricao($dataPost->descricao);
        $erro->setIdProjeto($dataPost->id_projeto);
        $erro->setIdTarefa($dataPost->id_tarefa);
        $erro->setNome($dataPost->nome);
        $erro->setIdFuncionario($user->funcionario_id);
        $erro->setIdFuncionarioFix(NULL);
        
        if ($erro->validation() && $erro->save()) {
            return $erro;
        } else {
            $this->db->rollback();
            throw new \Exception(PostResponse::createModelErrorMessages($erro), StatusCodes::ERRO_CLI);
        }
    }
}