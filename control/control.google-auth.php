<?php 

  @session_start();

  $json = new stdClass();
require_once "../config/settings.php";
  if(isset($_SESSION['SESSION_USER'])){

    if(isset($_POST['secret'])){
        
        $secret = trim($_POST['secret']);
        
        if(isset($_POST['cod_auth'])){
            
          $cod_auth = trim($_POST['cod_auth']); 
          
          include_once("../auth/lib/GoogleAuthenticator.php");
          require_once '../class/Conn.class.php';
          require_once '../class/User.class.php';
          
          $user_class = new User();
          $user_id = $_SESSION['SESSION_USER']['id'];
          
          $g = new GoogleAuthenticator();

         if(isset($_POST['insert'])){
             
             if ($g->checkCode($secret, $cod_auth)) {
                 

                if($user_class->update_GoogleAuth(1,$user_id, $secret)){
                    
                     echo json_encode(array(
                        'erro' => false,
                        'msg' => "Autenticação Válida e inserida em seu login"
                    ));
                    die;
                    
                }else{
                    echo json_encode(array(
                        'erro' => true,
                        'msg' => "Código Inválido"
                    ));
                    die;
                }

                }else{
                 echo json_encode(array(
                    'erro' => true,
                    'msg' => "Código Inválido"
                ));
                die;
             }
             
             
         }else if(isset($_POST['remove'])){
             
             if($user_class->update_GoogleAuth(0,$user_id, $secret)){
                
                 echo json_encode(array(
                    'erro' => false,
                    'msg' => "Autenticação removida de seu login"
                ));
                die;
                
            }else{
                echo json_encode(array(
                    'erro' => true,
                    'msg' => "Error"
                ));
                die;
            }
         }else if(isset($_POST['valid'])){
             if(isset($_SESSION['SESSION_USER']['google_auth_code'])){
                 $secret = trim($_SESSION['SESSION_USER']['google_auth_code']);
                
                
                if ($g->checkCode($secret, $cod_auth)) {
                    
                    $_SESSION['AUTH_TWO_FACTOR'] = true;
                    
                    
                    echo json_encode(array(
                        'erro' => false,
                        'msg' => "Válido"
                    ));
                    die;  
                    
                }else{
                     echo json_encode(array(
                        'erro' => true,
                        'msg' => "Incorreto"
                    ));
                    die;  
                }
                
             }else{
               echo json_encode(array(
                    'erro' => true,
                        'msg' => "Faça Login"
                ));
                die;   
             }
         }


        }else{
            echo json_encode(array(
                'erro' => true,
                'msg' => "Cod is required"
            ));
            die;
        }
        
    }else{
        echo json_encode(array(
            'erro' => true,
            'msg' => "Secret is required"
        ));
        die;
    }


  }