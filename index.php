<?php
  $startmicrotime = MicroTime(1);
  require_once('config.php');
  if ( !empty($config['server']) && !empty($config['username']) && !empty($config['password']) && !empty($config['database']) ) {
	$mysqli = new mysqli($config['server'], $config['username'], $config['password'], $config['database']);
  }
  $file = 'files/'.trim(htmlspecialchars(htmlspecialchars_decode($_GET['file'], ENT_NOQUOTES), ENT_NOQUOTES));
  $filesql = preg_replace('/files\//', '', $mysqli->real_escape_string($file));
  $contenttype = 'application/octet-stream';

  if (!file_exists($file)) {
    $server_root = '/'.preg_replace('/\//', '\/', $_SERVER['DOCUMENT_ROOT']).'\//';
    if (preg_match($server_root, realpath($file))) {
      // Log
    }
    unset($server_root);
    header("HTTP/1.1 404 Not Found");
    exit;
  }

  if (isset($_SERVER['HTTP_RANGE'])) {
    $range = $_SERVER['HTTP_RANGE'];
  } else if ($apache = apache_request_headers()) {
    $headers = array();
    foreach ($apache as $header => $val) {
      $headers[strtolower($header)] = $val;
    }
    if (isset($headers['range'])) {
      $range = $headers['range'];
    } else {
      $range = FALSE;
    }
  } else {
    $range = FALSE;
  }

  $filesize = filesize($file);
  if ($range) {
    $partial = true;
    list($param,$range) = explode('=',$range);
    if (strtolower(trim($param)) != 'bytes') {
      header("HTTP/1.1 400 Invalid Request");
      exit;
    }
    $range = explode(',',$range);
    $range = explode('-',$range[0]);
    if (count($range) != 2) {
      header("HTTP/1.1 400 Invalid Request");
      exit;
    }
    if ($range[0] === '') {
      $end = $filesize - 1;
      $start = $end - intval($range[0]);
    } else if ($range[1] === '') {
      $start = intval($range[0]);
      $end = $filesize - 1;
    } else {
      $start = intval($range[0]);
      $end = intval($range[1]);
    }
    if ($end >= $filesize || (!$start && (!$end || $end == ($filesize - 1)))) {
      $partial = false;
    }      
    $length = $end - $start + 1;
  } else {
    $partial = false;
  }

  header("Content-Type: $contenttype");
  header("Content-Length: $filesize");
  header('Content-Disposition: attachment; filename="'.basename($file).'"');
  header('Accept-Ranges: bytes');

  //
  if ($partial) {
    header('HTTP/1.1 206 Partial Content'); 
    header("Content-Range: bytes $start-$end/$filesize"); 
    if (!$fp = fopen($file, 'r')) {
      header("HTTP/1.1 500 Internal Server Error");
      exit;
    }
    if ($start) {
      fseek($fp,$start);
    }
    while ($length) {
      $read = ($length > 8192) ? 8192 : $length;
      $length -= $read;
      print(fread($fp,$read));
    }
    fclose($fp);
  } else {
    readfile($file);
  }
  if (!$mysqli->query("INSERT INTO `".$config['database']."`.`".$config['table']."` (`filename`, `ip`, `referer`, `agent`, `duration`, `status`) VALUES ('".$filesql."', '".$_SERVER['REMOTE_ADDR']."', '".$_SERVER['HTTP_REFERER']."', '".$_SERVER['HTTP_USER_AGENT']."', '".sprintf ("%01.2f sec", (MicroTime(1)-$startmicrotime))."', 'downloaded');")) {
    printf("%s\n", $mysqli->error);
  }
  exit;
?>
