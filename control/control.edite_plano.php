<?php


   @session_start();

   $json = new stdClass();
require_once "../config/settings.php";
   if(isset($_SESSION['SESSION_USER'])){


     if(isset($_POST['dados'])){


       $dados = json_decode($_POST['dados']);

       if($dados->nome != "" && $dados->valor != "" && $dados->dias != "" && $dados->template_zap != "" && $dados->id_plano != ""){

         require_once '../class/Conn.class.php';
         require_once '../class/Planos.class.php';
         require_once '../class/Logs.class.php';

         $planos = new Planos();
         $log    = new Logs();

         $update = $planos->update($dados);

         if($update){

           $log->log($_SESSION['SESSION_USER']['id'],"Editou o plano {$dados->nome}");

           $_SESSION['INFO'] = "<i class='fa fa-check text-success' ></i> Plano <b>{$dados->nome}</b> editado com sucesso! ";

           $json->erro = false;
           $json->msg  = "Plano editado com sucesso";
           echo json_encode($json);

         }else{

           $json->erro = true;
           $json->msg  = "Erro ao editar plano";
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
