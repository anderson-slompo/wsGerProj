<?php

namespace wsGerProj\Models;

class ImplantacaoTarefas extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $id_tarefa;

    /**
     *
     * @var integer
     */
    protected $id_implantacao;

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
     * Method to set the value of field id_implantacao
     *
     * @param integer $id_implantacao
     * @return $this
     */
    public function setIdImplantacao($id_implantacao)
    {
        $this->id_implantacao = $id_implantacao;

        return $this;
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
     * Returns the value of field id_implantacao
     *
     * @return integer
     */
    public function getIdImplantacao()
    {
        return $this->id_implantacao;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
        $this->belongsTo('id_implantacao', 'wsGerProj\Models\Implantacao', 'id', array('alias' => 'Implantacao'));
        $this->belongsTo('id_tarefa', 'wsGerProj\Models\Tarefa', 'id', array('alias' => 'Tarefa'));
        $this->belongsTo('id_implantacao', 'wsGerProj\Models\Implantacao', 'id', array('foreignKey' => true,'alias' => 'Implantacao'));
        $this->belongsTo('id_tarefa', 'wsGerProj\Models\Tarefa', 'id', array('foreignKey' => true,'alias' => 'Tarefa'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'implantacao_tarefas';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ImplantacaoTarefas[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ImplantacaoTarefas
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
