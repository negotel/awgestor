<?php

  @session_start();

  $json = new stdClass();

   if(isset($_SESSION['SESSION_USER'])){

     if(isset($_POST)){

       $id    = $_POST['id_cli'];
       $plano = $_POST['id_plano'];
       $meses = $_POST['vencimento'];

       if($plano != "" && $id != ""){

         require_once '../class/Conn.class.php';
         require_once '../class/User.class.php';
         require_once '../class/Logs.class.php';
         require_once '../class/Gestor.class.php';
         require_once '../class/Revenda.class.php';

         $users = new User();
         $user_rev   = $users->dados($_SESSION['SESSION_USER']['id']);
         $cli_rev    = $users->dados($id);
         $logs       = new Logs();
         $gestor     = new Gestor();
         $plano      = $gestor->plano($plano);
         $revenda    = new Revenda();

         if($cli_rev->id_rev == $_SESSION['SESSION_USER']['id']){

       
          if(!$plano){
              echo '{"erro":true,"msg":"Este plano não está disponível no presente momento."}';
              die;
            }
            
            // verificar se user pode renovar o user com a quantiodade de créditos atual
            if($revenda->verific_creditos($plano->creditos,$meses,$_SESSION['SESSION_USER']['id']) == false){
              echo '{"erro":true,"msg":"Seu saldo não é equivalente para está compra! Sentimos muito."}';
              die;
            }
            
              // verificar data do vencimento
              $explodeData_user  = explode('/',$cli_rev->vencimento);
              $explodeData2_user = explode('/',date('d/m/Y'));
              $dataVen_user      = $explodeData_user[2].$explodeData_user[1].$explodeData_user[0];
              $dataHoje_user     = $explodeData2_user[2].$explodeData2_user[1].$explodeData2_user[0];
            
              if($dataVen_user == $dataHoje_user){
                  $ven_user = date('d/m/Y', strtotime('+'.$meses.' months', strtotime(date('d-m-Y'))));;
              }else if($dataHoje_user > $dataVen_user){
                  $ven_user = date('d/m/Y', strtotime('+'.$mesess.' months', strtotime(date('d-m-Y'))));;
              }else{
                  $ven_user = date('d/m/Y', strtotime('+'.$meses.' months', strtotime( $explodeData_user[0].'-'.$explodeData_user[1].'-'.$explodeData_user[2] )));;
              }
              
              $creditos_gasto = ($plano->creditos*$meses);
               
             if($users->renew_rev($plano->id,$ven_user,$cli_rev->id)){
               $revenda->creditos_rev_change($_SESSION['SESSION_USER']['id'],$creditos_gasto);
               echo '{"erro":false,"msg":"Renovado"}';
               die;
             }else{
                   $json->erro = true;
                   $json->msg  = "Erro, entre em contato com o suporte";
                   echo json_encode($json);
             }
       
       
         }else{

           $json->erro = true;
           $json->msg  = "Não autorizado";
           echo json_encode($json);

         }

       }else{

         $json->erro = true;
         $json->msg  = "Preencha todos os campos";
         echo json_encode($json);

       }
     }else{

       $json->erro = true;
       $json->msg  = "Request required";
       echo json_encode($json);

     }

   }else{

     $json->erro = true;
     $json->msg  = "403";
     echo json_encode($json);

   }














?>
