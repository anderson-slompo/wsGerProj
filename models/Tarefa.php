<?php

namespace wsGerProj\Models;

class Tarefa extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var integer
     */
    protected $id_projeto;

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
     *
     * @var integer
     */
    protected $tipo;

    /**
     *
     * @var integer
     */
    protected $status;

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
     * Method to set the value of field id_projeto
     *
     * @param integer $id_projeto
     * @return $this
     */
    public function setIdProjeto($id_projeto)
    {
        $this->id_projeto = $id_projeto;

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
     * Method to set the value of field tipo
     *
     * @param integer $tipo
     * @return $this
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Method to set the value of field status
     *
     * @param integer $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

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
     * Returns the value of field id_projeto
     *
     * @return integer
     */
    public function getIdProjeto()
    {
        return $this->id_projeto;
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
     * Returns the value of field tipo
     *
     * @return integer
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Returns the value of field status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
        $this->hasMany('id', 'wsGerProj\Models\Erro', 'id_tarefa', array('alias' => 'Erro'));
        $this->hasMany('id', 'wsGerProj\Models\ImplantacaoTarefas', 'id_tarefa', array('alias' => 'ImplantacaoTarefas'));
        $this->hasMany('id', 'wsGerProj\Models\TarefaAnexos', 'id_tarefa', array('alias' => 'TarefaAnexos'));
        $this->hasMany('id', 'wsGerProj\Models\TarefaAtribuicao', 'id_tarefa', array('alias' => 'TarefaAtribuicao'));
        $this->hasMany('id', 'wsGerProj\Models\TarefaInteracao', 'id_tarefa', array('alias' => 'TarefaInteracao'));
        $this->hasMany('id', 'wsGerProj\Models\TarefaItens', 'id_tarefa', array('alias' => 'TarefaItens'));
        $this->hasMany('id', 'wsGerProj\Models\TarefaLog', 'id_tarefa', array('alias' => 'TarefaLog'));
        $this->belongsTo('id_projeto', 'wsGerProj\Models\Projeto', 'id', array('alias' => 'Projeto'));
        $this->hasMany('id', 'wsGerProj\Models\Erro', 'id_tarefa', NULL);
        $this->hasMany('id', 'wsGerProj\Models\ImplantacaoTarefas', 'id_tarefa', NULL);
        $this->hasMany('id', 'wsGerProj\Models\TarefaAnexos', 'id_tarefa', NULL);
        $this->hasMany('id', 'wsGerProj\Models\TarefaAtribuicao', 'id_tarefa', NULL);
        $this->hasMany('id', 'wsGerProj\Models\TarefaInteracao', 'id_tarefa', NULL);
        $this->hasMany('id', 'wsGerProj\Models\TarefaItens', 'id_tarefa', NULL);
        $this->hasMany('id', 'wsGerProj\Models\TarefaLog', 'id_tarefa', NULL);
        $this->belongsTo('id_projeto', 'wsGerProj\Models\Projeto', 'id', array('foreignKey' => true,'alias' => 'Projeto'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tarefa';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Tarefa[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Tarefa
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
