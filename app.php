<?php

ini_set('display_errors', true);
error_reporting(E_ALL);

/**
 * Local variables
 * @var \Phalcon\Mvc\Micro $app
 */
use Phalcon\Http\Response;
use wsGerProj\Http\StatusCodes;

define('WS_HOST', 'http://localhost.wsGerProj');
define('UPLOAD_PATH', '/var/www/html/wsGerProj/public/uploads/');


function exception_error_handler($severity, $message, $file, $line) {
    if (!(error_reporting() & $severity)) {
        // This error code is not included in error_reporting
        return;
    }
    
    throw new \ErrorException($message, 500, $severity, $file, $line);
}
set_error_handler("exception_error_handler");

require_once 'http/routes/admin.php';

//$app->before(function() use ($app) {
//    
//    $token = $app->request->getHeader('auth-token');
//    if( empty($token) ){
//        throw new \Exception("É necessário estar registrado no sistema para realizar requisições.", StatusCodes::NAO_AUTORIZADO);
//        
//    } else{
//        return true;
//    }
//});

$app->error(function ($exception) {
    
    $response = new Response();
    $response->setContentType('application/json', 'UTF-8');
    $response->setStatusCode($exception->getCode());
    $response->setHeader("Access-Control-Allow-Origin", "*");
    $response->setHeader("Access-Control-Allow-Methods", "GET, POST, OPTIONS, PUT, DELETE");
    $response->setHeader("Access-Control-Allow-Headers", "DNT,X-CustomHeader,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type");
    $response->setJsonContent(['error' => $exception->getMessage()]);
    $response->send();
    return false;
});

$app->after(function () use ($app) {
    $return = $app->getReturnedValue();
    
    if( $return instanceof  Response){
        $return->send();
        
    } else{        
        $response = new Response();
        $response->setContentType('application/json', 'UTF-8');
        $response->setJsonContent($return);
        $response->send();
    }
    
});
