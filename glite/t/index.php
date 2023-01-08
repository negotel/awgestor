<?php

   $page_explo = explode('/',$_GET['url']);
  
   if(!isset($page_explo[0])){
       require_once 'page_erro.php';
   	   die;
   }
   
   if($page_explo[0] == ""){
       require_once 'page_erro.php';
   	   die;
   }
   
   $chave = trim($page_explo[0]);


	require_once 'autoload.php';

	$packages = json_decode($i->API->getPackages($chave));

	if(isset($packages->erro)){
	    if($packages->erro){
	        
    	  require_once 'page_erro.php';
       	  die;   
    	        
	    }
	}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Gerador de Teste</title>
	
	
	<meta property="og:url"                content="https://glite.me/t/<?= $chave; ?>" />
    <meta property="og:type"               content="website" />
    <meta property="og:title"              content="Teste agora ! É grátis." />
    <meta property="og:description"        content="Vai ficar de fora ? Teste agora e veja como podemos te surpreender." />
    <meta property="og:image"              itemprop="image" content="https://glite.me/t/images/BANNER-COMPARTILHAR.png" />
    <meta property="og:image:type"         content="image/png">
    <meta property="og:image:width"        content="300">
    <meta property="og:image:height"       content="300">

	<meta name="description" content="Gerador de Teste">
	<meta name="keywords" content="teste gratis,gerador de teste,teste iptv,assista tv online,crie seu teste agora,teste free,hdtv,teste online,assistir filme online,filmes em HD">
	<meta name="robots" content="">
	<meta name="revisit-after" content="1 day">
	<meta name="language" content="Portuguese">
	<meta name="generator" content="N/A">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/favicon.png"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->

  <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</head>
