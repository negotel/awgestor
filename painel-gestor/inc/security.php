<?php

  // vcerificar acesso
  if(isset($_SESSION['SESSION_USER'])){

    $idU = $_SESSION['SESSION_USER']['id'];
    $tk  = $_SESSION['SESSION_USER']['token_access'];

    $access = $user_class_process->verific_access($tk,$idU);

    if(!isset($_SESSION['SESSION_CVD'])){
        if($access == false){
          @session_destroy();
          header('LOCATION: ../login');
          exit;
        }
    }

  }else{
    @session_destroy();
    header('LOCATION: ../login');
    exit;
  }







?>
