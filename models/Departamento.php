<?php

namespace wsGerProj\Models;

class Departamento extends \Phalcon\Mvc\Model
{
    const DESENVOLVIMENTO = 1;
    const TESTE = 2;
    const IMPLANTACAO = 3;
    const GERENCIA = 4;
    /**
     *
     * @var integer
     */
    protected $id;

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
        $this->hasMany('id', 'wsGerProj\Models\DepartamentosFuncionario', 'id_departamento', array('alias' => 'DepartamentosFuncionario'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'departamento';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Departamento[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Departamento
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function getFuncionarios(){
        $query = DepartamentosFuncionario::query()
                ->columns(['id_departamento', 'id_funcionario', 'nome'])
                ->join('wsGerProj\Models\Funcionario')
                ->where('id_departamento = :id_departamento:')
                ->bind(['id_departamento' => $this->getId()]);
        return $query->execute();
    }
    
}
