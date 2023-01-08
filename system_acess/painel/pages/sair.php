<?php

  @session_start();

  require_once '../class/Logs.class.php';
  $logs = new Logs();

  $logs->log($_SESSION['SESSION_USER']['id'],'Deslogou da conta');


    unset($_SESSION['SESSION_USER']);
    unset($_SESSION['AUTH_TWO_FACTOR']);
    unset($_SESSION['SESSION_CVD']);
    

  header("LOCATION: ../login");



?>
