<?php

namespace wsGerProj\Models;

class FuncionarioEnderecos extends \Phalcon\Mvc\Model
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
    protected $id_tipo_endereco;

    /**
     *
     * @var string
     */
    protected $endereco;

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
     * Method to set the value of field id_tipo_endereco
     *
     * @param integer $id_tipo_endereco
     * @return $this
     */
    public function setIdTipoEndereco($id_tipo_endereco)
    {
        $this->id_tipo_endereco = $id_tipo_endereco;

        return $this;
    }

    /**
     * Method to set the value of field endereco
     *
     * @param string $endereco
     * @return $this
     */
    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;

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
     * Returns the value of field id_tipo_endereco
     *
     * @return integer
     */
    public function getIdTipoEndereco()
    {
        return $this->id_tipo_endereco;
    }

    /**
     * Returns the value of field endereco
     *
     * @return string
     */
    public function getEndereco()
    {
        return $this->endereco;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
        $this->belongsTo('id_funcionario', 'wsGerProj\Models\Funcionario', 'id', array('alias' => 'Funcionario'));
        $this->belongsTo('id_tipo_endereco', 'wsGerProj\Models\TipoEndereco', 'id', array('alias' => 'TipoEndereco'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'funcionario_enderecos';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return FuncionarioEnderecos[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return FuncionarioEnderecos
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
