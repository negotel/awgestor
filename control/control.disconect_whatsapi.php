<?php

  @session_start();

  if(isset($_SESSION['SESSION_USER'])){

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
          
          $disconect = $wsapi->disconect_device($v_device);
          
          if($disconect){

                  //error
                  $return->erro = false;
                  $return->msg = "Desconectado!";
                  echo json_encode($return);
              
          }else{
              $return->erro = true;
              $return->msg = "Não foi possivel desconectar, tente mais tarde";
              echo json_encode($return);
          }
          
      }
     
      
  }



?>
