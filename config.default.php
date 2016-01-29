<?php
  /*
   *  Database configuration
   */

  define('DB_HOSTNAME', 'localhost');
  define('DB_NAME', 'crt');
  define('DB_USERNAME', 'crt');
  define('DB_PASSWORD', 'crt');

  /* General and logging */

  define('GENERAL_TITLE', 'CRTmgmt');
  define('GENERAL_DEBUG', false);

  /* Don't change */
  define('GENERAL_VERSION', file_get_contents('VERSION'));
