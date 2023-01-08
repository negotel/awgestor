
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Gestor Lite</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link href="<?=SET_URL_PRODUCTION?>/img/favicon.ico" rel="shortcut icon" />
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/util.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
 <link rel="stylesheet" href="<?=SET_URL_PRODUCTION?>/css/font-awesome.min.css"/>
 
 <link href="js/intlTelInput/css/intlTelInput.css" rel="stylesheet">

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

	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/login-fundo.png');background-size:cover;">
	    	<div class="wrap-login100">
	
					<div class="row" >

		  	  	    <div class="wrap-input100 validate-input" data-validate = "Nome">
						<input class="input100" autocomplete="off" list="autocompleteOff" type="text" id="nome" name="nome">
						<span class="focus-input100" data-placeholder="Digite seu nome"></span>
					</div>

					<div class="form-group col-md-12 wrap-input100 validate-input" data-validate = "Digite seu e-mail">
						<input class="input100" type="email" id="email" name="email" placeholder="Digite seu e-mail">
					</div>

				<!--	<div class="form-group col-md-6">-->
				<!--	<span style="height:10px!important;" ></span>-->
				<!--	<div class="btn-group">-->
				<!--		<button id="dropDownDDI" type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
				<!--			<img src="<?=SET_URL_PRODUCTION?>/img/country/br.png" /> +55-->
				<!--		</button>-->
				<!--		<div class="dropdown-menu" style="overflow-y: scroll;padding-top:50px;" >-->
				<!--		     	<a style="cursor:pointer;" onclick="mudaDDI('55','br')" class="dropdown-item"><img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/br.png" /> +55</a>-->
    <!--							<a style="cursor:pointer;" onclick="mudaDDI('351','pt');" class="dropdown-item" ><img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/pt.png" /> +351</a>-->
    <!--							<a style="cursor:pointer;" onclick="mudaDDI('1','usa');" class="dropdown-item" ><img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/usa.png" /> +1</a>-->
    <!--							<a style="cursor:pointer;" onclick="mudaDDI('49','ger');" class="dropdown-item"><img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/ger.png" /> +49</a>-->
    <!--							<a style="cursor:pointer;" onclick="mudaDDI('54','arg');" class="dropdown-item" ><img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/arg.png" /> +54</a>-->
    <!--							<a style="cursor:pointer;" onclick="mudaDDI('598','uru');" class="dropdown-item"><img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/uru.png" /> +598</a>-->
    <!--							<a style="cursor:pointer;" onclick="mudaDDI('44','gbr');" class="dropdown-item"><img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/gbr.png" /> +44</a>-->
    <!--							<a style="cursor:pointer;" onclick="mudaDDI('34','esp');" class="dropdown-item"><img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/esp.png" /> +34</a>-->
    <!--							<a style="cursor:pointer;" onclick="mudaDDI('1','can');" class="dropdown-item" ><img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/can.png" /> +1</a>-->
    <!--							<a style="cursor:pointer;" onclick="mudaDDI('57','col');" class="dropdown-item" ><img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/col.png" /> +57</a>-->
				<!--		    	<a style="cursor:pointer;" onclick="mudaDDI('81','jp');" class="dropdown-item" ><img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/jp.png" /> +81</a>-->
    <!--							<a style="cursor:pointer;" onclick="mudaDDI('244','ao');" class="dropdown-item" ><img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/ao.png" /> +244</a>-->

				<!--		</div>-->
				<!--	</div>-->

				<!--	<script>-->
    <!--      function mudaDDI(ddi,country){-->

    <!--          $("#ddi").val(ddi);-->
    <!--          $("#dropDownDDI").html('<img src="<?=SET_URL_PRODUCTION?>/img/country/'+country+'.png" /> +'+ddi);-->
    <!--      }-->
    <!--    </script>-->


				<!--	<input type="hidden" value="55" id="ddi" />-->

				<!--</div>-->

                    <div class="form-group col-md-12 wrap-input100 validate-input" style="padding:0px!important;" >
						<input class="input100" type="text" id="telefone" name="telefone" placeholder="Telefone">
					</div>



					<div class="form-group col-md-12 wrap-input100 validate-input" data-validate="Senha">
						<input class="input100" type="password" id="senha" name="senha" placeholder="Digite uma senha">
					</div>
                  <span style="font-size:12px;" >
                    <a style="color:blue;" target="_blank" href="<?=SET_URL_PRODUCTION?>/termos/termos-gestor.pdf"><i class="fa fa-external-link" ></i> Termos </a> - Ao criar a conta você concorda com os termos
                  </span>
			
					<div class="container-login100-form-btn" style=" width: 100%;">
						<div class="wrap-login100-form-btn" style=" width: 100%;">
							<div class="login100-form-bgbtn"></div>
							<button id="btn_create" style="width:100%;"  id="btn_login"  onclick="create();" class="login100-form-btn">
								Criar
							</button>
						</div>
					</div>
					
					</div>

				</div>
			</div>
		</div>
	</div>


	<div id="dropDownSelect1"></div>
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js?v=<?= filemtime('js/main.js'); ?>"></script>
<!--===============================================================================================-->
	<script src="js/function.js?v=<?= filemtime('js/function.js'); ?>"></script>
	<script src="js/jquery.mask.js"></script>
	
	<script src="js/intlTelInput/js/intlTelInput.js"></script>
	<script src="js/intlTelInput/js/utils.js"></script>
	
	<script>
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
	
</body>
</html>
