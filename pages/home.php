<?php

	require_once 'class/Conn.class.php';
	require_once 'class/Gestor.class.php';

	$gestor =new Gestor();
	$planos_g = $gestor->list_planos();
	
	$cobrancas = $gestor->num_cobrancas();
	$clientes = $gestor->num_clientes();
	
	
	$styleColorMes['01'] = "color: #ffffff;font-border: red; text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;";
	$styleColorMes['02'] = "color:#ff7527;";
	$styleColorMes['03'] = "";
	$styleColorMes['04'] = "color:#11caff;";
	$styleColorMes['05'] = "COLOR: #ffca11;";
	$styleColorMes['06'] = "color:#f5092c;";
	$styleColorMes['07'] = "COLOR: #ffca11;";
	$styleColorMes['08'] = "COLOR: #b37e0b;";
	$styleColorMes['09'] = "COLOR: #f5d609;";
	$styleColorMes['10'] = "COLOR: #f509da;";
	$styleColorMes['11'] = "COLOR: #0969f5;";
	$styleColorMes['12'] = "COLOR: #f5092c;";
	
	$smallTitle['01'] = '<y style="COLOR: #ffffff;font-border: red; text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;font-size: 10px;float: right;">#saúdeMental</y>';
	$smallTitle['02'] = '<y style="COLOR:#ff7527;font-family: \'montserrat\';font-size: 10px;float: right;">#adeusAlzheimer</y>';
	$smallTitle['03'] = '';
	$smallTitle['04'] = '<y style="color:#11caff;font-family: \'montserrat\';font-size: 10px;float: right;">#MundoMaisAzul<i style="color: #11caff!important;font-size: 11px!important;" class="fa fa-heart" ></i></y>';
	$smallTitle['05'] = '<y style="COLOR: #ffca11;font-family: \'montserrat\';font-size: 10px;float: right;">#trânsitoNãoSeBrinca</y>';
	$smallTitle['06'] = '<y style="color:#f5092c;font-size: 10px;float: right;">#doeSangue</y>';
	$smallTitle['07'] = '<y style="COLOR: #ffca11;font-family: \'montserrat\';font-size: 10px;float: right;">#adeusCâncer</y>';
	$smallTitle['08'] = '<y style="COLOR: #b37e0b;font-family: \'montserrat\';font-size: 10px;float: right;">#amamentação<i style="color: #b37e0b!important;font-size: 11px!important;" class="fa fa-heart" ></i></y>';
	$smallTitle['09'] = '<a href="https://www.cvv.org.br/chat/" target="_blank" ><y style="COLOR: #f5d609;font-family: \'montserrat\';font-size: 10px;float: right;">#prevençãoAoSuicídio</y></a>';
	$smallTitle['10'] = '<y style="COLOR: #f509da;font-family: \'montserrat\';font-size: 10px;float: right;">#outubroRosa</y>';
	$smallTitle['11'] = '<y style="COLOR: #0969f5;font-family: \'montserrat\';font-size: 10px;float: right;">#novembroAzul</y>';
	$smallTitle['12'] = '<y style="COLOR: #f5092c;font-family: \'montserrat\';font-size: 10px;float: right;">#prevençãoAIDS</y>';
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <title>Gestor Lite</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <meta name="keywords" content="chatbot whatsapp, gestor lite, iptv gestor, gerenciamento de clientes,gerenciador de clientes, emissor de cobranças, whatsapi, cobrar clientes, automatico,emitir cobranças,controle financeiro,financeiro,planilha excel">
    <meta name="description" content="Gestor lite - Gerenciamento facilitado de clientes">
    
    <meta name="author" content="Script Mundo">
    

    <link href="<?=SET_URL_PRODUCTION?>/img/favicon.ico" rel="shortcut icon" />
    
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:300,400,,500,600,700" rel="stylesheet">

    <link rel="stylesheet" href="<?=SET_URL_PRODUCTION?>/assets/css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="<?=SET_URL_PRODUCTION?>/assets/css/animate.css">
    
    <link rel="stylesheet" href="<?=SET_URL_PRODUCTION?>/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?=SET_URL_PRODUCTION?>/assets/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="<?=SET_URL_PRODUCTION?>/assets/css/magnific-popup.css">

    <link rel="stylesheet" href="<?=SET_URL_PRODUCTION?>/assets/css/aos.css">

    <link rel="stylesheet" href="<?=SET_URL_PRODUCTION?>/assets/css/ionicons.min.css">
    
    <link rel="stylesheet" href="<?=SET_URL_PRODUCTION?>/assets/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="<?=SET_URL_PRODUCTION?>/assets/css/jquery.timepicker.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
    
    <link rel="stylesheet" href="<?=SET_URL_PRODUCTION?>/assets/css/flaticon.css">
    <link rel="stylesheet" href="<?=SET_URL_PRODUCTION?>/assets/css/icomoon.css">
    <link rel="stylesheet" href="<?=SET_URL_PRODUCTION?>/assets/css/style.css">


    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-NTQZGRS');</script>
    <!-- End Google Tag Manager -->

    
    <style>
                
        .fa {
            font-size:30px !important; color:#fff !important;
        }
        .services:hover .fa{
          color:#6927ff !important;
        }
        
        .block-7 .fa{
            font-size:13px !important;
            color: #000 !important;
        }
        
        @media only screen and (max-width: 820px) {
           .one-third.js-fullheight.align-self-end.order-md-last.img-fluid{
                    margin-top: 188px;
                }
           }
           
          .icon_home{
             font-size: 20px!important;
             display:none;
          }
        .create_btn_home:hover .icon_home{
             display:block;
            
          }


        .iframe_compare::-webkit-scrollbar {
		 width: 5px!important;
		 height: 5px!important;
		}
		.iframe_compare::-webkit-scrollbar-thumb {
		 background: radial-gradient(circle, #8905fc 14%,#6927ff 76%)!important;
		 border-radius: 15px!important;
		}
		.iframe_compare::-webkit-scrollbar-thumb:hover{
		 background: linear-gradient(13deg, #6927ff 14%,#8905FC 64%)!important;
		}
		.iframe_compare::-webkit-scrollbar-track{
		 background: #ffffff!important;
		 border-radius: 10px!important;
		 box-shadow: inset 7px 10px 12px #f0f0f0!important;
		}
    
    </style>
    
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-161698646-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'UA-161698646-1');
    </script>

    <meta property="og:type" content="page">
    <meta property="og:url" content="<?=SET_URL_PRODUCTION?>/">
    <meta property="og:title" content="">
    <meta property="og:image" content="<?=SET_URL_PRODUCTION?>/img/logo.png">
    <meta property="og:description" content="Gestor lite - Gerenciamento facilitado de clientes">


  </head>
  <body>
      
      <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NTQZGRS"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

	  <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container">
	      <a class="navbar-brand" href="">
	          <img width="150" src="<?=SET_URL_PRODUCTION?>/img/logo.png" />
	      </a>
	      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="oi oi-menu"></span> Menu
	      </button>

	      <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav ml-auto">
	          <li class="nav-item"><a class="nav-link" href="#vantagens" >O que temos?</a></li>
	          <li class="nav-item"><a href="#prices" class="nav-link">Preços</a></li>
	          <li class="nav-item"><a href="<?=SET_URL_PRODUCTION?>/contato" class="nav-link">Contato</a></li>
	          <li class="nav-item cta"><a href="<?=SET_URL_PRODUCTION?>/login" class="nav-link"><span><i style="font-size: 16px!important;" class="fa fa-user"></i> Login</span></a></li>
	          <!--<li style="margin-left: 19px;" class="nav-item cta"><a href="tel:08000000270" class="nav-link"><span> <i style="font-size: 16px!important;" class="fa fa-phone"></i> 0800 000 0270</span></a></li>-->
	        </ul>
	      </div>
	    </div>
	  </nav>
    <!-- END nav -->

    <div class="hero-wrap js-fullheight">
      <div class="overlay"></div>
      <div class="container-fluid px-0">
      	<div class="row d-md-flex no-gutters slider-text align-items-center js-fullheight justify-content-end">
            <img class="one-third align-self-end order-md-last img-fluid" src="<?=SET_URL_PRODUCTION?>/img/GESTOR-LITE-HOME.png" alt="">
        <div style="margin-bottom: 136px;" class="one-forth d-flex align-items-center ftco-animate js-fullheight">
	        	<div class="text mt-5">
	        	    <p><a href="<?=SET_URL_PRODUCTION?>/login/create" class="create_btn_home btn btn-primary px-4 py-3">Criar conta Grátis  </a></p>
	            <h1 class="mb-3"><span style="COLOR: #6927ff;font-family: 'montserrat';" >Venha ser #gestor<y style="<?= $styleColorMes[date('m')];?> font-family: 'montserrat';" >lite</y><?= $smallTitle[date('m')]; ?></span></h1>
	            <p>
	             Faça cobranças, capte e gerencie clientes, tudo em apenas um lugar. Economize seu tempo com a gente.
                </p>
	            <!--<p><a href="<?=SET_URL_PRODUCTION?>/login/create" class="btn btn-primary px-4 py-3">Criar conta Grátis</a></p>-->
	          </div>
	        </div>
	    	</div>
      </div>
    </div>
    
   
    <section class="ftco-section services-section bg-light">
      <div class="container">
      	<div class="row justify-content-center mb-5 pb-3">
          <div class="col-md-7 text-center heading-section ftco-animate">
            <h3 class="mb-4">Veja o que podemos fazer por você</h3>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services d-flex align-items-center">
            	<div class="icon d-flex align-items-center justify-content-center order-md-last">
            	  <i class="fa fa-users" ></i>
            	</div>
              <div class="media-body pl-4 pl-md-0 pr-md-4 text-md-right">
                <h3 class="heading">Cadastre seus clientes</h3>
                <p class="mb-0">Faça uma lista completa de seus clientes, o ordene conforme seu vencimento.</p>
              </div>
            </div>      
          </div>
          <div class="col-md-6 d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services d-flex align-items-center">
            	<div class="icon d-flex align-items-center justify-content-center">
            		<i class="fa fa-whatsapp" ></i>
            	</div>
              <div class="media-body pl-4">
                <h3 class="heading">Cobrança por whatsapp</h3>
                <p class="mb-0">Seu cliente recebe todo mês a cobrança que você definir em seu painel, você determina a data que será enviada..</p>
              </div>
            </div>    
          </div>
          <div class="col-md-6 d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services d-flex align-items-center">
            	<div class="icon d-flex align-items-center justify-content-center order-md-last">
            		<i class="fa fa-line-chart"></i>
            	</div>
              <div class="media-body pl-4 pl-md-0 pr-md-4 text-md-right">
                <h3 class="heading">Controle financeiro</h3>
                <p>Não se perca mais para ter seu controle financeiro, esqueça planilhas antigas de excel, aqui é tudo mais simples.</p>
              </div>
            </div>      
          </div>
					<div class="col-md-6 d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services d-flex align-items-center">
            	<div class="icon d-flex align-items-center justify-content-center">
            		<i class="fa fa-user"></i>
            	</div>
              <div class="media-body pl-4">
                <h3 class="heading">Área de clientes</h3>
                <p>Ofereça para seus clientes uma área do cliente exclusiva do seu negócio. Aumente sua credibilidade e ofereça uma ótima experiencia para seu cliente.</p>
              </div>
            </div>      
          </div>
          <div class="col-md-6 d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services d-flex align-items-center">
            	<div class="icon d-flex align-items-center justify-content-center order-md-last">
            		<i class="fa fa-download"></i>
            	</div>
              <div class="media-body pl-4 pl-md-0 pr-md-4 text-md-right">
                <h3 class="heading">Exporte os dados</h3>
                <p>Faça download dos dados de seu painel, seus clientes, logs, mensagens enviadas por whatsapp etc...</p>
              </div>
            </div>    
          </div>
          <div class="col-md-6 d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services d-flex align-items-center">
            	<div class="icon d-flex align-items-center justify-content-center">
            		<i class="fa fa-link"></i>
            	</div>
              <div class="media-body pl-4">
                <h3 class="heading">Link de pagamento</h3>
                <p>Envie um link de pagamento para seu cliente ou divulgue sua campanha de marketing. Ofereça seus metodos de pagamentos personalizados em apenas um lugar.</p>
              </div>
            </div>      
          </div>
          <div class="col-md-6 d-flex align-self-stretch ftco-animate fadeInUp ftco-animated">
            <div class="media block-6 services d-flex align-items-center">
                <div class="icon d-flex align-items-center justify-content-center order-md-last">
                    <span class="flaticon-customer-service"></span>
                </div>
                <div class="media-body pl-4 pl-md-0 pr-md-4 text-md-right">
                    <h3 class="heading">Suporte Remoto</h3>
                    <p>
                        Agende gratuitamente o suporte remoto de um de nossos técnicos a qualquer hora do dia.
                    </p>
                </div>
            </div>
         </div>
         <div class="col-md-6 d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services d-flex align-items-center">
            	<div class="icon d-flex align-items-center justify-content-center">
            		<span class="flaticon-life-insurance"></span>
            	</div>
              <div class="media-body pl-4">
                <h3 class="heading">Satisfação Garantida</h3>
                 <p>
                        Nós te oferecemos uma semana grátis para testar nosso painel, assim lhe oferecendo uma enorme satisfação.
                    </p>
              </div>
            </div>      
          </div>

        </div>
      </div>
    </section>

    <section class="ftco-section ftco-counter img" id="section-counter">
    	<div class="container">
    		<div class="row justify-content-center mb-5">
          <div class="col-md-7 text-center heading-section heading-section-white ftco-animate">
            <span class="subheading">Mais de <?= substr($cobrancas->num,0,-3); ?> mil cobranças enviadas</span>
          </div>
        </div>
    		<div class="row justify-content-center">
    			<div class="col-md-10">
		    		<div class="row">
		          <div class="col-md-6 d-flex justify-content-center counter-wrap ftco-animate">
		            <div class="block-18 text-center">
		              <div class="text">
		                <strong class="number" data-number="<?= $clientes; ?>">0</strong>
		                <span>Clientes</span>
		              </div>
		            </div>
		          </div>
		          <div class="col-md-6 d-flex justify-content-center counter-wrap ftco-animate">
		            <div class="block-18 text-center">
		              <div class="text">
		                <strong class="number" data-number="<?= $cobrancas->num; ?>"><?= substr($cobrancas->num,0,-3).'000'; ?></strong>
		                <span>Cobranças Emitidas</span>
		              </div>
		            </div>
		          </div>
		         
		        </div>
	        </div>
        </div>
    	</div>
    </section>

    <!--<section style="margin-top:50px;" class="ftco-section ftco-no-pt ftc-no-pb" id="">-->
    <!--	<div class="container">-->
    <!--		<div class="row justify-content-center mb-5">-->
    <!--          <div class="col-md-7 text-center heading-section heading-section-white ftco-animate">-->
    <!--              <div class="col-md-12 text-center heading-section ftco-animate">-->
    <!--                <h3>Movimentações B2C</h3>-->
    <!--                <h2 id="valor_b2c" style="color:#6927ff;" >R$ </h2>-->
    <!--                <p style="color:#000;" >-->
    <!--                  Facilitamos a vida de diversos empreendedores, agilizando o processo de recebimento online.-->
    <!--                </p>-->
    <!--              </div>-->
                 
    <!--          </div>-->
    <!--       </div>-->
    <!--	</div>-->
    <!--</section>-->


    <section class="ftco-section ftco-no-pt ftc-no-pb">
    	<div class="container">
    		<div class="row">
    			<div class="col-lg-6 py-5">
    				<img src="<?=SET_URL_PRODUCTION?>/assets/images/site2.svg" class="img-fluid" alt="">
    				<div class="heading-section ftco-animate mt-5">
	            <h2 class="mb-4">Integrado com gateways de pagamentos</h2>
	            <p>
	                O painel Gestor Lite, é integrado com as melhores gateways de pagamentos. Possibilitando que seu cliente, através do seu link faça o pagamento de forma rápida segura e simples. Você é notificado na mesma hora que seu cliente efetuar o pagamento.
	            </p>
	          </div>
    			</div>
    			<div class="col-lg-6 py-5">
    				<div class="row">
    					<div class="col-md-6 ftco-animate">
    						<div class="media block-6 services border text-center">
		            	<div class="icon d-flex align-items-center justify-content-center">
		            		<i class="fa fa-handshake-o"></i>
		            	</div>
		              <div class="mt-3 media-body media-body-2">
		                <h3 class="heading">Mercado Pago</h3>
		                <p>Integrado com mercado pago, receba notificações assim que algum cliente assinar seu plano </p>
		              </div>
		            </div>
    					</div>
    					<div class="col-md-6 ftco-animate">
    						<div class="media block-6 services border text-center">
		            	<div class="icon d-flex align-items-center justify-content-center">
		            		<i class="fa fa-qrcode"></i>
		            	</div>
		              <div class="mt-3 media-body media-body-2">
		                <h3 class="heading">Pic Pay</h3>
		                <p>Adicione seu PicPay e receba pagamentos de seus clientes em uma das melhores carteiras digitais. </p>
		              </div>
		            </div>
    					</div>
    					<div class="col-md-6 ftco-animate">
    						<div class="media block-6 services border text-center">
		            	<div class="icon d-flex align-items-center justify-content-center">
		            		<i class="fa fa-barcode" ></i>
		            	</div>
		              <div class="mt-3 media-body media-body-2">
		                <h3 class="heading">Pag Hiper</h3>
		                <p>De a possibilidade que seu cliente precisa para gerar segundas vias e boletos a vontade</p>
		              </div>
		            </div>
    					</div>
    					<div class="col-md-6 ftco-animate">
    						<div class="media block-6 services border text-center">
        		            	<div class="icon d-flex align-items-center justify-content-center">
        		            		<svg style="width:50" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                      <defs/>
                                      <g fill="#FFF" fill-rule="evenodd">
                                        <path d="M393.072 391.897c-20.082 0-38.969-7.81-53.176-22.02l-77.069-77.067c-5.375-5.375-14.773-5.395-20.17 0l-76.784 76.786c-14.209 14.207-33.095 22.019-53.179 22.019h-9.247l97.521 97.52c30.375 30.375 79.614 30.375 109.988 0l97.239-97.238h-15.123zm-105.049 74.327c-8.55 8.53-19.93 13.25-32.05 13.25h-.02c-12.12 0-23.522-4.721-32.05-13.25l-56.855-56.855c7.875-4.613 15.165-10.248 21.758-16.84l63.948-63.948 64.23 64.23c7.637 7.66 16.188 14.013 25.478 18.952l-54.439 54.46zM310.958 22.78c-30.374-30.374-79.613-30.374-109.988 0l-97.52 97.52h9.247c20.082 0 38.97 7.834 53.178 22.02l76.784 76.785c5.57 5.592 14.622 5.57 20.17 0l77.069-77.068c14.207-14.187 33.094-22.02 53.176-22.02h15.123l-97.239-97.237zm6.028 96.346l-64.23 64.23-63.97-63.97c-6.593-6.592-13.86-12.206-21.736-16.818l56.853-56.877c17.69-17.645 46.476-17.668 64.121 0l54.44 54.461c-9.292 4.961-17.842 11.315-25.479 18.974h.001z"/>
                                        <path d="M489.149 200.97l-58.379-58.377h-37.706c-13.838 0-27.394 5.635-37.185 15.426l-77.068 77.069c-7.202 7.18-16.623 10.77-26.067 10.77-9.443 0-18.885-3.59-26.066-10.77l-76.785-76.785c-9.792-9.814-23.346-15.427-37.207-15.427h-31.81L22.78 200.97c-30.374 30.375-30.374 79.614 0 109.988l58.095 58.074 31.81.021c13.86 0 27.416-5.635 37.208-15.426l76.784-76.764c13.925-13.947 38.208-13.924 52.133-.02l77.068 77.066c9.791 9.792 23.346 15.405 37.185 15.405h37.706l58.379-58.356c30.374-30.374 30.374-79.613 0-109.988zm-362.19 129.724c-3.763 3.786-8.942 5.917-14.273 5.917H94.302l-48.59-48.564c-17.689-17.69-17.689-46.476 0-64.143L94.3 175.296h18.385c5.331 0 10.51 2.154 14.295 5.918l74.74 74.74-74.761 74.74zm339.257-42.647l-48.848 48.87h-24.305c-5.309 0-10.508-2.155-14.251-5.92l-75.023-75.043 75.023-75.023c3.743-3.764 8.942-5.918 14.252-5.918h24.304l48.847 48.891c8.573 8.551 13.273 19.93 13.273 32.05 0 12.141-4.7 23.52-13.273 32.093z"/>
                                      </g>
                                    </svg>
        		            	</div>
        		              <div class="mt-3 media-body media-body-2">
        		                <h3 class="heading">PIX</h3>
        		                <p>Receba 24 horas por dia 7 dias por semana através da sua chave pix.</p>
        		              </div>
        		            </div>
    					</div>
    				</div>
          </div>
    		</div>
    	</div>
    </section>
    
    <div  id="vantagens" style="margin-bottom:100px;"></div>
    
    <section class="ftco-section ftco-no-pt ftc-no-pb">
    	<div class="container">
    		<div class="row">
    		  	<div class="col-lg-6 py-5">
    				<img src="<?=SET_URL_PRODUCTION?>/assets/images/chatbot.jpg" class="img-fluid" alt="">
    				<div class="heading-section ftco-animate mt-5"></div>
    			</div>

    			<div class="col-lg-6 py-5">
    				 <h2 class="mb-4">Chat Bot integrado com todos seus clientes</h2>
    	            <p>
    	               Com a Gestor Lite, você terá um chatbot ligado 100% com sua base de clientes. <br />
    	               É possível interagir com seu cliente já sabendo de todos os dados dele até mesmo se ele já pagou ou não a última fatura. <br /><br />
    	               Podendo ter várias possibilidades de suporte agilizado, como por exemplo gerar uma segunda via através do chatbot. <br />
    	               Já funcionamos com <b>Whatsapp, Telegram, Messenger, Linkedin, Instagram, Twitter, Viber, Signal</b>
    	            </p>
    	            <div class="row text-center">
    	                <div class="col-md-3">
    	                    <i style="font-size:20px;margin-right:10px;color:#6927ff!important;" class="fa fa-whatsapp"></i><br /><span style="color:#6927ff;">Em operação</span>
    	                </div>
    	                <div class="col-md-3">
    	                    <i style="font-size:20px;margin-right:10px;color:#6927ff!important;" class="fa fa-instagram"></i><br /><span style="color:#6927ff;">Em operação</span>
    	                </div>
    	                <div class="col-md-3">
    	                    <i style="font-size:20px;margin-right:10px;color:#6927ff!important;" class="fa fa-telegram"></i><br /><span style="color:#6927ff;">Em operação</span>
    	                </div>
    	                 <div class="col-md-3">
    	                    <i style="font-size:20px;margin-right:10px;color:#6927ff!important;" class="fa fa-facebook-square"></i><br /><span style="color:#6927ff;">Em operação</span>
    	                </div>
    	                  
    	            </div>
                </div>

    		</div>
    	</div>
    </section>
    
      <section class="ftco-section ftco-no-pt ftc-no-pb">
    	<div class="container">
    		<div class="row">
    		 

    			<div class="col-lg-6 py-5">
    				 <h2 class="mb-4">Cobranças por whatsapp automática</h2>
    	            <p>
    	               Utilize seu whatsapp para enviar cobranças para seus clientes. Recupere clientes inadimplentes, envie campanhas no whatsapp. <br />
    	               Com o app mais usado do Brasil, você alavanca seu negócio até 100%.
    	            </p>
    	            <p>
    	                As vantagens para a empresa são inúmeras e para os clientes também, 
    	                pois a partir da cobrança pelo aplicativo, 
    	                eles têm mais tempo para pensar em uma resposta sem a surpresa ou constrangimento da cobrança.
    	            </p>
                </div>
                
                <div class="col-lg-6 py-5">
    				<img src="<?=SET_URL_PRODUCTION?>/img/ApiGlite.png" width="80%" class="img-fluid" alt="">
    				<div class="heading-section ftco-animate mt-5"></div>
    			</div>

    		</div>
    	</div>
    </section>
    
    <section class="ftco-section ftco-no-pt ftc-no-pb">
    	<div class="container">
    		<div class="row">
    		    
    		    <div class="col-lg-6 py-5">
    				<img src="<?=SET_URL_PRODUCTION?>/assets/images/notify-gestorlite.gif?v=2" width="80%" class="img-fluid" alt="">
    				<div class="heading-section ftco-animate mt-5"></div>
    			</div>
    		 

    			<div class="col-lg-6 py-5">
    				 <h2 class="mb-4">Notificações de conversão</h2>
    	            <p>
    	               Com nosso plugin de notificações de conversão,  suas taxas de vendas vão as alturas.
    	            </p>
    	            <p>
    	                Use nosso plugin e passe mais credibilidade para novos visitantes e futuros clientes.
    	            </p>
                </div>
                
               

    		</div>
    	</div>
    </section>


    
    <section class="ftco-section ftco-no-pt ftc-no-pb">
    	<div class="container">
    		<div class="row">

             
    			<div class="col-lg-6 py-5">
    				 <h2 class="mb-4">Personalize sua mensagem de cobrança.</h2>
    	            <p>
    	                A comunicação com cliente é o fator chave para um bom negócio e nós entendemos isso; é por isso que nós te entregamos a possibilidade interagir com seu cliente com a linguagem do seu negócio.
    	            </p>
                </div>
                
            	<div class="col-lg-6 py-5">
    				<img src="<?=SET_URL_PRODUCTION?>/img/person-mobile-website-gesorlite.png" class="img-fluid" alt="">
    				<div class="heading-section ftco-animate mt-5"></div>
    			</div>
    			
                
    		</div>
    	</div>
    </section>


  <section class="ftco-section ftco-no-pt ftc-no-pb">
    	<div class="container">
    		<div class="row">
    			
    
                
                <div class="col-lg-6 py-5">
    				<img src="<?=SET_URL_PRODUCTION?>/img/link-pay-gestorlite.png" class="img-fluid" alt="">
    				<div class="heading-section ftco-animate mt-5"> </div>
    			</div>
    			
    	 	 <div class="col-lg-6 py-5">
    				 <h2 class="mb-4">Utilize links de pagamentos</h2>
    	            <p>
    	               A tecnologia avança e nós também. A cada dia devemos nos reinventar e procurar soluções que atendam da melhor forma possível nossos clientes e clientes satisfeitos significa receita para seu estabelecimento. 
    	            </p>
    	            <p>
    	                É por isso que a Gestor Lite, oferece um link de pagamento para que você envie para clientes, por qualquer midia social. Um link que reune as melhoras formas de pagamentos que você definir em seu painel.
    	            </p>
                </div>
    			
    		</div>
    	</div>
    </section>
    
      <section class="ftco-section ftco-no-pt ftc-no-pb">
    	<div class="container">
    		<div class="row">
    		
    	
            
    			
    	   	 <div class="col-lg-6 py-5">
    				 <h2 class="mb-4">Gere tráfego para seu site</h2>
    	            <p>
    	               Em nossas ferramentas de marketing, você tem a possibilidade em gerar tráfego para seu website. <br />
    	               Deixe seu site no topo do google e saia na frente de seus concorrentes.
    	            </p>
    	            <p>
    	                 O Google determina os sites pela quantidade de acessos diários. Com nossa plataforma você pode ter até 1.000 acessos por dia.
    	                 E isso sem pagar nada a mais.
    	            </p>
                </div>
                
            	<div class="col-lg-6 py-5">
    				<img src="<?=SET_URL_PRODUCTION?>/img/trafego-website-gestorlite.png" class="img-fluid" alt="">
    				<div class="heading-section ftco-animate mt-5">
	            
	             </div>
    			</div>
                
    		</div>
    	</div>
    </section>

 <section class="ftco-section ftco-no-pt ftc-no-pb">
    	<div class="container">
    		<div class="row text-center">
    		    <div class="col-lg-12">
    		        <h3>
    		            Onde Gestor Lite foi notícia
    		        </h3>
    		    </div>
    		  	<div class="col-md-3 py-5">
    				<img title="Terra" src="<?=SET_URL_PRODUCTION?>/assets/images/news/terra.png" class="img-fluid" alt="">
    			</div>
    			<div class="col-md-3 py-5">
    				<img title="Portal Comunique-se" src="<?=SET_URL_PRODUCTION?>/assets/images/news/portal-comunique-se.png" class="img-fluid" alt="">
    			</div>
    			<div class="col-md-3 py-5">
    				<img title="Estadão" src="<?=SET_URL_PRODUCTION?>/assets/images/news/estadao.png" class="img-fluid" alt="">
    			</div>
    			<div class="col-md-3 py-5">
    				<img title="Mundo do Marketing" src="<?=SET_URL_PRODUCTION?>/assets/images/news/mk.png" class="img-fluid" alt="">
    			</div>

    		</div>
    	</div>
    </section>
    
    <!-- <section class="ftco-section ftco-no-pt ftc-no-pb">-->
    <!--	<div class="container">-->
    <!--		<div class="row text-center">-->
    <!--		    <div class="col-md-6">-->
    <!--		        <img width="100%" src="<?=SET_URL_PRODUCTION?>/img/post-terra-500x500.png" />-->
    <!--		    </div>-->
    <!--		    <div class="col-md-6">-->
    <!--		        <img width="100%" src="<?=SET_URL_PRODUCTION?>/img/mundo-marketing-post-500x500.png" />-->
    <!--		    </div>-->
    <!--		</div>-->
    <!--	</div>-->
    <!--</section>-->

    <section id="prices" class="ftco-section bg-light">
    	<div class="container">
    	<div class="row justify-content-center mb-5 pb-3">
          <div class="col-md-7 text-center heading-section ftco-animate">
            <h2 class="mb-4">Nossos planos</h2>
          </div>
        </div>
    	<div class="row d-flex">
     	<?php

				if($planos_g){

					while ($plano = $planos_g->fetch(PDO::FETCH_OBJ)) {
			?>

    		    
    		    
	        <div class="col-lg-4 col-md-6 ftco-animate">
	          <div class="block-7">
	            <div class="text-center">
		            <h2 class="heading"><?= $plano->nome; ?></h2>
		            <span class="price"><sup>R$</sup> <span class="number"><?= $plano->valor; ?><small class="per">/mês</small></span>
		            <span class="excerpt d-block">Ativação imediata</span>

		           	<p style="font-size:13px;"class="text-left" >
						<?= $plano->text; ?>
					</p>
		            <a href="<?=SET_URL_PRODUCTION?>/login/create" class="btn btn-primary d-block px-3 py-3 mb-4">Selecionar</a>
	            </div>
	          </div>
	        </div>
	        
	        <?php } } ?>
             <div class="col-md-12 text-center heading-section ftco-animate">
                <a href="#comparasion-price" class="btn btn-primary d-block px-3 py-3 mb-4">Compare</a>
              </div>
	      </div>
    	</div>
    </section>
    
    
    <section id="comparasion-price" class="ftco-section bg-light">
    	<div class="container">
    	<div class="row justify-content-center mb-5 pb-3">
          <div class="col-md-12 text-center heading-section ftco-animate">
            <h2 class="mb-4">Compare</h2>
          </div>
          <div class="row d-flex" style="width: 100%;">
              <div class="col-md-12" style="width: 100%;">
                  <iframe style="width: 100%!important;border: 0px;overflow-y: hidden;overflow-x: hidden;" class="iframe_compare" id="iframe-compare" src="<?=SET_URL_PRODUCTION?>/pages/compare.html?v=2" width="100%" height="700px" ></iframe>
              </div>
          </div>
        </div>
    	</div>
    </section>


    <section class="ftco-section testimony-section">
      <div class="container">
        <div class="row justify-content-center mb-5 pb-3">
          <div class="col-md-7 text-center heading-section ftco-animate">
            <span class="subheading"></span>
            <h2 class="mb-4">Veja quem já usa o Gestor</h2>
          </div>
        </div>
        <div class="row ftco-animate">
          <div class="col-md-12">
            <div class="carousel-testimony owl-carousel ftco-owl">
              <div class="item">
               
               <a target="_blank" href="https://www.youtube.com/watch?v=DqVsmJvca-0" >
                    
                <div class="testimony-wrap p-4 text-center">
                  <div class="user-img mb-4" style="background-image: url(<?=SET_URL_PRODUCTION?>/assets/images/videoplay.png)">
                    <span class="quote d-flex align-items-center justify-content-center">
                      <i class="fa fa-youtube"></i>
                    </span>
                  </div>
                  <div class="text">
                    <p class="name">Daniel</p>
                    <span class="position">Vendedor Info Produtos</span>
                  </div>
                </div>
               </a>
                
              </div>
              
              <div class="item">
                <a target="_blank" href="https://www.youtube.com/watch?v=kaEW9flOdHg" >
                    <div class="testimony-wrap p-4 text-center">
                      <div class="user-img mb-4" style="background-image: url(<?=SET_URL_PRODUCTION?>/assets/images/videoplay.png)">
                        <span class="quote d-flex align-items-center justify-content-center">
                           <i class="fa fa-youtube"></i>
                        </span>
                      </div>
                      <div class="text">
                        <p class="name">Beatriz</p>
                        <span class="position">Vendedora no Instagram</span>
                      </div>
                    </div>
                </a>
              </div>
              
               <div class="item">
                <a target="_blank" href="https://www.youtube.com/watch?v=fKX2nVXejps" >
                    <div class="testimony-wrap p-4 text-center">
                      <div class="user-img mb-4" style="background-image: url(<?=SET_URL_PRODUCTION?>/assets/images/videoplay.png)">
                        <span class="quote d-flex align-items-center justify-content-center">
                           <i class="fa fa-youtube"></i>
                        </span>
                      </div>
                      <div class="text">
                        <p class="name">Wisnaldo</p>
                        <span class="position">Vendedor Online</span>
                      </div>
                    </div>
                </a>
              </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section bg-light">
    	<div class="container">
    		<div class="row justify-content-center mb-5 pb-5">
    			<div class="col-md-7 text-center heading-section ftco-animate">
            <span class="subheading">Quer Mais ?</span>
            <h2 class="mb-4">Serviços</h2>
          </div>
    		</div>
    		<div class="row">
          <div class="col-md-12 nav-link-wrap mb-5 pb-md-5 pb-sm-1 ftco-animate">
            <div class="nav ftco-animate nav-pills justify-content-center text-center" id="v-pills-tab" role="tablist" aria-orientation="vertical">
              <a class="nav-link active" id="v-pills-nextgen-tab" data-toggle="pill" href="#v-pills-nextgen" role="tab" aria-controls="v-pills-nextgen" aria-selected="true">Base de conhecimento</a>

              <a class="nav-link" id="v-pills-performance-tab" data-toggle="pill" href="#v-pills-performance" role="tab" aria-controls="v-pills-performance" aria-selected="false">Marketing</a>

              <a class="nav-link" id="v-pills-effect-tab" data-toggle="pill" href="#v-pills-effect" role="tab" aria-controls="v-pills-effect" aria-selected="false">Análise Financeira</a>
            </div>
          </div>
          <div class="col-md-12 align-items-center ftco-animate">
            
            <div class="tab-content ftco-animate" id="v-pills-tabContent">

              <div class="tab-pane fade show active" id="v-pills-nextgen" role="tabpanel" aria-labelledby="v-pills-nextgen-tab">
              	<div class="d-md-flex">
	              	<div class="one-forth align-self-center">
	              		<img src="<?=SET_URL_PRODUCTION?>/assets/images/basedeconhecimento.svg" class="img-fluid" alt="">
	              	</div>
	              	<div class="one-half ml-md-5 align-self-center">
		                <h2 class="mb-4">Nossa Base de conhecimento</h2>
		              	<p>Além de suporte remoto e especializado 24 horas por dia, você tem acesso a nossa base de conhecimento, com tutoriais totalmente intuitivos com vídeos explicativos. Assim você não terá dúvidas para utilizar nosos painel.</p>
		                <p>E se sentir dúvidas, basta nos chamar no whatsapp, estaremos prontos para lhe atender.</p>
		                <p><a href="https://kb.gestorlite.com/" target="_blank" class="btn btn-primary py-3">Ver base de conhecimento</a></p>
		              </div>
	              </div>
              </div>

              <div class="tab-pane fade" id="v-pills-performance" role="tabpanel" aria-labelledby="v-pills-performance-tab">
                <div class="d-md-flex">
	              	<div class="one-forth order-last align-self-center">
	              		<img src="<?=SET_URL_PRODUCTION?>/assets/images/undraw_visual_data_b1wx.svg" class="img-fluid" alt="">
	              	</div>
	              	<div class="one-half order-first mr-md-5 align-self-center">
		                <h2 class="mb-4">Ferramentas de Marketings</h2>
		              	<p>Nosso painel possui ferramentas de marketing para alavancar suas vendas online e sair na frente de todo mundo. </p>
		                <p>Em breve teremos o plano com suporte especializado de marketing, aonde você, fala diretamente com nosso especialista que irá lhe ajudar como atingir seus objetivos.</p>
		                <p><a href="<?=SET_URL_PRODUCTION?>/login/create" class="btn btn-primary py-3">Criar conta grátis</a></p>
		              </div>
	              </div>
              </div>

              <div class="tab-pane fade" id="v-pills-effect" role="tabpanel" aria-labelledby="v-pills-effect-tab">
                <div class="d-md-flex">
	              	<div class="one-forth align-self-center">
	              		<img src="<?=SET_URL_PRODUCTION?>/assets/images/undraw_business_plan_5i9d.svg" class="img-fluid" alt="">
	              	</div>
	              	<div class="one-half ml-md-5 align-self-center">
		                <h2 class="mb-4">Análises financeiras</h2>
		              	<p>Além do controle financeiro, nós iremos te mostrar suas métricas de ganhos para o próximos 3 mesês.</p>
		                <p>Em seu painel financeiro nós calculamos sua média de ganhos analisamos e te informamos como está seu rendimento e mostramos uma futura projeção de ganhos, com gráficos simples de entender.</p>
		                <p><a href="<?=SET_URL_PRODUCTION?>/login/create" class="btn btn-primary py-3">Criar conta grátis</a></p>
		              </div>
	              </div>
              </div>
            </div>
          </div>
        </div>
    	</div>
    </section>

    <!--<section class="ftco-section bg-light">-->
    <!--  <div class="container">-->
    <!--    <div class="row justify-content-center mb-5 pb-3">-->
    <!--      <div class="col-md-7 text-center heading-section ftco-animate">-->
    <!--        <h2>Recent Blog</h2>-->
    <!--        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in</p>-->
    <!--      </div>-->
    <!--    </div>-->
    <!--    <div class="row">-->
    <!--      <div class="col-md-4 ftco-animate">-->
    <!--        <div class="blog-entry">-->
    <!--          <a href="blog-single.html" class="block-20" style="background-image: url('<?=SET_URL_PRODUCTION?>/assets/images/image_1.jpg');">-->
    <!--          </a>-->
    <!--          <div class="text d-flex py-4">-->
    <!--            <div class="meta mb-3">-->
    <!--              <div><a href="#">May 8, 2019</a></div>-->
    <!--              <div><a href="#">Admin</a></div>-->
    <!--              <div><a href="#" class="meta-chat"><span class="icon-chat"></span> 3</a></div>-->
    <!--            </div>-->
    <!--            <div class="desc pl-3">-->
	   <!--             <h3 class="heading"><a href="#">Even the all-powerful Pointing has no control about the blind texts</a></h3>-->
	   <!--           </div>-->
    <!--          </div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--      <div class="col-md-4 ftco-animate">-->
    <!--        <div class="blog-entry" data-aos-delay="100">-->
    <!--          <a href="blog-single.html" class="block-20" style="background-image: url('<?=SET_URL_PRODUCTION?>/assets/images/image_2.jpg');">-->
    <!--          </a>-->
    <!--          <div class="text d-flex py-4">-->
    <!--            <div class="meta mb-3">-->
    <!--              <div><a href="#">May 8, 2019</a></div>-->
    <!--              <div><a href="#">Admin</a></div>-->
    <!--              <div><a href="#" class="meta-chat"><span class="icon-chat"></span> 3</a></div>-->
    <!--            </div>-->
    <!--            <div class="desc pl-3">-->
	   <!--             <h3 class="heading"><a href="#">Even the all-powerful Pointing has no control about the blind texts</a></h3>-->
	   <!--           </div>-->
    <!--          </div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--      <div class="col-md-4 ftco-animate">-->
    <!--        <div class="blog-entry" data-aos-delay="200">-->
    <!--          <a href="blog-single.html" class="block-20" style="background-image: url('<?=SET_URL_PRODUCTION?>/assets/images/image_3.jpg');">-->
    <!--          </a>-->
    <!--          <div class="text d-flex py-4">-->
    <!--            <div class="meta mb-3">-->
    <!--              <div><a href="#">May 8, 2019</a></div>-->
    <!--              <div><a href="#">Admin</a></div>-->
    <!--              <div><a href="#" class="meta-chat"><span class="icon-chat"></span> 3</a></div>-->
    <!--            </div>-->
    <!--            <div class="desc pl-3">-->
	   <!--             <h3 class="heading"><a href="#">Even the all-powerful Pointing has no control about the blind texts</a></h3>-->
	   <!--           </div>-->
    <!--          </div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--    </div>-->
    <!--  </div>-->
    <!--</section>-->



    <footer class="ftco-footer ftco-bg-dark ftco-section">
      <div class="container">
      	<div class="row mb-5 pb-5 align-items-center d-flex">
      		<div class="col-md-6">
      			<div class="heading-section heading-section-white ftco-animate">
      				<span class="subheading">Pague menos pagando por um ano inteiro o plano Profissional do gestor lite.</span>
	            <h2 style="font-size: 30px;">Economize no pacote anual !</h2>
	          </div>
      		</div>
      		<div class="col-md-3 ftco-animate">
      			<div class="price">
      				<span class="subheading">Apenas</span>
      				<h3>R$300,00<span>/anual</span></h3>
      			</div>
      		</div>
      		<div class="col-md-3 ftco-animate">
      			<p class="mb-0"><a target="_blank" href="<?=SET_URL_PRODUCTION?>/faq?wpp&text=Gostaria%20de%20adquirir%20o%20plano%20de%201%20ano%20do%20gestor%20lite" class="btn btn-primary py-3 px-4">Contratar</a></p>
      		</div>
      	</div>
        <div class="row mb-5">
          <div class="col-md">
            <div class="ftco-footer-widget mb-4 bg-primary p-4">
              <h2 class="ftco-heading-2">Gestor Lite</h2>
              <p>Tenha controle financeiro, emita cobranças automáticas através do whatsapp e email. A eficácia de um painel pensado em você.</p>
              <ul class="ftco-footer-social list-unstyled mb-0">
                <li class="ftco-animate"><a target="_blank" href="https://www.youtube.com/channel/UCPJ7L33FkMayMW6EExnXCkw"><span class="icon-youtube"></span></a></li>
                <li class="ftco-animate"><a target="_blank" href="https://fb.me/gestorlite"><span class="icon-facebook"></span></a></li>
                <li class="ftco-animate"><a target="_blank" href="https://instagram.com/gestorlite/"><span class="icon-instagram"></span></a></li>
              </ul>
              <span style="color:#fff;font-size:20px;" >#gestorlite</span>
            </div>
          </div>
          <div class="col-md">
            <div class="ftco-footer-widget mb-4 ml-md-5">
              <h2 class="ftco-heading-2">Links úteis</h2>
              <ul class="list-unstyled">
                <li><a target="_blank" href="https://scriptmundo.com" class="py-2 d-block">Script Mundo</a></li>
                <li><a target="_blank" href="https://kb.gestorlite.com/" class="py-2 d-block">Base de conhecimento</a></li>
                <li><a target="_blank" href="<?=SET_URL_PRODUCTION?>/termos/termos-gestor.pdf" class="py-2 d-block">Termos de uso</a></li>
                <div id="reputation-ra"><script type="text/javascript" id="ra-embed-reputation" src="https://s3.amazonaws.com/raichu-beta/selos/bundle.js" data-id="dGtjV250d01zcWZQSlo1YTpzY3JpcHQtbXVuZG8=" data-target="reputation-ra" data-model="2"></script></div>
              </ul>
            </div>
          </div>
          <div class="col-md">
             <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Navegar</h2>
              <ul class="list-unstyled">
                <li><a href="<?=SET_URL_PRODUCTION?>/" class="py-2 d-block">Home</a></li>
                <li><a href="<?=SET_URL_PRODUCTION?>/login" class="py-2 d-block">Login</a></li>
                <li><a href="<?=SET_URL_PRODUCTION?>/login/create" class="py-2 d-block">Criar Conta</a></li>
                <li><a href="<?=SET_URL_PRODUCTION?>/faq" class="py-2 d-block">FAQ</a></li>
                <li><a href="<?=SET_URL_PRODUCTION?>/contato" class="py-2 d-block">Contato</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md">
            <div class="ftco-footer-widget mb-4">
            	<h2 class="ftco-heading-2">Office</h2>
            	<div class="block-23 mb-3">
	              <ul>
	                <li><a href="mailto:contact@gestorlite.com"><span class="icon icon-envelope"></span><span class="text">contact@gestorlite.com</span></a></li>
	              </ul>
	            </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">
            
            <p> Copyright &copy;<script>document.write(new Date().getFullYear());</script> Todos os direitos reservados | Uma ferramenta de <a href="" target="_blank">Script Mundo</a></p>
          </div>
        </div>
      </div>
    </footer>
    
  

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>

  <script>
      setInterval(function(){
          $.post('<?=SET_URL_PRODUCTION?>/b2c',function(data){
              $("#valor_b2c").html('R$ '+data);
          });
      },5000);
  </script>

  <script src="<?=SET_URL_PRODUCTION?>/assets/js/jquery.min.js"></script>
  <script src="<?=SET_URL_PRODUCTION?>/assets/js/jquery-migrate-3.0.1.min.js"></script>
  <script src="<?=SET_URL_PRODUCTION?>/assets/js/popper.min.js"></script>
  <script src="<?=SET_URL_PRODUCTION?>/assets/js/bootstrap.min.js"></script>
  <script src="<?=SET_URL_PRODUCTION?>/assets/js/jquery.easing.1.3.js"></script>
  <script src="<?=SET_URL_PRODUCTION?>/assets/js/jquery.waypoints.min.js"></script>
  <script src="<?=SET_URL_PRODUCTION?>/assets/js/jquery.stellar.min.js"></script>
  <script src="<?=SET_URL_PRODUCTION?>/assets/js/owl.carousel.min.js"></script>
  <script src="<?=SET_URL_PRODUCTION?>/assets/js/jquery.magnific-popup.min.js"></script>
  <script src="<?=SET_URL_PRODUCTION?>/assets/js/aos.js"></script>
  <script src="<?=SET_URL_PRODUCTION?>/assets/js/jquery.animateNumber.min.js"></script>
  <script src="<?=SET_URL_PRODUCTION?>/assets/js/bootstrap-datepicker.js"></script>
  <script src="<?=SET_URL_PRODUCTION?>/assets/js/jquery.timepicker.min.js"></script>
  <script src="<?=SET_URL_PRODUCTION?>/assets/js/scrollax.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="<?=SET_URL_PRODUCTION?>/assets/js/google-map.js"></script>
  <script src="<?=SET_URL_PRODUCTION?>/assets/js/main.js"></script>
    
  </body>
</html>