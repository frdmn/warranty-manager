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

// Construct new error exceptions
class ResourceNotFoundException extends Exception {}
class ConfigurationException extends Exception {}

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

function routeGetOverview() {
  // Create array with available routes
  $routes = array(
    'GET /' => 'This API overview, right here',
    'GET /certificates' => 'Get all available certificates',
    'GET /certificates/[id]' => 'Get certificate with ID \'[ID]\''
  );

  $data = array(
    'routes' => $routes
  );

  echo json_encode($data);
}

function routeGetCertificates() {
    $sql = "SELECT * FROM certificates";
    try {
        $dbCon = getDatabaseConnection();
        $stmt   = $dbCon->query($sql);
        $users  = $stmt->fetchAll(PDO::FETCH_OBJ);
        $dbCon = null;
        echo '{"users": ' . json_encode($users) . '}';
    }
    catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function routeGetCertificate($id) {
    $sql = "SELECT * FROM certificates WHERE id=:id";
    try {
        $dbCon = getDatabaseConnection();
        $stmt = $dbCon->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $user = $stmt->fetchObject();
        $dbCon = null;
        echo json_encode($user);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

/* Logic */

// Initalize Slim instance
$app = new \Slim\Slim();
$app->get('/', 'routeGetOverview');
$app->get('/certificates', 'routeGetCertificates');
$app->get('/certificates/:id', 'routeGetCertificate');
$app->run();
