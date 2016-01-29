<?php

// Include config file
include('config.php');

// Auto load composer components
require 'vendor/autoload.php';

// Include config file
include('includes/api.php');
include('includes/routes.php');

// Check if DEBUG is enabled
if (defined('GENERAL_DEBUG')) {
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
} else {
  error_reporting(E_ALL & ~E_NOTICE);
  ini_set('display_errors', 0);
}

// Middleware class to inject Content-Type headers
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

/* General functions */

// Create new Plates instance and map template folders
$templates = new League\Plates\Engine('templates');
$templates->addFolder('partials', 'templates/partials');

// Initalize Slim instance
$app = new \Slim\Slim();
$app->add(new \APIheaderMiddleware());

// Set routes
$app->get('/', 'dashboard');
$app->get('/api', 'routeGetOverview');
$app->get('/api/certificates', 'routeGetCertificates');
$app->get('/api/certificates/:id', 'routeGetCertificate');

$app->run();
