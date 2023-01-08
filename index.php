<!--<html>-->
<!--    <head>-->
<!--        <title>Estamos em manutenção</title>-->
<!--        <style>-->
<!--            h3{-->
<!--                margin-top:100px;-->
<!--            }-->
<!--            *{-->
<!--                font-family:arial;-->
<!--            }-->
<!--        </style>-->
<!--    </head>-->
<!--    <body>-->
<!--        <center>-->
<!--            <h3>Estamos em manutençãos</h3>-->
<!--            <p>Todas as datas de expiração de nossos clientes serão restituidas assim que voltarmos.</p>-->
<!--        </center>-->
<!--    </body>-->
<!--</html>-->
<?php

 header("Access-Control-Allow-Origin: *");   
 @date_default_timezone_set('America/Sao_Paulo');
 session_start();


 include_once "./config/settings.php";


 if(isset($_GET['af'])){
   $_SESSION['afiliado'] = $_GET['af'];
 }
 
if(isset($_GET['ref'])){
   $_SESSION['af'] = $_GET['ref'];

}

 if(isset($_GET['url'])){

    $exurl = explode('/',$_GET['url']);


    if($exurl[0] == "pay") {

      include_once 'libs/pay.php';

    }else if($exurl[0] == "faq"){

      include_once 'pages/faq.php';
      
    }else if($exurl[0] == "contato"){

      include_once 'pages/contato.php';

    }else if($exurl[0] == "novogestor"){

      include_once 'pages/home1.php';

    }else if($exurl[0] == "home2"){

      include_once 'pages/home2.php';

    }else if($exurl[0] == "b2c"){

      include_once 'pages/b2c.php';

    }else{
        include_once 'pages/404.php';
    }



 }else{

   include_once 'pages/home.php';
 }


?>
