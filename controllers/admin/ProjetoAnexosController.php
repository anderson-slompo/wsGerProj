<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace wsGerProj\Controllers\Admin;

use wsGerProj\Controllers\RestController,
    wsGerProj\Controllers\ControllerBase,
    wsGerProj\Http\PostResponse,
    wsGerProj\Http\StatusCodes,
    wsGerProj\Models\Projeto,
    wsGerProj\Models\ProjetoAnexos,
    wsGerProj\Models\Anexo;

/**
 * Description of ProjetoAnexosController
 *
 * @author anderson
 */
class ProjetoAnexosController extends ControllerBase implements RestController {

    public function create() {

        $descricoes = $this->request->getPost('descricao');
        $nomes = $this->request->getPost('nomes');
        $id_projeto = $this->request->getPost('projeto_id');
        
        $anexo_ids = [];
        
        foreach ($this->request->getUploadedFiles() as $i => $file) {

            $anexo = new Anexo();
            $anexo->setDescricao($descricoes[$i]);
            $anexo->setNome($nomes[$i]);
            $anexo->setOriginal($file->getName());
            $anexo->setCaminho(UPLOAD_PATH);
            
            if(!$anexo->validation() || !$anexo->save()){                
                throw new \Exception(PostResponse::createModelErrorMessages($anexo), StatusCodes::ERRO_CLI);
            }
            $novoNome = UPLOAD_PATH."anexo_".$anexo->getId().".".$file->getExtension();
            
            $anexo->setCaminho($novoNome);
            $anexo->save();
            
            $projeto_anexo = new ProjetoAnexos();
            $projeto_anexo->setIdAnexo($anexo->getId());
            $projeto_anexo->setIdProjeto($id_projeto);
            
            if(!$projeto_anexo->save()){
                throw new \Exception(PostResponse::createModelErrorMessages($projeto_anexo), StatusCodes::ERRO_CLI);
            }
            
            $anexo_ids[] = $anexo->getId();

            $file->moveTo($novoNome);
        }
        return PostResponse::createResponse(true, count($anexo_ids). " anexos adicionados com sucesso");
    }

    public function delete($id = null) {
        $dataPost = $this->request->getJsonRawBody();
        
        foreach ($dataPost->anexos_id as $anexo_id){
            $anexo = Anexo::findFirst($anexo_id);
            
            unlink($anexo->getCaminho());
            $anexo->getProjetoAnexos()->delete();
            $anexo->delete();
        }
        
        return PostResponse::createResponse(true, "Anexos removidos com sucesso");
    }

    public function index() {
        throw new \Exception('Não implementado', StatusCodes::NAO_ENCONTRADO);
    }

    public function show($id) {
        $projeto = Projeto::findFirst($id);

        if ($projeto) {

            $ret['anexos'] = $projeto->getAnexos()->toArray();

            return $ret;
        } else {
            throw new \Exception("Projeto #{$id} não encontrado", StatusCodes::NAO_ENCONTRADO);
        }
    }

    public function update($id) {
        throw new \Exception('Não implementado', StatusCodes::NAO_ENCONTRADO);
    }

}
