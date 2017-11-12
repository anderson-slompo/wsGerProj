<?php

namespace wsGerProj\Models;

use wsGerProj\Models\ImplantacaoTarefas;
use wsGerProj\Models\Tarefa;


class Implantacao extends \Phalcon\Mvc\Model
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
    protected $data_hora;

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
    protected $status;

    const STATUS_EM_ANDAMENTO = 0;
    const STATUS_FINALIZADA = 1;
    const STATUS_CANCELADA = 2;

    public static $status_desc = array(
        self::STATUS_EM_ANDAMENTO => 'Em andamento',
        self::STATUS_FINALIZADA => 'Finalizada',
        self::STATUS_CANCELADA => 'Cancelada',
    );

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
     * Method to set the value of field data_hora
     *
     * @param string $data_hora
     * @return $this
     */
    public function setDataHora($data_hora)
    {
        $this->data_hora = $data_hora;

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
     * Method to set the value of field status
     *
     * @param integer $status
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
     * Returns the value of field data_hora
     *
     * @return string
     */
    public function getDataHora()
    {
        return $this->data_hora;
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
     * Returns the value of field status
     *
     * @return integer
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
        $this->hasMany('id', 'wsGerProj\Models\ImplantacaoTarefas', 'id_implantacao', array('alias' => 'ImplantacaoTarefas'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'implantacao';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Implantacao[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Implantacao
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function getTarefas(){
        $fields = [
            'wsGerProj\Models\Tarefa.id',
            'wsGerProj\Models\Tarefa.nome',
            'wsGerProj\Models\Tarefa.descricao',
            'p.nome as projeto_nome'
        ];
        $query = Tarefa::query()
                ->columns($fields)
                ->innerJoin('wsGerProj\Models\ImplantacaoTarefas', "it.id_tarefa = wsGerProj\Models\Tarefa.id", 'it')
                ->innerJoin(' wsGerProj\Models\Projeto', 'p.id = id_projeto', 'p')
                ->where('id_implantacao = :id_implantacao:')
                ->bind(['id_implantacao'=>$this->getId()]);
        return $query->execute();
    }
}
