<?php

 @session_start();
 header("Access-Control-Allow-Origin: *");
 $json = new stdClass();
require_once "../config/settings.php";
 require_once '../class/Conn.class.php';
 require_once '../class/Clientes.class.php';
 require_once '../class/Gestor.class.php';
 require_once '../class/User.class.php';

 $clientes = new Clientes();
 $gestor = new Gestor();
 $user = new User();

 if(isset($_POST['token'])){
     
     $token = trim($_POST['token']);
     $dadosLogin = $clientes->getTokenLogin($token);
     
     
     if($dadosLogin){
         $_POST['email'] = $dadosLogin->email;
         $_POST['senha'] = $dadosLogin->senha;
     }
     
 }



 if(isset($_POST['email']) && isset($_POST['senha']) && isset($_POST['painel'])){

   if($_POST['email'] != "" && $_POST['senha'] != "" && $_POST['painel'] != ""){

     $email  = $_POST['email'];
     $senha  = $_POST['senha'];
     $painel = $_POST['painel'];


     // buscar dados do painel
     $dados_painel = $clientes->area_cli_dados($painel);

     if($dados_painel){

       // buscar user => dono do painel
       $user_dono = $user->dados($dados_painel->id_user);

       // verificar status do vencimento do dono do painel
       $vencimento = $user->vencimento($user_dono->vencimento);

       if($vencimento == "vencido"){
         $json->erro = true;
         $json->msg  = "Não foi possivel efetuar login no momento, tente mais tarde";
         echo json_encode($json);
       }else{

         // verificar plano user
         $plano = $gestor->plano($user_dono->id_plano);

         if($plano->mini_area_cliente == 1){

           // faz login
           $login = json_decode($clientes->login($_POST,$user_dono->id));


           if($login->erro){
             $json->erro = true;
             $json->msg  = "Email ou senha incorretos";
             echo json_encode($json);

           }else{
               
               if(isset($_POST['token'])){
                   $clientes->removeTokenLogin($_POST['token']);
               }
               
               
            echo json_encode($login);
           }

         }else{
           $json->erro = true;
           $json->msg  = "Você não pode usar a área de cliente";
           echo json_encode($json);
         }

       }

     }else{
       $json->erro = true;
       $json->msg  = "Erro ao efetuar login";
       echo json_encode($json);
     }

   }else{
     $json->erro = true;
     $json->msg  = "Existem campos vazios";
     echo json_encode($json);
   }


 }else{
   $json->erro = true;
   $json->msg  = "Request is required";
   echo json_encode($json);
 }


?>
