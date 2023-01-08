<?php

if (!isset($_SESSION['ADMIN_LOGADO'])) {
    echo '<script>location.href="index.php?page=login";</script>';
    die;
}

$whatsapi_class = new Whatsapi();
$comprovantes_class = new Comprovantes();
$gestor_class = new Gestor();

$traffic_class = new Traffic();
$num_traffic = $traffic_class->count_traffic_prossing();

$flyers_class = new Flyer();
$num_flyers = $flyers_class->count_flyer_prossing();

$list_contatos = $gestor_class->list_contatos();
$list_contatos3 = $gestor_class->list_contatos();

$list_faturas = $gestor_class->list__faturas_user();
$list_faturas2 = $gestor_class->list__faturas_user();

$num_fila_zap = $whatsapi_class->count_fila();
$num_comprovantes = $comprovantes_class->count_comp();

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


if (isset($_GET['delete_fat'])) {
    if ($gestor_class->delete_fat_user($_GET['delete_fat'])) {
        $msg_hide = "Fatura deletada";
        $color = "success";
    } else {
        $msg_hide = "Erro ao deletar fatura";
        $color = "danger";
    }

    echo '<script>location.href="?page=faturas&color_msg_hide=' . $color . '&msg_hide=' . $msg_hide . '";</script>';
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Administrativo</title>
    <link href="<?= SET_URL_PRODUCTION ?>/img/favicon.ico" rel="shortcut icon"/>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/dashboard/">

    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/docs/4.5/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"
          integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <meta name="theme-color" content="#563d7c">


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
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><i class="fa fa-file"></i> Faturas <?= $num_faturas; ?> </h1>
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

            <div class="card">
                <div class="card-head">
                    <h4>Lista de faturas</h4>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function () {


        $('#table_faturas_pay').DataTable({
            "order": [[0, "desc"]],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "scripts/post3.php",
                "type": "POST"
            },
            "columns": [
                {"data": "id"},
                {"data": "valor"},
                {"data": "status"},
                {"data": "forma"},
                {"data": "data"},
                {"data": "ref"},
                {"data": "id_user"},
                {"data": "opc"}
            ]
        });


    });

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
