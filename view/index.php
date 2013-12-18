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
    <meta name="robots" content="noindex, nofollow" />
    <!--[if lt IE 9]>
      <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <style>
      h1 { margin: 0px 0px; }

      header,footer { position: fixed; left: 0px; width: 98%; margin: 0px 1%; text-align: center; background-color: #fff; }

      header { height: 40px; top: 0px; padding-top: 5px; }
      footer { height: 20px; bottom: 0px; padding-bottom: 5px; }

      table { width: 98%; height: 100%; top: 0px; margin: 45px 1% 25px 1%; }
    </style>
  </head>
  <body>
    <header>
      <h1>Download log</h1>
    </header>
    <table>
      <thead>
        <tr>
          <th>File name</th>
          <th>Date &amp; Time</th>
          <th>IP</th>
          <th>Status</th>
          <th>IP Address</th>
          <th>Duration</th>
          <th>User agent</th>
        </tr>
      </thead>
      <tbody>
<?php
  for ($i = 0; $i<1000; $i++) {
    echo "<tr>";
    echo "<td>".rand()."</td>";
    echo "<td>".rand()."</td>";
    echo "<td>".rand()."</td>";
    echo "<td>".rand()."</td>";
    echo "<td>".rand()."</td>";
    echo "<td>".rand()."</td>";
    echo "<td>".rand()."</td>";
    echo "</tr>";
  }
?>
      </tbody>
    </table>
    <footer>
      <span><?php printf( "%01.2f sec", (MicroTime(1)-$startmicrotime) ); ?></span> |
      <span>&copy; <a itemprop="url" href="mailto:pdostal@pdostal.cz/">Pavel Dostál</a></span>
    </footer>
  </body>
</html>