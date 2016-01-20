<?php
// Auto load composer components
require '../vendor/autoload.php';

// Require config
include('../config.php');

// Construct new error exceptions
class ResourceNotFoundException extends Exception {}

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
  // 'prefix' => 'crt_',
]);

// GET "/" route
$app->get('/', function() use ($app, $database) {
  // Create array with available routes
  $routes = array(
    'GET /' => 'This API overview, right here',
    'GET /certificates' => 'Get all available certificates',
    'GET /certificates/[id]' => 'Get certificate with ID \'[ID]\''
  );

  // Render as JSON resulta
  $app->render(200,array(
    'msg' => array('routes'=>$routes)
  ));
});

// GET "/certificates" route
$app->get('/certificates', function() use ($app, $database) {
  // Run SQL select
  $data = $database->select("certificates", "*");

  // Render result
  $app->render(200,array(
    'msg' => $data
  ));
});

// GET "/certificates/:id" route
$app->get('/certificates/:id', function($id) use ($app, $database) {
  try {
    // Run SQL select
    $data = $database->select("certificates", "*", ['id' => $id]);

    if ($data) {
      // Render result
      $app->render(200,array(
        'msg' =>  $data
      ));
    } else {
      throw new ResourceNotFoundException();
    }
  } catch (ResourceNotFoundException $e) {
    // Render result
    $app->render(404,array(
      'msg' => 'Couldn\'t find certificate with ID '.$id
    ));
  } catch (Exception $e) {
    $app->render(400,array(
      'msg' => "Unexpected exception"
    ));
  }
});

$app->run();
