<?php

  @session_start();
require_once "../config/settings.php";
  if(isset($_POST['request'])){

    if(isset($_SESSION['DARK'])){
      unset($_SESSION['DARK']);
      echo 'desativa';
    }else{
      $_SESSION['DARK'] = true;
      echo 'ativa';
    }

  }


?>
