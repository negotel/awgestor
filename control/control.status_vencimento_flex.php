<?php

  @session_start();

  $json = new stdClass();
require_once "../config/settings.php";
  if(isset($_SESSION['SESSION_USER'])){

    if(isset($_POST['status'])){


      $status = $_POST['status'];

      if($status != ""){

        require_once '../class/Conn.class.php';
        require_once '../class/User.class.php';
        require_once '../class/Logs.class.php';

        $user = new User();
        $log  = new Logs();

        $dados->id = $_SESSION['SESSION_USER']['id'];
        $dados->vencimento_flex = $status == 0 ? 1 : 0;

        $update = $user->update_vencimento_flex($dados);

        if($update){

          $json->erro = false;
          echo json_encode($json);

        }else{

          $json->erro = true;
          echo json_encode($json);


        }


      }else{
        $json->erro = true;
        echo json_encode($json);
      }


    }else{
      $json->erro = false;
      $json->msg  = "Request is required";
      echo json_encode($json);
    }


  }else{
    $json->erro = false;
    $json->msg  = "403";
    echo json_encode($json);
  }



?>
