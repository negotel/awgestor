<?php 

 if(isset($_POST['email'])){
     
     if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
         
         $json = new stdClass();
         
         $ar1 = array(')','(','-',' ','+');
         $ar2 = array('','','','','');
         
         require_once 'autoload.php';
         
         $gestor_class = new Gestor();
         $user_class   = new User();
         $whatsapi_class = new Whatsapi();
         
         $msg_recover = $gestor_class->text_recover_pass(1);
         
         if($user_class->verific_email($_POST['email'])){
            
            $user = $user_class->dados_por_email($_POST['email']);
            
            $telefone = str_replace($ar1,$ar2,$user->telefone);
            $phone2   = str_replace($ar1,$ar2,$user->telefone);
            $phone    = $user->ddi.$telefone;
            
            $ar_zap1 = array('{name}','{pass}');
            $ar_zap2 = array(explode(' ',$user->nome)[0],$user->senha);
            $texto   = str_replace($ar_zap1,$ar_zap2,$msg_recover->text);
            
            if($whatsapi_class->fila($phone,$texto,$user->id,'gestorbot','gestorbot','0000','0000',"recover_pass")){
                
               $phone_ofuscate = '+'.$user->ddi.substr($phone2,0, -(strlen($phone2)-2))."****".substr($phone2,-2, 2);
               
               $json->erro = false;
               $json->msg = "<ul><li>Sua senha foi enviada para seu email ou whatsapp {$phone_ofuscate}, deve receber em alguns minutos.</li> <li>Pode levar até 5 min para receber o email.</li> <li>Verifique também sua caixa de spam.</li></ul>";
               
            }else{
                $json->erro = true;
                $json->msg = "Erro, tente mais tarde";
            }
            
            
         }else{
             $json->erro = true;
             $json->msg = "Não localizamos nenhum cadastro com este email em nosso sistema.";
         }
         
         
     }else{
         $json->erro = true;
         $json->msg = "Que coisa esquisita. Este email é muito doido. Tente de novo por obséquio.";
     }
     
     echo json_encode($json);
     
 }


?>