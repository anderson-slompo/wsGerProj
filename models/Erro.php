<?php

namespace wsGerProj\Models;

use Phalcon\Mvc\Model\Validator\PresenceOf;

class Erro extends \Phalcon\Mvc\Model
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
    protected $nome;

    /**
     *
     * @var string
     */
    protected $descricao;

    /**
     *
     * @var integer
     */
    protected $id_projeto;
    /**
     * 
     * @var boolean
     */
    protected $corrigido;

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
     * Method to set the value of field nome
     *
     * @param string $nome
     * @return $this
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

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
     * Method to set the value of field corrigido
     *
     * @param boolean $corrigido
     * @return $this
     */
    public function setCorrigido($corrigido)
    {
        $this->corrigido = $corrigido;

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
     * Returns the value of field nome
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
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
     * Returns the value of field id_projeto
     *
     * @return integer
     */
    public function getIdProjeto()
    {
        return $this->id_projeto;
    }

    /**
     * Returns the value of field corrigido
     *
     * @return boolean
     */
    public function getCorrigido()
    {
        return $this->corrigido;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
        $this->belongsTo('id_projeto', 'wsGerProj\Models\Projeto', 'id', array('alias' => 'Projeto'));
        $this->belongsTo('id_tarefa', 'wsGerProj\Models\Tarefa', 'id', array('alias' => 'Tarefa'));
        $this->belongsTo('id_projeto', 'wsGerProj\Models\Projeto', 'id', array('foreignKey' => true,'alias' => 'Projeto'));
        $this->belongsTo('id_tarefa', 'wsGerProj\Models\Tarefa', 'id', array('foreignKey' => true,'alias' => 'Tarefa'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'erro';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Erro[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Erro
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function validation(){
        $this->validate(new PresenceOf([
            "field" => "id_tarefa",
            "message" => "A tarefa é obrigatória!"
        ]));        
        $this->validate(new PresenceOf([
            "field" => "nome",
            "message" => "O nome é obrigatório!"
        ]));
        $this->validate(new PresenceOf([
            "field" => "descricao",
            "message" => "A descrição é obrigatória!"
        ]));
        $this->validate(new PresenceOf([
            "field" => 'id_projeto',
            "message" => 'O projeto é obrigatório!'
        ]));
        if (is_numeric($this->id)) {
            $this->_operationMade=2;
        }
                
        return !$this->validationHasFailed();
    }

}
