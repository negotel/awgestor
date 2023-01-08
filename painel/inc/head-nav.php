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
     
      
  if($_SESSION['SESSION_USER']['two_facto'] == 1 && !isset($_SESSION['AUTH_TWO_FACTOR'])){
      $auth_two = true;
  }else{
      $auth_two = false;
  }
  
  
?>


<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Gestor Lite">
    <meta name="generator" content="Gestor Lite">
    <title id="page-title" >Painel</title>

    <!-- Bootstrap core CSS -->
   <link href="css/bootstrap.min.css?v=<?=filemtime('css/bootstrap.min.css')?>" rel="stylesheet">
   <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.0.13/css/all.css'>
   <link href="css/icons/css/font-awesome.min.css" rel="stylesheet">
   
   <link href="css/novo-painel.css?v=<?=filemtime('css/novo-painel.css')?>" rel="stylesheet">
   
   <script async src="https://foxgo.com.br/social/pixel/d1x53tq89hfl7e633c13lr8w1k8v2sdz"></script>

       
   <link href="css/time-line.css" rel="stylesheet">
   
       <script id="navegg" type="text/javascript">
      (function(n,v,g){o="Navegg";if(!n[o]){
        a=v.createElement('script');a.src=g;b=document.getElementsByTagName('script')[0];
        b.parentNode.insertBefore(a,b);n[o]=n[o]||function(parms){
        n[o].q=n[o].q||[];n[o].q.push([this, parms])};}})
      (window, document, 'https://tag.navdmp.com/universal.min.js');
      window.naveggReady = window.naveggReady||[];
      window.nvg72904 = new Navegg({
        acc: 72904
      });
    </script>
       
   <!-- CSS Emojis -->
   <link href="emojis/css/emoji.css" rel="stylesheet">


    <link href="js/calc/css/sunny/jquery-ui-1.8.16.custom.css" rel="stylesheet">
    <link href="js/calc/mathquill/mathquill.css" rel="stylesheet">
       
    <!-- Favicons -->
    <meta name="theme-color" content="#563d7c">
    
    <link href="<?=SET_URL_PRODUCTION?>/img/favicon.ico" rel="shortcut icon" />

    
   <!-- pagename -->
   <?php
    if(isset($_GET['url'])){
      echo '<meta id="pagename" name="pagename"  content="'.$_GET['url'].'" /> ';
    }else{
      echo '<meta id="pagename" name="pagename" content="home" /> ';
    }
     ?>


    <style>
        #mceu_86{
            display:none !important;
        }
         #mceu_87{
         display:none !important;
        }
        .goog-te-banner-frame {
         display: none;
        }
        .nav-item {
            text-transform: uppercase;
        }
      .ui-widget-content{
          background-color: #6610f2 !important;
      }
      .ui-widget-header{
          background-color: #9d62fd !important;
      }
      .ui-dialog { z-index: 99999 !important ;}
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
      .alert-minimalist {
		background-color: rgb(241, 242, 240);
		border-color: rgba(149, 149, 149, 0.3);
		border-radius: 3px;
		color: rgb(149, 149, 149);
		padding: 10px;
	}
    
    	.alert-minimalist > [data-notify="icon"] {
    		height: 50px;
    		margin-right: 12px;
    	}
    	.alert-minimalist > [data-notify="title"] {
    		color: rgb(51, 51, 51);
    		display: block;
    		font-weight: bold;
    		font-size:12px;
    		margin-bottom: 5px;
    	}
    	.alert-minimalist > [data-notify="message"] {
    		font-size: 12px;
    	}
    	
       .sidebar-sticky::-webkit-scrollbar {
          width: 5px!important;
        }
        .sidebar-sticky{
            scrollbar-width:5px!important;;
        }
        
        
         .foxgo_ad{  
             width: 100%;
             height: 1000px;
             z-index: 9999999999999;
             position: absolute;
        }
        
        .bg-dark .auth_title,.auth_small{
            color:#000;
        }
        
    </style>
    <!-- Custom styles for this template -->
    <link href="css/dashboard.css" rel="stylesheet">
    
        
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-161698646-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'UA-161698646-1');
    </script>



  </head>
  <body <?php if($dark == 1){ echo "class='bg-dark'"; } ?> >
      
      <?php if($auth_two){ ?>
      <div style="height:100%;width:100%;position: fixed;background-color: rgb(114 25 225 / 98%);z-index: 999999;">
         <div style="z-index: 9999;position: fixed;margin-bottom: 31px;margin: 0 auto;width: 50%;margin-top: 16%;margin-left: 27%;background-color: #fff;" class="col-md-12 alert" >
            
            <div class="row text-center" >
                
                <div class="col-md-12">
                    <h3 class="auth_title" >Autenticação de 2 fatores</h3>
                </div>
                <div class="col-md-6">
                    <input maxlength="6" id="cod_valid" type="text" placeholder="Código de 6 digitos" class="form-control" />
                    <small class="auth_small" >Digite o código de segurança</small>
                </div>
                <div class="col-md-6">
                     <button id="btn_ValidTwoAuth" onclick="ValidTwoAuth();" style="width:100%;" class="btn btn-success" >Validar</button>
                </div>
                
            </div>
             
        </div>
     </div>
      <?php } ?>
      
            
       <?php  if($verificadozap == 0 || $verificadomail == 0){ ?>
       
        <!--<div style="z-index: 9999;bottom: 0px;position: fixed;margin-bottom: 31px;" class="col-md-12 alert alert-warning" >-->
        <!--    <p style="font-size:13px;" >-->
        <!--        Para melhor experiência em nosso sistema, verifique seus dados:-->
        <!--    </p>-->
        <!--    <ul style="font-size:13px;">-->
        <!--</div>-->
       
       <?php }  ?>
   
<!--      <div style="-->
<!--    position: fixed;-->
<!--    z-index: 99999;-->
<!--    text-align: center;-->
<!--    padding: 3px;-->
<!--    background-color: #7922ff;-->
<!--    width: 100%;-->
<!--    height: 21px;-->
<!--    font-size: 11px;-->
<!--">-->
<!--          <p>-->
<!--              Compre o código fonte da Gestor Lite <a target="_blank" style="color:#fff;" href="<?=SET_URL_PRODUCTION?>/sourcecode/" >  AQUI <i class="fa fa-external-link" ></i></a>-->
<!--          </p>-->
<!--      </div>-->
      
    <input type="hidden" id="moeda" value="<?= !empty($moeda->simbolo) ? $moeda->simbolo:null; ?>" />