<?php
	@session_start();


	 if(isset($_GET['plano'])){
          $_SESSION['plano'] = $_GET['plano'];
      }

	if(isset($_SESSION['PAINEL'])){
        
        if(isset($_SESSION['token'])){
            // login com token
            $postRequest = array(
                'token' => $_SESSION['token'],
                'painel' => $_SESSION['PAINEL']['slug']
            );
            
            $cURLConnection = curl_init('<?=SET_URL_PRODUCTION?>/control/control.login_cliente.php');
            curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, http_build_query($postRequest));
            curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
            
            $apiResponse = curl_exec($cURLConnection);
            curl_close($cURLConnection);
            $jsonArrayResponse = json_decode($apiResponse);

            if($jsonArrayResponse->erro == false){
                
              
                $dados = json_decode($apiResponse);
    
                $data = new stdClass();
                $data->erro         = false;
                $data->id           = $dados->id;
                $data->nome         = $dados->nome;
                $data->email        = $dados->email;
                $data->telefone     = $dados->telefone;
                $data->id_plano     = $dados->id_plano;
                $data->senha        = $dados->senha;
                $data->notas        = $dados->notas;
                
                $_SESSION['SESSION_CLIENTE'] = (array)$data;
                $_SESSION['LOGADO'] = true;
                
                unset($_SESSION['token']);
                
                if(isset($_GET['plano'])){
                    echo '<script>location.href="../'.$_SESSION['PAINEL']['slug'].'?plano='.$_GET['plano'].'"</script>';
                }else{
                    echo '<script>location.href="../'.$_SESSION['PAINEL']['slug'].'"</script>';
                }

                
                
  
            }
            
           
        }

	}else{
		echo "<center><h3 style='margin-top:20px;color:gray;font-family:arial;' >Algo de errado não está certo, entre em contato com o suporte!</h3><center>";
		exit;
	}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Login - <?= $_SESSION['PAINEL']['nome']; ?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="https://cliente.gestorlite.com/login/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="https://cliente.gestorlite.com/login/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.0.13/css/all.css'>
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
						Faça Login
					</span>

					<input type="hidden" name="painel_cliente" id="painel_cliente" value="<?= $_SESSION['PAINEL']['slug']; ?>">

					<div class="wrap-input100 validate-input" data-validate = "Digite um email valido tipo: bolsonaro@gov.br">
						<input class="input100" type="text" name="email" value="<?php if(isset($_SESSION['email_login'])){ echo $_SESSION['email_login']; }?>" id="email" placeholder="Digite seu email">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Senha inválida">
						<input class="input100" type="password" <?php if(isset($_SESSION['email_login'])){ echo 'autofocus'; }?> name="senha" id="senha" placeholder="Digite sua senha">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>

					<div class="container-login100-form-btn">
						<button id="btn_login_cli" onclick="login();" class="login100-form-btn">
							Login
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
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="https://cliente.gestorlite.com/login/js/main.js"></script>
	<script src="<?=SET_URL_PRODUCTION?>/cliente/login/js/function.js"></script>

</body>
</html>
