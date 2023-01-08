<?php 
  @session_start();


   if(isset($_SESSION['SESSION_USER'])){

     if(isset($_POST)){
         
  
         
         $id = $_SESSION['SESSION_USER']['id'];

        
         require_once '../../class/Conn.class.php';
         require_once '../../class/User.class.php';
         require_once '../../class/Logs.class.php';
         require_once '../../class/Whatsapi.class.php';
         
         $user       = new User();
         $whatsapi   = new Whatsapi();
         $logs       = new Logs();
         $dados_user = $user->dados($id);
         
  
      if(isset($_POST['confirm'])){
         
         if($dados_user->verificadomail == 0){
            
           if (filter_var($dados_user->email, FILTER_VALIDATE_EMAIL)) {
                

                $template = file_get_contents('<?=SET_URL_PRODUCTION?>/template_mail/template_2/index.html');                                
                
                $code = rand(1000,99999);
                $_SESSION['code_email'] = $code;
                
                $arry_nums = str_split($code);
                
                $codigos_html = "";
                
                foreach($arry_nums as $value){
                    $codigos_html .= "<span class=\"num\" >{$value}</span>";
                }
    
                $html_final = str_replace('{name}',explode(' ',$dados_user->nome)[0],str_replace('{codigo}',$codigos_html,$template));
                
                $to = $dados_user->email;
                $subject = "Confirme seu email com a Gestor Lite";
                $from = 'contact@gestorlite.com';
                 
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                 
                $headers .= "From: Gestor Lite <{$from}> \r\n".
                    'Reply-To: '.$from."\r\n" .
                    'X-Mailer: PHP/' . phpversion();
                    
               if( mail($to, $subject, $html_final, $headers) ){
                     echo json_encode(['erro' => false, 'msg' => 'Código enviado. Se digitou o email errado, clique em corrigir.']);
                     die;
               }
               
             
                
            }else{
                echo json_encode(['erro' => true, 'msg' => 'Email inválido']);
                die;
            }
            
        }else{
            echo json_encode(['erro' => true, 'msg' => 'Você já confirmou seu Email.']);
            die;
        }
           
           
      }else if(isset($_POST['check'])){
          
          if(isset($_POST['code'])){
              
              if(is_numeric($_POST['code'])){
                  
                  $code_session = $_SESSION['code_email'];
                  
                  if(trim($_POST['code']) == $code_session){
                      
                      $confirm = $user->confirm_contact('verificadomail',$dados_user->id);
                      
                      if($confirm){
                          echo json_encode(['erro' => false, 'msg' => 'Seu email foi confirmado.']);
                          die;
                      }else{
                         echo json_encode(['erro' => true, 'msg' => 'Desculpe, no momento não foi possivel confirmar seu email. Entre em contato com o suporte.']);
                         die; 
                      }
                      
                  }else{
                      echo json_encode(['erro' => true, 'msg' => 'Código de confirmação inválido']);
                      die;
                  }
                  
                  
              }else{
                  echo json_encode(['erro' => true, 'msg' => 'Código de confirmação inválido']);
                  die;
              }
              
          }else{
              echo json_encode(['erro' => true, 'msg' => 'Código de confirmação inválido']);
              die;
          }
          
      }
  
         
     }
     
 }


?>