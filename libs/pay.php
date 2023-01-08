<?php

  @session_start();

  require_once 'class/Conn.class.php';
  require_once 'class/Faturas.class.php';
  require_once 'class/User.class.php';
  require_once 'class/Gestor.class.php';
  require_once 'class/Financeiro.class.php';
  require_once 'class/Logs.class.php';
  require_once 'class/Afiliado.class.php';
  require_once 'libs/MercadoPago/lib/mercadopago.php';
  require_once 'class/MercadoPago.class.php';

  $faturas    = new Faturas();
  $user       = new User();
  $gestor     = new Gestor();
  $financeiro = new Financeiro();
  $logs       = new Logs();
  $mp         = new MercadoPago();
  $afiliado   = new Afiliado(); 
 
  if(isset($_GET['return'])){
     
     
        if(isset($_GET['collection_id'])):
           $id = $_GET['collection_id'];
        elseif(isset($_GET['id'])):
           $id = $_GET['id'];
        endif;
         
         
         if(isset($_GET['af'])){
             
             $afiliadoId = trim($_GET['af']);
             
             
             $getAf = $afiliado->getAfiliadoById($afiliadoId);
            
             if($getAf){
                 
                 $access_mp = $afiliado->getAccesMP($afiliadoId);
                 
                 if($access_mp){
                    $retorno = $mp->RetornoAf($getAf,$id,$access_mp);
                 }else{
                     $retorno = $mp->Retorno(@$id);
                 }
                 
             }else{
                 $retorno = $mp->Retorno(@$id);
             }
             
         }else{
        
              if(@$_GET['collection_id'] == "null"){
                   echo '<title>Não concluido</title>';
                   echo '<center><img  src="https://cdn2.scratch.mit.edu/get_image/user/33316225_60x60.png" /></center>';
                   echo '<script>setTimeout(function(){location.href="painel/pagamentos";},3000);</script>';
                   die;
                }
        
              $retorno = $mp->Retorno(@$id);
        
              echo '<title>Retornando...</title>';
              echo '<center><img src="img/09-segurança-google.gif"/> </center>';
              echo '<script>setTimeout(function(){location.href="painel/pagamentos";},5000);</script>';
              die;
         }

  }


?>
