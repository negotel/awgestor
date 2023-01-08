<?php

  @session_start();

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
