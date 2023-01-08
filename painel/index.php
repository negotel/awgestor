<?php
include_once "../config/settings.php";
    $explo_url[0] = false;

   if(isset($_GET['url'])){
       $explo_url = explode('/',$_GET['url']);
   }


    // __autoload
    require_once 'autoload.php';
    
     $user_class_process = new User();

   
    if($explo_url[0] != "payment_notification"){
        require_once 'inc/security.php';
        require_once 'inc/processo.php';
    }
   
    


   if(isset($_GET['url'])){
       
       
       if($explo_url[0] != "payment_notification"){
       

         if(is_file('pages/'.$_GET['url'].'.php')){
           // arquivo existe , acessar
           include_once 'pages/'.$_GET['url'].'.php';
    
         }else{
           // arquivo não existe, 404
           include_once 'pages/404.php';
    
         }
         
      }else{
          include_once 'payment_notification.php';
      }

   }else{

      include_once 'pages/home.php';

   }





?>
