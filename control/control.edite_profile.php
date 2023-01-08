<?php

  @session_start();

  $json = new stdClass();

  if(isset($_SESSION['SESSION_USER'])){

    if(isset($_POST['dados'])){


      $dados = json_decode($_POST['dados']);

      if($dados->nome != "" && $dados->email != "" && $dados->telefone != "" && $dados->dias != ""){
          
         $dados->nome = strip_tags($dados->nome);
         $dados->telefone = strip_tags($dados->telefone);
         $dados->email = strip_tags($dados->email);
          

        require_once '../class/Conn.class.php';
        require_once '../class/User.class.php';
        require_once '../class/Gestor.class.php';
        require_once '../class/Gateways.class.php';
        require_once '../class/Logs.class.php';

        $user     = new User();
        $log      = new Logs();
        $gestor   = new Gestor();
        $gateways = new Gateways();

        $userD      = $user->dados($_SESSION['SESSION_USER']['id']);
        $dados->id  = $_SESSION['SESSION_USER']['id'];
        $planoUser  = $gestor->plano($userD->id_plano);
        $dados_user = $user->dados($dados->id);
        
        $dados->verificadomail = 0;
        $dados->verificadozap = 0;
        
        if($dados_user->telefone != $dados->telefone || $dados_user->ddi != $dados->ddi){
            $dados->verificadozap = 0;
        }else{
            if($dados_user->verificadozap != 0){
                $dados->verificadozap = 1;
            }
        }
        
    
        if($dados_user->email != $dados->email){
            $dados->verificadomail = 0;
        }else{
           if($dados_user->verificadomail != 0){
             $dados->verificadomail = 1;
            }
        }
        
            
        if($planoUser->gateways == 1){
            // tem permissão para o uso das gateways de pagamento
            
            // alterar / inserir credencias do mercado pago
            
            $mp_credenciais = $gateways->dados_mp_user($_SESSION['SESSION_USER']['id']);
            if(isset($dados->mp_client_id) && isset($dados->mp_client_secret)){
                if($dados->mp_client_id != "" && $dados->mp_client_secret != ""){
                    
                    if($mp_credenciais){
                       // update 
                        $gateways->update_dados_mp($_SESSION['SESSION_USER']['id'],$dados->mp_client_id,$dados->mp_client_secret);
                    }else{
                        // insert
                        $gateways->insert_dados_mp($_SESSION['SESSION_USER']['id'],$dados->mp_client_id,$dados->mp_client_secret);
                    }
                }else{
                    if($mp_credenciais){
                        // delete
                        $gateways->delete_dados_mp($_SESSION['SESSION_USER']['id']);
                    }
                }
                
            }
            
        }    
        
    
        $update = $user->update($dados);
        
    

        if($update){

          $log->log($_SESSION['SESSION_USER']['id'],"Alterou o perfil");

          $json->erro = false;
          $json->msg  = "<i class='fa fa-check' ></i> Configurações atualizadas";
          echo json_encode($json);

        }else{

          $json->erro = true;
          $json->msg  = "<i class='fa fa-close' ></i> Erro ao alterar configurações";
          echo json_encode($json);


        }


      }else{
        $json->erro = true;
        $json->msg  = "<i class='fa fa-close' ></i> Existem campos vazios";
        echo json_encode($json);
      }


    }else{
      $json->erro = false;
      $json->msg  = "Request is required";
      echo json_encode($json);
    }


  }else{
    $json->erro = false;
    $json->msg  = "403";
    echo json_encode($json);
  }



?>
