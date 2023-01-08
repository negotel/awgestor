<?php


  @session_start();

  if(isset($_SESSION['SESSION_USER'])){

    $json = new stdClass();

    if(isset($_POST['slug'])){

      $slug = trim($_POST['slug']);

      require_once '../class/Conn.class.php';
      require_once '../class/Clientes.class.php';

      $clientes = new Clientes();

      $verific = $clientes->area_cli_dados($slug);
      if($verific == false){
        $json->erro = false;
        echo json_encode($json);
      }else{
        $json->erro = true;
        echo json_encode($json);
      }

    }


  }


?>
