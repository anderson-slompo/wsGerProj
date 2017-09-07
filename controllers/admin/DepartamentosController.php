<?php

namespace wsGerProj\Controllers\Admin;

use wsGerProj\Controllers\RestController;
use wsGerProj\Controllers\ControllerBase;
use wsGerProj\Http\GetResponse;
use wsGerProj\Http\DefaultParams;
use wsGerProj\Http\StatusCodes;
use wsGerProj\Models\Departamento;

/**
 * Description of DepartamentosController
 *
 * @author anderson
 */
class DepartamentosController extends ControllerBase implements RestController {

    public function index() {
        $query = Departamento::query();
        
        if($this->request->getQuery('search_id')){
            $query->andWhere('id = :id:')->bind(['id' => $this->request->getQuery('search_id')]);
        } else{
            if($this->request->getQuery('search_descricao')){
                $query->andWhere('descricao ILIKE :descricao:')->bind(['descricao' => "%{$this->request->getQuery('search_descricao')}%"]);
            }
        }
        if ($this->request->getQuery(DefaultParams::ORDER)) {
            $query->order($this->request->getQuery(DefaultParams::ORDER));
        }

        return GetResponse::createResponse($this->request, $query->execute()->toArray());
    }

    public function show($id) {
        $departamento = Departamento::findFirst($id);
        
        if($departamento){
            
            $departamentoRet = $departamento->toArray();
            
            $departamentoRet['funcionarios'] = $departamento->getFuncionarios()->toArray();           
            
            return $departamentoRet;
            
        } else{
            throw new \Exception("Departamento #{$id} não encontrado", StatusCodes::NAO_ENCONTRADO);
        }
    }

    public function create() {
        throw new \Exception("Não implementado", StatusCodes::NAO_ENCONTRADO);
    }

    public function delete($id) {
        throw new \Exception("Não implementado", StatusCodes::NAO_ENCONTRADO);
    }

    public function update($id) {
        throw new \Exception("Não implementado", StatusCodes::NAO_ENCONTRADO);
    }

}
