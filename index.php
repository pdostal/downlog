<?php
  require_once('config.php');
  $file = 'index/'.trim(htmlspecialchars(htmlspecialchars_decode($_GET['file'], ENT_NOQUOTES), ENT_NOQUOTES));
  require_once('getfile.php');
  exit;
?>