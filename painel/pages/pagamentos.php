<?php
if (isset($_SESSION['pre_cadastro'])) {
    unset($_SESSION['pre_cadastro']);
}


define('ProPayPal', 0);
if (ProPayPal) {
    define("PayPalClientId", "*********************");
    define("PayPalSecret", "*********************");
    define("PayPalBaseUrl", "https://api.paypal.com/v1/");
    define("PayPalENV", "production");
} else {
    define("PayPalClientId", "ELytI2JOSdpGAoG0_ZGlAaByfFftlnl_yzBOwFTmpX4POb2_5qIqXXYTYABdt6uPjqvUK7jDghWytNA6");
    define("PayPalSecret", "ATHxtQ3_9wYYM5bjVDTApXC9Xs7ev_rqVwJO1H1d1aOvnjTDbB-u5bcBm8yVapiOCe_Yx630q2ryZkMN");
    define("PayPalBaseUrl", "https://api.sandbox.paypal.com/v1/");
    define("PayPalENV", "sandbox");
}


include "../qrcodes/qrlib.php";

$faturas_class = new Faturas();
$comprovantes_class = new Comprovantes();
$whatsapi_class = new Whatsapi();

$list_faturas = $faturas_class->list($_SESSION['SESSION_USER']['id']);

if (isset($_FILES) && isset($_POST['meio_pay_idFat'])) {
    $files = $_FILES;
    $post = $_POST;
    $comp = $comprovantes_class->uploadComp($files, $post, '../comprovantes/', $user, $whatsapi_class);

    if ($comp) {
        $msg = $comp;
    } else {
        $msg = "Desculpe, ocorreu um erro. Entre em contato com o suporte.";
    }
}


?>
<!-- Head and Nav -->
<?php include_once 'inc/head-nav.php'; ?>


<input type="hidden" value="<?= PayPalClientId; ?>" id="client_sandbox"/>
<input type="hidden" value="<?= PayPalClientId; ?>" id="client_production"/>
<input type="hidden" value="<?= PayPalENV; ?>" id="env"/>

<!-- NavBar -->
<?php include_once 'inc/nav-bar.php'; ?>

