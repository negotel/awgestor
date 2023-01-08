<?php

  @session_start();

  require_once '../class/Logs.class.php';
  $logs = new Logs();

  $logs->log($_SESSION['SESSION_USER']['id'],'Deslogou da conta');


  @session_destroy();

  header("LOCATION: ../login");



?>
