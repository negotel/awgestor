<?php

  @session_start();

  if(isset($_SESSION['SESSION_USER'])){

      require_once "../config/settings.php";
    if(isset($_POST['gateway']) && isset($_POST['situ']) && isset($_POST['content'])){

        require_once '../class/Conn.class.php';
        require_once '../class/Gateways.class.php';
        
        $gateway = new Gateways();
        
        $gatew = $_POST['gateway'];
        $situ = $_POST['situ'];
        $content = $_POST['content'];
        
        if($gatew == 'picpay'){
          $gate = $gateway->picpay_dados_user($content,$situ,$_SESSION['SESSION_USER']['id']);
          if($gate){
              echo json_encode(['erro' => false, 'msg' => 'Gateway de pagamento alterada']);
              die;
          }else{
              echo json_encode(['erro' => true, 'msg' => 'Erro ao alterar a gateway de pagamento']);
              die;
          }
        }
        
        if($gatew == 'banco'){
          $gate = $gateway->bank_dados_user($content,$situ,$_SESSION['SESSION_USER']['id']);
          if($gate){
              echo json_encode(['erro' => false, 'msg' => 'Gateway de pagamento alterada']);
              die;
          }else{
              echo json_encode(['erro' => true, 'msg' => 'Erro ao alterar a gateway de pagamento']);
              die;
          }
        }
        
          if($gatew == 'mercadopago'){
              
              
              if(trim($content) == "@@@" || $content == ""){
                  $gateway->delete_dados_mp($_SESSION['SESSION_USER']['id']);
                  echo json_encode(['erro' => false, 'msg' => 'Gateway de pagamento removida']);
                  die;
              }
              
             $credenciais = explode('@@@',$content);
              
             $client_id = $credenciais[0];
             $client_secret = $credenciais[1];
             
             
             if($gateway->dados_mp_user($_SESSION['SESSION_USER']['id'])){
                 $gate = $gateway->update_dados_mp($_SESSION['SESSION_USER']['id'],$client_id,$client_secret);
             }else{
                 $gate = $gateway->insert_dados_mp($_SESSION['SESSION_USER']['id'],$client_id,$client_secret);
             }
              
          if($gate){
              echo json_encode(['erro' => false, 'msg' => 'Gateway de pagamento alterada']);
              die;
          }else{
              echo json_encode(['erro' => true, 'msg' => 'Erro ao alterar a gateway de pagamento']);
              die;
          }
        }
        
          if($gatew == 'paghiper'){
              
              
              if(trim($content) == "@@@" || $content == ""){
                  $gateway->delete_dados_ph($_SESSION['SESSION_USER']['id']);
                  echo json_encode(['erro' => false, 'msg' => 'Gateway de pagamento removida']);
                  die;
              }
              
             $credenciais = explode('@@@',$content);
              
             $apikey = $credenciais[0];
             $token  = $credenciais[1];
             $situ = $_POST['situ'];
             
             
             if($gateway->dados_ph_user($_SESSION['SESSION_USER']['id'])){
                 $gate = $gateway->update_dados_ph($_SESSION['SESSION_USER']['id'],$apikey,$token,$situ);
             }else{
                 $gate = $gateway->insert_dados_ph($_SESSION['SESSION_USER']['id'],$apikey,$token,$situ);
             }
              
          if($gate){
              echo json_encode(['erro' => false, 'msg' => 'Gateway de pagamento alterada']);
              die;
          }else{
              echo json_encode(['erro' => true, 'msg' => 'Erro ao alterar a gateway de pagamento']);
              die;
          }
        }
        
    }

  }


?>
