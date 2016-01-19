<?php
// Auto load composer components
require '../vendor/autoload.php';

// Require config
include('../config.php');

// Initalize Slim instance
$app = new \Slim\Slim();
$app->view(new \JsonApiView());
$app->add(new \JsonApiMiddleware());

// Check for necessarry credential/configuration constants
if (!defined('DB_HOSTNAME') || !defined('DB_NAME') | !defined('DB_USERNAME') | !defined('DB_PASSWORD')) {
  die('{"msg":"Invalid database connection","error":true,"status":500}');
}

// Initalize database connection
$database = new medoo([
  'database_type' => 'mysql',
  'database_name' => constant('DB_NAME'),
  'server' => constant('DB_HOSTNAME'),
  'username' => constant('DB_USERNAME'),
  'password' => constant('DB_PASSWORD'),
  'charset' => 'utf8',
  'prefix' => 'crt_',
]);

// GET "/" route
$app->get('/', function() use ($app) {
  $app->render(200,array(
    'msg' => 'Welcome to my json API!',
  ));
});

$app->run();
