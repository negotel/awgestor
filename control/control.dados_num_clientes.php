<?php

   @session_start();
require_once "../config/settings.php";
   $json     = new stdClass();

  if(isset($_SESSION['SESSION_USER'])){



       require_once '../class/Conn.class.php';
       require_once '../class/Clientes.class.php';

       $clientes = new Clientes();

       $list_clientes = $clientes->list_clientes($_SESSION['SESSION_USER']['id'],false);
    
       if($list_clientes){
           
           $all=0;
           $vencidos=0;
           $ativos=0;
           
           while($cli = $list_clientes->fetch(PDO::FETCH_OBJ)){
               
               $explodeData  = explode('/',$cli->vencimento);
               $explodeData2 = explode('/',date('d/m/Y'));
               $dataVen      = $explodeData[2].$explodeData[1].$explodeData[0];
               $dataHoje     = $explodeData2[2].$explodeData2[1].$explodeData2[0]; 
          
              if($dataHoje > $dataVen){
                 $vencidos++;
              }else if($dataVen == $dataHoje){
                  $ativos++;
              }else if($dataHoje < $dataVen){
                  $ativos++;
              }
               
               $all++;
           }
           
           $plano['porcentagem_vencidos'] = (int)substr ( ($vencidos / $all) * 100, 0, 4 );
           $plano['porcentagem_ativos'] = (int) substr ( ($ativos / $all) * 100, 0, 4 );
           
           echo $plano['porcentagem_vencidos'].'|'.$plano['porcentagem_ativos'];
       }
    

  }else{
    $json->erro = true;
    $json->msg  = "403";
    echo json_encode($json);
  }








?>
