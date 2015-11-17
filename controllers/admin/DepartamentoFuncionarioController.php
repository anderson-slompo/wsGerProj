<?php

namespace wsGerProj\Controllers\Admin;

use wsGerProj\Controllers\RestController;
use wsGerProj\Controllers\ControllerBase;
use wsGerProj\Http\GetResponse;
use wsGerProj\Http\DefaultParams;
use wsGerProj\Http\PostResponse;
use wsGerProj\Http\StatusCodes;
use wsGerProj\Models\Funcionario;
use wsGerProj\Models\DepartamentosFuncionario;

/**
 * Description of DepartamentoFuncionarioControllers
 *
 * @author anderson
 */
class DepartamentoFuncionarioController extends ControllerBase implements RestController {

    public function create() {
        
    }

    public function delete($id) {
        
    }

    public function index() {

        $query = DepartamentosFuncionario::query()
                ->columns(['id_funcionario', 'descricao as departamento'])
                ->join('wsGerProj\Models\Departamento');

        $binds = [];

        if ($this->request->getQuery('search_id_funcionario')) {
            $query->andWhere('id_funcionario = :id_funcionario:');
            $binds['id_funcionario'] = $this->request->getQuery('search_id_funcionario');
        }

        if ($this->request->getQuery('search_id_departamento')) {
            $query->andWhere('id_departamento = :id_departamento:');
            $binds['id_departamento'] = $this->request->getQuery('search_id_departamento');
        }
        if (count($binds)) {
            $query->bind($binds);
        }

        return GetResponse::createResponse($this->request, $query->execute()->toArray());
    }

    public function show($id) {
        
    }

    public function update($id) {
        
    }

}
