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
class ProjetosController extends ControllerBase implements RestController {

    public function create() {
        $projeto = $this->createProjetoFromJsonRawData();

        if ($projeto->validation() && $projeto->save()) {
            return PostResponse::createResponse(PostResponse::STATUS_OK, "Projeto [#{$projeto->getId()} {$projeto->getNome()}] inserido com sucesso.");
        } else {
            throw new \Exception(PostResponse::createModelErrorMessages($projeto), StatusCodes::ERRO_CLI);
        }
    }

    public function delete($id) {
        throw new \Exception('Não permitido', StatusCodes::NAO_AUTORIZADO);
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

        if ($projeto) {

            $projetoRet = $projeto->toArray();

            $projetoRet['funcionarios'] = $projeto->getFuncionarios()->toArray();
            $projetoRet['clientes'] = $projeto->getClientes()->toArray();
            $projetoRet['anexos'] = $projeto->getAnexos()->toArray();

            return $projetoRet;
        } else {
            throw new \Exception("Projeto #{$id} não encontrado", StatusCodes::NAO_ENCONTRADO);
        }
    }

    public function update($id) {
        $projeto = Projeto::findFirst($id);

        if ($projeto) {
            
            $projeto->deleteRelated();
            
            $projeto = $this->createProjetoFromJsonRawData($projeto);

            if ($projeto->validation() && $projeto->save()) {
                return PostResponse::createResponse(PostResponse::STATUS_OK, "Projeto [#{$projeto->getId()} {$projeto->getNome()}] inserido com sucesso.");
            } else {
                throw new \Exception(PostResponse::createModelErrorMessages($projeto), StatusCodes::ERRO_CLI);
            }

        } else {
            throw new \Exception("Projeto #{$id} não encontrado", StatusCodes::NAO_ENCONTRADO);
        }
    }

    /**
     * Cria objeto do projeto com base nos dados enviados por POST via JSON, caso seja passado o projeto será considerado edição do mesmo
     * 
     * @param Projeto $projeto
     * @return Projeto
     */
    private function createProjetoFromJsonRawData(Projeto $projeto = NULL) {

        $dataPost = $this->request->getJsonRawBody();

        if (is_null($projeto)) {
            $projeto = new Projeto;
        }

        $projeto->setNome($dataPost->nome);
        $projeto->setDescricao($dataPost->descricao);

        $projeto->projetoFuncionarios = $this->createProjetoFuncionarios($dataPost);
        $projeto->projetosCliente = $this->createProjetoClientes($dataPost);

        return $projeto;
    }

    private function createProjetoFuncionarios($dataPost) {
        $funcionarios = [];
        foreach ($dataPost->funcionarios as $postFuncionario) {
            $funcionario = new ProjetoFuncionarios();
            $funcionario->setIdFuncionario($postFuncionario->id);

            $funcionarios[] = $funcionario;
        }
        return $funcionarios;
    }

    private function createProjetoClientes($dataPost) {
        $clientes = [];
        foreach ($dataPost->clientes as $postCliente) {
            $cliente = new ProjetosCliente();
            $cliente->setIdCliente($postCliente->id);

            $clientes[] = $cliente;
        }
        return $clientes;
    }

}
