<?php

namespace wsGerProj\Models;

use Phalcon\Mvc\Model\Validator\Uniqueness,
    Phalcon\Mvc\Model\Validator\PresenceOf;
class Cliente extends \Phalcon\Mvc\Model {

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var string
     */
    protected $nome;

    /**
     *
     * @var integer
     */
    protected $id_externo;

    /**
     * Method to set the value of field id
     *
     * @param integer $id
     * @return $this
     */
    public function setId($id) {
        $this->id = $id;

        return $this;
    }

    /**
     * Method to set the value of field nome
     *
     * @param string $nome
     * @return $this
     */
    public function setNome($nome) {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Method to set the value of field id_externo
     *
     * @param integer $id_externo
     * @return $this
     */
    public function setIdExterno($id_externo) {
        $this->id_externo = $id_externo;

        return $this;
    }

    /**
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Returns the value of field nome
     *
     * @return string
     */
    public function getNome() {
        return $this->nome;
    }

    /**
     * Returns the value of field id_externo
     *
     * @return integer
     */
    public function getIdExterno() {
        return $this->id_externo;
    }

    /**
     * Initialize method for model.
     */
    public function initialize() {
        $this->setSchema("public");
        $this->hasMany('id', 'wsGerProj\Models\ProjetosCliente', 'id_cliente', array('alias' => 'ProjetosCliente'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource() {
        return 'cliente';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Cliente[]
     */
    public static function find($parameters = null) {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Cliente
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    public function validation() {
        $this->validate(new Uniqueness([
            "field" => "id_externo",
            "message" => "O campo Id Externo não pode se repetir!"
        ]));
        $this->validate(new PresenceOf([
            "field" => "nome",
            "message" => "O nome do cliente é obrigatório!"
        ]));
        
        return !$this->validationHasFailed();
    }

}