<main class="page-content">

    <div class="">

        <div style="padding: 10px;-webkit-box-shadow: 0px 0px 16px -2px rgb(0 0 0 / 84%);box-shadow: 0px 0px 16px -2px rgb(0 0 0 / 84%);width: 99%;"
             class="card row">

            <!--<div class="col-md-12">-->
            <!--    <div class="alert alert-danger" >-->
            <!--        <h2>Atenção</h2>-->
            <!--        <h4>NOVA CONTA PARA PAGAMENTOS (temporário)</h4>-->
            <!--    </div>-->
            <!--</div>-->


            <div class="col-md-12">
                <h1 class="h2"><?= $idioma->pagamentos; ?> <i class="fa fa-credit-card"></i></h1>
            </div>
            <div class="col-md-12">
                <?php if ($user->id_rev == 0) { ?>
                    <div class="col-md-6">
                        <button onclick="location.href='cart';" type="button" class="btn btn-outline-success"
                                name="button"><i class="fa fa-plus"></i> Nova fatura
                        </button>
                    </div>

                <?php } ?>
                <div class="col-md-6">
                    <?php if (isset($msg)) {
                        if ($msg != false) { ?>
                            <p class="alert alert-info">
                                <?= $msg; ?>
                            </p>
                        <?php }
                    } ?>
                </div>
                <?php if (isset($ven_user)) { ?>
                    <div class="col-md-12">
                        <p style="margin:10px;" class="alert alert-danger">
                            Seu painel expirou, renove para continuar
                        </p>
                    </div>
                <?php } ?>
            </div>


            <div class="col-md-12">
                <div class="row text-center" style="margin-top:5px;">
                    <div class="col-md-12">

                        <div class="table-responsive">
                            <table class="table table-striped table-sm">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th><?= $idioma->valor; ?></th>
                                    <th><?= $idioma->data; ?></th>
                                    <th><?= $idioma->forma; ?></th>
                                    <th><?= $idioma->status; ?></th>
                                    <th><?= $idioma->pagar; ?></th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php

                                if ($list_faturas) {

                                    $num_click = 0;

                                    while ($fatura = $list_faturas->fetch(PDO::FETCH_OBJ)) {

                                        $num_click++;

                                        if ($fatura->status == "Pendente") {
                                            if (!is_file('../qrcodes/imgs/' . $fatura->id . '.png')) {

                                                $filename = '../qrcodes/imgs/' . $fatura->id . '.png';
                                                $errorCorrectionLevel = 'L';
                                                $matrixPointSize = 4;

                                                QRcode::png('https://glite.me/c/' . $fatura->id, $filename, $errorCorrectionLevel, $matrixPointSize, 2);

                                            }
                                        }

                                        $moedaN = $faturas_class->getmoeda($fatura->moeda);

                                        switch ($fatura->status) {
                                            case 'Pendente':
                                                $status = "<span class='badge badge-secondary' >$idioma->pendente</span>";
                                                break;
                                            case 'Aprovado':
                                                $status = "<span class='badge badge-success' >$idioma->pago</span>";
                                                break;
                                            case 'Devolvido':
                                                $status = "<span class='badge badge-danger' >$idioma->devolvido</span>";
                                                break;
                                            case 'Rejeitado':
                                                $status = "<span class='badge badge-danger' >$idioma->rejeitado</span>";
                                                break;
                                            case 'Análise':
                                                $status = "<span class='badge badge-warning' >$idioma->analise</span>";
                                                break;
                                            case 'Cancelado':
                                                $status = "<span class='badge badge-danger' >$idioma->cancelado</span>";
                                                break;
                                            case 'Mediação':
                                                $status = "<span class='badge badge-danger' >$idioma->mediacao</span>";
                                                break;
                                            default:
                                                $status = "<span class='badge badge-info' >{$fatura->status}</span>";
                                                break;
                                        }

                                        switch ($fatura->forma) {

                                            case 'Boleto':
                                                $icon_f = "<i class='fa fa-barcode' ></i>";
                                                break;
                                            case 'TED':
                                                $icon_f = "<i class='fa fa-bank' ></i>";
                                                break;
                                            case 'Cartão de crédito':
                                                $icon_f = "<i class='fa fa-credit-card' ></i>";
                                                break;
                                            case 'Cartão de Débito':
                                                $icon_f = "<i class='fa fa-credit-card' ></i>";
                                                break;
                                            case 'Saldo MP':
                                                $icon_f = "<i class='fa fa-handshake-o' ></i>";
                                                break;
                                            case 'Meu Saldo':
                                                $icon_f = "<i class='fa fa-money' ></i>";
                                                break;

                                            default:
                                                $icon_f = "";
                                                break;
                                        }

                                        $comp_link = "<br /><span>&nbsp;</span>";

                                        if ($fatura->comprovante == '0') {
                                            if ($fatura->status != "Aprovado" && $fatura->status != "Devolvido" && $fatura->status != "Cancelado" && $fatura->status != "Mediação" && $fatura->status != "Rejeitado") {
                                                if ($fatura->forma == "Boleto" || $fatura->forma == "TED" || $fatura->forma == "Pendente") {
                                                    $comp_link = "<br /><a style='font-size:10px;' target='_blank' href='https://glite.me/c/" . $fatura->id . "' >Enviar comprovante <i class='fa fa-external-link' ></i></a>";
                                                }
                                            }
                                        }


                                        ?>


                                        <tr>
                                            <td title="<?= $idioma->o_identificador_e; ?> <?= $fatura->id; ?>"><?= $fatura->id; ?></td>
                                            <td title=""> <?= $moedaN->simbolo; ?> <?= $fatura->valor; ?> </td>
                                            <td title="<?= $idioma->data_fat_e; ?> <?= $fatura->data; ?> às <?= $fatura->hora; ?>"><?= $fatura->data; ?>
                                                - <?= $fatura->hora; ?></td>
                                            <td title="<?= $idioma->form_pay_fat_e; ?>  <?= $fatura->forma; ?>"><?= $icon_f . ' ' . $fatura->forma; ?><?php if ($fatura->comprovante != '0') {
                                                    echo '<a target="_blank" href="<?=SET_URL_PRODUCTION?>/comprovantes/' . $fatura->comprovante . '" ><i class="fa fa-file" ></i></a>';
                                                } ?><?= $comp_link; ?></td>
                                            <td title="<?= $idioma->status_fat_e; ?> <?= $fatura->status; ?>"><?= $status; ?></td>
                                            <td>
                                                <?php if ($fatura->status == "Pendente") { ?>
                                                    <button id="btn_pay_<?= $fatura->id; ?>"
                                                            onclick="init_pay_method(<?= $fatura->id; ?>,'<?= $fatura->moeda; ?>');"
                                                            title="PAGAR" type="button"
                                                            class="click_<?= $num_click; ?> btn btn-sm btn-success"
                                                            name="button"><?= $idioma->pagar; ?></button>
                                                    <button onclick="$('#id_fat_promo').val(<?= $fatura->id; ?>);$('#modal_codigo_promo').modal('show');"
                                                            class="btn btn-sm" <?php if ($dark == 1) {
                                                        echo 'style="color:#000;background-color:#fff;"';
                                                    } else {
                                                        echo 'style="color:#fff;background-color:#000;"';
                                                    } ?> ><i class="fa fa-ticket"></i></button>
                                                <?php } ?>
                                            </td>
                                        </tr>


                                    <?php }
                                } else { ?>

                                    <tr>
                                        <td class="text-center" colspan="6"><?= $idioma->nenhuma_fat_encontrada; ?></td>
                                    </tr>
                                <?php } ?>


                                </tbody>
                            </table>


                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>
