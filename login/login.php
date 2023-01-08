<!DOCTYPE html>
<html lang="en">
<head>
    <title>Gestor Lite</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link href="<?= SET_URL_PRODUCTION ?>/img/favicon.ico" rel="shortcut icon"/>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
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
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-161698646-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());
        gtag('config', 'UA-161698646-1');
    </script>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
        function onSubmit(token) {
            login(token);
        }
    </script>

</head>
<body>

<div class="limiter">
    <div class="container-login100" style="background-image: url('images/login-fundo.png');background-size:cover;">
        <div class="wrap-login100">
            <form id="form-login">


                <div class="wrap-input100 validate-input" data-validate="Valid email is: a@b.c">
                    <input class="input100" autocomplete="off" list="autocompleteOff" type="text" id="email"
                           name="email">
                    <span class="focus-input100" data-placeholder="Email"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate="Sua Senha">
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
                    <input class="input100" autocomplete="off" list="autocompleteOff" id="senha" type="password" name="pass">
                    <span class="focus-input100" data-placeholder="Sua Senha"></span>
                </div>

                <div class="container-login100-form-btn">
                    <div class="wrap-login100-form-btn">
                        <div class="login100-form-bgbtn"></div>
                        <!--							<button data-sitekey="6LdlwbEaAAAAAJYZSh3czVPfYVkdLMwJR8KOsFLD" data-callback='onSubmit' id="btn_login" class="g-recaptcha login100-form-btn">-->
                        <!--								ENTRAR-->
                        <!--							</button>-->
                        <button data-sitekey="6LdlwbEaAAAAAJYZSh3czVPfYVkdLMwJR8KOsFLD" onclick="login(this)" data-callback='onSubmit' id="btn_login" class="login100-form-btn">
                            ENTRAR
                        </button>
                    </div>
                </div>
            </form>

            <div class="container-login100-form-btn">
                <div class="wrap-login100-form-btn">
                    <p id="msg" class="text-center text-info"></p>
                </div>
            </div>

            <div class="text-center p-t-90">
                <a class="txt1" style="cursor:pointer;" data-toggle="modal" data-target="#modal_recover_pass">
                    Não lembra da senha?
                </a>
                <span>&nbsp; | &nbsp; </span>
                <a class="txt1" href="create">
                    Não tem conta?
                </a>
            </div>

        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal_recover_pass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Recuperar Senha</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">


                    <div class="row" id="body_modal_recover">


                        <div class="col-md-12">

                            <div class="form-group">

                                <input type="email" placeholder="Diga seu email" class="form-control" id="email_recover"
                                       name="email_recover" value=""/>

                            </div>
                            <small id="response_erro"></small>


                        </div>


                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button onclick="recover_pass();" id="btn_recover" type="button" class="btn btn-primary">Continuar
                </button>
            </div>
        </div>
    </div>
</div>


<div id="dropDownSelect1"></div>

<!--===============================================================================================-->
<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/bootstrap/js/popper.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/daterangepicker/moment.min.js"></script>
<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
<script src="js/main.js?v=<?= filemtime('js/main.js'); ?>"></script>
<!--===============================================================================================-->
<script src="js/function.js?v=<?= filemtime('js/function.js'); ?>"></script>
<script src="js/jquery.mask.js"></script>


<script>
    function recover_pass() {

        $("#btn_recover").prop('disabled', true);
        $("#btn_recover").html('<i class="fa fa-refresh fa-spin" ></i> Aguarde');

        var email = $("#email_recover").val();
        $.post('recover_pass/recover.php', {email: email}, function (data) {
            var obj = JSON.parse(data);

            if (typeof obj != "undefined") {

                if (obj.erro) {
                    $("#response_erro").addClass('text-danger');
                    $("#response_erro").html(obj.msg);

                    $("#btn_recover").prop('disabled', false);
                    $("#btn_recover").html('Continuar');

                } else {
                    $("#body_modal_recover").html('<p>' + obj.msg + '</p>');
                    $("#btn_recover").html('<i class="fa fa-check" ></i> Enviado');
                }

            } else {
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