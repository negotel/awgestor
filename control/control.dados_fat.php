<?php

  @session_start();

  if(isset($_SESSION['SESSION_USER'])){

    if(isset($_POST['id_fat'])){

      require_once '../class/Conn.class.php';
      require_once '../class/Faturas.class.php';

      $faturas = new Fatura();

      $fatura = $planos->dados($_POST['id_fat']);
      
      if($fatura){
          
          function convertMoney($type,$valor){
           if($type == 1){
             $a = str_replace(',','.',str_replace('.','',$valor));
             return $a;
           }else if($type == 2){
             return number_format($valor,2,",",".");
           }
    
         }
          
          $return = new stdClass();
          $return->erro  = false;
          $return->moeda = $fatura->moeda;
          $return->valor = convertMoney(1,$fatura->valor);
          
          echo json_encode($return);
          
      }else{
        echo '{"erro":true,"msg":"Fatura inexistente"}';
      }
    }else{
      echo '{"erro":true,"msg":"Request is required"}';
    }

  }else{
    echo '{"erro":true,"msg":"403"}';
  }



?>
