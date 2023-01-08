<?php

 require_once 'autoload.php';
 require_once 'system.php';

 $_SESSION['captcha'] = md5(rand(10000,9999999));

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>

  <meta charset="utf-8">
  <base  target="_blank">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <link rel="stylesheet" type="text/css" href="assets/css/checkout_v5_personalizado.min6e94.css?v=1.1">
  <meta name="robots" content="noindex" />
  <link href="<?=SET_URL_PRODUCTION?>/img/favicon.ico" rel="shortcut icon" />

  <style type="text/css">
  .form-group {
    margin-bottom: 5px !important;
  }
  input:not([type=radio]), select {
    height: 43px !important;
  }

</style>

    <?php if($auth){ ?>
    <title>R$ <?= $planoDados->valor; ?> | <?= $planoDados->nome; ?></title>
    <?php }else{ ?>
    <title>Link quebrado</title>
    <?php } ?>

<!-- Favicon -->
<link rel="shortcut icon" href="">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
<link href="assets/js/intlTelInput/css/intlTelInput.css" rel="stylesheet">
<style media="screen">
	@media screen and (max-width: 531px) {
		.container-fluid { display: flex; flex-flow: column-reverse; }
		}
		.iti {
			width: 100%;
		}
</style>


 <?php if($planoDados->banner_link != NULL AND $planoDados->banner_link != ""){ ?>

    <meta property="og:image" content="<?= $planoDados->banner_link; ?>">
    <meta property="og:image:width" content="906"> 
    <meta property="og:image:height" content="134"> 

 <?php } ?>
 
  <!-- Gestor Lite notify -->
    <script>
       (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js  = d.createElement(s); js.id = id;
        memberidGl = <?= $userGestor->id; ?>;
        js.src = '<?=SET_URL_PRODUCTION?>/notify-gestor/notify-gestorlite.js?v=9';
        fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'notify-gestor-lite'));
    </script>
    <!-- Gestor Lite notify -->
 
</head>
<body>


<div class="container-fluid" id="conteudo" style="padding-right: 0px;padding-top: 0px;padding-left: 0px;margin-right: 0px;">


