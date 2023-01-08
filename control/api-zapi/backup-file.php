<?php

  @session_start();

  if(isset($_SESSION['SESSION_USER'])){
      
      $endpoint = "http://api-zapi.gestorlite.com:3000";
      
     
      $return = new stdClass();

      require_once '../../class/Conn.class.php';
      require_once '../../class/Whatsapi.class.php';
      require_once '../../class/User.class.php';
      require_once '../../class/Gestor.class.php';

      $conn = new Conn();
      $pdo = $conn->pdo();


      $wsapi = new Whatsapi();
      $user  = new User();
      $gestor = new Gestor();
      
      $dados_u   = $user->dados($_SESSION['SESSION_USER']['id']);
      
      if($dados_u->id_plano != 7){
          echo json_encode(['erro' => true, 'msg' => 'Seu Plano não permite está API, faça Upgrade']);
          die;
      }

      $api = 'ZAPI';
      $key = substr(sha1(rand()),0,20);
      $user_id = $dados_u->id;
      $situ = 1;
      
      $keyantiga = $_POST['keydevice_zapi'];
      
      $v_device = $wsapi->verific_device($dados_u->id,$api);
      
      
      if(isset($_POST['remove'])){
          file_get_contents($endpoint."/close?device=".$keyantiga);
          $query = "DELETE FROM `whats_api` WHERE id_user='$user_id' AND api='$api' ";
          $pdo->query($query);
      }
      
    
       if(isset($_POST['load'])){
           
            function qrcode($endpoint,$key){
            // buscar qrcode
               $file = file_get_contents($endpoint."/start?device=".$key."&json");
               
              if($file){
                  if(json_decode($file)){
                      $return = json_decode($file);
                      if($return->erro == false){
                           
                            echo json_encode(['erro' => false, 'qrcode' => $return->qrcode, 'key' => $key]);
                            die;
                        
                           
                      }else{
                          echo json_encode(['erro' => true, 'msg' => 'Desculpe tente mais tarde']);
                          die;
                      }
                  }else{
                        echo json_encode(['erro' => true, 'msg' => 'Desculpe tente mais tarde']);
                        die;
                  }
              }else{
                    echo json_encode(['erro' => true, 'msg' => 'Desculpe tente mais tarde']);
                    die;
              }
            }
          
          if($v_device){
              // update key
              
              file_get_contents($endpoint."/close?device=".$keyantiga);
              
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
             
             
              $query = "UPDATE `whats_api` SET device_id='$key', situ='1' WHERE id_user='$user_id' AND api='$api' ";
              if($pdo->query($query)){
                  
                  
                qrcode($endpoint,$key);
                  
                  
              }else{
                  $return->erro = true;
                  $return->msg = "Erro ao alterar API ".strtoupper($api).", entre em contato com o suporte.";
                  echo json_encode($return);
              }
              
          }else{
    
              
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
              
              //add key
              $query = "INSERT INTO `whats_api` (device_id,id_user,api,situ) VALUES ('$key','$user_id','$api','$situ') ";
              
              try{
                 if($pdo->query($query)){
                  
                   qrcode($endpoint,$key);
                       
                  }else{
                      $return->erro = true;
                      $return->msg = "Erro ao adicionar API ".strtoupper($api)."";
                      echo json_encode($return);
                  }
              }catch(Exception $e){
                echo $e;
              }
             
          }
       }
  }
    

     



?>
