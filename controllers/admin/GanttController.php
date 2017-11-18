<?php

namespace wsGerProj\Controllers\Admin;

use wsGerProj\Controllers\ControllerBase,
    wsGerProj\Http\GetResponse,
    wsGerProj\Http\DefaultParams,
    wsGerProj\Http\StatusCodes;

class GanttController extends ControllerBase{

    public function getTarefasGantt(){
        
        $projetos = $this->makeProjetos();        
        $tarefas = $this->makeTarefas();

        return array_merge($projetos, $tarefas);
    }

    public function makeProjetos(){
        $db = $this->getDi()->getShared('db');
        
        $sql = "SELECT * FROM projetos_gantt";
        $result = $db->query($sql);
        $result->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
        $projetos = $result->fetchAll();

        foreach($projetos as &$projeto){
            $projeto['children'] = json_decode($projeto['children']);
        }
        
        return $projetos;
    }

    public function makeTarefas(){
        $db = $this->getDi()->getShared('db');
        
        $sql = "SELECT * FROM tarefas_gantt tg ORDER BY tg.from";
        $result = $db->query($sql);
        $result->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
        $tarefas = $result->fetchAll();

        $tarefasRet = [];

        foreach($tarefas as $tarefa){
            
            $tarefasRet[] = [
                'name' => "{$tarefa['nome']} - {$tarefa['fase_nome']} ({$tarefa['progress']}%)",
                'id' => $tarefa['id'],
                'tasks' => [
                    [
                        'name' => $tarefa['name'],
                        'from' => $tarefa['from'],
                        'to' => $tarefa['to'],
                        'progress' => $tarefa['progress']
                    ]
                ]
            ];
        }
        
        return $tarefasRet;
    }
    
}