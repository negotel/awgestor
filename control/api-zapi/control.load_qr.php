<?php


  //include "../../qrcodes/qrlib.php"; 


  @session_start();

  if(isset($_SESSION['SESSION_USER'])){
      
     
      $return = new stdClass();

      require_once '../../class/Conn.class.php';
      require_once '../../class/Whatsapi.class.php';
      require_once '../../class/Whatsgw.class.php';
      require_once '../../class/User.class.php';
      require_once '../../class/Gestor.class.php';

      $conn = new Conn();
      $pdo = $conn->pdo();


      $wsapi = new Whatsapi();
      $whatsgw = new Whatsgw();
      $user  = new User();
      $gestor = new Gestor();
      
      $dados_u   = $user->dados($_SESSION['SESSION_USER']['id']);
      
      $api = 'Whatsgw';
      $key = substr(sha1(rand()),0,20);
      $user_id = $dados_u->id;
      $situ = 1;
      
      $keyantiga = trim($_POST['keydevice_zapi']);
      
      $v_device = $wsapi->verific_device($dados_u->id,$api);
      
      
      if(isset($_POST['remove'])){
          $whatsgw->removeInstance($keyantiga);
          
          $query = "DELETE FROM `whats_api` WHERE id_user='$user_id' AND api='$api' ";
          $pdo->query($query);
          
           if(isset($_SESSION['time_whatsapp_status'])){
                 unset($_SESSION['time_whatsapp_status']['time']);
                 unset($_SESSION['time_whatsapp_status']['session']);
                 unset($_SESSION['time_whatsapp_status']);
            }
                                
      }
      
      if(isset($_POST['verifyConected'])){
          
          if($v_device->status == "connected"){
              echo '1';
          }else{
              echo '0';
          }
          
          
      }
      
    
       if(isset($_POST['load'])){
        
            
             if($v_device){
                 
                 // restar qrcode
                 $whatsgw->restartQrCode($v_device->device_id);
                 sleep(15);
                 $v_device = $wsapi->verific_device($dados_u->id,$api);
                 $dados_response = json_decode($v_device->response);
                 
                 if($v_device && $dados_response){
                        echo json_encode(['erro' => false, 'qrcode' => $dados_response->qrcode, 'key' => $v_device->device_id]);
                        die;
                 }else{
                      echo json_encode(['erro' => true, 'msg' => 'Desculpe tente mais tarde']);
                      die;
                 }
              
                 
             }else{
                 
                   // start qrcode

                    if($situ == 1){
                          
                          $api_ativa = $wsapi->verific_device_situ($dados_u->id);
                          
                          if($api_ativa){
                              if($api_ativa->api != $api){
                                 $return->erro = true;
                                 $return->msg = "Você já possui outra API ativa, desative-a para ativar está.";
                                 echo json_encode($return);
                                die;
                             }
                        }
                      }
                      
                         
                 $device_id_api = $whatsgw->initQrcode();
                 
                 if($device_id_api){
                     
                        $phone = $dados_u->ddi . str_replace(array(')','(',' ','-'),array('','','',''), $dados_u->telefone);
                     
                         $query = "INSERT INTO `whats_api` (device_id,id_user,api,situ,phone) VALUES ('$device_id_api','$user_id','$api','$situ','".$phone."') ";
                         $pdo->query($query);
                         
                         sleep(15);
                         $v_device = $wsapi->verific_device($dados_u->id,$api);
                         $dados_response = json_decode($v_device->response);
                         
                         if($v_device && $dados_response){
                             echo json_encode(['erro' => false, 'qrcode' => $dados_response->qrcode, 'key' => $v_device->device_id]);
                             die;
                         }else{
                             echo json_encode(['erro' => true, 'msg' => 'Desculpe tente mais tarde']);
                             die;
                         }
                 }else{
                     echo json_encode(['erro' => true, 'msg' => 'Desculpe tente mais tarde']);
                     die;
                 }
                 
             }
         
       }
  }
    

     



?>
