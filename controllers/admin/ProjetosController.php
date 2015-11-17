<?php

namespace wsGerProj\Controllers\Admin;

use wsGerProj\Controllers\RestController;
use wsGerProj\Controllers\ControllerBase;
use wsGerProj\Http\GetResponse;
use wsGerProj\Http\DefaultParams;
use wsGerProj\Http\PostResponse;
use wsGerProj\Http\StatusCodes;
use wsGerProj\Models\Projeto;
use wsGerProj\Models\ProjetoAnexos;
use wsGerProj\Models\ProjetoFuncionarios;
use wsGerProj\Models\ProjetosCliente;

/**
 * Description of ProjetosController
 *
 * @author anderson
 */
class ProjetosController extends ControllerBase implements RestController{
    public function create() {
        
    }

    public function delete($id) {
        
    }

    public function index() {
        $query = Projeto::query();
        
        if ($this->request->getQuery('search_id')) {
            $query->andWhere('id = :id:')->bind(['id' => $this->request->getQuery('search_id')]);
        } else {
            $binds = [];
            if ($this->request->getQuery('search_nome')) {
                $query->andWhere('nome ILIKE :nome:');
                $binds['nome'] = "%{$this->request->getQuery('search_nome')}%";
            }
            if ($this->request->getQuery('search_descricao')) {
                $query->andWhere('descricao ILKE :descricao:');
                $binds['descricao'] = "%{$this->request->getQuery('search_descricao')}%";
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
        $projeto = Projeto::findFirst($id);
        
        if($projeto){
            
            $projetoRet = $projeto->toArray();
            
            $projetoRet['funcionarios'] = $projeto->getFuncionarios()->toArray();
            $projetoRet['clientes'] = $projeto->getClientes()->toArray();
            $projetoRet['anexos'] = $projeto->getAnexos()->toArray();
            
            return $projetoRet;
            
        } else{
            throw new \Exception("Projeto #{$id} não encontrado", StatusCodes::NAO_ENCONTRADO);
        }
    }

    public function update($id) {
        
    }

}
