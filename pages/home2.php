<?php

	require_once 'class/Conn.class.php';
	require_once 'class/Gestor.class.php';

	$gestor =new Gestor();
	$planos_g = $gestor->list_planos();

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Gestor Lite - Gerenciamento facilitado de clientes</title>
	<meta charset="UTF-8">

	<meta name="keywords" content="gestor lite, iptv gestor, gerenciamento de clientes,emissor de cobranças, whatsapi, cobrar clientes, automatico,emitir cobranças,controle financeiro,financeiro,planilha excel">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Gestor lite - Gerenciamento facilitado de clientes">
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
	<link rel="stylesheet" href="<?=SET_URL_PRODUCTION?>/css/bootstrap.min.css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"/>
	<link rel="stylesheet" href="<?=SET_URL_PRODUCTION?>/css/flaticon.css"/>
	<link rel="stylesheet" href="<?=SET_URL_PRODUCTION?>/css/owl.carousel.min.css"/>
	<link rel="stylesheet" href="<?=SET_URL_PRODUCTION?>/css/animate.css"/>
	<link rel="stylesheet" href="<?=SET_URL_PRODUCTION?>/css/style.css"/>


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
		<a href="" class="site-logo"><img width="100" src="<?=SET_URL_PRODUCTION?>/img/logo.png" alt=""></a>
		<div class="nav-switch">
			<i class="fa fa-bars"></i>
		</div>
		<div class="nav-warp">
			<div class="user-panel">
				<a href="<?=SET_URL_PRODUCTION?>/login">Entrar</a> /
				<a href="<?=SET_URL_PRODUCTION?>/login/create">Registrar</a>
			</div>
			<ul class="main-menu">
				<li><a href="<?=SET_URL_PRODUCTION?>/contato">Contato</a></li>
				<li><a href="<?=SET_URL_PRODUCTION?>/faq">FAQ</a></li>
				<li><a target="_blank" href="https://kb.gestorlite.com">Base de conhecimento</a></li>
			</ul>
		</div>
	</header>
	<!-- Header section end -->


	<!-- Hero section -->
	<section class="hero-section set-bg" data-setbg="<?=SET_URL_PRODUCTION?>/img/bg.jpg">
		<div class="container h-100">
			<div class="hero-content text-white">
				<div class="row">
					<div class="col-lg-12 pr-0">
						<h4 class="title_gestor" >
						 GESTOR LITE
						</h4>
						<p> Tenha controle financeiro, emita cobranças automáticas e tenha WhatsAPI totalmente grátis. <br />
							Uma compilação melhorada do <u><a href="https://siteiptv.com" target="_blank" >Gestor</a></u> e ainda por um preço totalmente baixo.
						 </p>
						<a href="<?=SET_URL_PRODUCTION?>/login/create" class="site-btn">5 dias grátis</a>
					</div>
				</div>
				<div class="">
					<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
					<lottie-player
					    src="https://assets2.lottiefiles.com/temp/lf20_TOE9MF.json"  background="transparent" id="dash_video_home" speed="1"  style="width: 700px; height: 700px;"  loop  autoplay >
					</lottie-player>
				</div>
			</div>
		</div>
	</section>
	<!-- Hero section end -->


	<!-- Features section -->
	<section class="features-section spad">
		<div class="container">
			<div class="section-title">
				<img width="80" src="<?=SET_URL_PRODUCTION?>//img/section-title-icon.png" alt="#">
				<p>Gestor lite</p>
				<h2>Veja o que podemos fazer por você</h2>
			</div>
			<div class="row">
			    
				<div class="col-lg-4 col-md-6 feature-item">
					<div class="ft-icon">
						<i class="fa fa-users"></i>
					</div>
					<h4>Cadastre seus clientes</h4>
					<p>Faça uma lista completa de seus clientes, o ordene conforme seu vencimento.</p>
				</div>
				<div class="col-lg-4 col-md-6 feature-item fi-center-top">
					<div class="ft-icon">
						<i class="fa fa-whatsapp"></i>
					</div>
					<h4>Cobrança por whatsapp</h4>
					<p>Seu cliente recebe todo mês a cobrança que você definir em seu painel, você determina a data que será enviada.</p>
				</div>
				<div class="col-lg-4 col-md-6 feature-item">
					<div class="ft-icon">
						<i class="fa fa-grav"></i>
					</div>
					<h4>ChatBot do whatsapp</h4>
					<p>Olha que legal ! Aqui você encontra um autoresponder automático. Tenha acesso a um painel e programe seu robô chatbot.</p>
				</div>
				<div class="col-lg-4 col-md-6 feature-item">
					<div class="ft-icon">
						<i class="fa fa-line-chart"></i>
					</div>
					<h4>Controle financeiro</h4>
					<p>Não se perca mais para ter seu controle financeiro, esqueça planilhas antigas de excel, aqui é tudo mais simples.</p>
				</div>
				<div class="col-lg-4 col-md-6 feature-item">
					<div class="ft-icon">
						<i class="fa fa-code"></i>
					</div>
					<h4>Xtream UI</h4>
					<p>Integre seu painel Xtream-UI e gere testes automáticos, com envio por email e whatsapp</p>
				</div>
				<div class="col-lg-4 col-md-6 feature-item">
					<div class="ft-icon">
						<i class="fa fa-user"></i>
					</div>
					<h4>Área de clientes</h4>
					<p>Oferaça para seus clientes uma área do cliente exclusiva do seu negócio. Aumente sua credibilidade e ofereça uma ótima experiencia para seu cliente.</p>
				</div>
				<div class="col-lg-4 col-md-6 feature-item">
					<div class="ft-icon">
						<i class="fa fa-download"></i>
					</div>
					<h4>Exporte os dados</h4>
					<p>Faça download dos dados de seu painel, seus clientes, logs, mensagens enviadas por whatsapp etc...
					 </p>
				</div>
				<div class="col-lg-4 col-md-6 feature-item">
					<div class="ft-icon">
						<i class="fa fa-handshake-o"></i>
					</div>
					<h4>Mercado Pago</h4>
					<p>Integrado com mercado pago, receba notificações assim que algum cliente assinar seu plano
					 </p>
				</div>
				<div class="col-lg-4 col-md-6 feature-item">
					<div class="ft-icon">
						<i class="fa fa-qrcode"></i>
					</div>
					<h4>PicPay</h4>
					<p>Adicione seu PicPay e receba pagamentos de seus clientes.
					 </p>
				</div>
				<div class="col-lg-4 col-md-6 feature-item">
					<div class="ft-icon">
						<i class="fa fa-bank"></i>
					</div>
					<h4>Banco</h4>
					<p>Adicione informações de seus bancos, para recebimento de pagamentos ou transferências. </p>
				</div>
				<div class="col-lg-4 col-md-6 feature-item">
					<div class="ft-icon">
						<i class="fa fa-link"></i>
					</div>
					<h4>Link de pagamento</h4>
					<p>Envie um link de pagamento para seu cliente ou divulgue sua campanha de marketing. Ofereça seus metodos de pagamentos personalizados em apenas um lugar.
					 </p>
				</div>
				<div class="col-lg-4 col-md-6 feature-item">
					<div class="ft-icon">
						<i class="fa fa-envelope"></i>
					</div>
					<h4>Envio de emails</h4>
					<p>Envie emails de cobranças do dia exato que a assinatura de seu cliente estiver próxima do vencimento.
					 </p>
				</div>
			</div>
		</div>
	</section>
	<!-- Features section end -->



	<!-- Skills & testimonials section -->
	<section class="section_gestor skills-and-testimonials-section spad">
		<div class="container">
			<div class="row">
				<!-- Testimonials -->
				<div class="col-lg-12">
					<div class="testimonials-slider owl-carousel">
						<div class="text-center ">
							 <center><img src="<?=SET_URL_PRODUCTION?>/img/review/IMGA_GESTORLITE.png" alt=""></center>
						</div>

					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Skills & testimonials section end -->
	
	<section class=" spad">
		<div class="container">
			<div class="row">
			    <h3 style="margin-bottom:20px;" >Gestor Lite:</h3>
				<!-- Testimonials -->
			    	<div class="col-lg-12">
			    	    <center>
			    	        <div class="embed-responsive embed-responsive-21by9">
                               <iframe width="560" height="315" src="https://www.youtube.com/embed/0Qxljtfk7qY" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>					    
                            </div>
                          </center>  
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<section class=" spad">
		<div class="container">
			<div class="row">
			    <h3 style="margin-bottom:20px;" >ChatBot Whatsapp</h3>
				<!-- Testimonials -->
			    	<div class="col-lg-12">
			    	    <center>
			    	        <div class="embed-responsive embed-responsive-21by9">
                               <iframe width="560" height="315" src="https://www.youtube.com/embed/x4JQG3ISt-Q" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>					    
                            </div>
                          </center>  
					</div>
				</div>
			</div>
		</div>
	</section>
	
		<!-- depoimentos-->
	<section class="section_gestor spad">
		<div class="container">
			<div class="row">
			    
			   
			    <div class="col-lg-12">
			        <h3 class="text-white" style="margin-bottom:20px;" >Depoimentos</h3>
			    </div>
				<!-- Testimonials -->
			    	<div class="col-lg-6">
			    	    <center>
			    	        <div class="embed-responsive embed-responsive-21by9">
                                <iframe width="560" height="315" src="https://www.youtube.com/embed/kaEW9flOdHg" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
					    </center>
					</div>
					<div class="col-lg-6">
			    	    <center>
			    	        <div class="embed-responsive embed-responsive-21by9">
                             <iframe width="560" height="315" src="https://www.youtube.com/embed/DqVsmJvca-0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>                            </div>
					    </center>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- depoimentos -->

	<section class=" spad">
		<div class="container">
			<div class="row">
				<!-- Testimonials -->
			    	<div class="col-lg-6">
                        <img alt="Gestor Lite" title="Gestor Lite" src="<?=SET_URL_PRODUCTION?>/img/gestorlite_home.png" />
					</div>
					<div class="col-lg-6">
					    <br /><br />
                        <h4>
                            Com o Gestor Lite você economiza seu tempo para fazer outras tarefas mais importantes! Deixe que nós cobramos seus clientes no dia exato !
                        </h4>
                        <br /><br />
                        <h4>
                            Agora você não precisa esquentar a cabeça e ficar tentando se lembrar da cobrança de todos seus clientes, agende o dia que enviamos um email e whatsapp, com a mensagem que você definir!
                        </h4>
                        <br /><br />
                        <h4>
                         Para seu negócio ser o melhor, Faça o melhor !
                        </h4>
                        <br /><br />
                        <a href="#planos" class="btn btn-primary" style="border-radius:20px;width:100%;" >Ver planos</a>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<section class=" spad">
		<div class="container">
			<div class="row">
				<!-- Testimonials -->
			    	
					<div class="col-lg-6">
					    <br /><br />
                        <h4>
                            Sim ! Nós somos o melhor painel de gestão de clientes na atualidade.
                        </h4>
                        <br /><br />
                        <h4>
                          Melhor preço do mercado com essas funcionabilidades disponíveis no painel.
                        </h4>
                        <br /><br />
                        <h4>
                          Automatize seu negócio.
                        </h4>
                        <br /><br />
                        <a href="#planos" class="btn btn-primary" style="border-radius:20px;width:100%;" >Ver planos</a>
					</div>
					<div class="col-lg-6">
                        <img alt="Gestor Lite" title="Gestor Lite" src="<?=SET_URL_PRODUCTION?>/img/GESTOR1.png" />
					</div>
					
				</div>
			</div>
		</div>
	</section>
	
	<section class=" spad">
		<div class="container">
			<div class="row">
				<!-- Testimonials -->
			    	
			    	<div class="col-lg-6">
                        <img alt="Gestor Lite" title="Gestor Lite" src="<?=SET_URL_PRODUCTION?>/img/GESTOR3.png" />
					</div>
			    	
					<div class="col-lg-6">
					    <br /><br />
                        <h4>
                            Já pensou na credibilidade do seu serviço se enviar os testes aos clientes de forma automatizada ?
                        </h4>
                        <br /><br />
                        <h4>
                          Com nossas ferramentas, você pode alavancar suas vendas e ganhar a confiança do cliente logo da primeira vez.
                        </h4>
                        <br /><br />
                        <a href="#planos" class="btn btn-primary" style="border-radius:20px;width:100%;" >Ver planos</a>
					</div>
					
					
				</div>
			</div>
		</div>
	</section>

	<!-- Pricing section -->
	<section id="planos" class="pricing-section spad pt-0">
		<div class="container">
			<div style="margin-top:20px;" class="section-title">
				<img width="80" src="<?=SET_URL_PRODUCTION?>//img/section-title-icon.png" alt="#">
				<h2>Nossos planos</h2>
			</div>
			<div class="row">


				<?php

				if($planos_g){

					while ($plano = $planos_g->fetch(PDO::FETCH_OBJ)) {

				?>


				<div class="col-lg-4 col-md-8 offset-md-2 offset-lg-0">
					<div class="pricing-plan <?php if($plano->popular == 1){ echo "gold-plan";} ?>">
						<div class="pricing-title">
							<h4><?= $plano->nome; ?></h4>
						</div>
						<div class="pricing-body">
							<h3>R$ <?= $plano->valor; ?><span style="font-size:13px;color:#ccc;" >/Mês</span></h3>
								<p style="margin-top:10px;" class="text-left" >
									<?= $plano->text; ?>
								</p>
							<a href="<?=SET_URL_PRODUCTION?>/login/create" class="site-btn">Selecionar</a>
						</div>
					</div>
				</div>

			<?php } } ?>

			</div>
		</div>
	</section>
	<!-- Pricing section end -->



	<!-- Banner section -->
	<section class="banner-section set-bg" data-setbg="<?=SET_URL_PRODUCTION?>/img/banner-bg.jpg">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 banner-text text-white">
					<h3>Pague R$ 250,00 contratando um ano</h3>
					<p>Pague menos pagando por um ano inteiro o plano Profissional do gestor lite.</p>
				</div>
				<div class="col-lg-3 text-left text-lg-right">
					<a href="<?=SET_URL_PRODUCTION?>/faq?wpp&text=Gostaria de adquirir o plano de 1 ano do gestor lite" target="_blank" class="site-btn">Contratar</a>
				</div>
			</div>
		</div>
	</section>
	<!-- Banner section end -->



	<!-- Footer top section -->
	<section class="footer-top-section text-white spad">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<div class="footer-widget about-widget">
						<img width="200" src="<?=SET_URL_PRODUCTION?>//img/logo.png" alt="logo">
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
						<img width="200" src="<?=SET_URL_PRODUCTION?>/painel/img/ferramenta-scriptmundo_dark_on.png" alt="logo">
						<p>Script Mundo, fundada em 2016 vem forte no mercado de desenvolvimento de softwares e sistemas. Nosso principal objetivo é ser referência nesta área da tecnologia.
