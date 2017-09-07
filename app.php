<?php

ini_set('display_errors', true);
error_reporting(E_ALL);

/**
 * Local variables
 * @var \Phalcon\Mvc\Micro $app
 */
use Phalcon\Http\Response,
    wsGerProj\Http\StatusCodes,
    wsGerProj\Middlewares\AuthMiddleware,
    Phalcon\Events\Manager as EventsManager,
    wsGerProj\Config\Settings;

define('WS_HOST', 'http://localhost.wspromind');
define('UPLOAD_PATH', '/var/www/html/wsGerProj/public/uploads/');

function exception_error_handler($severity, $message, $file, $line) {
    if (!(error_reporting() & $severity)) {
        // This error code is not included in error_reporting
        return;
    }

    throw new \ErrorException("{$message} [{$file} - {$line}]", 500, $severity, $file, $line);
}

set_error_handler("exception_error_handler");

require_once 'http/routes/admin.php';

$eventsManager = new EventsManager();
$eventsManager->attach('micro', function ($event, $app) {
    if ($event->getType() == 'beforeExecuteRoute') {
        $skippedRoutes = ['login', 'check-token'];
        $routeName = $app['router']->getMatchedRoute()->getName();
        if (!in_array($routeName, $skippedRoutes)) {
            $auth = $app->request->getDigestAuth();
            if (count($auth)) {
                $m = $app->getDI()->get('memcached');
                $data = $m->get($auth['token']);
                if ($m->getResultCode() == \Memcached::RES_NOTFOUND) {
                    throw new \Exception('É necessário estar registrado no sistema para realizar requisições.'.$auth['token'], StatusCodes::NAO_AUTORIZADO);
                } else {
                    $m->set($auth['token'], $data, time() + Settings::LOGIN_EXPIRATION); //renova 
                    return true;
                }
            } else{
                throw new \Exception('É necessário estar registrado no sistema para realizar requisições2.', StatusCodes::NAO_AUTORIZADO);
            }
        } else {
            return true;
        }
    }
});
$app->setEventsManager($eventsManager);

$app->error(function ($exception) {

    $response = new Response();
    $response->setContentType('application/json', 'UTF-8');
    $response->setStatusCode($exception->getCode());
    $response->setHeader("Access-Control-Allow-Origin", "*");
    $response->setHeader("Access-Control-Allow-Methods", "GET, POST, OPTIONS, PUT, DELETE");
    $response->setHeader("Access-Control-Allow-Headers", "Authorization,DNT,X-CustomHeader,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type");
    $response->setJsonContent(['error' => $exception->getMessage()]);
    $response->send();
    return false;
});

$app->after(function () use ($app) {
    $return = $app->getReturnedValue();

    if ($return instanceof Response) {
        $return->send();
    } else {
        $response = new Response();
        $response->setContentType('application/json', 'UTF-8');
        $response->setJsonContent($return);
        $response->send();
    }
});
