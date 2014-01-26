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

      table { width: 98%; height: 100%; top: 0px; margin: 45px 5px 25px 5px; }

      .filename { min-width: 150px; }
      .datetime { min-width: 150px; }
      .ip { min-width: 125px; }
      .status { min-width: 90px; }
      .duration { min-width: 70px; }
      .referer { min-width: 60px; }
      .agent { min-width: 150px; }
    </style>
  </head>
  <body>
    <header>
      <h1>Download log</h1>
    </header>
    <table>
      <thead>
        <tr>
          <th class='filename'>File name</th>
          <th class='datetime'>Date &amp; Time</th>
          <th class='ip'>IP</th>
          <th class='status'>Status</th>
          <th class='duration'>Duration</th>
          <th class='referer'>Referer</th>
          <th class='agent'>User agent</th>
        </tr>
      </thead>
      <tbody>
<?php
  foreach ($mysqli->query('SELECT * FROM `'.$config['table'].'`') as $field) {
    echo "<tr>";
    echo "<td class='filename'>".$field['filename']."</td>";
    echo "<td class='datetime'>".$field['datetime']."</td>";
    echo "<td class='ip'>".$field['ip']."</td>";
    echo "<td class='status'>".$field['status']."</td>";
    echo "<td class='duration'>".$field['duration']."</td>";
    echo "<td class='referer'>".$field['referer']."</td>";
    echo "<td class='agent'>".$field['agent']."</td>";
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