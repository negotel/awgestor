<?php


   @session_start();
require_once "../config/settings.php";
   $json = new stdClass();

   if(isset($_SESSION['SESSION_USER'])){


     if(isset($_POST['dados'])){


       $dados = json_decode($_POST['dados']);

       if($dados->nome != "" && $dados->valor != "" && $dados->dias != "" && $dados->template_zap != ""){

         require_once '../class/Conn.class.php';
         require_once '../class/Planos.class.php';
         require_once '../class/Logs.class.php';

         $planos = new Planos();
         $log    = new Logs();

         $dados->id_user = $_SESSION['SESSION_USER']['id'];

         $insert = $planos->insert($dados);

         if($insert){

           $log->log($_SESSION['SESSION_USER']['id'],"Adicionou um novo plano [ {$dados->nome} ]");

           $_SESSION['INFO'] = "<i class='fa fa-check text-success' ></i> Plano <b>{$dados->nome}</b> adicionado com sucesso! ";

           $json->erro = false;
           $json->msg  = "Plano adicionado com sucesso";
           echo json_encode($json);

         }else{

           $json->erro = true;
           $json->msg  = "Erro ao adicionar plano";
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


   }else{

     $json->erro = true;
     $json->msg  = "403";
     echo json_encode($json);

   }









?>
