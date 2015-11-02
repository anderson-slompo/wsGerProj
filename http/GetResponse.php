<?php

namespace wsGerProj\Http;

use wsGerProj\Config\Settings,
    wsGerProj\Http\DefaultParams;

/**
 * Classe que gera o modelo para retorno de requisões GET para qualquer recurso do sistema
 *
 * @author anderson
 */
class GetResponse {

    /**
     * Objeto a ser Retornado para o controlador
     *
     * @var GetResponseVO 
     */
    private $retorno;

    /**
     * Requisição do cliente
     *
     * @var \Phalcon\Http\Request 
     */
    private $request;

    /**
     * Página consultada
     *
     * @var int 
     */
    private $currentPage;

    /**
     *
     * @var dados enviados pelo controlador 
     */
    private $data;

    /**
     * Total de registros
     *
     * @var int 
     */
    private $count;
    
    const WAY_NEXT = 1;
    const WAY_PREV = -1;

    /**
     * Função responsavel por criar objeto de retorno de pesquisas
     * 
     * @param \wsGerProj\Http\Phalcon\Http\Request $request
     * @param array $data
     */
    public static function createResponse(\Phalcon\Http\Request $request, array $data) {

        $response = new GetResponse;
        $response->retorno = new GetResponseVO;
        $response->data = $data;
        $response->count = count($data);
        $response->retorno->count = $response->count;
        $response->request = $request;
        $response->setCurrentPage()
                ->setPreviousPage()
                ->setNextPage()
                ->setResults();
        return $response->retorno;
    }

    /**
     * Pega a Página consultada na requisição
     */
    private function setCurrentPage() {
        $this->currentPage = $this->request->getQuery(DefaultParams::PAGE, NULL, 1);
        return $this;
    }

    /**
     * Verifica se existe página anterior
     * 
     * @return boolean
     */
    private function hasPreviousPage() {
        return !($this->count == 0 ||
                $this->count <= Settings::RECORDS ||
                $this->currentPage == 1);
    }

    /**
     * verifica se existe próxima página
     * 
     * @return boolean
     */
    private function hasNextPage() {
        return !($this->count == 0 ||
                $this->count <= Settings::RECORDS ||
                $this->currentPage == ceil($this->count / Settings::RECORDS));
    }

    /**
     * Preenche a url de pagina anterior da resposta
     * 
     * @return \wsGerProj\Http\GetResponse
     */
    private function setPreviousPage() {
        if ($this->hasPreviousPage()) {
            $this->retorno->previous = $this->getPageURL(self::WAY_PREV);
        } else {
            $this->retorno->previous = NULL;
        }
        return $this;
    }

    /**
     * preenche a url de próxima pagina do retorno
     * 
     * @return \wsGerProj\Http\GetResponse
     */
    private function setNextPage() {
        if ($this->hasNextPage()) {
            $this->retorno->next = $this->getPageURL(self::WAY_NEXT);
        } else {
            $this->retorno->next = NULL;
        }
        return $this;
    }

    /**
     * retorna url de proxima pagina ou anterioir dependendo do define passado de parametro self::WAY_*
     * 
     * @param int|self::WAY_* $way
     * @return string
     */
    private function getPageURL($way){
        
        $parsed = parse_url($_SERVER['REQUEST_URI']);
        if(isset($parsed['query'])){
            parse_str($parsed['query'], $params);
            unset($params['_url']);
        } else{
            $params = [];
        }
        $params[DefaultParams::PAGE] = $this->currentPage + $way;
        
        $formated = http_build_query($params);
        $uri = $this->request->getURI();
        
        return WS_HOST."{$parsed['path']}?{$formated}";
    }
    
    /**
     * Preenche os registros a serem exibidos na pagina solicitada
     * 
     * @return \wsGerProj\Http\GetResponse
     */
    private function setResults() {
        $startRow = ($this->currentPage - 1)*Settings::RECORDS;
        $this->retorno->results = array_slice($this->data, $startRow, Settings::RECORDS);
        return $this;
    }

}
