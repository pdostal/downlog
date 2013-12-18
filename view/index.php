<?php
  $startmicrotime = MicroTime(1);
  require_once('config.php');
  if ( !empty($config['server']) && !empty($config['username']) && !empty($config['password']) && !empty($config['database']) ) {
	$mysqli = new mysqli($config['server'], $config['username'], $config['password'], $config['database']);
  }
?>
<!doctype html>
<html lang="cs">
  <head>
    <meta charset="utf-8">
    <title>View</title>
    <meta name="description" content="View download log" />
    <meta name="author" content="Pavel Dostál" />
    <!--[if lt IE 9]>
      <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>
  <body>
    <h1>Download log</h1>
    <footer>
      <span><?php printf( "%01.2f sec", (MicroTime(1)-$startmicrotime) ); ?></span> |
      <span>&copy; <a itemprop="url" href="mailto:pdostal@pdostal.cz/">Pavel Dostál</a></span>
    </footer>
  </body>
</html>