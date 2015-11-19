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
use wsGerProj\Models\ProjetoFuncionarios;
use wsGerProj\Models\DepartamentosFuncionario;

/**
 * Description of FuncionarioController
 *
 * @author anderson
 */
class FuncionarioController extends ControllerBase implements RestController {

    public function create() {
        $funcionario = $this->createFuncionarioFromJsonRawData();

        if ($funcionario->validation() && $funcionario->save()) {
            return PostResponse::createResponse(PostResponse::STATUS_OK, "Funcionário [#{$funcionario->getId()} {$funcionario->getNome()}] inserido com sucesso.");
        } else {
            throw new \Exception(PostResponse::createModelErrorMessages($funcionario), StatusCodes::ERRO_CLI);
        }
    }

    public function delete($id) {
        $functionario = Funcionario::findFirst($id);
        if ($functionario) {
            $msg = $functionario->getStatus() ? "inativado" : "ativado";
            $functionario->setStatus(!$functionario->getStatus());
            
            if ($functionario->save()) {
                return PostResponse::createResponse(PostResponse::STATUS_OK, "Funcionário {$msg} com sucesso");
            } else {
                throw new \Exception(PostResponse::createModelErrorMessages($functionario), StatusCodes::ERRO_CLI_CONFLICT);
            }

            return $functionarioRet;
        } else {
            throw new \Exception("Funcionário #{$id} não encontrado", StatusCodes::NAO_ENCONTRADO);
        }
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
        $funcionario = Funcionario::findFirst($id);
        if ($funcionario) {
            
            $funcionario->deleteRelated();

            $funcionario = $this->createFuncionarioFromJsonRawData($funcionario);
            if ($funcionario->validation() && $funcionario->save()) {
                return PostResponse::createResponse(PostResponse::STATUS_OK, "Funcionário [#{$funcionario->getId()} {$funcionario->getNome()}] alterado com sucesso.");
            } else {
                throw new \Exception(PostResponse::createModelErrorMessages($funcionario), StatusCodes::ERRO_CLI);
            }
        } else {
            throw new \Exception("Funcionário #{$id} não encontrado", StatusCodes::NAO_ENCONTRADO);
        }
    }

    /**
     * Cria objeto do funcionario com base nos dados enviados por POST via JSON, caso seja passado o funcionario será considerado edição do mesmo
     * 
     * @param Funcionario $funcionario
     * @return Funcionario
     */
    private function createFuncionarioFromJsonRawData(Funcionario $funcionario = NULL) {

        $dataPost = $this->request->getJsonRawBody();

        if (is_null($funcionario)) {
            $funcionario = new Funcionario;
        }
        $funcionario->setNome($dataPost->nome);
        $funcionario->setLogin($dataPost->login);
        $funcionario->setStatus($dataPost->status);
        $funcionario->setDataAdmissao($dataPost->data_admissao);
        $funcionario->setDataNascimento($dataPost->data_nascimento);
        $funcionario->setSenha(md5($dataPost->senha));
        
        $funcionario->funcionarioContatos = $this->createFuncionarioContatos($dataPost);
        $funcionario->funcionarioEnderecos = $this->createFuncionarioEnderecos($dataPost);
        $funcionario->projetoFuncionarios = $this->createFuncionarioProjetos($dataPost);
        $funcionario->departamentosFuncionario = $this->createFuncionarioDepartamentos($dataPost);

        return $funcionario;
    }

    private function createFuncionarioContatos($dataPost) {
        $contatos = [];
        foreach ($dataPost->contatos as $postContato) {
            $contato = new FuncionarioContatos();

            $contato->setIdFuncionario($funcionario);
            $contato->setIdTipoContato($postContato->id_tipo_contato);
            $contato->setContato($postContato->contato);

            $contatos[] = $contato;
        }
        return $contatos;
    }

    private function createFuncionarioEnderecos($dataPost) {
        $enderecos = [];
        foreach ($dataPost->enderecos as $postEndereco) {
            $endereco = new FuncionarioEnderecos();

            $endereco->setIdFuncionario($funcionario);
            $endereco->setIdTipoEndereco($postEndereco->id_tipo_endereco);
            $endereco->setEndereco($postEndereco->endereco);

            $enderecos[] = $endereco;
        }
        return $enderecos;
    }

    private function createFuncionarioProjetos($dataPost) {
        $projetos = [];
        foreach ($dataPost->projetos as $postProjeto) {
            $projeto = new ProjetoFuncionarios();

            $projeto->setIdFuncionario($funcionario);
            $projeto->setIdProjeto($postProjeto->id);

            $projetos[] = $projeto;
        }
        return $projetos;
    }

    private function createFuncionarioDepartamentos($dataPost) {
        $departamentos = [];
        foreach ($dataPost->departamentos as $postDepartamento) {
            $departamento = new DepartamentosFuncionario();

            $departamento->setIdFuncionario($funcionario);
            $departamento->setIdDepartamento($postDepartamento->id);

            $departamentos[] = $departamento;
        }
        return $departamentos;
    }

}
