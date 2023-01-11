<?php

   @session_start();
   date_default_timezone_set('America/Sao_Paulo');
require_once "../config/settings.php";
   if(isset($_SESSION['SESSION_USER'])){

     require_once '../class/Conn.class.php';
     require_once '../class/Logs.class.php';
     require_once '../class/Whatsapi.class.php';

     $logs = new Logs();
     $ws   = new Whatsapi();

     $registros = $ws->list_msgs($_SESSION['SESSION_USER']['id']);

     if($registros){


        $logs->log($_SESSION['SESSION_USER']['id'],'Fez download dos registros de Whatsapp');

        $arrayDados[] = array();

        while($reg = $registros->fetch(PDO::FETCH_OBJ)){
          $arrayDados[] = (array)$reg;
        }


        $json = json_encode($arrayDados);

        header('Content-disposition: attachment; filename='.date('d-m-Y_H-i').'_ws_messages.json');
        header('Content-type: application/json');

        echo $json;

    }else{
      header('LOCATION: ../painel/whatsapi');
    }



   }else{
     echo "403";
   }



?>
