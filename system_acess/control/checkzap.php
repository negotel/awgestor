<?php

 require_once 'conf.php';
 
 if(isset($_POST['check'])){
     
     if($_POST['check'] == "" ){
         echo json_encode(['erro' => true, 'msg' => "Preencha todos os campos"]);
         die;
     }

     
     $user_class = new User();
     $wpp_class = new Whatsapi();

     
     $get = $user_class->getUserCheck($_POST['check']);
     
     if($get){
         
       $api =  $wpp_class->verific_device_situ($get->id);
         
         if($api){
             
             
             //
             
             if($api->api == "ZAPI"){
                 
                  $ch=curl_init();
                  $timeout=5;
                  $device = trim($api->device_id);
                  curl_setopt($ch, CURLOPT_URL, "http://api-zapi.gestorlite.com:3000/qrcode?device={$device}");
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                  curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
                  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                  $return   = curl_exec($ch);
                  $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                  curl_close($ch);

                  if($httpcode == "200"){
                      
                       if($return == ""){
                              echo json_encode(['erro' => false, 'msg' => "O cliente {$get->nome} está conectado na API do Whatsapp", 'date' => date('d/m/Y H:i:s')]);
                              die;
                         }else{
                             echo json_encode(['erro' => true, 'msg' => "O cliente {$get->nome} não está conectado na API do Whatsapp", 'date' => date('d/m/Y H:i:s')]);
                             die;
                         }
                         
                  }else{
                       echo json_encode(['erro' => true, 'msg' => "No momento não consegui verificar. <br /> Talvez o dispositivo de {$get->nome} esteja com baixa conexão de internet ou em modo de hibernação", 'date' => date('d/m/Y H:i:s')]);
                       die;
                  }
                 

             }else{
                 echo json_encode(['erro' => false, 'msg' => "O cliente {$get->nome}, usa a API da Gestor Lite. Está conectada", 'date' => date('d/m/Y H:i:s')]);
                 die;
             }
             
             
         }else{
              echo json_encode(['erro' => true, 'msg' => "O cliente {$get->nome}, não possui nenhuma Whats API ativa em seu painel", 'date' => date('d/m/Y H:i:s')]);
              die;
         }
         
     }else{
         echo json_encode(['erro' => true, 'msg' => "Usuário não encontrado"]);
         die;
     }
     
 
 }







?>