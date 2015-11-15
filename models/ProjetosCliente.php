<?php

namespace wsGerProj\Models;

class ProjetosCliente extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $id_projeto;

    /**
     *
     * @var integer
     */
    protected $id_cliente;

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
     * Method to set the value of field id_cliente
     *
     * @param integer $id_cliente
     * @return $this
     */
    public function setIdCliente($id_cliente)
    {
        $this->id_cliente = $id_cliente;

        return $this;
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
     * Returns the value of field id_cliente
     *
     * @return integer
     */
    public function getIdCliente()
    {
        return $this->id_cliente;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
        $this->belongsTo('id_projeto', 'wsGerProj\Models\Projeto', 'id', array('foreignKey' => true,'alias' => 'Projeto'));
        $this->belongsTo('id_cliente', 'wsGerProj\Models\Cliente', 'id', array('foreignKey' => true,'alias' => 'Cliente'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'projetos_cliente';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProjetosCliente[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProjetosCliente
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
