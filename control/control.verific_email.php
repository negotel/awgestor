<?php

  @session_start();

  if(isset($_SESSION['SESSION_USER'])){

    $json = new stdClass();

    if(isset($_POST['email'])){

      if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){

        require_once '../class/Conn.class.php';
        require_once '../class/Clientes.class.php';

        $clientes = new Clientes();

        if($clientes->verific_email($_POST['email'])){

          $json->erro = false;
          $json->msg  = "Email válido";
          echo json_encode($json);

        }else{

          $json->erro = true;
          $json->msg  = "Email ja cadastrado no gestor lite";
          echo json_encode($json);

        }


      }else{

        $json->erro = true;
        $json->msg  = "Coloque um email válido";
        echo json_encode($json);

      }


    }

  }


?>
