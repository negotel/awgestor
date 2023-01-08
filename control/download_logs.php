<?php

   @session_start();
   date_default_timezone_set('America/Sao_Paulo');

   if(isset($_SESSION['SESSION_USER'])){

     require_once '../class/Conn.class.php';
     require_once '../class/Logs.class.php';

     $logs = new Logs();

     $registros = $logs->list_logs($_SESSION['SESSION_USER']['id']);

     if($registros){


        $logs->log($_SESSION['SESSION_USER']['id'],'Fez download dos registros');

        $arrayDados[] = array();

        while($reg = $registros->fetch(PDO::FETCH_OBJ)){
          $arrayDados[] = (array)$reg;
        }


        $json = json_encode($arrayDados);

        header('Content-disposition: attachment; filename='.$_SESSION['SESSION_USER']['id'].'_logs.json');
        header('Content-type: application/json');

        echo $json;

    }else{
      header('LOCATION: ../registros');
    }



   }else{
     echo "403";
   }



?>
