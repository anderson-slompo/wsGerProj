<?php

namespace wsGerProj\Models;

use Phalcon\Mvc\Model\Validator\PresenceOf,
    Phalcon\Mvc\Model\Validator\Numericality;

class TarefaItens extends \Phalcon\Mvc\Model {

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
    protected $titulo;

    /**
     *
     * @var string
     */
    protected $descricao;

    /**
     *
     * @var integer
     */
    protected $porcentagem;

    /**
     *
     * @var integer
     */
    protected $status;

    const STATUS_NAO_CONCLUIDO = 0;
    const STATUS_CONCLUIDO = 1;

    public static $status_desc = [
        self::STATUS_NAO_CONCLUIDO => 'Não concluído',
        self::STATUS_CONCLUIDO => 'Concluído',
    ];

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
     * Method to set the value of field id_tarefa
     *
     * @param integer $id_tarefa
     * @return $this
     */
    public function setIdTarefa($id_tarefa) {
        $this->id_tarefa = $id_tarefa;

        return $this;
    }

    /**
     * Method to set the value of field titulo
     *
     * @param string $titulo
     * @return $this
     */
    public function setTitulo($titulo) {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Method to set the value of field descricao
     *
     * @param string $descricao
     * @return $this
     */
    public function setDescricao($descricao) {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * Method to set the value of field porcentagem
     *
     * @param integer $porcentagem
     * @return $this
     */
    public function setPorcentagem($porcentagem) {
        $this->porcentagem = $porcentagem;

        return $this;
    }

    /**
     * Method to set the value of field status
     *
     * @param integer $status
     * @return $this
     */
    public function setStatus($status) {
        $this->status = $status;

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
     * Returns the value of field id_tarefa
     *
     * @return integer
     */
    public function getIdTarefa() {
        return $this->id_tarefa;
    }

    /**
     * Returns the value of field titulo
     *
     * @return string
     */
    public function getTitulo() {
        return $this->titulo;
    }

    /**
     * Returns the value of field descricao
     *
     * @return string
     */
    public function getDescricao() {
        return $this->descricao;
    }

    /**
     * Returns the value of field porcentagem
     *
     * @return integer
     */
    public function getPorcentagem() {
        return $this->porcentagem;
    }

    /**
     * Returns the value of field status
     *
     * @return integer
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Initialize method for model.
     */
    public function initialize() {
        $this->setSchema("public");
        $this->belongsTo('id_tarefa', 'wsGerProj\Models\Tarefa', 'id', array('foreignKey' => true, 'alias' => 'Tarefa'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource() {
        return 'tarefa_itens';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return TarefaItens[]
     */
    public static function find($parameters = null) {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return TarefaItens
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    public function validation() {
        if (is_numeric($this->id)) {
            $this->_operationMade=2;
        }
        $this->validate(new PresenceOf([
            "field" => "titulo",
            "message" => "O titulo do item da tarefa é obrigatório!"
        ]));
        $this->validate(new PresenceOf([
            "field" => "descricao",
            "message" => "A descrição do item da tarefa é obrigatória!"
        ]));
        $this->validate(new PresenceOf([
            "field" => "porcentagem",
            "message" => "A porcentagem do item é obrigatória!"
        ]));
        $this->validate(new Numericality([
            "field" => "porcentagem",
            "message" => "A porcentagem do item deve ser um numero!"
        ]));
        
        return !$this->validationHasFailed();
    }

}
