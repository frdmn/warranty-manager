<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="certfificate monitor">
    <meta name="author" content="Jonas Friedmann <j@frd.mn>">
    <link rel="icon" href="assets/images/favicon.ico">

    <title><?= GENERAL_TITLE ?> - <?=$this->e($title)?></title>

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
            <small><?= GENERAL_VERSION ?></small>
            <button disabled class='btn btn-primary pull-right'>Add</button>
        </h1>
      </div>

      <?=$this->section('content')?>
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
