<?php

namespace wsGerProj\Controllers\Admin;

use wsGerProj\Controllers\ControllerBase,
    wsGerProj\Models\Funcionario,
    wsGerProj\Http\StatusCodes,
    wsGerProj\Config\Settings,
    wsGerProj\Http\PostResponse,
    wsGerProj\Models\Departamento;

/**
 * Description of AuthController
 *
 * @author anderson
 */
class AuthController extends ControllerBase {

    public function login() {
        $dataPost = $this->request->getJsonRawBody();
        $usuario = $dataPost->login;
        $senha = md5($dataPost->senha);
        
        $query = Funcionario::query()
                ->where('login = :login:')
                ->andWhere('senha = :senha:')
                ->bind([
                    'login' => $usuario,
                    'senha' => $senha
                ])
                ->execute();
        
        if ($query->count() == 1) {
            $result = $query[0];
            $token = base64_encode(uniqid("user_id={$result->getId()}", true));

            $user = $result->getUserDefinition();

            $m = $this->getDI()->get('memcached');
            $memCacheResult = $m->set($token, $user, time() + Settings::LOGIN_EXPIRATION);

            if(!$memCacheResult){
                throw new \Exception("Erro ao armazenar token: ".\Memcached::getResultCode(), StatusCodes::ERRO_SERVIDOR);
            }

            return [
                'success' => true,
                'token' => $token,
                'usuario' => $user   
            ];
        } else {
            throw new \Exception("Usuário e/ou senha incorretos", StatusCodes::NAO_AUTORIZADO);
        }
    }

    public function checkToken($token) {
        $m = $this->getDI()->get('memcached');
        $data = $m->get($token);

        if ($m->getResultCode() == \Memcached::RES_NOTFOUND) {
            throw new \Exception('Login expirado', StatusCodes::NAO_AUTORIZADO);
        } else {
            $m->set($token, $data, time() + Settings::LOGIN_EXPIRATION);
            return PostResponse::createResponse(true, "Login ativo");
        }
    }

}
