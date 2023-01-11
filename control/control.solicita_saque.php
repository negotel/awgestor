<?php

  @session_start();

  if(isset($_SESSION['SESSION_USER']) && isset($_POST)){
    require_once "../config/settings.php";
    require_once '../class/Conn.class.php';
    require_once '../class/User.class.php';
    require_once '../class/Gestor.class.php';
    require_once '../class/Revenda.class.php';

    $user    = new User();
    $gestor  = new Gestor();
    $revenda = new Revenda();
    
    $dados_user = $user->dados($_SESSION['SESSION_USER']['id']);
    $moeda      = $user->getmoeda($dados_user->moeda);

    if(isset($_POST['valor'])){

      $valor = $revenda->convertMoney(1,str_replace('R$','',str_replace('€','',$_POST['valor'])));

      if($valor < 50.00){
        echo '{"erro":true,"msg":"É necessário ser acima de '.$moeda->simbolo.' 50,00"}';
        die;
      }else{

      
        $saldo = $revenda->saldo_user($_SESSION['SESSION_USER']['id'],true);

        if($valor<=$saldo){
            
            if($_POST['info'] == ""){
                echo '{"erro":false,"msg":"Nos diga como pretende receber o dinheiro}';
                die;
            }

          if($revenda->solicita_saque($valor,$_POST['info'],$_SESSION['SESSION_USER']['id'])){

            echo '{"erro":false,"msg":"Seu saque foi solicitado"}';
            die;

          }else{
            echo '{"erro":true,"msg":"Desculpe, ocorreu um erro, entre em contato com o suporte."}';
            die;
          }


        }else{
          echo '{"erro":true,"msg":"Você não possui esta quantia para retirar"}';
          die;
        }

      }

    }






  }


?>
