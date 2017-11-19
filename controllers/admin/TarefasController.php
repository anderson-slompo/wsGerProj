<?php

namespace wsGerProj\Controllers\Admin;

use wsGerProj\Controllers\RestController,
    wsGerProj\Controllers\ControllerBase,
    wsGerProj\Http\GetResponse,
    wsGerProj\Http\DefaultParams,
    wsGerProj\Http\PostResponse,
    wsGerProj\Http\StatusCodes,
    wsGerProj\Models\Tarefa,
    wsGerProj\Models\TarefaItens;

/**
 * Description of TarefasController
 *
 * @author anderson
 */
class TarefasController extends ControllerBase implements RestController {

    public function create() {
        $this->db->begin();

        $tarefa = $this->createTarefaFromJsonRawData();

        $id = $tarefa->getId();
        $this->db->commit();
        return PostResponse::createResponse(PostResponse::STATUS_OK, ['message' => "Tarefa [#{$id} {$tarefa->getNome()}] inserida com sucesso.", 'id' => $id]);
    }

    public function delete($id) {
        
    }

    public function index() {
        $query = Tarefa::query();

        if ($this->request->getQuery('search_id')) {
            $query->andWhere('id = :id:')->bind(['id' => $this->request->getQuery('search_id')]);
        } else {
            $binds = [];
            if ($this->request->getQuery('search_nome')) {
                $query->andWhere('nome ILIKE :nome:');
                $binds['nome'] = "%{$this->request->getQuery('search_nome')}%";
            }
            if ($this->request->getQuery('search_descricao')) {
                $query->andWhere('descricao ILIKE :descricao:');
                $binds['descricao'] = "%{$this->request->getQuery('search_descricao')}%";
            }

            if ($this->request->getQuery('search_tipo')) {
                $query->andWhere('tipo = :tipo:');
                $binds['tipo'] = $this->request->getQuery('search_tipo');
            }
            if ($this->request->getQuery('search_status')) {
                $query->andWhere('status = :status:');
                $binds['status'] = $this->request->getQuery('search_status');
            }
            if ($this->request->getQuery('search_projeto')) {
                $query->andWhere('id_projeto = :projeto:');
                $binds['projeto'] = $this->request->getQuery('search_projeto');
            }

            if (count($binds)) {
                $query->bind($binds);
            }
        }

        $user = $this->getDI()->get('currentUser');
        if(!$user->isGerente){
            if(count($user->projetos)){
                $query->andWhere('id_projeto IN( '.implode(', ',$user->projetos).' )');
            } else{
                $query->andWhere('id_projeto is null');
            }            
        }

        if ($this->request->getQuery(DefaultParams::ORDER)) {
            $query->order($this->request->getQuery(DefaultParams::ORDER));
        }

        return GetResponse::createResponse($this->request, $query->execute()->toArray());
    }

    public function show($id) {
        $tarefa = Tarefa::findFirst($id);

        if ($tarefa) {

            $tarefaRet = $tarefa->toArray();
            $tarefaRet['itens'] = $tarefa->getItens()->toArray();
            $tarefaRet['anexos'] = $tarefa->getAnexos()->toArray();
            $tarefaRet['atribuicoes'] = $tarefa->getAtribuicoes()->toArray();
            $tarefaRet['erros'] = $tarefa->getErros()->toArray();
            $tarefaRet['interacoes'] = $tarefa->getInteracoes()->toArray();

            return $tarefaRet;
        } else {
            throw new \Exception("Tarefa #{$id} não encontrada", StatusCodes::NAO_ENCONTRADO);
        }
    }

    public function update($id) {
        $tarefa = Tarefa::findFirst($id);

        if ($tarefa) {

            $this->db->begin();

            $this->createTarefaFromJsonRawData($tarefa);

            $this->db->commit();
            return PostResponse::createResponse(PostResponse::STATUS_OK, "Tarefa [#{$id} {$tarefa->getNome()}] alterada com sucesso.");
        } else {
            throw new \Exception("Tarefa #{$id} não encontrada", StatusCodes::NAO_ENCONTRADO);
        }
    }

    public function getTipos() {
        return Tarefa::$tipoDesc;
    }

    public function getStatus() {
        return Tarefa::$statusDesc;
    }
    public function getTipoID($id) {
        return ['id' => $id, 'nome' => Tarefa::$tipoDesc[$id]];
    }

    public function getStatusID($id) {
        return ['id' => $id, 'nome' => Tarefa::$statusDesc[$id]];
    }

    private function createTarefaFromJsonRawData(Tarefa $tarefa = NULL) {

        $dataPost = $this->request->getJsonRawBody();

        if (is_null($tarefa)) {
            $tarefa = new Tarefa();
        }

        $tarefa->setDescricao($dataPost->descricao);
        $tarefa->setIdProjeto($dataPost->id_projeto->id);
        $tarefa->setNome($dataPost->nome);
        $tarefa->setTipo($dataPost->tipo->id);
        if (!is_numeric($tarefa->getId())) {
            $tarefa->setStatus(Tarefa::STATUS_NOVA);
        }
        if ($tarefa->validation() && $tarefa->save()) {
            $this->createTarefaItens($tarefa, $dataPost);
            return $tarefa;
        } else {
            $this->db->rollback();
            throw new \Exception(PostResponse::createModelErrorMessages($tarefa), StatusCodes::ERRO_CLI);
        }
    }

    public function createTarefaItens(Tarefa $tarefa, $dataPost) {

        foreach ($dataPost->add_itens as $postItem) {
            $item = new TarefaItens();

            $item->setDescricao($postItem->descricao);
            $item->setPorcentagem($postItem->porcentagem);
            $item->setTitulo($postItem->titulo);
            $item->setStatus(TarefaItens::STATUS_NAO_CONCLUIDO);
            $item->setIdTarefa($tarefa->getId());

            if (!$item->validation() || !$item->save()) {
                $this->db->rollback();
                throw new \Exception(PostResponse::createModelErrorMessages($item), StatusCodes::ERRO_CLI);
            }
        }

        return true;
    }

}
