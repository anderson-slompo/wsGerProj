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
        if($return->status == Tarefa::STATUS_NOVA || $return->status == Tarefa::STATUS_RETORNO_TESTE){
            $return->funcionarios = Funcionario::getFuncionariosDepartamento(Departamento::DESENVOLVIMENTO);
        } elseif($return->status == Tarefa::STATUS_AGUARDANTO_TESTE){
            $return->funcionarios = Funcionario::getFuncionariosDepartamento(Departamento::TESTE);
        } elseif($return->status == Tarefa::STATUS_AGUARDANDO_IMPLANTACAO){
            $return->funcionarios = Funcionario::getFuncionariosDepartamento(Departamento::IMPLANTACAO);
        } else{
            throw new \Exception("A tarefa não pode ser atribuida pois já esta atribuida na fase atual", 400);
        }

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

        return $atribuicao;
    }
}