<?php
namespace wsGerProj\Http;

/**
 * Objeto de valor a ser retornado em requições get
 *
 * @author anderson
 */
final class GetResponseVO {
    
    /**
     * Total de registros encontrados
     * 
     * @var int 
     */
    public $count;

    /**
     * URL para próxima pagina
     *
     * @var string 
     */
    public $next;

    /**
     * URL para página anterior
     *
     * @var string 
     */
    public $previous;
    
    /**
     * lista de registros encontrados
     *
     * @var array 
     */
    public $results;
    
    public function __construct() {
        $this->count = 0;
        $this->next = NULL;
        $this->previous = NULL;
        $this->results = [];
    }
    
}
