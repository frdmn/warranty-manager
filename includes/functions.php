<?php
function getVersion(){
  $version = file_get_contents(__dir__.'/../VERSION');
  return $version;
}
