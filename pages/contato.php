<?php

    if(isset($_GET['wpp'])){

     $fone = "16058469318";
     $text = isset($_GET['text']) ? $_GET['text'] : "";
    
     echo '<script>location.href="https://api.whatsapp.com/send?phone='.$fone.'&text='.$text.'";</script>';
      die;
    }





	require_once 'class/Conn.class.php';
	
    date_default_timezone_set('America/Sao_Paulo');


?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Gestor Lite - Contato</title>
	<meta charset="UTF-8">

	<meta name="keywords" content="faq, suporte gestor, gestor lite, iptv gestor, gerenciamento de clientes,emissor de cobranças, whatsapi, cobrar clientes, automatico,emitir cobranças,controle financeiro,financeiro,planilha excel">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Gestor Lite - Contato - Suporte">
    <meta name="robots" content="">
    <meta name="revisit-after" content="1 day">
    <meta name="language" content="Portuguese">
    <meta name="generator" content="N/A">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="author" content="Script Mundo">
    
	<!-- Favicon -->
	<link href="img/favicon.ico" rel="shortcut icon"/>

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,500,500i,600,600i,700,700i" rel="stylesheet">


	<!-- Stylesheets -->
	<link rel="stylesheet" href="css/bootstrap.min.css"/>
	<link rel="stylesheet" href="css/font-awesome.min.css"/>
	<link rel="stylesheet" href="css/flaticon.css"/>
	<link rel="stylesheet" href="css/owl.carousel.min.css"/>
	<link rel="stylesheet" href="css/animate.css"/>
	<link rel="stylesheet" href="css/style.css"/>


	<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	
	  <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-161698646-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'UA-161698646-1');
    </script>

