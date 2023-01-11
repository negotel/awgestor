<?php

  @session_start();
require_once "../config/settings.php";
  if(isset($_SESSION['SESSION_USER'])){

    if(isset($_POST['ordem_atual'])){


      require_once '../class/Conn.class.php';
      require_once '../class/Financeiro.class.php';

      $financeiro = new Financeiro();

       $ordem = $_POST['ordem_atual'];
       $str1  = str_replace('gif[]=load','',$ordem);
       $array = explode('&grap[]=',$str1);

       $new = '';

       foreach ($array as $key => $value) {
          if($value != ""){
            $new .= $value.',';
          }
       }

      $new_ordem = rtrim($new,',');

      $update_graph_u = $financeiro->update_graph_u($_SESSION['SESSION_USER']['id'],$new_ordem);
      if($update_graph_u){
        echo '{"erro":false}';
      }else{
        echo '{"erro":true}';
      }
    }
 }



?>
