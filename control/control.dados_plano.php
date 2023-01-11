<?php

  @session_start();
require_once "../config/settings.php";
  if(isset($_SESSION['SESSION_USER'])){

    if(isset($_POST['id_plano'])){


      require_once '../class/Conn.class.php';
      require_once '../class/Planos.class.php';

      $planos = new Planos();

      $dados = $planos->plano($_POST['id_plano']);
      if($dados){
          echo json_encode($dados);
      }else{
        echo '{"erro":true,"msg":"Plano inexistente"}';
      }
    }else{
      echo '{"erro":true,"msg":"Request is required"}';
    }

  }else{
    echo '{"erro":true,"msg":"403"}';
  }



?>
