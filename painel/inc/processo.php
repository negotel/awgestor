<?php
  
  $gestor_class_process = new Gestor();
  $user = $user_class_process->dados($_SESSION['SESSION_USER']['id']);
  $dark = $user->dark;
   

  // verificar data do vencimento
  $explodeData_user  = explode('/',$user->vencimento);
  $explodeData2_user = explode('/',date('d/m/Y'));
  $dataVen_user      = $explodeData_user[2].$explodeData_user[1].$explodeData_user[0];
  $dataHoje_user     = $explodeData2_user[2].$explodeData2_user[1].$explodeData2_user[0];

  if($dataVen_user == $dataHoje_user){
      $ven_user = "<b class='badge badge-primary'>Seu painel Gestor Lite, vence hoje: {$user->vencimento}</b>";
  }else if($dataHoje_user > $dataVen_user){
 
     if($user->vencimento == "00/00/0000"){
       $ven_user = "<b class='badge badge-info'>Escolha um plano Gestor Lite</b>";
     }else{
       $ven_user = "<b class='badge badge-danger'>Painel Gestor Lite vencido, renove</b>";
     }

    if(isset($_GET['url'])){
      if($_GET['url'] != "pagamentos" && $_GET['url'] != "cart" && $_GET['url'] != "sair"){
        echo '<script>location.href="pagamentos";</script>';
        exit;
      }
    }else{
        echo '<script>location.href="pagamentos";</script>';
        exit;
    }

  }

    /*Buscar plano user*/
   $plano_usergestor = $gestor_class_process->plano($user->id_plano);

   if($plano_usergestor == false){
     $plano_usergestor = new stdClass();
     $plano_usergestor->financeiro = 0;
     $plano_usergestor->financeiro_avan = 0;
     $plano_usergestor->gateways = 0;
   }


   if(isset($_SESSION['PLANO_SELECT'])){
     echo '<script>location.href="cart";</script>';
   }

    


?>
