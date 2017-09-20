<?php

namespace wsGerProj\Controllers\Admin;

use wsGerProj\Controllers\RestController,
    wsGerProj\Controllers\ControllerBase,
    wsGerProj\Http\GetResponse,
    wsGerProj\Http\DefaultParams,
    wsGerProj\Http\PostResponse,
    wsGerProj\Http\StatusCodes,
    wsGerProj\Models\Tarefa,
    wsGerProj\Models\TarefaAtribuicao,
    wsGerProj\Models\Funcionario,
    wsGerProj\Models\Departamento;

class TarefaAtribuicaoController extends ControllerBase implements RestController {
    public function index(){

    }
    
    public function show($id){
        $atribuicao = TarefaAtribuicao::findFirst($id);
        
        if ($atribuicao) {

            $atribuicaoRet = $atribuicao->toArray();
            $atribuicao['tarefa'] = $atribuicao->getTarefa()->toArray();
            
            return $tarefaRet;
        } else {
            throw new \Exception("Atribuição #{$id} não encontrada", StatusCodes::NAO_ENCONTRADO);
        }
    }

    public function getTarefa($id){
        $sql = "SELECT t.id as tarefa_id,
                        t.nome as tarefa_nome,
                        p.nome as projeto_nome,
                        t.tipo,
                        t.status
                FROM tarefa t
                INNER JOIN projeto p ON p.id = t.id_projeto
                WHERE t.id = ?";
                
        $result = $this->getDi()->getShared('db')->query($sql,[$id]);
        $result->setFetchMode(\Phalcon\Db::FETCH_OBJ);
        $return = $result->fetch();
        $return->status_nome = Tarefa::$statusDesc[$return->status];
        
        $devs =  Funcionario::getFuncionariosDepartamento(Departamento::DESENVOLVIMENTO);

        $return->funcionarios = array(
            TarefaAtribuicao::FASE_DESENVOLVIMENTO => $devs,
            TarefaAtribuicao::FASE_TESTES => Funcionario::getFuncionariosDepartamento(Departamento::TESTE),
            TarefaAtribuicao::FASE_RETORNO_TESTES => $devs,
            TarefaAtribuicao::FASE_IMPLANTACAO => Funcionario::getFuncionariosDepartamento(Departamento::IMPLANTACAO),
        );

        $return->fases = TarefaAtribuicao::$fasesDesc;

        return $return;
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
        $atribuicao->setFase($dataPost->fase);
        
        if ($atribuicao->validation() && $atribuicao->save()) {
            return $atribuicao;
        } else {
            $this->db->rollback();
            throw new \Exception(PostResponse::createModelErrorMessages($atribuicao), StatusCodes::ERRO_CLI);
        }
    }

}