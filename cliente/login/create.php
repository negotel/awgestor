<?php

	@session_start();

	if(isset($_SESSION['PAINEL'])){
        
	}else{
		echo "<center><h3 style='margin-top:20px;color:gray;font-family:arial;' >Entre em contato com o suporte!</h3><center>";
		exit;
	}
	


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Criar conta - <?= $_SESSION['PAINEL']['nome']; ?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="https://cliente.gestorlite.com/login/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="https://cliente.gestorlite.com/login/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="https://cliente.gestorlite.com/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="https://cliente.gestorlite.com/login/vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="https://cliente.gestorlite.com/login/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="https://cliente.gestorlite.com/login/vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="https://cliente.gestorlite.com/login/css/util.css">
	<link rel="stylesheet" type="text/css" href="https://cliente.gestorlite.com/login/css/main.css">
<!--===============================================================================================-->
</head>
<body>

	<div class="limiter">
	    
		<div class="container-login100">
		    
		  <?php if(isset($_SESSION['email_login'])){ echo '<span class="alert alert-info" >Identificamos que você possui uma conta, faça login</span>'; }?>

			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="https://cliente.gestorlite.com/logo/<?= $_SESSION['PAINEL']['logo']; ?>" alt="IMG">
				</div>
                
				<div class="login100-form validate-form">
					<span class="login100-form-title">
					 Crie sua conta
					</span>

					<input type="hidden" name="painel_cliente" id="painel_cliente" value="<?= $_SESSION['PAINEL']['slug']; ?>">

                    <div class="wrap-input100 validate-input" data-validate = "Digite seu nome">
						<input class="input100" type="text" name="nome" value="" id="nome" placeholder="Digite seu nome">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="wrap-input100 validate-input" data-validate = "Digite seu nome">
						<input class="input100" type="text" name="whatsapp" value="" id="whatsapp" placeholder="Digite seu whatsapp">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-whatsapp" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Digite um email valido tipo: bolsonaro@gov.br">
						<input class="input100" type="text" name="email" value="" id="email" placeholder="Digite seu email">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "">
						<input class="input100" type="password"  name="senha" id="senha" placeholder="Digite uma senha">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<?php 
					
					 	if(isset($_GET['ind'])){
                    	   echo '<input type="hidden" id="ind" value="'.$_GET['ind'].'" />';
                    	}else{
                    	    echo '<input type="hidden" id="ind" value="0" />';
                    	}
					    
					
					?>

					<div class="container-login100-form-btn">
						<button id="btn_create_cli" onclick="create();" class="login100-form-btn">
							Criar
						</button>
						<span id="responde_msg" ></span>
					</div>
    

					<div class="text-center p-t-100">

					</div>
				</div>
			</div>
		</div>
	</div>


    <input type="hidden" value="<?php if(isset($_GET['plano'])){ echo $_GET['plano']; }else{ echo '0'; } ?>" id="idplano" />

<!--===============================================================================================-->
	<script src="https://cliente.gestorlite.com/login/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="https://cliente.gestorlite.com/login/vendor/bootstrap/js/popper.js"></script>
	<script src="https://cliente.gestorlite.com/login/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="https://cliente.gestorlite.com/login/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
    <script src="https://cliente.gestorlite.com/login/vendor/tilt/tilt.jquery.min.js"></script>
    
    <script src="<?=SET_URL_PRODUCTION?>/login/js/jquery.mask.js"></script>
    
	<script >
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
	</script>
<!--===============================================================================================-->
	<script src="https://cliente.gestorlite.com/login/js/main.js"></script>
	<script src="<?=SET_URL_PRODUCTION?>/cliente/login/js/function.js"></script>

</body>
</html>