</head>
<body>
	<!-- Page Preloder -->
	<div id="preloder">
		<div class="loader"></div>
	</div>

	<!-- Header section -->
	<header class="header-section">
		<a href="" class="site-logo"><img width="100" src="./img/logo.png" alt=""></a>
		<div class="nav-switch">
			<i class="fa fa-bars"></i>
		</div>
		<div class="nav-warp">
			<div class="user-panel">
				<a href="login">Entrar</a> /
				<a href="login/create">Registrar</a>
			</div>
			<ul class="main-menu">
				<li ><a class="text-primary" href="<?=SET_URL_PRODUCTION?>/contato">Contato</a></li>
				<li><a class="text-primary" href="<?=SET_URL_PRODUCTION?>/faq">FAQ</a></li>
				<li><a class="text-primary" target="_blank" href="https://kb.gestorlite.com">Base de conhecimento</a></li>
			</ul>
		</div>
	</header>
	<!-- Header section end -->

	
	<!-- contato section -->
	<section class="section spad"  >
		<div class="container">
			<div class="section-title">
				<p>Gestor lite</p>
				<h3>Entre em contato conosco</h3>
				<h5>0800 000 0270</h5>
			</div>
			<div class="row">
			    <div class="col-md-12 text-center" >
			        <p id="response_msg" ></p>
			    </div>
                <div class="form-group col-md-6" >
                    <input type="text" placeholder="Seu nome *" value="" id="nome_contato" class="form-control" />
                </div>
                <div class="form-group col-md-6" >
                    <input type="email" placeholder="Seu email *" value="" id="email_contato" class="form-control" />
                </div>
                <div class="form-group col-md-6" >
                    <input type="text" placeholder="Assunto *" value="" id="assunto_contato" class="form-control" />
                </div>
                <div class="form-group col-md-1" >
                        
                 <div class="btn-group">
    				<button id="dropDownDDI" id="btn_drop_ddi" type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    					<img src="<?=SET_URL_PRODUCTION?>/img/country/br.png" /> +55
    				</button>
    				<div class="dropdown-menu">
    					<a style="cursor:pointer;" onclick="mudaDDI('55','br')" class="dropdown-item"><img src="<?=SET_URL_PRODUCTION?>/img/country/br.png" /> +55</a>
    					<a style="cursor:pointer;" onclick="mudaDDI('351','pt');" class="dropdown-item" ><img src="<?=SET_URL_PRODUCTION?>/img/country/pt.png" /> +351</a>
    					<a style="cursor:pointer;" onclick="mudaDDI('1','usa');" class="dropdown-item" ><img src="<?=SET_URL_PRODUCTION?>/img/country/usa.png" /> +1</a>
    					<a style="cursor:pointer;" onclick="mudaDDI('49','ger');" class="dropdown-item"><img src="<?=SET_URL_PRODUCTION?>/img/country/ger.png" /> +49</a>
    					<a style="cursor:pointer;" onclick="mudaDDI('54','arg');" class="dropdown-item" ><img src="<?=SET_URL_PRODUCTION?>/img/country/arg.png" /> +54</a>
    					<a style="cursor:pointer;" onclick="mudaDDI('598','uru');" class="dropdown-item"><img src="<?=SET_URL_PRODUCTION?>/img/country/uru.png" /> +598</a>
    					<a style="cursor:pointer;" onclick="mudaDDI('44','gbr');" class="dropdown-item"><img src="<?=SET_URL_PRODUCTION?>/img/country/gbr.png" /> +44</a>
    					<a style="cursor:pointer;" onclick="mudaDDI('34','esp');" class="dropdown-item"><img src="<?=SET_URL_PRODUCTION?>/img/country/esp.png" /> +34</a>
    					<a style="cursor:pointer;" onclick="mudaDDI('1','can');" class="dropdown-item" ><img src="<?=SET_URL_PRODUCTION?>/img/country/can.png" /> +1</a>
    					<a style="cursor:pointer;" onclick="mudaDDI('57','col');" class="dropdown-item" ><img src="<?=SET_URL_PRODUCTION?>/img/country/col.png" /> +57</a>
    				</div>
    			</div>
    		     <input type="hidden" value="55" id="ddi_contato" />
                     
                </div>
                <div class="form-group col-md-5" >
                    <input type="text" placeholder="Whatsapp *" value="" id="whatsapp_contato" class="form-control" />
                </div>
                 <div class="form-group col-md-6" >
                    <select class="form-control" id="cliente_gestor" name="cliente_gestor" >
                        <option value="1" >Sou cliente gestor</option>
                        <option value="0" >Não sou cliente gestor</option>
                    </select>
                </div>
                <div class="form-group col-md-6" >
                    <input style="cursor:no-drop;" type="text" disabled value="<?= date('d/m/Y'); ?>" class="form-control" />
                </div>
                <div class="form-group col-md-12" >
                     <textarea class="form-control" placeholder="Descreva sua dúvida, sugestão ou critica... *" id="msg_contato" name="msg_contato" ></textarea>
                </div>
                 <div class="form-group col-md-12" >
                     <button onclick="send_form();" style="width:100%!important;" id="btn_send_contato" class="btn btn-lg btn-outline-primary" >Enviar <i class="fa fa-send" ></i></button>
                </div>
			</div>
		</div>
	</section>
	<!-- contato section end -->
	

	<!-- Footer top section -->
	<section class="footer-top-section text-white spad">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<div class="footer-widget about-widget">
						<img width="200" src="./img/logo.png" alt="logo">
						<p>No ano de 2019 a Script Mundo lançou o painel Gestor, e devido ao grande sucesso, decidimos abrir novos horizontes lançando o Gestor Lite. O painel Gestor Lite diferente do gestor não há necessidades de possuir uma hospedagem para usa-lo, e além de tudo o WhatsAPI é incluso em qualquer pacote.</p>
					</div>
				</div>
				<div class="col-lg-2 col-md-3">
					<div class="footer-widget">
						<h4 class="fw-title">Links úteis</h4>
						<div class="row">
							<div class="col-sm-12">
								<ul>
									<li><a href="https://scriptmundo.com" target="_blank" >Script Mundo</a></li>
									<li><a href="https://siteiptv.com" target="_blank" >Painel Gestor</a></li>
									<li><a href="<?=SET_URL_PRODUCTION?>" target="_blank" >Gestor Lite</a></li>
									<li><a href="<?=SET_URL_PRODUCTION?>/termos/termos-gestor.pdf" target="_blank" >Termos de uso</a></li>
									<li><a href="<?=SET_URL_PRODUCTION?>/faq?contato" target="_blank" >Contato</a></li>
								</ul>
							</div>

						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-3">
					<div class="footer-widget about-widget">
						<img width="200" src="painel/img/ferramenta-scriptmundo_dark_on.png" alt="logo">
						<p>Script Mundo, fundada em 2016 vem forte no mercado de desenvolvimento de softwares e sistemas. Nosso principal objetivo é ser referência nesta área da tecnologia.
