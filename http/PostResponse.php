<?php
namespace wsGerProj\Http;

/**
 * Classe responsavel pelas respostas a requisições de inserção
 *
 * @author anderson
 */
class PostResponse {
    
    const STATUS_OK = true;
    const STATUS_FAIL = false;

    public static function createResponse($status, $message){
        $result = new PostResponseVO;
        $result->sucess = $status;
        $result->message = $message;
        return $result;
    }

}
