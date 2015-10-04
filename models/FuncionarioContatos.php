<?php

namespace wsGerProj\Models;

class FuncionarioContatos extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $id_funcionario;

    /**
     *
     * @var integer
     */
    protected $id_tipo_contato;

    /**
     *
     * @var string
     */
    protected $contato;

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
     * Method to set the value of field id_tipo_contato
     *
     * @param integer $id_tipo_contato
     * @return $this
     */
    public function setIdTipoContato($id_tipo_contato)
    {
        $this->id_tipo_contato = $id_tipo_contato;

        return $this;
    }

    /**
     * Method to set the value of field contato
     *
     * @param string $contato
     * @return $this
     */
    public function setContato($contato)
    {
        $this->contato = $contato;

        return $this;
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
     * Returns the value of field id_tipo_contato
     *
     * @return integer
     */
    public function getIdTipoContato()
    {
        return $this->id_tipo_contato;
    }

    /**
     * Returns the value of field contato
     *
     * @return string
     */
    public function getContato()
    {
        return $this->contato;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
        $this->belongsTo('id_funcionario', 'wsGerProj\Models\Funcionario', 'id', array('alias' => 'Funcionario'));
        $this->belongsTo('id_tipo_contato', 'wsGerProj\Models\TipoContato', 'id', array('alias' => 'TipoContato'));
        $this->belongsTo('id_funcionario', 'wsGerProj\Models\Funcionario', 'id', array('foreignKey' => true,'alias' => 'Funcionario'));
        $this->belongsTo('id_tipo_contato', 'wsGerProj\Models\Tipocontato', 'id', array('foreignKey' => true,'alias' => 'Tipocontato'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'funcionario_contatos';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return FuncionarioContatos[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return FuncionarioContatos
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
