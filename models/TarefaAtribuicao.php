<?php

namespace wsGerProj\Models;

class TarefaAtribuicao extends \Phalcon\Mvc\Model
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
     * @var integer
     */
    protected $id_funcionario;

    /**
     *
     * @var string
     */
    protected $data_inicio;

    /**
     *
     * @var string
     */
    protected $data_termino;

    /**
     *
     * @var integer
     */
    protected $fase;

    /**
     *
     * @var string
     */
    protected $data_hora;

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
     * Method to set the value of field data_inicio
     *
     * @param string $data_inicio
     * @return $this
     */
    public function setDataInicio($data_inicio)
    {
        $this->data_inicio = $data_inicio;

        return $this;
    }

    /**
     * Method to set the value of field data_termino
     *
     * @param string $data_termino
     * @return $this
     */
    public function setDataTermino($data_termino)
    {
        $this->data_termino = $data_termino;

        return $this;
    }

    /**
     * Method to set the value of field fase
     *
     * @param integer $fase
     * @return $this
     */
    public function setFase($fase)
    {
        $this->fase = $fase;

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
     * Returns the value of field id_funcionario
     *
     * @return integer
     */
    public function getIdFuncionario()
    {
        return $this->id_funcionario;
    }

    /**
     * Returns the value of field data_inicio
     *
     * @return string
     */
    public function getDataInicio()
    {
        return $this->data_inicio;
    }

    /**
     * Returns the value of field data_termino
     *
     * @return string
     */
    public function getDataTermino()
    {
        return $this->data_termino;
    }

    /**
     * Returns the value of field fase
     *
     * @return integer
     */
    public function getFase()
    {
        return $this->fase;
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
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
        $this->belongsTo('id_tarefa', 'wsGerProj\Models\Tarefa', 'id', array('alias' => 'Tarefa'));
        $this->belongsTo('id_funcionario', 'wsGerProj\Models\Funcionario', 'id', array('alias' => 'Funcionario'));
        $this->belongsTo('id_tarefa', 'wsGerProj\Models\Tarefa', 'id', array('foreignKey' => true,'alias' => 'Tarefa'));
        $this->belongsTo('id_funcionario', 'wsGerProj\Models\Funcionario', 'id', array('foreignKey' => true,'alias' => 'Funcionario'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tarefa_atribuicao';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return TarefaAtribuicao[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return TarefaAtribuicao
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
