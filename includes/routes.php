<?php
// GET "/"
function dashboard() {
  global $app;
  $app->render('dashboard.php', array());
}
