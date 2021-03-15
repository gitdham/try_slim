<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require '../core/Database.php';

$app = new \Slim\App;
$app->get('/hello/{name}', function (Request $req, Response $res) {
  $name = $req->getAttribute('name');
  $res->getBody()->write('Hello ' . $name);

  return $res;
});

// customer routes
require './routes/customers.php';
$app->run();
