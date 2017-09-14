<?php

namespace wsGerProj\Controllers\Admin;

use wsGerProj\Controllers\RestController,
    wsGerProj\Controllers\ControllerBase,
    wsGerProj\Http\GetResponse,
    wsGerProj\Http\DefaultParams,
    wsGerProj\Http\PostResponse,
    wsGerProj\Http\StatusCodes,
    wsGerProj\Models\Tarefa,
    wsGerProj\Models\TarefaAtribuicao;

class TarefasController extends ControllerBase implements RestController {
    public function index(){

    }
    
    public function show($id){
        $atribuicao = TarefaAtribuicao::findFirst($id);
        
        if ($tarefa) {

            $tarefaRet = $tarefa->toArray();
            $tarefaRet['itens'] = $tarefa->getItens()->toArray();
            $tarefaRet['anexos'] = $tarefa->getAnexos()->toArray();

            return $tarefaRet;
        } else {
            throw new \Exception("Atribuição #{$id} não encontrada", StatusCodes::NAO_ENCONTRADO);
        }
    }

    public function create(){
        $this->db->begin();
        
        $atribuicao = $this->createAtribuicaoFromJsonRawData();

        $id = $atribuicao->getId();
        $this->db->commit();
        return PostResponse::createResponse(PostResponse::STATUS_OK, ['message' => "Tarefa #{$atribuicao->id_tarefa} atribuída com sucesso.", 'id' => $id]);
    }

    public function update($id){

    }

    public function delete($id){

    }

    public function createAtribuicaoFromJsonRawData(){
        
        $dataPost = $this->request->getJsonRawBody();
        
        $atribuicao = new TarefaAtribuicao();
        $atribuicao->setIdTarefa($dataPost->id_tarefa);
        $atribuicao->setIdFuncionario($dataPost->id_funcionario);
        $atribuicao->setDataInicio($dataPost->data_inicio);
        $atribuicao->setDataTermino($dataPost->data_termino);
        $atribuicao->setDataHora(date('Y-m-d H:i:s'));

        return $atribuicao;
    }
}