</div>
</div>


<!--  Modal payments -->
<div class="modal fade" id="modal_payment_2" tabindex="-1" role="dialog" aria-labelledby="Titutlo_modal_payment_2"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="Titutlo_modal_payment_2">Como deseja pagar? <span id="valor_fat"></span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="body_modal_payment_2">


                <div class="row">

                    <div class="col-md-12 margin">


                        <div id="como_pagar" class="row">
                            <div class="col-md-4"></div>
                            <div <?php if ($user->af == 0 || $user->af == NULL) { ?> class="col-md-4" <?php } else { ?>  class="col-md-12  text-center" <?php } ?>
                                    id="mercadopago_div">
                                <button onclick="meio_pay('ted');" id="btn_mp_pay"
                                        class="btn btn-lg btn-outline-secondary">Pagamento por Pix
                                </button>
                            </div>

                            <!--<div  class="col-md-4"  style="display:none;" id="paypal_div" >-->
                            <!--    <button onclick="meio_pay('paypal');" id="btn_paypal_pay" class="btn btn-lg btn-outline-secondary" >PayPal <i class="fa fa-paypal" ></i></button>-->
                            <!--</div>-->

                            <?php if ($user->af == 0 || $user->af == NULL) { ?>
                                <!--<div class="col-md-4" >-->
                                <!--    <button onclick="meio_pay('ted');" class="btn btn-lg btn-outline-secondary" >Transferência <i class="fa fa-bank" ></i></button>-->
                                <!--</div>-->
                            <?php } ?>
                            <div class="col-md-4"></div>
                        </div>

                        <div style="display:none;" id="row_ted" class="row">
                            <div style="margin-bottom:10px;" class="col-md-12">
                                <button class="btn btn-secondary btn-sm"
                                        onclick="$('#row_ted').hide();$('#como_pagar').show(100);"><i
                                            class="fa-arrow-left fa"></i> Voltar
                                </button>
                            </div>

                            <div class="col-md-6">

                                <!--<ul>
                                    <li>
                                        Banco: <b>323</b> Mercado Pago
                                    </li>
                                    <li>
                                        Agência: <b>0001</b>
                                    </li>
                                    <li>
                                        Conta: <b>3511001336-1</b>
                                    </li>
                                     <li>
                                        Titular: <b>LUAN ROSA ALVES DA SILVA</b>
                                    </li>
                                    <li>
                                        CPF: <b>13026833908</b>
                                    </li>
                                </ul>-->
                                <hr>
                                <ul>

                                    <li>
                                        Titular: <b>Luan Rosa Alves Da Silva</b>
                                    </li>
                                    <li>
                                        CHAVE PIX: <b>130.268.339-08</b>
                                    </li>
                                    <center><strong><font size="4" color="#7922ff">QRCODE PIX</font></strong><br>
                                        <img src="<?= SET_URL_PRODUCTION ?>/painel/img/qrcode-pix.png?v=2" alt="Pix"
                                             width="70%"/><br/>
                                        <span>e43be946-3b08-4eea-b59d-a230053dea8b</span>

                                </ul>


                                <script>

                                    function copyById(containerId) {
                                        var range_ = document.createRange(); // create new Range object
                                        range_.selectNode(document.getElementById(containerId)); // set our Range to contain the Node we want to copy from
                                        window.getSelection().removeAllRanges(); // remove any previous selections
                                        window.getSelection().addRange(range_); // select
                                        document.execCommand("copy"); // copy to clipboard
                                        window.getSelection().removeAllRanges(); // remove selection
                                        alert("Copiado!");
                                    }


                                    // add onClick event handler to your button with additional function() to not invoke copyById immediately:
                                    document.getElementById('copy-button').onclick = function () {
                                        copyById('to-copy');
                                    }
                                </script>
                                </center>

                            </div>

                            <div class="col-md-6">
                                <p>Após efetuar a transferência, envie o comprovante pelo botão abaixo.</p>
                                <p>
                                <form id="form_comp" action="" method="POST" enctype="multipart/form-data">
                                    <label class="btn btn-outline-primary btn-sm " id="btn_comp" for="comprovante">Enviar
                                        comprovante</label>
                                    <input onchange="send_comp();" type="file" style="display:none;" name="comprovante"
                                           id="comprovante"/>
                                    <input type="hidden" id="meio_pay_idFat" name="meio_pay_idFat" value=""/>
                                </form>
                                </p>
                                <p>Precisa enviar o comprovante pelo celular ? Escaneie o QrCode Abaixo ou digite o
                                    endereço na barra de pesquisa.</p>
                                <p id="dados_mobile"></p>
                            </div>


                        </div>

                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $idioma->fechar; ?></button>
            </div>

        </div>
    </div>
