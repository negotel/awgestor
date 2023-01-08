<?php

 @session_start();

 if(isset($_SESSION['SESSION_USER'])){

   if(isset($_POST['data1']) && isset($_POST['data2']) && isset($_POST['type_export'])){

     if($_POST['data1'] != "" && $_POST['data2'] != "" && $_POST['type_export'] != ""){

       $data1 = date('d/m/Y',  strtotime($_POST['data1']));
       $data2 = date('d/m/Y',  strtotime($_POST['data2']));
       $type  = $_POST['type_export'];

       require_once '../class/Conn.class.php';
       require_once '../class/Gestor.class.php';
       require_once '../class/Financeiro.class.php';
       require_once '../class/Logs.class.php';

       $gestor     = new Gestor();
       $financeiro = new Financeiro();
       $logs       = new Logs();



       $dados_exp = $financeiro->export_dados($data1,$data2,$_SESSION['SESSION_USER']['id']);

       if($type == "pdf"){
         include_once 'export_types/pdf/ex_pdf.php';
       }else if($type == "json"){
         include_once 'export_types/json/ex_json.php';
       }else if($type == "txt"){
         include_once 'export_types/txt/ex_txt.php';
       }else if($type == "xls"){
         include_once 'export_types/xls/ex_xls.php';
       }else{
         $_SESSION['INFO'] = "Parece que este tipo de arquivo eu ainda não consigo exportar.";
         echo "<script>location.href='../painel/financeiro';</script>";
       }

     }else{
       $_SESSION['INFO'] = "Você deixou de nos dizer algo";
       echo "<script>location.href='../painel/financeiro';</script>";
     }

   }else{
     $_SESSION['INFO'] = "Você deixou de nos dizer algo";
     echo "<script>location.href='../painel/financeiro';</script>";
   }

 }else{
    echo "<script>location.href='../login';</script>";
 }


?>
