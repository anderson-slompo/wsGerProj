<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace wsGerProj\Controllers\Admin;

use wsGerProj\Controllers\RestController;
use wsGerProj\Controllers\ControllerBase;
use wsGerProj\Http\GetResponse;
use wsGerProj\Http\StatusCodes;
use wsGerProj\Models\TipoEndereco;

/**
 * Description of TipoEnderecoController
 *
 * @author anderson
 */
class TipoEnderecoController extends ControllerBase implements RestController {
    public function create() {
        throw new Exception("Não implementado", StatusCodes::NAO_ENCONTRADO);
    }

    public function delete($id) {
        throw new Exception("Não implementado", StatusCodes::NAO_ENCONTRADO);
    }

    public function index() {
        $tipos = TipoEndereco::find();
        
        return GetResponse::createResponse($this->request, $tipos->toArray());
    }

    public function show($id) {
        $tipo = TipoEndereco::findFirst($id);

        if ($tipo) {
            return $tipo->toArray();
        } else {
            throw new \Exception("Tipo Endereço #{$id} não encontrado", StatusCodes::NAO_ENCONTRADO);
        }
    }

    public function update($id) {
        throw new Exception("Não implementado", StatusCodes::NAO_ENCONTRADO);
    }

}