</div>

<!--  Modal del clientes -->
<div class="modal fade" id="modal_payment_paypal" tabindex="-1" role="dialog"
     aria-labelledby="Titutlo_modal_payment_paypal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"
                    id="Titutlo_modal_payment_paypal"><?= $idioma->ta_quase_la; ?> <?= explode(' ', $user->nome)[0]; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="body_modal_payment_paypal">

                <div class="row">

                    <div class="col-md-12 text-center margin">

                        <h4><?= $idioma->pague_sua_fat; ?> <i class="fa fa-smile-o"></i></h4>

                        <div id="corpo_paypal">

                        </div>

                        <small><?= $idioma->seguro_pay; ?> <i class="fa fa-lock"></i> </small>
                        <br/>
                        <img width="100%" src="img/paypal.png" alt="">

                    </div>

                </div>

            </div>

        </div>
    </div>
</div>


<!--  Modal del clientes -->
<div class="modal fade" id="modal_payment" tabindex="-1" role="dialog" aria-labelledby="Titutlo_modal_payment"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"
                    id="Titutlo_modal_payment"><?= $idioma->ta_quase_la; ?> <?= explode(' ', $user->nome)[0]; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="body_modal_payment">

                <div class="row">

                    <div class="col-md-12 text-center margin">

                        <h4><?= $idioma->pague_sua_fat; ?> <i class="fa fa-smile-o"></i></h4>

                        <a style="width:100%" id="btn_mp" href="#" class="btn btn-info"><?= $idioma->pagar; ?></a>
                        <br/>
                        <small><?= $idioma->seguro_pay; ?> <i class="fa fa-lock"></i> </small>
                        <br/>
                        <img width="100%" src="../libs/MercadoPago/img/mercado-pago-logo.png" alt="">

                    </div>

                </div>

            </div>

        </div>
    </div>
