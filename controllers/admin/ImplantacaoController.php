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

class ImplantacaoController extends ControllerBase implements RestController {

    public function index() {
        $query = Implantacao::query();

        if ($this->request->getQuery('search_id')) {
            $query->andWhere('id = :id:')->bind(['id' => $this->request->getQuery('search_id')]);
        } else {
            $binds = [];
            if ($this->request->getQuery('search_nome')) {
                $query->andWhere('nome ILIKE :nome:');
                $binds['nome'] = "%{$this->request->getQuery('search_nome')}%";
            }
            if (count($binds)) {
                $query->bind($binds);
            }
        }
        if ($this->request->getQuery(DefaultParams::ORDER)) {
            $query->order($this->request->getQuery(DefaultParams::ORDER));
        }

        return GetResponse::createResponse($this->request, $query->execute()->toArray());
    }

    public function show($id) {
        $impl = Implantacao::findFirst($id);

        if ($impl) {
            $implRet = $impl->toArray();
            $implRet['tarefas'] = $impl->getTarefas()->toArray();

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
        
        $impl = new Implantacao();
        $impl->setNome($dataPost->nome);
        $impl->setDescricao($dataPost->ddescricao);
        $impl->setStatus(Implantacao::STATUS_EM_ANDAMENTO);
        $impl->setDataHora(date('Y-m-d H:i:s'));
        
        return $impl;
    }
    
}
