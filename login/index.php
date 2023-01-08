<?php

 @date_default_timezone_set('America/Sao_Paulo');
 @session_start();


include_once "../config/settings.php";

 if(isset($_GET['url'])){

    if($_GET['url'] == "create"){

      include_once 'create.php';

    }else{
      include_once 'login.php';
    }

 }else{
     include_once 'login.php';

 }


?>
