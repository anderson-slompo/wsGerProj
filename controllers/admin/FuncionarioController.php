<?php

namespace wsGerProj\Controllers\Admin;

use wsGerProj\Controllers\RestController;
use wsGerProj\Controllers\ControllerBase;
use wsGerProj\Http\GetResponse;
use wsGerProj\Http\DefaultParams;
use wsGerProj\Http\PostResponse;
use wsGerProj\Http\StatusCodes;
use wsGerProj\Models\Funcionario;
use wsGerProj\Models\FuncionarioContatos;
use wsGerProj\Models\FuncionarioEnderecos;

/**
 * Description of FuncionarioController
 *
 * @author anderson
 */
class FuncionarioController extends ControllerBase implements RestController {

    public function create() {
        $funcionario = $this->createFuncionarioFromJsonRawData();
    }

    public function delete($id) {
        
    }

    public function index() {
        $query = Funcionario::query();

        if ($this->request->getQuery('search_id')) {
            $query->andWhere('id = :id:')->bind(['id' => $this->request->getQuery('search_id')]);
        } else {
            $binds = [];
            if ($this->request->getQuery('search_nome')) {
                $query->andWhere('nome ILIKE :nome:');
                $binds['nome'] = "%{$this->request->getQuery('search_nome')}%";
            }
            if ($this->request->getQuery('search_status')) {
                $query->andWhere('status = :status:');
                $binds['status'] = $this->request->getQuery('search_status');
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
        $functionario = Funcionario::findFirst($id);
        if ($functionario) {

            $functionarioRet = $functionario->toArray();
            
            $functionarioRet['contatos'] = $functionario->getContatos()->toArray();
            $functionarioRet['enderecos'] = $functionario->getEnderecos()->toArray();
            $functionarioRet['departamentos'] = $functionario->getDepartamentos()->toArray();
            $functionarioRet['projetos'] = $functionario->getProjetos()->toArray();

            return $functionarioRet;
        } else {
            throw new \Exception("Funcionário #{$id} não encontrado", StatusCodes::NAO_ENCONTRADO);
        }
    }
    
    public function update($id) {
        
    }

    /**
     * Cria objeto do cliente com base nos dados enviados por POST via JSON
     * 
     * @return Funcionario
     */
    private function createFuncionarioFromJsonRawData() {

        $dataPost = $this->request->getJsonRawBody();

        $funcionario = new Funcionario;
        $funcionario->setNome($dataPost->nome);
        $funcionario->setLogin($dataPost->login);
        $funcionario->setSenha($dataPost->senha);
        $funcionario->setStatus(TRUE);
        $funcionario->setDataAdmissao($dataPost->data_admissao);
        $funcionario->setDataNascimento($dataPost->data_nascimento);

        return $funcionario;
    }

}
