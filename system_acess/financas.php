<?php

if (isset($_SESSION['SUB_ACCESS'])) {
    echo '<script>location.href="index.php?page=home";</script>';
    die;
}


if (!isset($_SESSION['ADMIN_LOGADO'])) {
    echo '<script>location.href="index.php?page=login";</script>';
    die;
}

//$get_dados_users = json_decode( file_get_contents('SET_URL_PRODUCTION/system_acess/cont_user.php') );

$url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
$url .= "://" . $_SERVER['HTTP_HOST'];
$url .= "/".explode("/", substr(str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER["SCRIPT_NAME"]), 0, -1))[1];
$url .= "/cont_user.php";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$get_dados_users = json_decode(curl_exec($curl));

curl_close($curl);
$whatsapi_class = new Whatsapi();
$comprovantes_class = new Comprovantes();
$gestor_class = new Gestor();
$financeiro_class = new Financeiro();

$traffic_class = new Traffic();
$num_traffic = $traffic_class->count_traffic_prossing();

$flyers_class = new Flyer();
$num_flyers = $flyers_class->count_flyer_prossing();

if (isset($_GET['delete_mov'])) {
    $id_mov = $_GET['delete_mov'];
    if ($financeiro_class->remove_mov_admin($id_mov)) {
        echo '<script>location.href="?page=financas&color_msg_hide=success&msg_hide=Removido com sucesso";</script>';
        die;
    } else {
        echo '<script>location.href="?page=financas&color_msg_hide=danger&msg_hide=Erro ao remover";</script>';
        die;
    }
}

$list_contatos = $gestor_class->list_contatos();
$list_contatos3 = $gestor_class->list_contatos();

$list_faturas = $gestor_class->list__faturas_user_pay();
$list_faturas2 = $gestor_class->list__faturas_user_pay();

$num_fila_zap = $whatsapi_class->count_fila();
$num_comprovantes = $comprovantes_class->count_comp();

$valor_mes = $gestor_class->soma_mes_atual_gestor();

if ($list_contatos3) {
    $num_contatos = count($list_contatos3->fetchAll(PDO::FETCH_OBJ));
} else {
    $num_contatos = 0;
}

if ($list_faturas2) {
    $num_faturas = count($list_faturas2->fetchAll(PDO::FETCH_OBJ));
} else {
    $num_faturas = 0;
}


$valor_mes_atual = explode('|', $financeiro_class->soma_mes_atual_admin());
$movimentacoes = $financeiro_class->list_admin(5000000);
$movimentacoes2 = $financeiro_class->list_admin(5000000);


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Administrativo</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/dashboard/">

    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/docs/4.5/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"
          integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <meta name="theme-color" content="#563d7c">

    <link href="<?= SET_URL_PRODUCTION ?>/img/favicon.ico" rel="shortcut icon"/>

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .table-cell-edit {
            background-color: lightgoldenrodyellow;
        }
    </style>
    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">
