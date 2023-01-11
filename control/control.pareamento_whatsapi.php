<?php

  @session_start();
require_once "../config/settings.php";
  if(isset($_SESSION['SESSION_USER'])){
      
       $return->erro = true;
       $return->msg = "Entre em contato com Script Mundo para iniciar o pareamento: <br /> <i class='fa fa-whatsapp' ></i> 45 2032-0776 <br /> <i class='fa fa-envelope' ></i> contato@scriptmundo.com";
       echo json_encode($return);
                  
     die;
      
      
      

      $return = new stdClass();

      require_once '../class/Conn.class.php';
      require_once '../class/Whatsapi.class.php';
      require_once '../class/User.class.php';

      $wsapi = new Whatsapi();
      $user  = new User();
      
      $dados_u  = $user->dados($_SESSION['SESSION_USER']['id']);
      $v_device = $wsapi->verific_device($dados_u->id);
      if($v_device){
          //verifica status de conexao 
          
          $status = $wsapi->verifique_connect($v_device);
          
          if($status != "active"){
              // buscar qr code
              $qrcode = $wsapi->qrcode($v_device);
              
              
              if($qrcode){
                  
                  $return->erro = false;
                  $return->qrcode = $qrcode;
                  echo json_encode($return);
                  
              }else{
                  //error
                  $return->erro = true;
                  $return->msg = "Serviço indisponível no momento <br /> Volte mais tarde ou atualize a página.";
                  echo json_encode($return);
              }
              
              
          }else{
              //dispositivo pareado
              $return->erro = true;
              $return->msg = "Seu dispositivo já está pareado <br /> <button style='margin-top:10px;' id='btn_desconect' class='btn btn-outline-danger' onclick='desconect_device();' ><i class='fa fa-chain-broken' ></i> Desconectar</button>";
              echo json_encode($return);
          }
          
      }else{
          //create new device
          $device = $wsapi->create_device_api('GESTORLITE_'.$dados_u->id);
         if($device){
             
             
             if($wsapi->cadastro_device($device,$dados_u->id)){
                 
                 $status = $wsapi->verifique_connect($device);
                 
                 if($status != "active"){
                      // buscar qr code
                      $qrcode = $wsapi->qrcode($device);
                      
                      if($qrcode){
                          
                          $return->erro = false;
                          $return->qrcode = $qrcode;
                          echo json_encode($return);
                          
                      }else{
                          //error
                          $return->erro = true;
                          $return->msg = "Serviço indisponível no momento <br /> Volte mais tarde ou atualize a página.";
                          echo json_encode($return);
                      }
                      
                      
                  }else{
                      //dispositivo pareado
                      $return->erro = true;
                      $return->msg = "Seu dispositivo já está pareado";
                      echo json_encode($return);
                  }
                 
             }else{
                 //error 
                 $return->erro = true;
                 $return->msg = "Serviço indisponível no momento <br /> Volte mais tarde ou atualize a página.";
                 echo json_encode($return); 
             }
             
            
         }else{
             // error
              $return->erro = true;
              $return->msg = "Serviço indisponível no momento <br /> Volte mais tarde ou atualize a página.";
              echo json_encode($return);
         }
         
      }
    
    
     
      
  }



?>
