<?php

 
 if(isset($_SESSION['ADMIN_LOGADO'])){
     echo '<script>location.href="index.php?page=home";</script>';
     die;
 }
 
 if( isset($_POST['user']) && isset($_POST['senha']) && isset($_POST['login']) ){
     $continue = true;
     
//     if (isset($_POST['g-recaptcha-response'])) {
//        $captcha_data = $_POST['g-recaptcha-response'];
//        $continue = true;
//
//        $resposta = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$KEYSECRET_RECAPTCHA."&response=".$captcha_data."&remoteip=".$_SERVER['REMOTE_ADDR']));
//
//        if($resposta->success){
//            $continue = true;
//        }else{
//
//             $continue = false;
//             $msg = "reCaptcha incorreto";
//        }
//
//
//    }else{
//        $continue = false;
//        $msg = "Complete o reCaptcha";
//    }
     
     
     if($continue){
     
         if($senha == $_POST['senha'] && $username == $_POST['user']){
             
             
             if(isset($_GET['sub_access'])){
              $_SESSION['SUB_ACCESS'] = true;   
             }
             
             
             $login = true;
             $_SESSION['ADMIN_LOGADO'] = true;
             echo '<script>location.href="index.php?page=home";</script>';
             die;
         }else{
             $login = false;
             $msg = "Login incorreto";
         }
         
     }else{
         $login = false;
     }
     
 }else{
     $login = false;
 }


?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8"/>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
	<title>Administrativo</title>
	<link href="css/style.css" rel="stylesheet"/>
	<script src="js/script.js"></script>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<link href="<?=SET_URL_PRODUCTION?>/img/favicon.ico" rel="shortcut icon" />

</head>
<body>
    
    <div class="container">
        
        <div class="logo">
            <img src="<?=SET_URL_PRODUCTION?>/img/logo.png" />
        </div>
        
        <div class="div-login" >
            
            <form action="" method="POST" >
                
                <div class="input" >
                    <center><input type="text" name="user" id="user" placeholder="Username" class="input_campo" /></center>
                </div>
                
                <div class="input" >
                    <center><input type="password" name="senha" id="senha" placeholder="Senha" class="input_campo" /></center>
                </div>
                
<!--                <div class="input" >-->
<!--                    <center><div class="g-recaptcha" data-sitekey="--><?//= $KEYSITE_RECAPTCHA; ?><!--"></div></center>-->
<!--                </div>-->
                
                 <div class="input" >
                     <center><input type="submit" name="login" id="login" value="Entrar" class="input_submit" /></center>
                </div>
                
                <p class="msg-erro">
                    <?php if($login == false){ ?>
                     <?= @$msg; ?>
                    <?php }?>
                </p>
                
            </form>
            
        </div>
        
    </div>
 
</body>
</html>