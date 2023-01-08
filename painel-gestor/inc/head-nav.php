<?php

  $user_class_p = new User();
  $user  = $user_class_p->dados($_SESSION['SESSION_USER']['id']);
  $moeda = $user_class_p->getmoeda($user->moeda);

  if(isset($_SESSION['SESSION_CVD'])){
    $cvd  = $user_class_p->dados_cvd($_SESSION['SESSION_CVD']['id']);
  }




      $verificadozap  = $user->verificadozap;
      $verificadomail = $user->verificadomail;

     $li = "";

     if($verificadozap == 0){
         $li .= "<li><i class='fa fa-warning' ></i> Por favor, confirme seu número de <b>Whatsapp</b>. <b class='text-primary' style='cursor:pointer;' onclick=\"modal_check('whatsapp');\" >CLIQUE AQUI</b></li>";
     }

      if($verificadomail == 0){
         $li .= "<li><i class='fa fa-warning' ></i> Por favor, confirme seu endereço de <b>Email</b>. <b class='text-primary' style='cursor:pointer;' onclick=\"modal_check('email');\" >CLIQUE AQUI</b></li>";
     }





?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Painel :: Gestor Lite</title>


    <link rel="icon" href="img/favicon.png" type="image/png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css?v=<?=filemtime('css/bootstrap.min.css')?>" />
    <!-- themefy CSS -->
    <link rel="stylesheet" href="vendors/themefy_icon/themify-icons.css" />
    <!-- swiper slider CSS -->
    <link rel="stylesheet" href="vendors/swiper_slider/css/swiper.min.css" />
    <!-- select2 CSS -->
    <link rel="stylesheet" href="vendors/select2/css/select2.min.css" />
    <!-- select2 CSS -->
    <link rel="stylesheet" href="vendors/niceselect/css/nice-select.css" />
    <!-- owl carousel CSS -->
    <link rel="stylesheet" href="vendors/owl_carousel/css/owl.carousel.css" />
    <!-- gijgo css -->
    <link rel="stylesheet" href="vendors/gijgo/gijgo.min.css" />
    <!-- font awesome CSS -->
    <link rel="stylesheet" href="vendors/font_awesome/css/all.min.css" />
    <link rel="stylesheet" href="vendors/tagsinput/tagsinput.css" />
    <!-- datatable CSS -->
    <link rel="stylesheet" href="vendors/datatable/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="vendors/datatable/css/responsive.dataTables.min.css" />
    <link rel="stylesheet" href="vendors/datatable/css/buttons.dataTables.min.css" />
    <!-- text editor css -->
    <link rel="stylesheet" href="vendors/text_editor/summernote-bs4.css" />
    <!-- morris css -->
    <link rel="stylesheet" href="vendors/morris/morris.css">
    <!-- metarial icon css -->
    <link rel="stylesheet" href="vendors/material_icon/material-icons.css" />

    <link href="emojis/css/emoji.css" rel="stylesheet">


    <!-- menu css  -->
    <link rel="stylesheet" href="css/metisMenu.css">
    <!-- style CSS -->
    <link rel="stylesheet" href="css/style.css?v=<?=filemtime('css/style.css')?>" />
    <link rel="stylesheet" href="css/colors/default.css" id="colorSkinCSS">

     <!-- pagename -->
   <?php
    if(isset($_GET['url'])){
      echo '<meta id="pagename" name="pagename"  content="'.$_GET['url'].'" /> ';
    }else{
      echo '<meta id="pagename" name="pagename" content="home" /> ';
    }
     ?>


     <style>
         .sidebar #sidebar_menu li ul li a.active {
            color: #ffffff;
            background-color: #7922ff;
            padding: 10px!important;
            border-radius: 8px;
        }
     </style>

</head>
  <body class="crm_body_bg <?php if($dark == 1){ echo "bg-dark"; } ?>"  >


       <?php  if($verificadozap == 0 || $verificadomail == 0){ ?>

        <!--<div style="z-index: 9999;bottom: 0px;position: fixed;margin-bottom: 31px;" class="col-md-12 alert alert-warning" >-->
        <!--    <p style="font-size:13px;" >-->
        <!--        Para melhor experiência em nosso sistema, verifique seus dados:-->
        <!--    </p>-->
        <!--    <ul style="font-size:13px;">-->
        <!--        <?= $li; ?>-->
        <!--</div>-->

       <?php }  ?>


    <input type="hidden" id="moeda" value="<?= $moeda->simbolo; ?>" />
    
