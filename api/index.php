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
    // Run inner middleware and application
    $this->next->call();
    $reqMediaType = $app->request->getMediaType();
    $reqIsAPI = (bool) preg_match('|^/api/.*$|', $app->request->getPath());
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
  global $jsonObject, $app;

  // Parse inputs
  $inputPage = $app->request->get('page') ? $app->request->get('page') : 1;
  $realPage = $inputPage - 1;
  $inputMaxresults = $app->request->get('results') ? $app->request->get('results') : 5;

  // Construct SQL query
  $sql = "SELECT * FROM certificates ORDER BY id ASC LIMIT ".$realPage * $inputMaxresults." , ".$inputMaxresults;

  try {
    $dbCon = getDatabaseConnection();
    $stmt = $dbCon->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
    $dbCon = null;
    if (!empty($result)) {
      $jsonObject['data']['page'] = $inputPage;
      $jsonObject['data']['hosts'] = $result;
    } else {
      $app->response->setStatus(404);
      $jsonObject['status'] = 'error';
      $jsonObject['message'] = 'Couldn\'t find any certificates';
    }
    echo json_encode($jsonObject);
  } catch(PDOException $e) {
    $app->response->setStatus(500);
    $jsonObject['status'] = 'error';
    $jsonObject['message'] = $e->getMessage();
    echo json_encode($jsonObject);
  }
}

// GET "/certificates/[id]"
function routeGetCertificate($id) {
  global $jsonObject, $app;

  // Construct SQL query
  $sql = "SELECT * FROM certificates WHERE id=:id";
  try {
    $dbCon = getDatabaseConnection();
    $stmt = $dbCon->prepare($sql);
    $stmt->bindParam("id", $id);
    $stmt->execute();
    $result = $stmt->fetchObject();
    $dbCon = null;
    if ($result) {
      $jsonObject['data'] = $result;
    } else {
      $app->response->setStatus(404);
      $jsonObject['status'] = 'error';
      $jsonObject['message'] = 'Couldn\'t find certificate with id '.$id;
    }
    echo json_encode($jsonObject);
  } catch(PDOException $e) {
    $app->response->setStatus(500);
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
