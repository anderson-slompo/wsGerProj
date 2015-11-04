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

    /**
     * Cria objeto de retorno para requisição bem sucedida de inserção ou atualização
     * 
     * @param int $status
     * @param string $message
     * @return \wsGerProj\Http\PostResponseVO
     */
    public static function createResponse($status, $message){
        $result = new PostResponseVO;
        $result->sucess = $status;
        $result->message = $message;
        return $result;
    }
    
    /**
     * Recebe um model e une as excessões para retornar em texto
     * 
     * @param \Phalcon\Mvc\Model $model
     * @return string
     */
    public static function createModelErrorMessages(\Phalcon\Mvc\Model $model) {
        $excepts = [];
        foreach ($model->getMessages() as $message) {
            $excepts[] = $message;
        }
        return implode("\n", $excepts);
    }

}
