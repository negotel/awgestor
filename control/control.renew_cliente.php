<?php

  @session_start();

  $json = new stdClass();

   if(isset($_SESSION['SESSION_USER'])){

     if(isset($_POST)){

       $id = $_POST['id'];
       $plano = $_POST['plano'];

       if($plano != "" && $id != ""){

         require_once '../class/Conn.class.php';
         require_once '../class/Clientes.class.php';
         require_once '../class/Logs.class.php';
         require_once '../class/Planos.class.php';

         $clientes = new Clientes();
         $dados    = $clientes->dados($id);
         $logs     = new Logs();
         $planos   = new Planos();
         $plano    = $planos->plano($plano);

         if($dados->id_user == $_SESSION['SESSION_USER']['id']){

           if($clientes->renew($plano,$dados->id,$dados->vencimento)){

             $_SESSION['INFO'] = "<span><i class='fa fa-check' ></i> Cliente <b>{$dados->nome}</b> atualizado!</span>";

             $logs->log($_SESSION['SESSION_USER']['id'],"Renovou o cliente [ {$dados->nome} ] ");


             $json->erro = false;
             $json->msg  = "Cliente atualizado";
             echo json_encode($json);

           }else{

             $json->erro = true;
             $json->msg  = "Erro ao atualizar cliente <b>{$dados->nome}</b>";
             echo json_encode($json);

           }

         }else{

           $json->erro = true;
           $json->msg  = "Não autorizado";
           echo json_encode($json);

         }

       }else{

         $json->erro = true;
         $json->msg  = "Preencha todos os campos";
         echo json_encode($json);

       }
     }else{

       $json->erro = true;
       $json->msg  = "Request required";
       echo json_encode($json);

     }

   }else{

     $json->erro = true;
     $json->msg  = "403";
     echo json_encode($json);

   }














?>
