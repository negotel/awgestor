<?php

 @date_default_timezone_set('America/Sao_Paulo');
 @session_start();

 if(isset($_GET['ref'])){
   $_SESSION['ref'] = $_GET['ref'];
 }


 if(isset($_GET['url'])){

    $exurl = explode('/',$_GET['url'])[0];

    if(is_file('pages/'.$exurl.'.php')){


      $pagename = $exurl;

     if($pagename != "login" && $pagename != "mp_nt" && $pagename != "sair"){
      include_once 'inc/acess.php';
     }
     
    include_once 'pages/'.$exurl.'.php';
    
    }else{
      $pagename = '404';
      include_once 'pages/404.php';

    }

 }else{
   $pagename = 'home';
   include_once 'pages/home.php';
 }


?>
