<?php

// Require config file
include('../config.php');

// Auto load composer components
require '../vendor/autoload.php';

// Check if DEBUG is enabled
if (defined('DEBUG')) {
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
} else {
  error_reporting(E_ALL & ~E_NOTICE);
  ini_set('display_errors', 0);
}

// Middleware to inject Content-Type headers
class APIheaderMiddleware extends \Slim\Middleware {
  public function call() {
    $app = $this->app;
    // Get request path and media type
    $reqMediaType = $app->request->getMediaType();
    $reqIsAPI = (bool) preg_match('|^/api/.*$|', $app->request->getPath());
  // Run inner middleware and application
        $this->next->call();
    if ($reqMediaType === 'application/json' || $reqIsAPI) {
      $app->response->headers->set('Content-Type', 'application/json');
      $app->response->headers->set('Access-Control-Allow-Methods', '*');
      $app->response->headers->set('Access-Control-Allow-Origin', '*');
    } else {
      $app->response->headers->set('Content-Type', 'text/html');
    }
  }
}

// Standard exception data
$jsonObject = array(
  'status' => 'success'
);

/* General functions */

function getDatabaseConnection() {
  try {
    $db_username = constant('DB_USERNAME');
    $db_password = constant('DB_PASSWORD');
    $conn = new PDO('mysql:host='.constant('DB_HOSTNAME').';dbname='.constant('DB_NAME').'', $db_username, $db_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
  }
  return $conn;
}

/* Routes */

// GET "/"
function routeGetOverview() {
  global $jsonObject;

  // Create array with available routes
  $routes = array(
    'GET /' => 'This API overview, right here',
    'GET /certificates' => 'Get all available certificates',
    'GET /certificates/[id]' => 'Get certificate with ID \'[ID]\''
    );

  $jsonObject['data'] = $routes;

  echo json_encode($jsonObject);
}

// GET "/certificates"
function routeGetCertificates() {
  global $jsonObject;

  // Construct SQL query
  $sql = "SELECT * FROM certificates";
  try {
    $dbCon = getDatabaseConnection();
    $stmt = $dbCon->query($sql);
    $users = $stmt->fetchAll(PDO::FETCH_OBJ);
    $dbCon = null;
    $jsonObject['data'] = $users;
    echo json_encode($jsonObject);
  }
  catch(PDOException $e) {
    $jsonObject['status'] = 'error';
    $jsonObject['message'] = $e->getMessage();
    echo json_encode($jsonObject);
  }
}

// GET "/certificates/[id]"
function routeGetCertificate($id) {
  global $jsonObject;

  // Construct SQL query
  $sql = "SELECT * FROM certificates WHERE id=:id";
  try {
    $dbCon = getDatabaseConnection();
    $stmt = $dbCon->prepare($sql);
    $stmt->bindParam("id", $id);
    $stmt->execute();
    $user = $stmt->fetchObject();
    $dbCon = null;
    if ($user) {
      $jsonObject['data'] = $user;
    } else {
      $jsonObject['status'] = 'error';
      $jsonObject['message'] = 'Couldn\'t find certificate with id '.$id;
    }
    echo json_encode($jsonObject);
  } catch(PDOException $e) {
    $jsonObject['status'] = 'error';
    $jsonObject['message'] = $e->getMessage();
    echo json_encode($jsonObject);
  }
}

/* Logic */

// Initalize Slim instance
$app = new \Slim\Slim();
$app->add(new \APIheaderMiddleware());

$app->get('/', 'routeGetOverview');
$app->get('/certificates', 'routeGetCertificates');
$app->get('/certificates/:id', 'routeGetCertificate');

$app->run();
