<?php

namespace wsGerProj\Models;

class DepartamentosFuncionario extends \Phalcon\Mvc\Model
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
    protected $id_departamento;

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
     * Method to set the value of field id_departamento
     *
     * @param integer $id_departamento
     * @return $this
     */
    public function setIdDepartamento($id_departamento)
    {
        $this->id_departamento = $id_departamento;

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
     * Returns the value of field id_departamento
     *
     * @return integer
     */
    public function getIdDepartamento()
    {
        return $this->id_departamento;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
        $this->belongsTo('id_departamento', 'wsGerProj\Models\Departamento', 'id', array('foreignKey' => true,'alias' => 'Departamento'));
        $this->belongsTo('id_funcionario', 'wsGerProj\Models\Funcionario', 'id', array('foreignKey' => true,'alias' => 'Funcionario'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'departamentos_funcionario';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return DepartamentosFuncionario[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return DepartamentosFuncionario
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
