<?php

/*
 * General
 */

// Standard exception data
$jsonObject = array(
  'status' => 'success'
);

/* Functions */

/**
 * Establish MySQL database for further/later use
 * @return {PDO} connection instance
 */
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

// Dashboard

/**
 * Route - "GET /"
 * @return void
 */
function dashboard() {
  global $templates;
  echo $templates->render('partials::dashboard');
}

// API

/**
 * Route - "GET /api/" - to display an API route overview
 * @return void
 */
function routeGetOverview() {
  global $jsonObject;

  // Create array with available routes
  $routes = array(
    'GET /' => 'This API overview, right here',
    'GET /warranties' => 'Get all available warranties',
    'GET /warranties/[id]' => 'Get certificate with ID \'[ID]\''
    );

  $jsonObject['data'] = $routes;

  echo json_encode($jsonObject);
}

/**
 * Route - "GET /api/warranties" - to show all available warranties
 * @return void
 */
function routeGetWarranties() {
  global $jsonObject, $app;

  // Parse inputs
  $inputPage = $app->request->get('page') ? $app->request->get('page') : 1;
  $realPage = $inputPage - 1;
  $inputMaxresults = $app->request->get('results') ? $app->request->get('results') : 15;

  // Construct SQL query
  $sql = "SELECT * FROM warranties ORDER BY id ASC LIMIT ".$realPage * $inputMaxresults." , ".$inputMaxresults;

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
      $jsonObject['message'] = 'Couldn\'t find any warranties';
    }
    echo json_encode($jsonObject);
  } catch(PDOException $e) {
    $app->response->setStatus(500);
    $jsonObject['status'] = 'error';
    $jsonObject['message'] = $e->getMessage();
    echo json_encode($jsonObject);
  }
}

/**
 * Route - "GET /api/warranties/:id" - to show a specific warranty
 * @return void
 */
function routeGetWarranty($id) {
  global $jsonObject, $app;

  // Construct SQL query
  $sql = "SELECT * FROM warranties WHERE id=:id";
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
