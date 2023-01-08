<?php

  @session_start();
  header('Content-Type: application/json');

  $json = new stdClass();


  if(isset($_SESSION['SESSION_USER'])){

    require_once '../class/Conn.class.php';
    require_once '../class/Clientes.class.php';
    require_once '../class/Logs.class.php';

    $clientes = new Clientes();
    $logs     = new Logs();

    $clientes_list = $clientes->list_export($_SESSION['SESSION_USER']['id']);

    if($clientes_list){

      $logs->log($_SESSION['SESSION_USER']['id'],"Exportou os clientes");

      header('Content-disposition: attachment; filename=usuarios_gestor_lite.json');
      header('Content-type: application/json');

     echo json_encode($clientes_list);

    }else{

      $json->erro = true;
      $json->msg  = "Erro ao listar seus clientes, talvez você não tenha clientes";
      echo json_encode($json);

    }


  }else{

    $json->erro = true;
    $json->msg  = "Não autorizado";
    echo json_encode($json);

  }



?>