</head>
<body>
<?php require_once 'inc/nav.php'; ?>
<div class="container-fluid">
    <div class="row">
        <?php require_once 'inc/menu.php'; ?>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">


            <div class="row" style="margin-top:10px;">
                <div class="col-md-3">
                    <div style="padding:10px;" class="card">
                        <h4><i class="text-secondary fa fa-dollar"></i>
                            R$ <?= $financeiro_class->convertMoney(2, ($financeiro_class->convertMoney(1, $valor_mes_atual[0]) - $financeiro_class->convertMoney(1, $valor_mes_atual[1]))); ?>
                        </h4>
                        <small>Saldo atual</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div style="padding:10px;" class="card">
                        <h4><i class="text-success fa fa-arrow-up"></i> R$ <?= $valor_mes_atual[0]; ?></h4>
                        <small>Entrada: <?= $financeiro_class->text_mes(date('m'), true); ?></small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div style="padding:10px;" class="card">
                        <h4><i class="text-info fa fa-handshake-o"></i> R$ <?= $valor_mes; ?></h4>
                        <small style="font-size:12px;">Valor Não Tarifado | Mercado Pago / TED</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div style="padding:10px;" class="card">
                        <h4><i class="text-danger fa fa-arrow-down"></i> R$ <?= $valor_mes_atual[1]; ?></h4>
                        <small>Total Saidas</small>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row" style="margin-top:10px;">

                <?php

                foreach ($get_dados_users->p as $key => $value) {

                    ?>
                    <div class="col-md-3">
                        <div style="padding:10px;" class="card">
                            <h4><i class="text-secondary fa fa-users"></i> <?= $value->qtd; ?></h4>
                            <small><?= $value->plano; ?></small>
                        </div>
                    </div>
                <?php } ?>

                <div style="margin-top:5px;" class="col-md-4">
                    <div style="padding:10px;" class="card">
                        <h4><i class="text-secondary fa fa-users"></i> <?= $get_dados_users->total; ?></h4>
                        <small>TOTAL</small>
                    </div>
                </div>


                <div style="margin-top:5px;" class="col-md-4">
                    <div style="padding:10px;" class="card">
                        <h4 class="<?php if ($get_dados_users->porcentagem < 10) {
                            echo 'text-danger';
                        } ?><?php if ($get_dados_users->porcentagem > 10 && $get_dados_users->porcentagem < 50) {
                            echo 'text-warning';
                        } ?><?php if ($get_dados_users->porcentagem > 50 && $get_dados_users->porcentagem < 100) {
                            echo 'text-success';
                        } ?>"><i class="<?php if ($get_dados_users->porcentagem < 10) {
                                echo 'text-danger';
                            } ?><?php if ($get_dados_users->porcentagem > 10 && $get_dados_users->porcentagem < 50) {
                                echo 'text-warning';
                            } ?><?php if ($get_dados_users->porcentagem > 50 && $get_dados_users->porcentagem < 100) {
                                echo 'text-success';
                            } ?> fa fa-percent"></i> <?= $get_dados_users->porcentagem; ?></h4>
                        <small>Isso representa <b><?= $get_dados_users->porcentagem; ?> %</b> de todos os
                            clientes</small>
                    </div>
                </div>


            </div>


            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <div class="btn-gorup">
                    <button onclick="add_novimentacao();" class="btn btn-info btn-sm"><i class="fa fa-plus"></i>
                        Adicionar movimentação
                    </button>
                </div>
            </div>
            <?php if (isset($_GET['msg_hide'])) { ?>
                <div id="msg_hide" class="alert alert-<?= $_GET['color_msg_hide'] ?>">
                    <?= $_GET['msg_hide']; ?>
                </div>
                <script>
                    setTimeout(function () {
                        $("#msg_hide").hide(100);
                    }, 5000);
                </script>
            <?php } ?>

            <div class="row">
                <div class="col-md-12">

                    <div class="card">
                        <div class="card-head">
                            <h4>Movimentações</h4>
                        </div>
                        <div class="card-body">

                            <div style="margin-bottom:50px;" class="table-responsive">
                                <table id="table_mov" class="">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Valor</th>
                                        <th>Tipo</th>
                                        <th>Data</th>
                                        <th>Nota</th>
                                        <th>Opção</th>
                                        <th style="display:none"></th>
                                    </tr>
                                    </thead>
                                    <tbody>


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="margin-top:50px;" class="col-md-12">
                    <div class="card">
                        <div class="card-head">
                            <h4>Lista de faturas pagas</h4>
                        </div>
                        <div class="card-body">

                            <div style="margin-bottom:50px;" class="table-responsive">
                                <table id="table_faturas_pay" class="">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Valor</th>
                                        <th>Status</th>
                                        <th>Forma</th>
                                        <th>Data</th>
                                        <th>REF</th>
                                        <th>Cliente</th>
                                        <th>Opção</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </main>
    </div>
</div>

<!-- Modal confirm -->
<div class="modal fade" id="modal_confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div id="header_color" class="modal-header">
                <h5 class="modal-title" id="title_confirm"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="text-center modal-body">
                <center><h3 id="msg_confirm"></h3></center>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <a type="button" class="btn btn-primary text-white" id="button_confirm">Continuar</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal modal_nota_view -->
<div class="modal fade" id="modal_nota_view" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div id="header_color" class="modal-header">
                <h5 class="modal-title" id="title_confirm">Nota da movimentação</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="p_nota"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal movimentacao -->
