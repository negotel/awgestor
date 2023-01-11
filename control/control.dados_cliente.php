<?php

   @session_start();

   $json     = new stdClass();
require_once "../config/settings.php";
  if(isset($_SESSION['SESSION_USER'])){

     if(isset($_POST['id'])){

       $id = trim($_POST['id']);

       require_once '../class/Conn.class.php';
       require_once '../class/Clientes.class.php';

       $clientes = new Clientes();

        // verificar se cliente é do respectivo user
        $cliente_dados = $clientes->dados($id);

        if($cliente_dados){


          if($cliente_dados->id_user == $_SESSION['SESSION_USER']['id']){

            if($cliente_dados->vencimento != 0){
              $explo = explode('/',$cliente_dados->vencimento);
              $ven = $explo[2].'-'.$explo[1].'-'.$explo[0];
            }else{
              $ven = 0;
            }

              $json->erro       = false;
              $json->nome       = $cliente_dados->nome;
              $json->email      = $cliente_dados->email;
              $json->vencimento = $ven;
              $json->id_plano   = $cliente_dados->id_plano;
              $json->telefone   = $cliente_dados->telefone;
              $json->notas      = $cliente_dados->notas;
              $json->recebe_zap = $cliente_dados->recebe_zap;
              $json->senha      = $cliente_dados->senha;
              $json->categoria  = $cliente_dados->categoria;
              $json->identificador_externo  = $cliente_dados->identificador_externo;

              echo json_encode($json);

            }else{

              $json->erro = true;
              $json->msg  = "Cliente não te pertence";
              echo json_encode($json);

            }

        }else{

          $json->erro = true;
          $json->msg  = "Cliente não existe";
          echo json_encode($json);

        }


     }else{
       $json->erro = true;
       $json->msg  = "POST vazio";
       echo json_encode($json);
     }


  }else{
    $json->erro = true;
    $json->msg  = "403";
    echo json_encode($json);
  }








?>
