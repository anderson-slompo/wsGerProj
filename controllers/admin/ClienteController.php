<?php

namespace wsGerProj\Controllers\Admin;

use wsGerProj\Controllers\RestController;
use wsGerProj\Models\Cliente;
use Phalcon\Mvc\Controller;
use wsGerProj\Http\GetResponse;
use wsGerProj\Http\DefaultParams;
use wsGerProj\Http\PostResponse;
use wsGerProj\Http\StatusCodes;

class ClienteController extends Controller implements RestController {

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

        $cliente = new Cliente;
        $cliente->setNome($this->request->getPost('nome'));
        $cliente->setIdExterno($this->request->getPost('id_externo'));

        if ($cliente->validation() && $cliente->save()) {
            return PostResponse::createResponse(PostResponse::STATUS_OK, "Cliente criado com sucesso");
        } else {
            $except = '';
            foreach ($cliente->getMessages() as $message) {
                $except.= $message . "/";
            }
            throw new \Exception($except);
        }
    }

    public function update($id) {
        $cliente = Cliente::findFirst($id);

        if ($cliente) {

            $cliente->setNome($this->request->getPost('nome'));
            $cliente->setIdExterno($this->request->getPost('id_externo'));

            if ($cliente->validation() && $cliente->save()) {
                return PostResponse::createResponse(PostResponse::STATUS_OK, "Cliente atualizado com sucesso");
            } else {
                $except = '';
                foreach ($cliente->getMessages() as $message) {
                    $except.= $message . "/";
                }
                throw new \Exception($except, StatusCodes::ERRO_CLI);
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
                $except = '';
                foreach ($cliente->getMessages() as $message) {
                    $except.= $message . "/";
                }
                throw new \Exception($except, StatusCodes::ERRO_CLI);
            }
        } else {
            throw new \Exception("Cliente #{$id} não encontrado", StatusCodes::NAO_ENCONTRADO);
        }
    }

}
