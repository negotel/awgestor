<?php 

 @session_start();

 $captcha = true;
 $chave   = "6Le3c7EZAAAAAJ_gWq-n5i56QQJRCS2j5SJFeePK";
 
 
     if($captcha){
    
            if(isset($_POST['recaptcha'])){
                
                if($_POST['recaptcha'] != ""){
            
                    $ch = curl_init();
                
                    curl_setopt_array($ch, [
                        CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify',
                        CURLOPT_POST => true,
                        CURLOPT_POSTFIELDS => [
                            'secret' => $chave,
                            'response' => $_POST['recaptcha'],
                            'remoteip' => $_SERVER['REMOTE_ADDR']
                        ],
                        CURLOPT_RETURNTRANSFER => true
                    ]);
                
                    $output = curl_exec($ch);
                    curl_close($ch);
                
                    $json = json_decode($output);
                    
                    if($json->success) {
                        echo json_encode(["erro" => false, "success" => true, "msg" => "reCAPTCHA verificado"]);
                        $_SESSION['recaptcha'] = true;
                    }else{
                        echo json_encode(["erro" => false, "success" => false, "msg" => "<i class='fa fa-close' ></i> Complete o reCAPTCHA para continuar"]);
                        $_SESSION['recaptcha'] = false;
                    }
                    
                }else{
                    echo json_encode(["erro" => false, "success" => false, "msg" => "<i class='fa fa-close' ></i> Complete o reCAPTCHA para continuar"]);
                    $_SESSION['recaptcha'] = false;
                }
            }else{
                echo json_encode(["erro" => false, "success" => false, "msg" => "<i class='fa fa-close' ></i> Complete o reCAPTCHA para continuar"]);
                $_SESSION['recaptcha'] = false;
            }

    }else{
        echo json_encode(["erro" => false, "msg" => "reCAPTCHA desabilitado"]);
    }



?>