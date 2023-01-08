<!DOCTYPE html>
<html lang="pt-br">
<head><meta charset="euc-jp">
	<title>Gestor Lite</title>
	
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
		<div class="container-login100" style="background-image: url('images/bgsite.webp');">
			<div class="wrap-login100">
				<div class="login100-form validate-form">
					<span style="overflow:hidden;" class="login100-form-logo">
						<img style="width: 100px;" src="images/logo-login.png" />
					</span>
					<center><span class="text-center" id="msg" ></span></center>
					<span class="login100-form-title p-b-34 p-t-27">
					LOGIN
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Digite seu e-mail">
						<input class="input100" type="email" id="email" name="email" placeholder="Digite seu e-mail">
					</div>

					<div class="wrap-input100 validate-input" data-validate="Digite sua senha">
						<input class="input100" type="password" id="senha" name="senha" placeholder="Digite sua senha">
					</div>

					<div class="container-login100-form-btn">
						<button id="btn_login" onclick="login();" class="login100-form-btn">
							Entrar
						</button>
					</div>

					<div class="text-center p-t-90">
						<a class="text-white txt1" style="cursor:pointer;" data-toggle="modal" data-target="#modal_recover_pass">
							Não lembra da senha ?
						</a>
						<span style="color:#fff;" >&nbsp; | &nbsp; </span>
						<a class="txt1" href="create">
							Não tem conta ?
						</a>
					</div>

				</div>
			</div>
		</div>

	</div>
	


<!-- Modal -->
<div class="modal fade" id="modal_recover_pass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Recuperar Senha</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" >
         <div class="container" >
             
             
             <div class="row" id="body_modal_recover" >
                 
                 
                 <div class="col-md-12" >
                     
                     <div class="form-group" >
                         
                         <input type="email" placeholder="Diga seu email" class="form-control" id="email_recover" name="email_recover" value="" />
                         
                     </div>
                     <small id="response_erro" ></small>
                     
                     
                 </div>
                 
                 
             </div>
             
         </div>
         
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button onclick="recover_pass();" id="btn_recover" type="button" class="btn btn-primary">Continuar</button>
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
	<script src="js/main.js"></script>
<!--===============================================================================================-->
	<script src="js/function.js"></script>
<!--===============================================================================================-->

 <script>
     function recover_pass(){
         
         $("#btn_recover").prop('disabled', true);
         $("#btn_recover").html('<i class="fa fa-refresh fa-spin" ></i> Aguarde');
         
         var email = $("#email_recover").val();
         $.post('recover_pass/recover.php',{email:email},function(data){
            var obj = JSON.parse(data);
            
            if(typeof obj != "undefined"){
                
                if(obj.erro){
                    $("#response_erro").addClass('text-danger');
                    $("#response_erro").html(obj.msg); 
                    
                    $("#btn_recover").prop('disabled', false);
                    $("#btn_recover").html('Continuar');
                    
                }else{
                    $("#body_modal_recover").html('<p>'+obj.msg+'</p>');
                    $("#btn_recover").html('<i class="fa fa-check" ></i> Enviado');
                }
                
            }else{
                $("#response_erro").addClass('text-danger');
                $("#response_erro").html('Erro, tente novamente mais tarde.');
                $("#btn_recover").prop('disabled', false);
                $("#btn_recover").html('Continuar');
            }
            
         });
     }
 </script>

</body>
</html>
