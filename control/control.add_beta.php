<?php

  @session_start();
require_once "../config/settings.php";
  $json = new stdClass();

    if(isset($_POST['dados'])){

        $dados = json_decode($_POST['dados']);

      if($dados->nome != "" && $dados->email != "" && $dados->whatsapp != ""){

        require_once '../class/Conn.class.php';
        require_once '../class/Gestor.class.php';

        $gestor = new Gestor();


        $inser = $gestor->insert_beta($dados);

        if($inser){
            
            if(!isset($_SESSION['GRUPO_BETA'])){
                $_SESSION['GRUPO_BETA'] = true;
            }
            
            $json->erro = false;
            $json->msg  = "Você agora está no grupo beta, se você for selecionado iremos entrar em contato.";
            echo json_encode($json);
            
            
        }else{
            $json->erro = false;
            $json->msg  = "Erro ao adicionar você ao grupo beta.";
            echo json_encode($json);
        }

      }else{

        $json->erro = true;
        $json->msg  = "Preencha todos os campos";
        echo json_encode($json);

      }


    }else{

      $json->erro = true;
      $json->msg  = "Request is required";
      echo json_encode($json);

    }




?>