<body>


	<div class="container-contact100">
		<div class="wrap-contact100">
			<form id="form_gera_teste" class="contact100-form validate-form">

				<div class="row">

    				<div class="col-md-12 wrap-input100 validate-input" data-validate="Seu nome é obrigatório">
    					<span class="label-input100">Seu Nome</span>
    					<input class="input100" type="text" name="name" placeholder="Digite seu nome">
    					<span class="focus-input100"></span>
    				</div>

				<div class="col-md-12 wrap-input100 validate-input" data-validate = "Digite um email válido. ex: eu@gmail.com">
					<span class="label-input100">Seu Email</span>
					<input class="input100" type="text" name="email" placeholder="Digite seu email">
					<span class="focus-input100"></span>
				</div>
				
				<div class="col-md-4 wrap-input100 validate-input" data-validate = "Digite um email válido. ex: eu@gmail.com">
					<div  class="btn-group">
					    <input type="hidden" value="55" id="ddi" name="ddi" />
						<button style="font-size: 0.8rem;" id="dropDownDDI" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/br.png" /> +55
						</button>
						<div class="dropdown-menu">
							<a style="cursor:pointer;" onclick="mudaDDI('55','br')" class="dropdown-item"><img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/br.png" /> +55</a>
							<a style="cursor:pointer;" onclick="mudaDDI('351','pt');" class="dropdown-item" ><img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/pt.png" /> +351</a>
							<a style="cursor:pointer;" onclick="mudaDDI('1','usa');" class="dropdown-item" ><img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/usa.png" /> +1</a>
							<a style="cursor:pointer;" onclick="mudaDDI('49','ger');" class="dropdown-item"><img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/ger.png" /> +49</a>
							<a style="cursor:pointer;" onclick="mudaDDI('54','arg');" class="dropdown-item" ><img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/arg.png" /> +54</a>
							<a style="cursor:pointer;" onclick="mudaDDI('598','uru');" class="dropdown-item"><img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/uru.png" /> +598</a>
							<a style="cursor:pointer;" onclick="mudaDDI('44','gbr');" class="dropdown-item"><img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/gbr.png" /> +44</a>
							<a style="cursor:pointer;" onclick="mudaDDI('34','esp');" class="dropdown-item"><img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/esp.png" /> +34</a>
							<a style="cursor:pointer;" onclick="mudaDDI('1','can');" class="dropdown-item" ><img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/can.png" /> +1</a>
							<a style="cursor:pointer;" onclick="mudaDDI('57','col');" class="dropdown-item" ><img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/col.png" /> +57</a>
						    <a style="cursor:pointer;" onclick="mudaDDI('244','ao');" class="dropdown-item" ><img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/ao.png" /> +244</a>

						</div>
					</div>
				</div>



				
				<div class="col-md-8 wrap-input100 validate-input" data-validate = "Digite um whatsapp">
					<span class="label-input100">Seu Whatsapp - <span style="cursor:pointer;" onclick="$('#info_zap').modal('show');" style="font-size:12px;" class="text-info" >Ajuda <i class="fa fa-question"  ></i></span></span>
					<input  class="input100" type="text" name="whatsapp" id="whatsapp" placeholder="Digite seu whatsapp">
					<span class="focus-input100"></span>
					
					
				</div>
				

				<div class="col-md-12 wrap-input100 input100-select">
					<span class="label-input100">Selecione o pacote</span>
					<div>
						<select class="selection-2" id="package_id" name="package_id">
						<?php

						 if($packages){

							 foreach ($packages as $key => $package) {


						?>

							<option value="<?= $package->id;?>" ><?= str_replace("credito","",str_replace("crédito","",str_replace("Crédito","",str_replace("CRÉDITO","",str_replace("creditos","",str_replace("créditos","",str_replace("Créditos","",str_replace("CRÉDITOS","",$package->name))))))));?></option>

					<?php } }else{ ?>
							<option>Houve um erro ao buscar os pacotes</option>
					<?php } ?>
				  	</select>
					</div>
					<span class="focus-input100"></span>
				</div>
				
				<div class="col-md-12" style="text-align: center;" data-validate = "">
					<div data-size="normal" class="g-recaptcha" style="display: inline-block;" data-sitekey="6Le3c7EZAAAAAKHfQymf7uPw96d7-9gXBBfEf4Fw"></div>
				</div>

				<input type="hidden" value="<?= $chave; ?>" name="chave" id="chave" />
				
				 

				<div class="col-md-12 container-contact100-form-btn">
					<div class="wrap-contact100-form-btn">
						<div class="contact100-form-bgbtn"></div>
							<button id="btn_gerar" type="submit" class="contact100-form-btn">
								<span>
									GERAR TESTE
									<i id="icon_refresh" class="fa fa-refresh m-l-7" aria-hidden="true"></i>
								</span>
							</button>
					</div>
					<span style="margin-top:5px!important;font-size:12px!important;font-family:arial!important;color:gray!important;" >&copy; Gerador de testes <?= date('Y'); ?></span>
				</div>
				
				</div>
				
			</form>
		</div>
	</div>


	<!-- Modal -->
	<div class="modal fade" id="modal_return" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
	    <div class="modal-content">
	      <div style="height:100px;padding-top:30px;" class="modal-body text-center">
	         <h4 id="msg_return" ></h4>
	      </div>
	    </div>
	  </div>
	</div>
	
		<!-- Modal -->
	<div class="modal fade" id="info_zap" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
	      <div class="modal-body ">
	         <p>
	             Digite seu whatsapp da forma correta. <br />
	             Você irá receber o teste por whatsapp automáticamente. <br />
	             Ex: Se seu número possui o <b>nono digito</b> no whatsapp, <b>coloque</b>. Caso contrário <b>não coloque</b>.
	         </p>
	      </div>
	    </div>
	  </div>
	</div>




	<div id="dropDownSelect1"></div>

<!--===============================================================================================-->
  <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
  <script src="<?=SET_URL_PRODUCTION?>/login/js/jquery.mask.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
	<script>
		$(".selection-2").select2({
			minimumResultsForSearch: 20,
			dropdownParent: $('#dropDownSelect1')
		});
		
		
        $( document ).ready(function() {
           
             var SPMaskBehavior = function (val) {
              return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
            },
            spOptions = {
              onKeyPress: function(val, e, field, options) {
                  field.mask(SPMaskBehavior.apply({}, arguments), options);
                }
            };
            
            $('#whatsapp').mask(SPMaskBehavior, spOptions);
            
         });


    function mudaDDI(ddi,country){

          $("#ddi").val(ddi);
          $("#dropDownDDI").html('<img src="<?=SET_URL_PRODUCTION?>/img/country/'+country+'.png" /> +'+ddi);
      }

		
	</script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>


</body>
</html>
