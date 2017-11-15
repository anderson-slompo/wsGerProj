<?php

namespace wsGerProj\Controllers\Admin;

use wsGerProj\Controllers\RestController;
use wsGerProj\Models\Implantacao;
use wsGerProj\Models\ImplantacaoTarefas;
use wsGerProj\Controllers\ControllerBase;
use wsGerProj\Http\GetResponse;
use wsGerProj\Http\DefaultParams;
use wsGerProj\Http\PostResponse;
use wsGerProj\Http\StatusCodes;
use wsGerProj\Models\Funcionario;

class ImplantacaoController extends ControllerBase implements RestController {

    public function index() {
        $db = $this->getDi()->getShared('db');
        
        $sql = "SELECT * FROM implantacao_desc WHERE 1=1 ";        

        if ($this->request->getQuery('search_id')) {
            $sql.= " AND id = {$this->request->getQuery('search_id')} ";
        } else {
            if ($this->request->getQuery('search_nome')) {
                $sql.= " AND nome ILIKE '%{$this->request->getQuery('search_nome')}%' ";
            }
        }
        if ($this->request->getQuery(DefaultParams::ORDER)) {
            $sql .= " ORDER BY ".$this->request->getQuery(DefaultParams::ORDER);
        }

        $result = $db->query($sql);
        $result->setFetchMode(\Phalcon\Db::FETCH_ASSOC);

        return GetResponse::createResponse($this->request, $result->fetchAll());
    }

    public function show($id) {
        $impl = Implantacao::findFirst($id);

        if ($impl) {
            $implRet = $impl->toArray();
            $func = Funcionario::findFirst($implRet['id_funcionario']);
            $data_hora = \DateTime::createFromFormat('Y-m-d H:i:s', $implRet['data_hora']);
            $implRet['data_hora'] =  $data_hora->format('d/m/Y H:i');
            $implRet['status_nome'] = Implantacao::$status_desc[$implRet['status']];
            $implRet['tarefas'] = $impl->getTarefas()->toArray();
            $implRet['funcionario_nome'] = $func->getNome();

            return $implRet;
        } else {
            throw new \Exception("Implantação #{$id} não encontrada", StatusCodes::NAO_ENCONTRADO);
        }
    }

    public function create() {

        $impl = $this->createImplantacaoFromJsonRawData();
               
        if ($impl->validation() && $impl->save()) {
            return PostResponse::createResponse(PostResponse::STATUS_OK, "Implantacao [#{$impl->getId()} {$impl->getNome()}] inserida com sucesso.");
        } else {
            throw new \Exception(PostResponse::createModelErrorMessages($impl), StatusCodes::ERRO_CLI);
        }
    }

    public function update($id) {
        throw new \Exception("Método não implementado.");
    }

    public function delete($id) {
        $impl = Implantacao::findFirst($id);

        if ($impl) {
            $impl->setStatus(Implantacao::STATUS_CANCELADA);
            if ($impl->save()) {
                return PostResponse::createResponse(PostResponse::STATUS_OK, "Implantação removida com sucesso");
            } else {
                throw new \Exception(PostResponse::createModelErrorMessages($impl), StatusCodes::ERRO_CLI_CONFLICT);
            }
        } else {
            throw new \Exception("Implantação #{$id} não encontrada", StatusCodes::NAO_ENCONTRADO);
        }
    }

    /**
     * Cria objeto do cliente com base nos dados enviados por POST via JSON
     * 
     * @return Cliente
     */
    private function createImplantacaoFromJsonRawData(){
        
        $dataPost = $this->request->getJsonRawBody();
        $user = $this->getDI()->get('currentUser');
        
        $impl = new Implantacao();
        $impl->setNome($dataPost->nome);
        $impl->setDescricao($dataPost->descricao);
        $impl->setStatus(Implantacao::STATUS_EM_ANDAMENTO);
        $impl->setDataHora(date('Y-m-d H:i:s'));
        $impl->setIdFuncionario($user->funcionario_id);

        $impl->implantacaoTarefas = $this->createImplantacaoTarefas($impl, $dataPost);
        
        if ($impl->validation() && $impl->save()) {
            return $impl;
        } else {
            $this->db->rollback();
            throw new \Exception(PostResponse::createModelErrorMessages($impl), StatusCodes::ERRO_CLI);
        }

        return $impl;
    }
    
    public function createImplantacaoTarefas(Implantacao $impl, $dataPost) {
        $tarefas = [];
        foreach ($dataPost->tarefas as $tarefa) {
            $tar = new ImplantacaoTarefas();
            $tar->setIdImplantacao($impl);;
            $tar->setIdTarefa($tarefa->tarefa_id);

            $tarefas[] = $tar;
        }

        return $tarefas;
    }
}
