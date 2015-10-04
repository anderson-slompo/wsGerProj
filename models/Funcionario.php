<?php

namespace wsGerProj\Models;

class Funcionario extends \Phalcon\Mvc\Model
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
    protected $login;

    /**
     *
     * @var string
     */
    protected $senha;

    /**
     *
     * @var string
     */
    protected $data_nascimento;

    /**
     *
     * @var string
     */
    protected $data_admissao;

    /**
     *
     * @var string
     */
    protected $status;

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
     * Method to set the value of field login
     *
     * @param string $login
     * @return $this
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Method to set the value of field senha
     *
     * @param string $senha
     * @return $this
     */
    public function setSenha($senha)
    {
        $this->senha = $senha;

        return $this;
    }

    /**
     * Method to set the value of field data_nascimento
     *
     * @param string $data_nascimento
     * @return $this
     */
    public function setDataNascimento($data_nascimento)
    {
        $this->data_nascimento = $data_nascimento;

        return $this;
    }

    /**
     * Method to set the value of field data_admissao
     *
     * @param string $data_admissao
     * @return $this
     */
    public function setDataAdmissao($data_admissao)
    {
        $this->data_admissao = $data_admissao;

        return $this;
    }

    /**
     * Method to set the value of field status
     *
     * @param string $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

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
     * Returns the value of field login
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Returns the value of field senha
     *
     * @return string
     */
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     * Returns the value of field data_nascimento
     *
     * @return string
     */
    public function getDataNascimento()
    {
        return $this->data_nascimento;
    }

    /**
     * Returns the value of field data_admissao
     *
     * @return string
     */
    public function getDataAdmissao()
    {
        return $this->data_admissao;
    }

    /**
     * Returns the value of field status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
        $this->hasMany('id', 'wsGerProj\Models\DepartamentosFuncionario', 'id_funcionario', array('alias' => 'DepartamentosFuncionario'));
        $this->hasMany('id', 'wsGerProj\Models\FuncionarioContatos', 'id_funcionario', array('alias' => 'FuncionarioContatos'));
        $this->hasMany('id', 'wsGerProj\Models\FuncionarioEnderecos', 'id_funcionario', array('alias' => 'FuncionarioEnderecos'));
        $this->hasMany('id', 'wsGerProj\Models\ProjetoFuncionarios', 'id_funcionario', array('alias' => 'ProjetoFuncionarios'));
        $this->hasMany('id', 'wsGerProj\Models\TarefaAtribuicao', 'id_funcionario', array('alias' => 'TarefaAtribuicao'));
        $this->hasMany('id', 'wsGerProj\Models\TarefaInteracao', 'id_funcionario', array('alias' => 'TarefaInteracao'));
        $this->hasMany('id', 'wsGerProj\Models\DepartamentosFuncionario', 'id_funcionario', NULL);
        $this->hasMany('id', 'wsGerProj\Models\FuncionarioContatos', 'id_funcionario', NULL);
        $this->hasMany('id', 'wsGerProj\Models\FuncionarioEnderecos', 'id_funcionario', NULL);
        $this->hasMany('id', 'wsGerProj\Models\ProjetoFuncionarios', 'id_funcionario', NULL);
        $this->hasMany('id', 'wsGerProj\Models\TarefaAtribuicao', 'id_funcionario', NULL);
        $this->hasMany('id', 'wsGerProj\Models\TarefaInteracao', 'id_funcionario', NULL);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'funcionario';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Funcionario[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Funcionario
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
