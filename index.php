<?php
    // Auto load composer components
    require 'vendor/autoload.php';

    require_once('includes/functions.php');

    // Require config
    include('config.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="certfificate monitor">
    <meta name="author" content="Jonas Friedmann <j@frd.mn>">
    <link rel="icon" href="assets/images/favicon.ico">

    <title><?= GENERAL_TITLE ?> - Overview</title>

    <!-- Core CSS -->
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <!-- Begin page content -->
    <div class="container">
      <div class="page-header">
        <h1>
            <?= GENERAL_TITLE ?>
            <small><?= getVersion(); ?></small>
            <button class='btn btn-primary pull-right'>Add</button>
        </h1>
      </div>

      <div class="row">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th></th>
                    <th>Hostname</th>
                    <th>Expiration</th>
                    <th>Customer</th>
                    <th>Usage</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="6"><center>loading</center></td>
                </tr>
                <!-- <tr>
                    <th scope="row">2</th>
                    <td>tls.startup.ru</td>
                    <td>about 1 year</td>
                    <td>Customer A (#300123)</td>
                    <td>Postfix</td>
                    <td><button type="button" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></button> <button type="button" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-minus"></span></button></td>
                </tr> -->
            </tbody>
        </table>
      </div>
    </div>

    <footer class="footer">
      <div class="container">
        <p class="text-muted pull-left">Made by <strong><a href="https://frd.mn" target="_blank" href="#">frdmn</a></strong> under <a href="LICENSE">MIT</a> license.</p>
        <p class="text-muted pull-right"></p>
      </div>
    </footer>

    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/build.js"></script>
  </body>
</html>
