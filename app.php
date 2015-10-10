<?php

/**
 * Local variables
 * @var \Phalcon\Mvc\Micro $app
 */
use Phalcon\Http\Response;
use wsGerProj\Http\StatusCodes;

require_once 'http/routes/admin.php';

$app->before(function() use ($app) {
    
    $token = $app->request->getHeader('auth-token');
    if( empty($token) ){
        throw new \Exception("É necessário estar registrado no sistema para realizar requisições.", StatusCodes::NAO_AUTORIZADO);
        
    } else{
        return true;
    }
});

$app->error(function ($exception) {
    $response = new Response();
    $response->setContentType('application/json', 'UTF-8');
    $response->setStatusCode($exception->getCode());
    $response->setJsonContent(['error' => $exception->getMessage()]);
    $response->send();
    return false;
});

$app->after(function () use ($app) {

    $response = new Response();
    $response->setContentType('application/json', 'UTF-8');
    $response->setJsonContent($app->getReturnedValue());
    $response->send();
});
