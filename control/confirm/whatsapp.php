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
         
         if($dados_user->verificadozap == 0){
            
            $phone = $dados_user->ddi.str_replace('-','',str_replace(' ','',str_replace(')','',str_replace('(','',$dados_user->telefone))));
            
            if($phone>10){
                
                $device = "2f8cbc1b5b92ce32b422";
                $json   = file_get_contents("http://api-zapi.gestorlite.com:3000/check?device={$device}&num={$phone}");
                
                if(json_decode($json)){
                    
                    $dados = json_decode($json);
                    
                    if (json_last_error() === 0) {
                         
                        if($dados->exists->status == "200"){
                            if(isset($dados->exists->jid)){
                                
                                
                                $num  = explode("@",$dados->exists->jid)[0];
                                $code = rand(1000,99999);
                                $_SESSION['code_whatsapp'] = $code;
                                
                                $msg  = urlencode("Oi ".explode(' ',$dados_user->nome)[0]."! Tudo bem? 💜\n\nPara confirmar seu número do Whatsapp na Gestor Lite, utilize o código:\n\n*{$code}*");
                                $send = file_get_contents("http://api-zapi.gestorlite.com:3000/send?device={$device}&num={$num}&msg={$msg}");
                               
                               
                                echo json_encode(['erro' => false, 'msg' => 'Código enviado. Se digitou o número errado, clique em corrigir.']);
                                die;
                                
                                
                            }else{
                                echo json_encode(['erro' => true, 'msg' => 'Adicione um número de whatsapp válido.']);
                                die;
                            }
                        }else{
                            echo json_encode(['erro' => true, 'msg' => 'Seu número está inválido']);
                            die;
                        }
                         
                    }else{
                         echo json_encode(['erro' => true, 'msg' => 'Desculpe, entre em contato com nosso suporte.']);
                         die;
                    }
                                        
                }else{
                    echo json_encode(['erro' => true, 'msg' => 'Desculpe, entre em contato com nosso suporte.']);
                    die;
                }
                
            }else{
                echo json_encode(['erro' => true, 'msg' => 'Seu número está inválido']);
                die;
            }
            
        }else{
            echo json_encode(['erro' => true, 'msg' => 'Você já confirmou seu Whatsapp.']);
            die;
        }
           
           
      }else if(isset($_POST['check'])){
          
          if(isset($_POST['code'])){
              
              if(is_numeric($_POST['code'])){
                  
                  $code_session = $_SESSION['code_whatsapp'];
                  
                  if(trim($_POST['code']) == $code_session){
                      
                      $confirm = $user->confirm_contact('verificadozap',$dados_user->id);
                      
                      if($confirm){
                          echo json_encode(['erro' => false, 'msg' => 'Seu número foi confirmado.']);
                          die;
                      }else{
                         echo json_encode(['erro' => true, 'msg' => 'Desculpe, no momento não foi possivel confirmar seu whatsapp. Entre em contato com o suporte.']);
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