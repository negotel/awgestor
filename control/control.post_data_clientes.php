<?php

  @session_start();

  $json = new stdClass();
require_once "../config/settings.php";
   if(isset($_SESSION['SESSION_USER'])){

     if(isset($_POST)){

       $dados_cli = json_decode($_POST['dados']);

       if($dados_cli->nome != "" && $dados_cli->telefone != "" && $dados_cli->notas != "" && $dados_cli->plano != "" && $dados_cli->vencimento != "" && $dados_cli->id != ""){

         require_once '../class/Conn.class.php';
         require_once '../class/Clientes.class.php';
         require_once '../class/Logs.class.php';

         $clientes = new Clientes();
         $dados    = $clientes->dados($dados_cli->id);
         $logs     = new Logs();

         if($dados->id_user == $_SESSION['SESSION_USER']['id']){

        if($dados->email != ""){

           if($dados->email != $dados_cli->email){
             if($clientes->verific_email($dados_cli->email) == false){
               $json->erro = true;
               $json->msg  = "Este email já esta em uso";
               echo json_encode($json);
               die;
             }
           }
        
        }
        
        if(!isset($dados_cli->categoria)){
           $dados_cli->categoria = 0;
        }else{
        
            if($dados_cli->categoria == ""){
                $dados_cli->categoria = 0;
            }
        }
        
      if(!isset($dados_cli->identificador_externo)){
           $dados_cli->identificador_externo = NULL;
        }else{
        
            if($dados_cli->identificador_externo == ""){
                $dados_cli->identificador_externo = NULL;
            }
        }
        
          $explode            = explode('/',$dadosUser->vencimento);
          $totime             = $explode[2].$explode[1].$explode[0];
          $dadosUser->totime  = $totime;

        
           if($clientes->update($dados_cli)){

             $_SESSION['INFO'] = "<span><i class='fa fa-check' ></i> Cliente <b>{$dados->nome}</b> atualizado!</span>";

             $logs->log($_SESSION['SESSION_USER']['id'],"Atualizou o cliente [ {$dados->nome} ] ");


             $json->erro = false;
             $json->msg  = "Cliente atualizado";
             echo json_encode($json);

           }else{

             $json->erro = true;
             $json->msg  = "Erro ao atualizar cliente {$dados->nome}";
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
