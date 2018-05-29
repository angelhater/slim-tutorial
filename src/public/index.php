<?php
/**
 * Created by PhpStorm.
 * User: zgy
 * Date: 2018/5/29
 * Time: 11:29
 */
use \Psr\Http\Message\RequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = true;

$app = new \Slim\App(['setting' => $config]);

$container = $app->getContainer();
$container['logger'] = function ($c) {
    $logger = new \Monolog\Logger('my_logger');
    $file_handler = new \Monolog\Handler\StreamHandler('../logs/app.log');
    $logger->pushHandler($file_handler);
    return $logger;
};

$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("hello, $name");
    $this->logger->addInfo('something interesting happend');
    return $response;
});
$app->run();