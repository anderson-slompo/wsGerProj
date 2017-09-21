<?php

namespace wsGerProj\Models;

class User{

    public $funcionario_id, $login, $nome, $isGerente, $isDesenvolvedor, $isTester, $isImplantador, $departamentos, $projetos;


    public function __construct($funcionario_id, $nome, $login){
        $this->funcionario_id = $funcionario_id;
        $this->login = $login;
        $this->nome = $nome;
        $this->isGerente = false;
        $this->isDesenvolvedor = false;
        $this->isTester = false;
        $this->isImplantador = false;
        $this->departamentos = array();
        $this->projetos = array();
    }

    public function setDepartamentos($departamentos){
        $this->departamentos = $departamentos;
        $this->setCargos();
    }

    public function setProjetos($projetos){
        $this->projetos = $projetos;
    }

    private function setCargos(){
        foreach($this->departamentos as $dep){
            $this->isGerente = ($dep == Departamento::GERENCIA && !$this->isGerente) ? true : $this->isGerente;
            $this->isDesenvolvedor = ($dep == Departamento::DESENVOLVIMENTO && !$this->isDesenvolvedor) ? true : $this->isDesenvolvedor;
            $this->isTester = ($dep == Departamento::TESTE && !$this->isTester) ? true : $this->isTester;
            $this->isImplantador = ($dep == Departamento::IMPLANTACAO && !$this->isImplantador) ? true : $this->isImplantador;
        }
    }
}