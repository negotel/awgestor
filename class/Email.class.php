<?php

 class Email extends Conn{
     
     
      function __construct()
      {
        $this->conn = new Conn;
        $this->pdo  = $this->conn->pdo();
      }
      
      private $smtp_host = "mail.gestorlite.com";
      private $smtp_porta = '465';
      private $smtp_username = "contact@gestorlite.com";
      private $smtp_password = "rAp_Kiw0PLp4";
      private $smtp_email = "contact@gestorlite.com";
      
      
      
      function send_mail($destino,$obj,$debug=false){
          
            $Mailer  = new PHPMailer();
          
            $Mailer->IsSMTP();
 			$Mailer->isHTML(true);
 			
 			$Mailer->Charset    = 'UTF-8';
 			$Mailer->SMTPSecure = 'ssl';
 			$Mailer->SMTPAuth = true;
            $Mailer->SMTPAutoTLS = false; 
 			
 			$Mailer->Host     = $this->smtp_host;
 			$Mailer->Port     = $this->smtp_porta;
 			$Mailer->Username = $this->smtp_username;
 			$Mailer->Password = $this->smtp_password;
            $Mailer->From     = $this->smtp_email;
            $Mailer->FromName = 'Gestor Lite';
            
            
 			$Mailer->Subject = $obj->nome.' - Gestor Lite';
 			$Mailer->Body    = $obj->corpo;
 			$Mailer->AltBody = strip_tags($obj->corpo);

 			$Mailer->AddAddress($destino);

 			if($Mailer->Send()){
 				return true;
 			}else{
 			    if($debug){
                 return $Mailer->ErrorInfo;
     			}else{
     			    return false;
     			}
 			    
 			}
          
      }
     
     
     
 }