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
        $tarefa = $this->createTarefaFromJsonRawData();
        $valid = $tarefa->validation();
        die(var_dump($valid,true));
        if ($tarefa->validation() && $tarefa->save()) {
            $id = $tarefa->getId();
            return PostResponse::createResponse(PostResponse::STATUS_OK, ['message' => "Tarefa [#{$id} {$tarefa->getTitulo()}] inserida com sucesso.", 'id' => $id]);
        } else {
            throw new \Exception(PostResponse::createModelErrorMessages($tarefa), StatusCodes::ERRO_CLI);
        }
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
                $binds['tipo'] = $this->request->getQuery('search_status');
            }
            if ($this->request->getQuery('search_projeto')) {
                $query->andWhere('id_projeto = :projeto:');
                $binds['projeto'] = $this->request->getQuery('search_projeto');
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
        $tarefa = Tarefa::findFirst($id);

        if ($tarefa) {

            $tarefaRet = $tarefa->toArray();
            $tarefaRet['itens'] = $tarefa->getItens()->toArray();
            $tarefaRet['anexos'] = $tarefa->getAnexos()->toArray();

            return $tarefaRet;
        } else {
            throw new \Exception("Tarefa #{$id} não encontrada", StatusCodes::NAO_ENCONTRADO);
        }
    }

    public function update($id) {
        
    }

    public function getTipos() {
        return Tarefa::$tipoDesc;
    }

    public function getStatus() {
        return Tarefa::$statusDesc;
    }

    private function createTarefaFromJsonRawData(Tarefa $tarefa = NULL) {

        $dataPost = $this->request->getJsonRawBody();

        if (is_null($tarefa)) {
            $tarefa = new Tarefa;
        }

        $tarefa->setDescricao($dataPost->descricao);
        $tarefa->setIdProjeto($dataPost->id_projeto);
        $tarefa->setNome($dataPost->nome);
        $tarefa->setTipo($dataPost->tipo);

//        $tarefa->tarefaItens = $this->createTarefaItens($dataPost,$tarefa);

        return $tarefa;
    }

    public function createTarefaItens($dataPost, Tarefa $tarefa) {

        $itens = [];

        foreach ($dataPost->add_itens as $postItem) {
            $item = new TarefaItens();
            
            $item->setDescricao($postItem->descricao);
            $item->setPorcentagem($postItem->porcentagem);
            $item->setTitulo($postItem->titulo);
            $item->setStatus(TarefaItens::STATUS_NAO_CONCLUIDO);
            $item->setIdTarefa($tarefa);
            
            $itens[] = $item;
        }

        return $itens;
    }

}