Estamos localizados no Paraná desde a fundação. </p>
						<div class="fw-social social">
							<a href="https://facebook.com/scriptmundo.oficial" target="_blank" ><i class="fa fa-facebook"></i></a>
							<a href="https://twitter.com/scriptmundo" target="_blank" ><i class="fa fa-twitter"></i></a>
							<a href="https://github.com/luannsr12" target="_blank" ><i class="fa fa-github"></i></a>
							<a href="https://instagram.com/scriptmundo" target="_blank" ><i class="fa fa-instagram"></i></a>
							<a href="https://www.youtube.com/channel/UCPJ7L33FkMayMW6EExnXCkw" target="_blank" ><i class="fa fa-youtube-play"></i></a>
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
				<li><a href="<?=SET_URL_PRODUCTION?>/login" >Entrar</a></li>
				<li><a href="<?=SET_URL_PRODUCTION?>/login/create" >Criar conta</a></li>
				<li><a href="<?=SET_URL_PRODUCTION?>/faq?contato" target="_blank" >Contato</a></li>
			</ul>
			<div class="copyright">
Copyright &copy;<script>document.write(new Date().getFullYear());</script> Todos os direitos reservados | Uma ferramenta de <a href="https://scriptmundo.com" target="_blank">Script Mundo</a>
</div>
		</div>
	</footer>
	<!-- Footer top section end -->
 

	<!--====== Javascripts & Jquery ======-->
	<script src="<?=SET_URL_PRODUCTION?>/js/jquery-3.2.1.min.js"></script>
	<script src="<?=SET_URL_PRODUCTION?>/js/bootstrap.min.js"></script>
	<script src="<?=SET_URL_PRODUCTION?>/js/owl.carousel.min.js"></script>
	<script src="<?=SET_URL_PRODUCTION?>/js/circle-progress.min.js"></script>
	<script src="<?=SET_URL_PRODUCTION?>/js/main.js"></script>


	</body>
</html>
