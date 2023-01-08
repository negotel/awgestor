<?php

 require_once 'conf.php';
 
 if(isset($_POST['solicita'])){
     
     
     if($_POST['instalador'] == ""){
         echo json_encode(['erro' => true, 'msg' => "Selecione um instalador"]);
         die;
     }
     
     if($_POST['id_cliente'] == ""){
         echo json_encode(['erro' => true, 'msg' => "Informe o ID do cliente"]);
         die;
     }
     
     if($_POST['dominio_install'] == ""){
         echo json_encode(['erro' => true, 'msg' => "Informe o dominio"]);
         die;
     }
     
     $id_cliente = $_POST['id_cliente'];
     $dominio    = $_POST['dominio_install'];
     $info       = $_POST['info_install'] != "" ? $_POST['info_install']: "Nenhuma";
     $instalador = $_POST['instalador'];
     
     $explo_intalador = explode('=',$instalador);
     $zap_instalador  = $explo_intalador[0];
     $email_instalador = $explo_intalador[1];
     
     $user_class = new User();
     
     $user = $user_class->dados($id_cliente);
     
     if($user){
         
     $zap = $user->ddi.str_replace(' ','',str_replace('-','',str_replace('(','',str_replace(')','',$user->telefone))));
     
     $texto = "*Uma soliciatação de instalação de VPS*

*Dados do clientes:* 

Nome: *{$user->nome}*
Email: *{$user->email}*
Whatsapp: *wa.me/{$zap}*
ID: *{$user->id}*

*Dados VPS*:

Dominio: *{$dominio}*\n

*Informações adicionais:*

{$info}
     ";
     
    $send_zap = file_get_contents("http://94.156.189.238:3000/send?device=gestorlite&num={$zap_instalador}&msg=".urlencode($texto));
     
    $to = $email_instalador;
    $subject = "Solicitação de instalação de VPS";
    $from = 'contact@gestorlite.com';
     
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
     
    $headers .= "From: Gestor Lite <{$from}> \r\n".
        'Reply-To: '.$from."\r\n" .
        'X-Mailer: PHP/' . phpversion();
        
        
    $send_mail = mail($to, $subject, $texto, $headers);
    
    if($send_zap == true && $send_mail == true){
        echo json_encode(['erro' => false, 'msg' => "Solicitação enviada ao instalador"]);
        die;
    }else{
        echo json_encode(['erro' => true, 'msg' => "Erro eo enviar solicitação"]);
        die;
    }
    
    
   
     
    }else{
        echo json_encode(['erro' => true, 'msg' => "Cliente com este ID não foi encontrado"]);
        die;
    }
     
 }







?>