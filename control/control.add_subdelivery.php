<?php

  @session_start();

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
    
    $user      = $user_class->dados($_SESSION['SESSION_USER']['id']);

    if(isset($_POST['content'])){

        $content     = $_POST['content'];
        $deliveryId  = $_POST['delivery'];
        $reverse     = $_POST['reverse'];

        if($content){

          if($content != "" && $deliveryId != "" ){

           
            $insert = $delivery->insert_subdelivery($content,$deliveryId,$reverse);
            
            if($insert){
                echo '{"erro":false,"msg":"Adicionado com sucesso!"}';
                die;
            }else{
                echo '{"erro":true,"msg":"Tente mais tarde."}';
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
    
    if(isset($_POST['deleteSub'])){
        $id = trim($_POST['id']);
        $deliveryId = trim($_POST['deliveryId']);
        
        $delete = $delivery->delete_subdelivery($id,$deliveryId,$user->id);
        
        if($delete){
            echo '{"erro":false,"msg":"Deletado com sucesso!"}';
            die;
        }else{
            echo '{"erro":true,"msg":"Erro ao deletar, entre em contato com o suporte"}';
            die;
        }
        
    }


    if(isset($_POST['getInfo'])){
        $id = trim($_POST['id']);
        $deliveryId = trim($_POST['deliveryId']);
        
       $dados = $delivery->get_infoSubDelivery($id,$deliveryId,$user->id);
       
       if($dados){
           echo json_encode($dados);
       }else{
           echo '{"erro":true,"msg":"Desculpe, entre em contato com o suporte"}';
           die;
       }
        
    }
    
    if(isset($_POST['editSub'])){
        $content    = $_POST['contentEdit'];
        $id         = $_POST['id'];
        $deliveryId  = $_POST['deliveryId'];
        $reverse     = $_POST['reverse'];

        if($content){

          if($content != "" && $deliveryId != "" && $id != ""){

           
            $update = $delivery->update_subdelivery($id,$content,$deliveryId,$user->id,$reverse);
            
            if($update){
                echo '{"erro":false,"msg":"Atualziado com sucesso!"}';
                die;
            }else{
                echo '{"erro":true,"msg":"Tente mais tarde."}';
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





  }


?>


