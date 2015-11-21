<?php

namespace wsGerProj\Controllers;

use wsGerProj\Models\Anexo,
    Phalcon\Http\Response,
    wsGerProj\Http\StatusCodes;

/**
 * Description of DownloadController
 *
 * @author anderson
 */
class DownloadController extends ControllerBase {

    public function download($id) {
        $anexo = Anexo::findFirst($id);
        $response = new Response();
        if ($anexo) {
            $response->setStatusCode(StatusCodes::OK);
            $response->setFileToSend($anexo->getCaminho(),$anexo->getOriginal());
            
        } else {
            $response->setStatusCode(StatusCodes::NAO_ENCONTRADO);
        }
        return $response;
    }

}
