<?php

namespace wsGerProj\Models;

class Projeto extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var string
     */
    protected $nome;

    /**
     *
     * @var string
     */
    protected $descricao;

    /**
     * Method to set the value of field id
     *
     * @param integer $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Method to set the value of field nome
     *
     * @param string $nome
     * @return $this
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Method to set the value of field descricao
     *
     * @param string $descricao
     * @return $this
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the value of field nome
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Returns the value of field descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
        $this->hasMany('id', 'wsGerProj\Models\Erro', 'id_projeto', array('alias' => 'Erro'));
        $this->hasMany('id', 'wsGerProj\Models\ProjetoAnexos', 'id_projeto', array('alias' => 'ProjetoAnexos'));
        $this->hasMany('id', 'wsGerProj\Models\ProjetoFuncionarios', 'id_projeto', array('alias' => 'ProjetoFuncionarios'));
        $this->hasMany('id', 'wsGerProj\Models\ProjetosCliente', 'id_projeto', array('alias' => 'ProjetosCliente'));
        $this->hasMany('id', 'wsGerProj\Models\Tarefa', 'id_projeto', array('alias' => 'Tarefa'));
        $this->hasMany('id', 'wsGerProj\Models\Erro', 'id_projeto', NULL);
        $this->hasMany('id', 'wsGerProj\Models\ProjetoAnexos', 'id_projeto', NULL);
        $this->hasMany('id', 'wsGerProj\Models\ProjetoFuncionarios', 'id_projeto', NULL);
        $this->hasMany('id', 'wsGerProj\Models\ProjetosCliente', 'id_projeto', NULL);
        $this->hasMany('id', 'wsGerProj\Models\Tarefa', 'id_projeto', NULL);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'projeto';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Projeto[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Projeto
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