</div>

<!--  Modal del clientes -->
<div class="modal fade" id="modal_codigo_promo" tabindex="-1" role="dialog" aria-labelledby="Titutlo_modal_codigo_promo"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="Titutlo_modal_payment"><?= explode(' ', $user->nome)[0]; ?>, utilize um
                    código promocional.</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="">

                <input id="id_fat_promo" value="" type="hidden"/>

                <div class="row">

                    <div class="col-md-12" id="response"></div>

                    <div class="col-md-12 text-center margin">

                        <div class="form-group">
                            <label>Informe um código promocional</label>
                            <input type="text" class="text-center form-control" style="text-transform: uppercase;"
                                   placeholder="Digite aqui" name="codigo_promo" id="codigo_promo"/>
                        </div>

                        <div class="form-group">
                            <button id="valida_cod" class="btn btn-success btn-sm" onclick="aply_promo();">Validar
                            </button>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>
</div>


</div>

<script src="https://www.paypalobjects.com/api/checkout.js"></script>


<script>

    function aply_promo() {
        $("#valida_cod").prop('disabled', true);
        var idFat = $("#id_fat_promo").val();
        var cod = $("#codigo_promo").val();
        $.post('../control/control.cod_promo.php', {promo: true, fat: idFat, cod: cod}, function (data) {
            try {

                var obj = JSON.parse(data);

                if (obj.erro) {
                    $("#response").html('<p class="alert alert-danger" >' + obj.msg + '</p>');
                } else {
                    $("#response").html('<p class="alert alert-success" >' + obj.msg + '</p>');
                    location.href = "";
                }

            } catch (e) {
                $("#response").html('<p class="alert alert-danger" >Erro inesperado, entre em contato com o suporte.</p>');
            }


            $("#valida_cod").prop('disabled', false);

        });
    }


    function init_pay_method(idFat, moeda) {
        $("#mercadopago_div").show();
        $("#paypal_div").hide();

        if (moeda != "BRL") {
            $("#mercadopago_div").hide();
            $("#paypal_div").show();
        }

        $("#row_ted").hide();
        $("#como_pagar").show(100);

        $('#btn_pay_' + idFat).prop('disabled', true);
        $('#btn_pay_' + idFat).html('<i class="fa fa-refresh fa-spin" ></i>');
        $("#meio_pay_idFat").val(idFat);
        $('#modal_payment_2').modal('show');
        $('#btn_pay_' + idFat).prop('disabled', false);
        $('#btn_pay_' + idFat).html('Pagar');
    }

    function send_comp() {
        $("#btn_comp").prop('disabled', true);
        $("#btn_comp").html('Aguarde... <i class="fa fa-refresh fa-spin" ></i> ');
        $("#form_comp").submit();
    }


    function init_paypal(idfat) {

    }


    function meio_pay(meio) {


        var idFat = $("#meio_pay_idFat").val();

        if (meio == 'mp') {
            $("#btn_mp_pay").prop('disabled', true);
            $("#btn_mp_pay").html('Mercado Pago <i class="fa fa-refresh fa-spin" ></i>');
            $("#modal_payment_2").modal('toggle');
            modal_payment_p(idFat);
            $("#btn_mp_pay").prop('disabled', false);
            $("#btn_mp_pay").html('Mercado Pago <i class="fa fa-handshake-o" ></i>');
        } else if (meio == "ted") {
            $("#como_pagar").hide();
            $("#row_ted").show(100);
            $("#dados_mobile").html('<center><img src="../qrcodes/imgs/' + idFat + '.png" /><br /><b>https://glite.me/c/' + idFat + '</b></center>');
        } else if (meio == "paypal") {
            $("#modal_payment_2").modal('toggle');
            $("#modal_payment_paypal").modal('show');
        }
    }
</script>

<!-- footer -->
<?php include_once 'inc/footer.php'; ?>
