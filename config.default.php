<?php
  /*
   *  Database configuration
   */

  define('DB_HOSTNAME', 'localhost');
  define('DB_NAME', 'wrnty');
  define('DB_USERNAME', 'wrnty');
  define('DB_PASSWORD', 'wrnty');

  /* General and logging */

  define('GENERAL_TITLE', 'CRTmgmt');
  define('GENERAL_DEBUG', false);

  /* Don't change */
  define('GENERAL_VERSION', file_get_contents('VERSION'));
