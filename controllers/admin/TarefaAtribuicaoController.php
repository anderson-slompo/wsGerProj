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

    public static $statusTarefaBusca = [
        Departamento::DESENVOLVIMENTO => [
            Tarefa::STATUS_AGUARDANDO_DESENVOLVIMENTO,
            Tarefa::STATUS_DESENVOLVIMENTO,
            Tarefa::STATUS_RETORNO_TESTE
        ],
        Departamento::TESTE => [
            Tarefa::STATUS_AGUARDANTO_TESTE,
            Tarefa::STATUS_TESTE,
        ],
        Departamento::IMPLANTACAO => [
            Tarefa::STATUS_AGUARDANDO_IMPLANTACAO,
            Tarefa::STATUS_IMPLANTADA,
        ]
    ];

    public function index(){}

    public function getTarefasAtuais(){
        $user = $this->getDI()->get('currentUser');
        
        $ret = [];
        $db = $this->getDi()->getShared('db');
        
        if($user->isDesenvolvedor){
            $result = $db->query($this->makeQueryAtribuicaoDepartamento($user->funcionario_id, Departamento::DESENVOLVIMENTO));
            $ret[Departamento::DESENVOLVIMENTO] = $this->fetchTarefas($result);
        }
        if($user->isTester){
            $result = $db->query($this->makeQueryAtribuicaoDepartamento($user->funcionario_id, Departamento::TESTE));
            $ret[Departamento::TESTE] = $this->fetchTarefas($result);
        }
        if($user->isImplantador){
            $result = $db->query($this->makeQueryAtribuicaoDepartamento($user->funcionario_id, Departamento::IMPLANTACAO));
            $ret[Departamento::IMPLANTACAO] = $this->fetchTarefas($result);
        }
        return $ret;
    }

    private function fetchTarefas($result){
        $ret = [];
        $result->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
        while($row = $result->fetchArray()){
            $row['status_nome'] = Tarefa::$statusDesc[$row['status']];
            $ret[] = $row;
        }

        return $ret;
    }

    private function getStatusDepartamento($dep){
        return implode(',', self::$statusTarefaBusca[$dep]);
    }

    private function makeQueryAtribuicaoDepartamento($funcionario_id, $departamento){
        $sql = "SELECT *
                FROM tarefas_atuais
                WHERE id_funcionario = {$funcionario_id}
                AND status IN( ? ) ";
        $sql = str_replace('?', $this->getStatusDepartamento($departamento), $sql);
        // die($sql);
        return $sql;
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