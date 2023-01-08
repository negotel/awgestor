<?php 

    @session_start();
    

    if(!isset($_SESSION['AFILIADO'])){
        header('Location: <?=SET_URL_PRODUCTION?>/parceiro/login');
        exit();
    }

    if($_SESSION['AFILIADO']['parceiro'] == 0){
        header('Location: <?=SET_URL_PRODUCTION?>/parceiro/sair');
        exit();
    }


?>