Estamos localizados no Paraná desde a fundação. </p>
						<div class="fw-social social">
							<a href="https://facebook.com/scriptmundo.oficial" target="_blank" ><i class="fa fa-facebook"></i></a>
							<a href="https://twitter.com/scriptmundo" target="_blank" ><i class="fa fa-twitter"></i></a>
							<a href="https://github.com/luannsr12" target="_blank" ><i class="fa fa-github"></i></a>
							<a href="https://instagram.com/scriptmundo" target="_blank" ><i class="fa fa-instagram"></i></a>
							<a href="https://youtube.com/scriptmundo" target="_blank" ><i class="fa fa-youtube-play"></i></a>
							<a href="<?=SET_URL_PRODUCTION?>/faq?wpp&text=" target="_blank" ><i class="fa fa-whatsapp"></i></a>
						</div>

					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Footer top section end -->


	<!-- Footer section -->
	<footer class="footer-section">
		<div class="container">
			<ul class="footer-menu">
				<li><a href="login" >Entrar</a></li>
				<li><a href="login/create" >Criar conta</a></li>
				<li><a href="<?=SET_URL_PRODUCTION?>/faq?contato" >Contato</a></li>
			</ul>
			<div class="copyright">
                Copyright &copy;<script>document.write(new Date().getFullYear());</script> Todos os direitos reservados | Uma ferramenta de <a href="https://scriptmundo.com" target="_blank">Script Mundo</a>
                </div>
		</div>
	</footer>
	<!-- Footer top section end -->

	<!--====== Javascripts & Jquery ======-->
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/popper.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<script src="js/circle-progress.min.js"></script>
	<script src="js/jquery.mask.js"></script>
	<script src="js/main.js"></script>
	<script type="text/javascript" src="https://use.fontawesome.com/fc727a7e55.js"></script>
    <script>
            $( document ).ready(function() {
        
             var SPMaskBehavior = function (val) {
              return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
            },
            spOptions = {
              onKeyPress: function(val, e, field, options) {
                  field.mask(SPMaskBehavior.apply({}, arguments), options);
                }
            };
        
            $('#whatsapp_contato').mask(SPMaskBehavior, spOptions);
        
         });
 
    
    function send_form(){
        
        $("#btn_send_contato").prop('disabled', true);
        $("#btn_send_contato").html('Aguarde <i class="fa fa-spinner fa-spin"></i>');
        
        var dados_contato = new Object();
        dados_contato.nome = $("#nome_contato").val();
        dados_contato.email = $("#email_contato").val();
        dados_contato.assunto = $("#assunto_contato").val();
        dados_contato.ddi = $("#ddi_contato").val();
        dados_contato.whatsapp = $("#whatsapp_contato").val();
        dados_contato.cliente = $("#cliente_gestor").val();
        dados_contato.msg = $("#msg_contato").val();
        
        if(dados_contato.nome != "" && dados_contato.email != "" && dados_contato.assunto != "" && dados_contato.ddi != "" && dados_contato.whatsapp != "" && dados_contato.cliente != "" && dados_contato.msg != ""){
            
            var dados = JSON.stringify(dados_contato);
            
            $.post('pages/contato_controll.php',{dados:dados},function(data){
                var obj = JSON.parse(data);
                
                if(obj){
                    if(obj.erro){
                        $("#response_msg").removeClass('text-success');
                        $("#response_msg").addClass('text-danger');
                        $("#response_msg").html(obj.msg);
                        hide_msg();
                    }else{
                        $("#response_msg").removeClass('text-danger');
                        $("#response_msg").addClass('text-success');
                        $("#response_msg").html(obj.msg);
                        hide_msg();
                        zera_campos();
                    }
                }
                
            });
            
        }else{
            $("#response_msg").removeClass('text-success');
            $("#response_msg").addClass('text-danger');
            $("#response_msg").html('Por gentileza, preencha todos os campos!');
            hide_msg();
        }
        
       
    }
    
    function zera_campos(){
        $("#nome_contato").val('');
        $("#email_contato").val('');
        $("#assunto_contato").val('');
        $("#ddi_contato").val('55');
        $("#whatsapp_contato").val('');
        $("#cliente_gestor").val('0');
        $("#msg_contato").val('');
        $("#btn_drop_ddi").html('<img src="<?=SET_URL_PRODUCTION?>/img/country/br.png" /> +55');
    }
    
    function hide_msg(){
        setTimeout(function(){
            $("#response_msg").html('');
        },10000);
        
        $("#btn_send_contato").prop('disabled', false);
        $("#btn_send_contato").html('Enviar <i class="fa fa-send" ></i>');
        
    }
 
 
      function mudaDDI(ddi,country){

          $("#ddi_contato").val(ddi);
          $("#dropDownDDI").html('<img src="<?=SET_URL_PRODUCTION?>/img/country/'+country+'.png" /> +'+ddi);
      }
    </script>


	</body>
</html>
