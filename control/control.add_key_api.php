<?php

  @session_start();
require_once "../config/settings.php";
  if(isset($_SESSION['SESSION_USER'])){
      
      

      $return = new stdClass();

      require_once '../class/Conn.class.php';
      require_once '../class/Whatsapi.class.php';
      require_once '../class/User.class.php';

       $conn = new Conn();
       $pdo = $conn->pdo();


      $wsapi = new Whatsapi();
      $user  = new User();
      
      $api  = $_POST['api'];
      $situ = $_POST['situ'];
      
      if($_POST['api'] == "" ||  $_POST['api_key'] == "" || $_POST['situ'] == "" || $_POST['api_key'] == "@@@@"){
          $return->erro = true;
          $return->msg = "Preencha todos os campos";
          echo json_encode($return);
          die;
      } 
      
      $dados_u  = $user->dados($_SESSION['SESSION_USER']['id']);
      $v_device = $wsapi->verific_device($dados_u->id,$api);
      if($v_device){
          // update key
          
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
         
          
          
          $key = $_POST['api_key'];
          $user_id = $dados_u->id;
          
          $query = "UPDATE `whats_api` SET device_id='$key', situ='$situ' WHERE id_user='$user_id' AND api='$api' ";
          if($pdo->query($query)){
              
              $return->erro = false;
              $return->msg = "Api ".strtoupper($api)." Alterada";
              echo json_encode($return);
          }else{
              $return->erro = true;
              $return->msg = "Erro ao alterar API ".strtoupper($api)."";
              echo json_encode($return);
          }
          
      }else{
          
          $key = $_POST['api_key'];
          $user_id = $dados_u->id;
          
          
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
          if($pdo->query($query)){
              
              $return->erro = false;
              $return->msg = "Api ".strtoupper($api)." Adicionada";
              echo json_encode($return);
          }else{
              $return->erro = true;
              $return->msg = "Erro ao adicionar API ".strtoupper($api)."";
              echo json_encode($return);
          }
         
      }
    
    
     
      
  }



?>
