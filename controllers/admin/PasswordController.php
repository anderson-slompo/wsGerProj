<?php

namespace wsGerProj\Controllers\Admin;

use wsGerProj\Controllers\ControllerBase,
    wsGerProj\Http\PostResponse,
    wsGerProj\Http\DefaultParams,
    wsGerProj\Http\StatusCodes,
    wsGerProj\Models\Funcionario;

class PasswordController extends ControllerBase{

    public function change(){
        $user = $this->getDI()->get('currentUser');
        $dataPost = $this->request->getJsonRawBody();

        $query = Funcionario::query()
                ->where('login = :login:')
                ->andWhere('senha = :senha:')
                ->bind([
                    'login' => $user->login,
                    'senha' => md5($dataPost->current_password)
                ])
                ->execute();
        if ($query->count() == 1) {
            if($dataPost->new_password != $dataPost->confirmation_password){
                throw new \Exception("A nova senha e a confirmação não conferem.", StatusCodes::ERRO_CLI);
            }
            $result = $query[0];
            $result->senha = md5($dataPost->new_password);
            if(!$result->save()){
                throw new \Exception("Erro inesperado", StatusCodes::ERRO_SERVIDOR);
            }
            return PostResponse::createResponse(PostResponse::STATUS_OK, "Senha alterada com sucesso. Favor realizar o login novamente.");
        } else{
            throw new \Exception("Senha atual informada inválida.", StatusCodes::ERRO_CLI);
        }
    }
    
}