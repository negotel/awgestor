<?php
    require_once "../config/settings.php";
    require_once 'conf/conf.php';

 if(isset($_GET['page'])){
     if(is_file($_GET['page'].'.php')){
         include_once $_GET['page'].'.php';
     }else{
         include_once '404.php';
     }
 }else{
     include_once 'login.php';
 }



?>