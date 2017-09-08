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

            $m = $this->getDI()->get('memcached');
            $memCacheResult = $m->set($token, ['login' => $result->getLogin(), 'nome'=>$result->getNome()], time() + Settings::LOGIN_EXPIRATION);

            if(!$memCacheResult){
                throw new \Exception("Erro ao armazenar token: ".\Memcached::getResultCode(), StatusCodes::ERRO_SERVIDOR);
            }

            $isGerente = false;
            $isDesenvolvedor = false;
            $isTester = false;
            $isImplantador = false;
            $departamentos = $result->getDepartamentos()->toArray();
            foreach($departamentos as $dep){
                $isGerente = ($dep['id'] == Departamento::GERENCIA && !$isGerente) ? true : $isGerente;
                $isDesenvolvedor = ($dep['id'] == Departamento::DESENVOLVIMENTO && !$isDesenvolvedor) ? true : $isDesenvolvedor;
                $isTester = ($dep['id'] == Departamento::TESTE && !$isTester) ? true : $isTester;
                $isImplantador = ($dep['id'] == Departamento::IMPLANTACAO && !$isImplantador) ? true : $isImplantador;
            }
            
            return [
                'success' => true,
                'token' => $token,
                'usuario' => [
                    'login' => $result->getLogin(),
                    'nome' => $result->getNome(),
                    'isGerente' => $isGerente,
                    'isDesenvolvedor' => $isDesenvolvedor,
                    'isTester' => $isTester,
                    'isImplantador' => $isImplantador
                ]                
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
