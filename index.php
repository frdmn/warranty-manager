<?php

// Include config file
include('config.php');

// Set version
define('GENERAL_VERSION', file_get_contents('VERSION'));

// Auto load composer components
require 'vendor/autoload.php';

// Include config file
include('includes/routes.php');

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
$app = new \Slim\Slim(array(
    'debug' => (defined('GENERAL_DEBUG') && GENERAL_DEBUG === true) ? true : false
));

$app->add(new \APIheaderMiddleware());

// Set routes
$app->get('/', 'dashboard');
$app->get('/api', 'routeGetOverview');
$app->get('/api/warranties', 'routeGetWarranties');
$app->get('/api/warranties/:id', 'routeGetWarranty');

// Run application
$app->run();
