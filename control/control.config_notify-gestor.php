<?php
   @session_start();

   $json = new stdClass();

   if(isset($_SESSION['SESSION_USER'])){

     if(isset($_POST['dados'])){


       $dados = json_decode($_POST['dados']);

       if($dados->notify != "" && $dados->teste != "" && $dados->bussines != "" ){

         require_once '../class/Conn.class.php';
         require_once '../class/Gestor.class.php';
         require_once '../class/User.class.php';

         $gestor = new Gestor();
         $user   = new User();
         
         $dados_user = $user->dados($_SESSION['SESSION_USER']['id']);
         
         if($dados_user){
             
             $dados_plano = $gestor->plano($dados_user->id_plano);
             
             if($dados_plano){
                 
                 if($dados_plano->notify_page == 1){
                     
                     $setConf = $user->setNotifyGestor($_POST['dados'],$_SESSION['SESSION_USER']['id']);
                     
                     if($setConf){
                         echo json_encode(array('erro'=>false,'msg'=>'Alterado co sucesso'));
                     }else{
                         echo json_encode(array('erro'=>true,'msg'=>'Erro, entre em contato com o suporte.'));
                     }
                     
                 }else{
                     echo json_encode(array('erro'=>true,'msg'=>'Seu plano não permite está função. Faça Upgrade'));
                 }
                 
             }else{
                 echo json_encode(array('erro'=>true,'msg'=>'Erro, entre em contato com o suporte.'));
             }

         }else{
             echo json_encode(array('erro'=>true,'msg'=>'Erro, entre em contato com o suporte.'));
         }

      }else{
          echo json_encode(array('erro'=>true,'msg'=>'Preencha todos os campos'));
      }
    
     }else{
         echo json_encode(array('erro'=>true,'msg'=>'Preencha todos os campos'));
     }

  }


?>
