<?php
// Inlcude functions
include_once('includes/functions.php');

// GET "/"
function dashboard() {
  global $app;
  $app->render('dashboard.php', array());
}
