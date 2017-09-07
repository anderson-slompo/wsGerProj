<?php

namespace wsGerProj\Models;

class TarefaLog extends \Phalcon\Mvc\Model
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
    protected $id_tarefa;

    /**
     *
     * @var string
     */
    protected $data_hora;

    /**
     *
     * @var string
     */
    protected $dados_antes;

    /**
     *
     * @var string
     */
    protected $dados_depois;

    /**
     *
     * @var integer
     */
    protected $id_funcionario;

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
     * Method to set the value of field id_tarefa
     *
     * @param integer $id_tarefa
     * @return $this
     */
    public function setIdTarefa($id_tarefa)
    {
        $this->id_tarefa = $id_tarefa;

        return $this;
    }

    /**
     * Method to set the value of field data_hora
     *
     * @param string $data_hora
     * @return $this
     */
    public function setDataHora($data_hora)
    {
        $this->data_hora = $data_hora;

        return $this;
    }

    /**
     * Method to set the value of field dados_antes
     *
     * @param string $dados_antes
     * @return $this
     */
    public function setDadosAntes($dados_antes)
    {
        $this->dados_antes = $dados_antes;

        return $this;
    }

    /**
     * Method to set the value of field dados_depois
     *
     * @param string $dados_depois
     * @return $this
     */
    public function setDadosDepois($dados_depois)
    {
        $this->dados_depois = $dados_depois;

        return $this;
    }

    /**
     * Method to set the value of field id_funcionario
     *
     * @param integer $id_funcionario
     * @return $this
     */
    public function setIdFuncionario($id_funcionario)
    {
        $this->id_funcionario = $id_funcionario;

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
     * Returns the value of field id_tarefa
     *
     * @return integer
     */
    public function getIdTarefa()
    {
        return $this->id_tarefa;
    }

    /**
     * Returns the value of field data_hora
     *
     * @return string
     */
    public function getDataHora()
    {
        return $this->data_hora;
    }

    /**
     * Returns the value of field dados_antes
     *
     * @return string
     */
    public function getDadosAntes()
    {
        return $this->dados_antes;
    }

    /**
     * Returns the value of field dados_depois
     *
     * @return string
     */
    public function getDadosDepois()
    {
        return $this->dados_depois;
    }

    /**
     * Returns the value of field id_funcionario
     *
     * @return integer
     */
    public function getIdFuncionario()
    {
        return $this->id_funcionario;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
        $this->belongsTo('id_tarefa', 'wsGerProj\Models\Tarefa', 'id', array('alias' => 'Tarefa'));
        $this->belongsTo('id_tarefa', 'wsGerProj\Models\Tarefa', 'id', array('foreignKey' => true,'alias' => 'Tarefa'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tarefa_log';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return TarefaLog[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return TarefaLog
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
