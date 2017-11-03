<?php

namespace wsGerProj\Models;

use Phalcon\Mvc\Model\Validator\Uniqueness,
    Phalcon\Mvc\Model\Validator\PresenceOf;

class Tarefa extends \Phalcon\Mvc\Model {

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var integer
     */
    protected $id_projeto;

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
    protected $tipo;

    /**
     *
     * @var integer
     */
    protected $status;

    const STATUS_NOVA = 1;
    const STATUS_AGUARDANDO_DESENVOLVIMENTO = 2;
    const STATUS_DESENVOLVIMENTO = 3;
    const STATUS_AGUARDANTO_TESTE = 4;
    const STATUS_TESTE = 5;
    const STATUS_RETORNO_TESTE = 6;
    const STATUS_AGUARDANDO_IMPLANTACAO = 7;
    const STATUS_IMPLANTADA = 8;
    const STATUS_CANCELADA = 0;

    public static $statusDesc = [
        self::STATUS_NOVA => 'Nova',
        self::STATUS_AGUARDANDO_DESENVOLVIMENTO => 'Aguardando desenvolvimento',
        self::STATUS_DESENVOLVIMENTO => 'Em desenvolvimento',
        self::STATUS_AGUARDANTO_TESTE => 'Aguardando testes',
        self::STATUS_TESTE => 'Em teste',
        self::STATUS_RETORNO_TESTE => 'Retorno de teste',
        self::STATUS_AGUARDANDO_IMPLANTACAO => 'Aguardando implantação',
        self::STATUS_IMPLANTADA => 'Implantada',
        self::STATUS_CANCELADA => 'Cancelada',
    ];

    const TIPO_NOVA = 1;
    const TIPO_MELHORIA = 2;

    public static $tipoDesc = [
        self::TIPO_NOVA => 'Nova',
        self::TIPO_MELHORIA => 'Melhoria'
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
     * Method to set the value of field id_projeto
     *
     * @param integer $id_projeto
     * @return $this
     */
    public function setIdProjeto($id_projeto) {
        $this->id_projeto = $id_projeto;

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
     * Method to set the value of field tipo
     *
     * @param integer $tipo
     * @return $this
     */
    public function setTipo($tipo) {
        $this->tipo = $tipo;

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
     * Returns the value of field id_projeto
     *
     * @return integer
     */
    public function getIdProjeto() {
        return $this->id_projeto;
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
     * Returns the value of field descricao
     *
     * @return string
     */
    public function getDescricao() {
        return $this->descricao;
    }

    /**
     * Returns the value of field tipo
     *
     * @return integer
     */
    public function getTipo() {
        return $this->tipo;
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
        $this->hasMany('id', 'wsGerProj\Models\Erro', 'id_tarefa', array('alias' => 'Erro'));
        $this->hasMany('id', 'wsGerProj\Models\ImplantacaoTarefas', 'id_tarefa', array('alias' => 'ImplantacaoTarefas'));
        $this->hasMany('id', 'wsGerProj\Models\TarefaAnexos', 'id_tarefa', array('alias' => 'TarefaAnexos'));
        $this->hasMany('id', 'wsGerProj\Models\TarefaAtribuicao', 'id_tarefa', array('alias' => 'TarefaAtribuicao'));
        $this->hasMany('id', 'wsGerProj\Models\TarefaInteracao', 'id_tarefa', array('alias' => 'TarefaInteracao'));
        $this->hasMany('id', 'wsGerProj\Models\TarefaItens', 'id_tarefa', array('alias' => 'TarefaItens'));
        $this->hasMany('id', 'wsGerProj\Models\TarefaLog', 'id_tarefa', array('alias' => 'TarefaLog'));
        $this->belongsTo('id_projeto', 'wsGerProj\Models\Projeto', 'id', array('foreignKey' => true, 'alias' => 'Projeto'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource() {
        return 'tarefa';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Tarefa[]
     */
    public static function find($parameters = null) {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Tarefa
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }
    
    public function getAnexos(){
        $query = TarefaAnexos::query()
                ->columns(['id_anexo as id', 'nome', 'descricao', 'caminho','original'])
                ->join('wsGerProj\Models\Anexo')
                ->where('id_tarefa = :id_tarefa:')
                ->bind(['id_tarefa' => $this->getId()]);
        return $query->execute();
    }
    
    public function getItens(){
        $query = TarefaItens::query()
                ->columns(['id', 'titulo', 'descricao', 'porcentagem','status'])
                ->where('id_tarefa = :id_tarefa:')
                ->bind(['id_tarefa' => $this->getId()]);
        return $query->execute();
    }
    public function getAtribuicoes(){

        $faseNomeField = "CASE fase ";
        foreach(TarefaAtribuicao::$fasesDesc as $id_fase => $nome_fase){
            $faseNomeField.= " WHEN {$id_fase} THEN '{$nome_fase}' ";
        }
        $faseNomeField.= " END AS fase_nome";

        $query = TarefaAtribuicao::query()
                ->join('wsGerProj\Models\Funcionario', "wsGerProj\Models\Funcionario.id = id_funcionario")
                ->columns(['wsGerProj\Models\TarefaAtribuicao.id', 'id_funcionario', 'data_inicio', 'data_termino','fase', 'conclusao', 'nome as funcionario_nome', $faseNomeField])
                ->where('id_tarefa = :id_tarefa:')
                ->bind(['id_tarefa' => $this->getId()]);
        return $query->execute();
    }

    public function getErros(){
        $query = Erro::query()
                ->columns(['id', 'nome', 'descricao', "CASE corrigido WHEN TRUE THEN 'Sim' ELSE 'Não' END AS corrigido",'id_projeto', 'id_tarefa'])
                ->where('id_tarefa = :id_tarefa:')
                ->bind(['id_tarefa' => $this->getId()]);
        return $query->execute();
    }
    
    public function validation(){
        $this->validate(new PresenceOf([
            "field" => "nome",
            "message" => "O nome da tarefa é obrigatório!"
        ]));
        $this->validate(new PresenceOf([
            "field" => "descricao",
            "message" => "A descricao da tarefa é obrigatória!"
        ]));
        $this->validate(new PresenceOf([
            "field" => "tipo",
            "message" => "O tipo da tarefa é obrigatório!"
        ]));
        $this->validate(new PresenceOf([
            "field" => "id_projeto",
            "message" => "Toda tarefa necessita de um projeto!"
        ]));
        if (is_numeric($this->id)) {
            $this->_operationMade=2;
        }
        $this->validate(new Uniqueness([
            "field" => "nome",
            "message" => "Nome da tarefa escolhido já utilizado!"
        ]));
        
        return !$this->validationHasFailed();
    }

}