<div class="modal fade" id="modal_add_mov" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div id="header_color" class="modal-header">
                <h5 class="modal-title" id="title_confirm">Adicionar movimentacao</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="text" placeholder="Valor" id="valor" class="form-control"/>
                </div>
                <div class="form-group">
                    <select id="tipo" class="form-control">
                        <option value="1">Entrada</option>
                        <option value="2">Saída</option>
                    </select>
                </div>
                <div class="form-group">
                    <textarea id="nota" class="form-control" placeholder="Nota sobre a movimentação"></textarea>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" onclick="add_mov_fun();" class="btn btn-primary text-white" id="btn_add_mov">
                    Adicionar
                </button>
            </div>
        </div>
    </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="<?= SET_URL_PRODUCTION ?>/painel/js/jquery.maskMoney.js"></script>

<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

<script>


    $(document).ready(function () {

        // $.fn.dataTable.moment('DD/MM/YYYY');


        $('#table_mov').DataTable({
            "order": [[0, "desc"]],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "scripts/post2.php",
                "type": "POST"
            },
            "columns": [
                {"data": "id"},
                {"data": "valor"},
                {"data": "tipo"},
                {"data": "data"},
                {"data": "nota"},
                {"data": "opc"}
            ]
        });

        //  $('#table_faturas_pay').DataTable( {
        //     "order": [[ 0, "desc" ]],
        //     "processing": true,
        //     "serverSide": true,
        //     "ajax": {
        //         "url": "scripts/post3.php?pagos",
        //         "type": "POST"
        //     },
        //     "columns": [
        //         { "data": "id" },
        //         { "data": "valor" },
        //         { "data": "status" },
        //         { "data": "forma" },
        //         { "data": "data" },
        //         { "data": "ref" },
        //         { "data": "id_user" },
        //         { "data": "opc" }
        //     ]
        // } );


        $("#valor").maskMoney({prefix: 'R$ ', thousands: '.', decimal: ',', affixesStay: true});


    });


    function modal_view_nota(idmov) {
        var nota = $("#nota_" + idmov).val();
        $("#p_nota").html(nota);
        $("#modal_nota_view").modal('show');
    }

    function add_mov_fun() {

        $("#btn_add_mov").prop('disabled', true);
        $("#btn_add_mov").html('Aguarde <i class="fa fa-refresh fa-spin" ></i>');

        var valor = $("#valor").val();
        var tipo = $("#tipo").val();
        var nota = $("#nota").val();

        $.post('control/add_mov.php', {valor: valor, tipo: tipo, nota: nota}, function (data) {
            var obj = JSON.parse(data);

            if (obj.erro) {
                alert(obj.msg);
                $("#btn_add_mov").prop('disabled', false);
                $("#btn_add_mov").html('Adicionar');

            } else {
                location.href = "?page=financas&color_msg_hide=success&msg_hide=Adicionado com sucesso!";
            }
        });
    }

    function add_novimentacao() {
        $("#modal_add_mov").modal('show');
    }

    function modal_confirm(url, msg, bg) {
        $("#header_color").removeClass();
        $("#header_color").addClass('modal-header ' + bg);
        $("#title_confirm").html(' <i class="fa fa-warning" ></i> ' + msg);
        $("#button_confirm").attr('href', url);
        $("#msg_confirm").html(msg);
        if (bg == "bg-danger") {
            $("#title_confirm").addClass('text-white');
        } else {
            $("#title_confirm").removeClass('text-white');
        }


        $("#modal_confirm").modal('show');

    }

    function view_contato(contato) {
        $.get('index.php?page=contato&dados_contato=' + contato, function (data) {
            var contato_res = JSON.parse(data);
            $("#nome").val(contato_res.nome);
            $("#email").val(contato_res.email);
            $("#telefone").val(contato_res.whatsapp);
            $("#assunto").val(contato_res.assunto);
            $("#msg").text(contato_res.msg);
            $("#cliente").val(contato_res.cliente);
            $("#data").val(contato_res.data);
            $("#ip").val(contato_res.ip);
            $("#cidade").val(contato_res.cidade);
        });
    }


</script>


</body>
</html>
