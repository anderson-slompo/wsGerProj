<?php

namespace wsGerProj\Controllers\Admin;

use wsGerProj\Controllers\RestController;
use wsGerProj\Models\Cliente;
use Phalcon\Mvc\Controller;
use wsGerProj\Http\GetResponse;
use wsGerProj\Http\DefaultParams;
use wsGerProj\Http\PostResponse;

class ClienteController extends Controller implements RestController {

    public function index() {
        $query = Cliente::query();

        if ($this->request->getQuery('id')) {
            $query->andWhere('id = :id:')->bind(['id' => $this->request->getQuery('id')]);
        } else {
            $binds = [];
            if ($this->request->getQuery('nome')) {
                $query->andWhere('nome LIKE :nome:');
                $binds['nome'] = $this->request->getQuery('nome');
            }
            if ($this->request->getQuery('id_externo')) {
                $query->andWhere('id_externo = :id_externo:');
                $binds['id_externo'] = $this->request->getQuery('id_externo');
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

    public function create() {

        $cliente = new Cliente;
        $cliente->setNome($this->request->getPost('nome'));
        $cliente->setIdExterno($this->request->getPost('id_externo'));

        if ($cliente->save()) {
            return PostResponse::createResponse(PostResponse::STATUS_OK, "Cliente criado com sucesso");
        } else {
            $except = '';
            foreach ($cliente->getMessages() as $message) {
                $except.= $message. "\n";
            }
            throw new \Exception($except);
        }
    }

    public function update() {
        throw new \Exception("Error Processing update Request", 1);
    }

    public function delete() {
        throw new \Exception("Error Processing delete Request", 1);
    }

}
