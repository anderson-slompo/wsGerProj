<?php

namespace wsGerProj\Models;

class ProjetoAnexos extends \Phalcon\Mvc\Model
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
    protected $id_anexo;

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
     * Returns the value of field id_projeto
     *
     * @return integer
     */
    public function getIdProjeto()
    {
        return $this->id_projeto;
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
        $this->belongsTo('id_projeto', 'wsGerProj\Models\Projeto', 'id', array('foreignKey' => true,'alias' => 'Projeto'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'projeto_anexos';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProjetoAnexos[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProjetoAnexos
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
