<?php

namespace wsGerProj\Controllers\Admin;

use wsGerProj\Controllers\ControllerBase,
    wsGerProj\Http\GetResponse,
    wsGerProj\Http\DefaultParams,
    wsGerProj\Http\StatusCodes;

class DashGerenteController extends ControllerBase{

    public function getTarefasAguardandoAtribuicao(){
        $db = $this->getDi()->getShared('db');

        $sql = "SELECT * FROM tarefas_aguardando_atribuicao";
        $result = $db->query($sql);
        $result->setFetchMode(\Phalcon\Db::FETCH_ASSOC);

        return $result->fetchAll();
    }

    public function getStatusProjetos(){
        $db = $this->getDi()->getShared('db');

        $sql = "SELECT * FROM status_projetos";
        $result = $db->query($sql);
        $result->setFetchMode(\Phalcon\Db::FETCH_ASSOC);

        return $result->fetchAll();
    }

    public function getTarefasAtrasadas(){
        $db = $this->getDi()->getShared('db');

        $sql = "SELECT * FROM tarefas_atuais WHERE atrasada IS TRUE ORDER BY inicio";
        $result = $db->query($sql);
        $result->setFetchMode(\Phalcon\Db::FETCH_ASSOC);

        return $result->fetchAll();
    }

    public function getTarefasExecussao(){
        $db = $this->getDi()->getShared('db');

        $sql = "SELECT * FROM tarefas_atuais ORDER BY inicio";
        $result = $db->query($sql);
        $result->setFetchMode(\Phalcon\Db::FETCH_ASSOC);

        return $result->fetchAll();
    }
    
}