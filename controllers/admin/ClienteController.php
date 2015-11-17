<?php

namespace wsGerProj\Controllers\Admin;

use wsGerProj\Controllers\RestController;
use wsGerProj\Models\Cliente;
use wsGerProj\Controllers\ControllerBase;
use wsGerProj\Http\GetResponse;
use wsGerProj\Http\DefaultParams;
use wsGerProj\Http\PostResponse;
use wsGerProj\Http\StatusCodes;

class ClienteController extends ControllerBase implements RestController {

    public function index() {
        $query = Cliente::query();

        if ($this->request->getQuery('search_id')) {
            $query->andWhere('id = :id:')->bind(['id' => $this->request->getQuery('search_id')]);
        } else {
            $binds = [];
            if ($this->request->getQuery('search_nome')) {
                $query->andWhere('nome ILIKE :nome:');
                $binds['nome'] = "%{$this->request->getQuery('search_nome')}%";
            }
            if ($this->request->getQuery('search_id_externo')) {
                $query->andWhere('id_externo = :id_externo:');
                $binds['id_externo'] = $this->request->getQuery('search_id_externo');
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
        $cliente = Cliente::findFirst($id);

        if ($cliente) {
            return $cliente->toArray();
        } else {
            throw new \Exception("Cliente #{$id} não encontrado", StatusCodes::NAO_ENCONTRADO);
        }
    }

    public function create() {

        $cliente = $this->createClienteFromJsonRawData();
               
        if ($cliente->validation() && $cliente->save()) {
            return PostResponse::createResponse(PostResponse::STATUS_OK, "Cliente [#{$cliente->getId()} {$cliente->getNome()}] inserido com sucesso.");
        } else {
            throw new \Exception(PostResponse::createModelErrorMessages($cliente), StatusCodes::ERRO_CLI);
        }
    }

    public function update($id) {
        $dataPost = $this->request->getJsonRawBody();
        $cliente = Cliente::findFirst($id);

        if ($cliente) {

            $cliente->setNome($dataPost->nome);
            $cliente->setIdExterno($dataPost->id_externo);

            if ($cliente->validation() && $cliente->save()) {
                return PostResponse::createResponse(PostResponse::STATUS_OK, "Cliente [#{$cliente->getId()} {$cliente->getNome()}] atualizado com sucesso.");
            } else {                
                throw new \Exception(PostResponse::createModelErrorMessages($cliente), StatusCodes::ERRO_CLI_CONFLICT);
            }
        } else {
            throw new \Exception("Cliente #{$id} não encontrado", StatusCodes::NAO_ENCONTRADO);
        }
    }

    public function delete($id) {
        $cliente = Cliente::findFirst($id);

        if ($cliente) {

            if ($cliente->delete()) {
                return PostResponse::createResponse(PostResponse::STATUS_OK, "Cliente removido com sucesso");
            } else {
                throw new \Exception(PostResponse::createModelErrorMessages($cliente), StatusCodes::ERRO_CLI_CONFLICT);
            }
        } else {
            throw new \Exception("Cliente #{$id} não encontrado", StatusCodes::NAO_ENCONTRADO);
        }
    }

    /**
     * Cria objeto do cliente com base nos dados enviados por POST via JSON
     * 
     * @return Cliente
     */
    private function createClienteFromJsonRawData(){
        
        $dataPost = $this->request->getJsonRawBody();
        
        $cliente = new Cliente;
        $cliente->setNome($dataPost->nome);
        $cliente->setIdExterno($dataPost->id_externo);
        
        return $cliente;
    }
    
}