<!-- INICIO BODY -->
<?php if($auth){ ?>

    <div class="col-lg-8 col-lg-offset-2 col-md-12  col-xs-12 padding-l-r-zero">
      <div class="panel panel-default padding-l-r-zero" id="produto">

        <div class="panel-body" style=" text-align: center; padding: 0px;">

          <div style="/*background-color: #038583 */">
              <?php if($planoDados->banner_link != NULL AND $planoDados->banner_link != ""){ ?>
             <img class="" src="<?= $planoDados->banner_link; ?>" alt=""  style="margin: 0 auto;width: 100%; height-min: 30px;"  >
            <?php  } ?>
          </div>

        </div>

        <div class="panel-footer text-center"  >
          <i class="fa fa-lock"></i> Você está em um ambiente seguro
          <!--   -->
        </div>

      </div>
    </div>

    <div style=" padding-left: 0;" class="  col-lg-offset-2 col-md-8 col-lg-5 col-xs-12  ">
      <div class="col-lg-12  col-xs-12 padding-l-r-zero " style="margin-bottom: 15px;">
        <div class="panel panel-default" id="dados_cadastrais">
          <div class="panel-heading">
            <h1>1 - Dados cadastrais</h1>
            </div>
            <div class="panel-body">
                
                <input type="hidden" id="plano_id" value="<?= $planoId; ?>" />
                <input type="hidden" id="captcha" value="<?= $_SESSION['captcha']; ?>" />


              <div class="form-group">
                <label for="nome">Nome completo</label>
                <input type="text" id="nome" name="nome" placeholder="Digite seu nome completo" class="form-control ca" maxlength="200"  value="" />
              </div>


              <div class="form-group">
                <label for="email" style="margin-right: 10px;">E-mail </label>
                <input type="text" id="email" name="email" placeholder="Digite seu melhor e-mail" class="form-control ca" maxlength="200" value="" data-obgt="1" />
              </div>


                <div class="form-group">
                  <label for="telefone" >Seu Whatsapp</label>
                  <div class="input-container"  >
                    <input style="width:100%!important;" type="text" id="telefone" placeholder="Seu Número do whatsapp" name="telefone" class="form-control telefone  ca" maxlength="20"  value="" />
                    <!-- <i class="fa fa-question-circle infoTelefone" ></i> -->
                  </div>
                </div>
          </div>

        </div> <!-- Fim dos dados cadastrais -->
      </div>


      <div class="col-lg-12 col-xs-12 padding-l-r-zero" id="divPagamento" style="margin-top: -18px;">
        <div class="panel panel-default" id="pagamento"  style="margin-bottom: 0px;">
          <div class="panel-heading">
            <h1>2 - Pagamento </h1>
            </div>
            <div class="panel-body">
                
                

                <div class="clearfix" > </div>

                <div class="divValor form-group esconder">
                  <h3>R$ <?= $planoDados->valor; ?> </h3>
                </div>

	              <button onclick="continuar_gliteme();" id="button_next" data-loading-text="Aguarde..."   class="btn btn-block btn-success submit-button" type="submit" >
	                <!-- <span class="submit-button-lock" ></span> -->
	                <span class="align-middle txtBtnPagar" >Ir para pagamento</span>
	              </button>
                <div class="pagamentoSeguro">
									<img src='assets/img/cadeado.svg' alt="Você está em Ambiente Seguro. SSL criptografia 128 bits" style=" width: 209px; height: 68px;"/>
								</div>
              </div>
            </div>

             <div style="height: auto;font-size: 10px;margin-bottom: 20px;" id="codReferencia"></div>
             <h6 style="color: #b3b2b2;">*OBS.: Seu cadastro será realizado em nossa plataforma.</h6>
          </div>

          </div>


            <div class="col-md-4 col-lg-3 col-xs-12 " style="padding-right: 0px;"  >
              <div  class="panel panel-default col-xs-12" id="detalhes" style="padding: 0px;">
                <div class="panel-body padding-l-r-zero"  style="text-align: center;padding: 0px;">

						<div style="min-height:60px;" class="panel-heading text-right">
							<a target="_blank" style="text-decoration:none;" href="<?=SET_URL_PRODUCTION?>">
								<span style="color: gray;font-size: 9px;">POWERED BY <img style="filter: gray;-webkit-filter: grayscale(100%);" width="50" src="<?=SET_URL_PRODUCTION?>/img/logo.png" alt=""> </span>
							</a>
  						    </div>
								<style media="screen">

								.secure-buy:before {
									position: absolute;
									content: " ";
									left: 0;
									bottom: -10px;
									display: block;
									border-bottom: 10px;
									border-left: 10px solid rgba(0,0,0,0);
									border-right: 0 solid rgba(0,0,0,0);
									border-top: 10px solid #56a03f;
								}

								.secure-buy {
									top: 33px;
							    background-color: #7cd063;
							    padding: 10px 12px 10px 16px;
							    left: -10px;
							    position: absolute;
							    z-index: 1;
							    color: #fff;
							    font-size: 12px;
							    text-transform: uppercase;
							    font-weight: 700;
								}

								</style>
								  <div class="secure-buy secure-purchase-badge without-product">
										<svg style="display: inline-block;vertical-align: middle;" width="22" height="26" viewBox="0 0 22 26" xmlns="http://www.w3.org/2000/svg" class="secure-purchase-badge__shield"><path data-v-4371cce6="" d="M21.284 5.3s3.65 16.194-10.176 20.243C-2.718 21.494.93 5.3.93 5.3L11.108.644 21.284 5.3zM10.605 18.67l6.42-6.378-1.764-1.751-4.656 4.626-3.124-3.104-1.763 1.751 4.887 4.856z" fill="#FFF" fill-rule="evenodd" class="secure-purchase-badge__shield-path"></path></svg>
										<span style="display: inline-block;vertical-align: middle;" class="secure-purchase-badge__label">Compra 100% Segura</span>
									</div>

									<div style="padding-top:30px;" class="panel-body">

										<div class="row">
												<div class="col-md-12 text-left">
														<h3><?= $planoDados->nome; ?></h3>
														<p style="margin-top: 14px;color: gray;font-size: 12px;" >Este é um produto digital, você receberá os dados para acessá-lo por email ou whatsapp</p>
												</div>
												<div class="col-md-12 text-left">
														<hr>
												</div>
												<div class="col-md-12 text-left">
														<h2 style="font-weight: 900;color: #353535;" >R$ <?= $planoDados->valor; ?></h2>
												</div>
										</div>

									</div>
								<div style="min-height: <?php if($mpUser){ ?>230px;<?php }else{ ?>150px;<?php } ?>" class="panel-footer">

										<div class="col-md-12 text-left">
												<p style="margin-top: 14px;color: gray;font-size: 12px;" >Nós aceitamos:</p>
												<?php $not= 0; ?>
												 <?php if($mpUser){ ?>
                                                        <img style="margin-right:10px;width:50px;" src="img/mercado-pago.png?v=<?= filemtime('img/mercado-pago.png'); ?>" alt="Mercado Pago" title="Mercado Pago" aria-hidden="true">
                                                  <?php }else{ $not++;} ?>
                                                  <?php if(isset($ppUser->situ) && @$ppUser->situ == 1){ ?>
                                                        <img style="margin-right:10px;width:50px;" title="Pic Pay" src="img/ppay-icon.png?v=<?= filemtime('img/ppay-icon.png'); ?>" alt="Pic Pay" aria-hidden="true">
                                                  <?php }else{ $not++;} ?>
                                                   <?php if($phUser){ ?>
                                                        <img style="margin-right:10px;width:50px;" title="Pag Hiper" src="img/paghiper.png?v=<?= filemtime('img/paghiper.png'); ?>" alt="Pag Hiper" aria-hidden="true">
                                                  <?php }else{ $not++;} ?>
                                                  <?php if(isset($pixUser->situ) && @$pixUser->situ == 1){ ?>
                                                        <img style="margin-right:10px;width:50px;" title="Pix" src="img/pix.png?v=<?= filemtime('img/pix.png'); ?>" alt="Pix" aria-hidden="true">
                                                  <?php }else{ $not++;} ?>
                                                  <br />
                                                  <hr>
                                                  <?php if($mpUser){ ?>
                                                   <img style="margin-right:10px;width:100%;" title="Bandeiras Cartão" src="img/cartaos.png"/>
                                                  <?php } ?>
                                                  
                                                  <?php if($not == 4){ ?>
                                                    <p>Após o cadastro, veja as opções</p>
                                                  <?php } ?>
										</div>

								</div>
                </div>
              </div>
            </div>


            <!-- FIM BODY -->
            <?php }else{ ?>
            <div class="col-lg-8 col-lg-offset-2 col-md-12  col-xs-12 padding-l-r-zero">
                
                <div style="margin-top:50px;" class="panel">
                    <div class="panel-heading text-center" style="height:30px;"></div>
                    <div class="panel-body text-center">
                        
                        <h3> <i class="fa fa-meh-o"></i> Este item foi removido</h3>
                        <br />
                        <img width="60%" src="https://cdn.dribbble.com/users/1665077/screenshots/10738715/media/90712c2d7fd869e9d7586a108024d62c.gif" />
                    </div>
                </div>
                
            </div>
            <?php } ?>

        </div>

		</body>

		<script src="assets/js/jquery-3.2.1.min.js"></script>
		<script src="assets/js/jquery.mask.js"></script>
		<script src="assets/js/intlTelInput/js/intlTelInput.js"></script>
		<script src="assets/js/intlTelInput/js/utils.js" ></script>
		<script src="https://glite.me/p/js/main.js?v=1.2"></script>
		<script type="text/javascript">
				$(document).ready(function() {
				    var e = function(e) {
				            return 11 === e.replace(/\D/g, "").length ? "(00) 00000-0000" : "(00) 0000-00009"
				        },
				        n = {
				            onKeyPress: function(n, t, a, o) {
				                a.mask(e.apply({}, arguments), o)
				            }
				        };
				    $("#telefone").mask(e, n)
				}),



		     window.onload = function() {

		          var consultInput = document.querySelector('#telefone');
	                iti = window.intlTelInput(consultInput, {
	                  initialCountry: "br",
	                  nationalMode: true,
	                  preferredCountries:["br", "pt", "us", "gb"],
	                  geoIpLookup: function (callback) {
	                     $.get('https://ipinfo.io', function () {
	                     }, "jsonp").always(function (resp) {
	                         var countryCode = 'ag';
	                         callback(countryCode);
	                     });
	                 },
	                  utilsScript: "/js/plugins/intlTelInput/js/utils.js",
	                });
		       }

		</script>
  </html>
	