<?php

if(!$_GET['type']){
    die();
}


set_time_limit(12000);//coloque no inicio do arquivo
ini_set('max_execution_time', 12000);



    
    $conn = new Conn();
    $pdo = $conn->pdo();
    
    
    
    $list = "";
    
    $query_select_vencidos = $pdo->query("SELECT * FROM `user` WHERE send_mail='0'");
    $users= $query_select_vencidos->fetchAll(PDO::FETCH_OBJ);
    var_dump($users);
    $w=0;
     while($user = $query_select_vencidos->fetchAll(PDO::FETCH_OBJ)){
         
         
         if($user->vencimento != 0 && $user->vencimento != ""){

            $explodeData  = explode('/',$user->vencimento);
            $explodeData2 = explode('/',date('d/m/Y'));
            $dataVen      = $explodeData[2].$explodeData[1].$explodeData[0];
            $dataHoje     = $explodeData2[2].$explodeData2[1].$explodeData2[0];


            if($_GET['type'] == "vencidos"){
                
                
                if(isset($_GET['patrao'])){
                    
                    if($dataHoje > $dataVen || $user->vencimento == "00/00/0000" ){
                       
                     $num = str_replace(' ', '',str_replace('-', '',str_replace('(', '',str_replace(')', '',$user->telefone))));  
                     
                     if(isset($_GET['mail'])){
                         if($user->id_plano == 7){  
                            $list .= "{$user->nome};{$user->email};{$user->ddi}{$num}\n\n";
                         }
                     }else{
                          if($user->id_plano == 7){  
                            $list .= "\r\nID: {$user->id} | NOME: {$user->nome} | EMAIL: {$user->email} | WHATSAPP: {$user->ddi}{$num} | PLANO: {$user->id_plano} | VENCIMENTO: {$user->vencimento}\r\n";
                         }
                     }
                     
                     $arquivo = "clientes_gestor_vencidos.txt";
    
                    }
                    
                    
                }else{

                   if($dataHoje > $dataVen || $user->vencimento == "00/00/0000"){
                       
                     $num = str_replace(' ', '',str_replace('-', '',str_replace('(', '',str_replace(')', '',$user->telefone))));  
                       
                     $list .= "\r\nNOME: {$user->nome} | EMAIL: {$user->email} | WHATSAPP: {$user->ddi}{$num} | VENCIMENTO: {$user->vencimento}\r\n";
        
                     $arquivo = "clientes_gestor_vencidos.txt";
    
                    }
                }
            }else if($_GET['type'] == "marketing_mail_all"){
            
                $arquivo = "marketing_mail_all.txt";
                if($w < 249 && $user->email != "marcosfalves25@gmail.com" && $user->email != "nelsonguiana@gmail.com"){
                    
                    if(filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
                       if(explode('@',$user->email)[1] == 'gmail.com' || explode('@',$user->email)[1] == 'hotmail.com' || explode('@',$user->email)[1] == 'outlook.com' || explode('@',$user->email)[1] == 'yahoo.com' ){
                        $list .= "{$user->email}\r\n";
                        $w++;
                        
                        
                        $pdo->query("UPDATE `user` SET send_mail='1' WHERE id='".$user->id."' ");
                        
                      }
                    }
                    
                }                
            }else if($_GET['type'] == "marketing_mail_vencidos"){
            
                $arquivo = "marketing_mail_vencidos.txt";
                
              if($dataHoje > $dataVen || $user->vencimento == "00/00/0000"){
                   
                 $num = str_replace(' ', '',str_replace('-', '',str_replace('(', '',str_replace(')', '',$user->telefone))));  
                   
                 $list .= "{$user->email}\r\n";
    
                }
            }else if($_GET['type'] == "marketing_mail_plano"){
                
                $arquivo = "marketing_mail_plano_{$_GET['nameP']}.txt";
                
                $idp = $_GET['idp'];
                
                if($user->id_plano == $idp){
                  $list .= "{$user->email}\r\n";  
                }
            }else if($_GET['type'] == "marketing_mail_all_mailwizz"){
            
                $arquivo = "marketing_mail_all.txt";
                
                $list .= "{$user->email}\r\n";
                
            }
         }
        
        
     }
    
      
    
      // Configurações header para forçar o download
      header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
      header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
      header ("Cache-Control: no-cache, must-revalidate");
      header ("Pragma: no-cache");
      header ("Content-type: application/x-msexcel");
      header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
      header ("Content-Description: PHP Generated Data" );
      // Envia o conteúdo do arquivo
      echo $list;
      exit;

    