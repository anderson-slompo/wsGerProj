<?php

namespace wsGerProj\Models;

class TarefaAnexos extends \Phalcon\Mvc\Model
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
    protected $id_anexo;

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
     * Method to set the value of field id_anexo
     *
     * @param integer $id_anexo
     * @return $this
     */
    public function setIdAnexo($id_anexo)
    {
        $this->id_anexo = $id_anexo;

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
     * Returns the value of field id_anexo
     *
     * @return integer
     */
    public function getIdAnexo()
    {
        return $this->id_anexo;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
        $this->belongsTo('id_anexo', 'wsGerProj\Models\Anexo', 'id', array('foreignKey' => true,'alias' => 'Anexo'));
        $this->belongsTo('id_tarefa', 'wsGerProj\Models\Tarefa', 'id', array('foreignKey' => true,'alias' => 'Tarefa'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tarefa_anexos';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return TarefaAnexos[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return TarefaAnexos
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
