<?php

  @session_start();

  if(isset($_SESSION['SESSION_USER'])){


    if(isset($_POST['modelo']) && isset($_POST['content'])){

        require_once '../class/Conn.class.php';
        require_once '../class/ApiPainel.class.php';
        
        $apiPainel = new ApiPainel();
        
        $modelo  = $_POST['modelo'];
        $content = $_POST['content'];
        $id      = $_POST['id'];
        
          $up = $apiPainel->update_message_modelo($content,$modelo,$_SESSION['SESSION_USER']['id'],$id);
          if($up){
              echo json_encode(['erro' => false, 'msg' => 'Modelo alterado']);
              die;
          }else{
              echo json_encode(['erro' => true, 'msg' => 'Erro ao alterar o modelo de mensagem']);
              die;
          }
        
    }

  }


?>
