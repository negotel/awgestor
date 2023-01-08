<?php

  @session_start();

  if(isset($_SESSION['SESSION_USER']) && isset($_POST)){

    require_once '../class/Conn.class.php';
    require_once '../class/User.class.php';
    require_once '../class/Faturas.class.php';

    $user    = new User();
    $faturas = new Faturas();

    if(isset($_POST['promo'])){

        $cod   = $_POST['cod'];
        $fat   = $_POST['fat'];

        $verifyC = $faturas->verify_cod_user($_SESSION['SESSION_USER']['id'],$cod);

        if($verifyC){

            $aply = $faturas->get_cod($cod,$fat);

          if($aply){
              
              echo '{"erro":false,"msg":"Desconto Aplicado"}';
            
          }else{
              echo '{"erro":true,"msg":"Código não é válido"}';
          }
          

        }else{

          echo '{"erro":true,"msg":"Você já usou este código"}';

        }


    }






  }


?>
