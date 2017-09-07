<?php

namespace wsGerProj\Models;

use Phalcon\Mvc\Model\Validator\Uniqueness,
    Phalcon\Mvc\Model\Validator\PresenceOf;

class Projeto extends \Phalcon\Mvc\Model
{

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
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
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
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
        $this->hasMany('id', 'wsGerProj\Models\Erro', 'id_projeto', array('alias' => 'Erro'));
        $this->hasMany('id', 'wsGerProj\Models\ProjetoAnexos', 'id_projeto', array('alias' => 'ProjetoAnexos'));
        $this->hasMany('id', 'wsGerProj\Models\ProjetoFuncionarios', 'id_projeto', array('alias' => 'ProjetoFuncionarios'));
        $this->hasMany('id', 'wsGerProj\Models\ProjetosCliente', 'id_projeto', array('alias' => 'ProjetosCliente'));
        $this->hasMany('id', 'wsGerProj\Models\Tarefa', 'id_projeto', array('alias' => 'Tarefa'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'projeto';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Projeto[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Projeto
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
    
    public function getFuncionarios(){
        $query = ProjetoFuncionarios::query()
                ->columns(['id_funcionario as id', 'nome'])
                ->join('wsGerProj\Models\Funcionario')
                ->where('id_projeto = :id_projeto:')
                ->bind(['id_projeto' => $this->getId()]);
        return $query->execute();
    }
    
    public function getClientes(){
        $query = ProjetosCliente::query()
                ->columns(['id_cliente as id', 'nome'])
                ->join('wsGerProj\Models\Cliente')
                ->where('id_projeto = :id_projeto:')
                ->bind(['id_projeto' => $this->getId()]);
        return $query->execute();
    }
    
    public function getAnexos(){
        $query = ProjetoAnexos::query()
                ->columns(['id_anexo as id', 'nome', 'descricao', 'caminho','original'])
                ->join('wsGerProj\Models\Anexo')
                ->where('id_projeto = :id_projeto:')
                ->bind(['id_projeto' => $this->getId()]);
        return $query->execute();
    }

    public function deleteRelated(){
        $this->getProjetosCliente()->delete();
        $this->getProjetoFuncionarios()->delete();
    }
    
    public function validation(){
        $this->validate(new PresenceOf([
            "field" => "nome",
            "message" => "O nome do projeto é obrigatório!"
        ]));
        $this->validate(new PresenceOf([
            "field" => "descricao",
            "message" => "A descricao do proejto é obrigatória!"
        ]));
        if (is_numeric($this->id)) {
            $this->_operationMade=2;
        }
        $this->validate(new Uniqueness([
            "field" => "nome",
            "message" => "Nome do projeto escolhido já utilizado!"
        ]));


        return !$this->validationHasFailed();
    }
}
