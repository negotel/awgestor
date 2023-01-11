
<?php

  @session_start();
require_once "../config/settings.php";
  if(isset($_SESSION['SESSION_USER']) && isset($_POST)){

    require_once '../class/Conn.class.php';
    require_once '../class/User.class.php';
    require_once '../class/Gestor.class.php';
    require_once '../class/Planos.class.php';
    require_once '../class/Delivery.class.php';

    $user_class     = new User();
    $gestor   = new Gestor();
    $planos   = new Planos();
    $delivery = new Delivery();

    $user     = $user_class->dados($_SESSION['SESSION_USER']['id']);

    if(isset($_POST['dados'])){

        $dados    = json_decode($_POST['dados']);
        

        if($dados){

          if($dados->nome != "" && $dados->plano_id != "" && $dados->text_delivery != ""){

            // dados do plano gestor
            $plano = $planos->plano($dados->plano_id);

            if(!$plano){
              echo '{"erro":true,"msg":"<h3>Este plano não está disponível no presente momento.</h3>"}';
              die;
            }

            $plano_gestor = $gestor->plano($user->id_plano);

            // verificar se user pode adicionar mais paineis deliverys
            if($delivery->verific_deliverys($plano_gestor->deliverys,$_SESSION['SESSION_USER']['id'])){
              echo '{"erro":true,"msg":"<h3>Desculpe, você não pode adicionar mais envios em seu plano gestor atual. <a href=\'/painel/cart?upgrade\'>Faça um upgrade</a></h3>"}';
              die;
            }
            
            if($delivery->get_deliveryByPlano($dados->plano_id,$user->id) != false){
                echo '{"erro":true,"msg":"<h3>Você já utilizou este plano um envio automático</h3>"}';
                die;
            }
            
            if($delivery->insert_delivery($dados->nome,$dados->plano_id,$dados->text_delivery,$user->id)){
                echo '{"erro":false,"msg":"<h3>Adicionado com sucesso!</h3>"}';
                die;
            }else{
                echo '{"erro":true,"msg":"Desculpe, não foi possível adicionar, entre em contato com o suporte"}';
                die;
            }



          }else{
            echo '{"erro":true,"msg":"Por obséquio, preencha todos os campos."}';
            die;
          }

        }else{
          echo '{"erro":true,"msg":"Epa! Deu ruim."}';
          die;
        }

    }


    if(isset($_POST['getInfo'])){
        
        if(!isset($_POST['id'])){
          echo '{"erro":true,"msg":"id is required"}';
          die;  
        }
        
        $deliveryId = trim($_POST['id']);
            
        $dados = $delivery->get_infoDelivery($deliveryId,$user->id);
        
        if($dados){
            echo json_encode($dados);
        }else{
            echo '{"erro":true,"msg":"Desculpe, entre em contato com o suporte"}';
            die;
        }
        
        
        
    }
    
    if(isset($_POST['editDelivery'])){
        
        if(isset($_POST['dadosEdit'])){
            
            if(json_decode($_POST['dadosEdit'])){
                
                $dados = json_decode($_POST['dadosEdit']);
                
                if($dados->nome != "" && $dados->id != "" && $dados->plano_id != "" && $dados->text_delivery != "" && $dados->situ != ""){
                    
                        $update = $delivery->update_delivery($dados,$user->id);
                        
                        if($update){
                            echo '{"erro":false,"msg":"Editado com sucesso!"}';
                        }else{
                            echo '{"erro":true,"msg":"Não foi possível concluir a edição"}';
                            die;
                        }
                    
                }else{
                    echo '{"erro":true,"msg":"Preecha todos os campos"}';
                    die;
                }
                
            }else{
                echo '{"erro":true,"msg":"Desculpe, entre em contato com o suporte"}';
                die;
            }
            
        }else{
            echo '{"erro":true,"msg":"Desculpe, entre em contato com o suporte"}';
            die;
        }
        
    }

    if(isset($_POST['deleteDelivery'])){
        
        if(isset($_POST['id'])){
            
            
            $id  = trim($_POST['id']);
            
            $delete = $delivery->delete_delivery($id,$user->id);
            
            if($delete){
                echo '{"erro":false,"msg":"Deletado com sucesso!"}';
            }else{
                echo '{"erro":true,"msg":"Desculpe, não foi possível deletar este Delivery"}';
                die; 
            }
            
            
        }else{
           echo '{"erro":true,"msg":"Desculpe, entre em contato com o suporte"}';
           die; 
        }
        
    }


  }


?>


