<?php
   @session_start();

   $json = new stdClass();

   if(isset($_SESSION['SESSION_USER'])){


     if(isset($_POST['dados'])){


       $dados = json_decode($_POST['dados']);

       if($dados->valor != "" && $dados->hora != "" && $dados->data != "" && $dados->tipo != "" && $dados->nota != ""){

         require_once '../class/Conn.class.php';
         require_once '../class/Financeiro.class.php';
         require_once '../class/Logs.class.php';

         $financeiro = new Financeiro();
         $log        = new Logs();

         $dados->id_user = $_SESSION['SESSION_USER']['id'];
         $dados->data = date('d/m/Y',  strtotime($dados->data));

         $insert = $financeiro->insert($dados);

         if($insert){

           $log->log($_SESSION['SESSION_USER']['id'],"Adicionou uma movimentação no financeiro");

           $_SESSION['INFO'] = "<i class='fa fa-check text-success' ></i> Movimentação adicionada com sucesso! ";

           $json->erro = false;
           $json->msg  = "Movimentação adicionada com sucesso";
           echo json_encode($json);

         }else{

           $json->erro = true;
           $json->msg  = "Erro ao adicionar movimentação";
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
