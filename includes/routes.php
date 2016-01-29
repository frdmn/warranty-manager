<?php
// GET "/"
function dashboard() {
  global $templates;
  echo $templates->render('partials::dashboard');
}
