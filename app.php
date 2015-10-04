<?php

/**
 * Local variables
 * @var \Phalcon\Mvc\Micro $app
 */
use Phalcon\Http\Response;
use wsGerProj\Http\StatusCodes;

require_once 'http/routes/admin.php';

$app->error(function ($exception) {
    $response = new Response();
    $response->setContentType('application/json', 'UTF-8');
    $response->setStatusCode(StatusCodes::ERRO_CLI);
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
