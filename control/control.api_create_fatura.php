<?php
   @session_start();
   header("Access-Control-Allow-Origin: *");
   $json = new stdClass();
    

 if(isset($_POST['id_plano'])){
     require_once "../config/settings.php";

     if($_POST['id_plano'] != "" && $_POST['id_cliente'] != ""){
         
         require_once '../class/Conn.class.php';
         require_once '../class/Clientes.class.php';
         require_once '../class/Gestor.class.php';
         require_once '../class/User.class.php';
         require_once '../class/Planos.class.php';
        
         $clientes = new Clientes();
         $gestor = new Gestor();
         $user = new User();
         $planos = new Planos();
         $fatura = new stdClass();
        
        $plano = $planos->plano($_POST['id_plano']);
        
        if($plano){
            
            $fatura->id_plano   = $plano->id;
            $fatura->valor      = str_replace('R$','',str_replace(' ','',str_replace('€','',$plano->valor)));
            $fatura->data       = date('d/m/Y');
            $fatura->status     = 'Pendente';
            $fatura->id_cli     = $_POST['id_cliente'];
            $fatura->ref        = sha1(date('d/m/Y H:i:s'));
            
            $create = $clientes->create_fat($fatura);
            
            if($create){
                $json->erro = false;
                $json->msg  = 'Fatura criada';
                $json->ref  = $fatura->ref;
                echo json_encode($json);
                die;
            }else{
                $json->erro = true;
                $json->msg  = 'Erro ao criar fatura';
                echo json_encode($json);
                die;
            }
            
        }else{
            $json->erro = true;
            $json->msg  = 'Plano não disponível';
            echo json_encode($json);
            die;
        }
        
         
     }else{
        $json->erro = true;
        $json->msg  = 'request is required';
        echo json_encode($json);
        die;
     }
     
 }
    