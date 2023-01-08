<?php

if (!isset($_SESSION['ADMIN_LOGADO'])) {
    echo '<script>location.href="index.php?page=login";</script>';
    die;
}

$whatsapi_class = new Whatsapi();
$comprovantes_class = new Comprovantes();
$gestor_class = new Gestor();
$faturas_class = new Faturas();
$user_class = new User();
$mp_class = new MercadoPago();
$revenda_class = new Revenda();

$traffic_class = new Traffic();
$num_traffic = $traffic_class->count_traffic_prossing();

$flyers_class = new Flyer();
$num_flyers = $flyers_class->count_flyer_prossing();


$num_fila_zap = $whatsapi_class->count_fila();
$comprovantes = $comprovantes_class->list_comp();
$num_comprovantes = $comprovantes_class->count_comp();

if (isset($_POST['aceita_comp'])) {

    $fat = $_POST['fat'];
    $user = $_POST['user'];

    if ($comprovantes_class->aprova_comp($fat, $user, $user_class, $faturas_class, $whatsapi_class, $mp_class, $gestor_class, $revenda_class)) {
        echo json_encode(array('success' => true));
        die;
    } else {
        echo json_encode(array('success' => false));
        die;
    }
}

if (isset($_POST['rejeita_comp'])) {

    $fat = $_POST['fat'];
    $user = $_POST['user'];

    if ($comprovantes_class->rejeita_comp($fat, $user, $user_class, $faturas_class, $whatsapi_class, $mp_class, $gestor_class, $revenda_class)) {
        echo json_encode(array('success' => true));
        die;
    } else {
        echo json_encode(array('success' => false));
        die;
    }
}


if (isset($_POST['remove_comp'])) {

    $fat = $_POST['fat'];

    if ($comprovantes_class->remove_comp($fat)) {
        echo json_encode(array('success' => true));
        die;
    } else {
        echo json_encode(array('success' => false));
        die;
    }
}


$list_contatos3 = $gestor_class->list_contatos();
if ($list_contatos3) {
    $num_contatos = count($list_contatos3->fetchAll(PDO::FETCH_OBJ));
} else {
    $num_contatos = 0;
}

?>
<!doctype html>
<html lang="pt-br">
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
                <h1 class="h2"><i class="fa fa-upload"></i> Comprovantes <?= $num_comprovantes; ?> </h1>
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
                    <h4>Comprovantes</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_users2" class="">
                            <thead>
                            <tr>
                                <th style="display:none;">1</th>
                                <th>Id</th>
                                <th>Arquivo</th>
                                <th>Cliente</th>
                                <th>Valor</th>
                                <th>Fatura</th>
                                <th>Opção</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php if ($num_comprovantes > 0) {

                                while ($comprovante = $comprovantes->fetch(PDO::FETCH_OBJ)) {

                                    $fatura = $faturas_class->dados($comprovante->id_fat);

                                    ?>


                                    <tr>
                                        <td><?= $comprovante->id; ?></td>
                                        <td><?php if ($fatura->comprovante != '0') {
                                                echo '<a target="_blank" href="'.SET_URL_PRODUCTION.'/comprovantes/' . $fatura->comprovante . '" >' . $fatura->comprovante . ' <i class="fa fa-external-link" ></i></a>';
                                            } ?></td>
                                        <td><?= $fatura->id_user; ?></td>
                                        <td>R$ <?= $fatura->valor; ?></td>
                                        <td><?= $fatura->id; ?></td>
                                        <td>

                                            <button onclick="aceita_comp(<?= $fatura->id; ?>,<?= $fatura->id_user; ?>);"
                                                    id="btn_aceita_comp<?= $fatura->id; ?>"
                                                    class="btn btn-sm btn-success" title="Aceitar">
                                                <i class="fa fa-check"></i>
                                            </button>
                                            <button onclick="rejeita_comp(<?= $fatura->id; ?>,<?= $fatura->id_user; ?>);"
                                                    id="btn_rejeita_comp<?= $fatura->id; ?>"
                                                    class="btn btn-sm btn-danger" title="Rejeitar">
                                                <i class="fa fa-close"></i>
                                            </button>
                                            <button onclick="remove_comp(<?= $fatura->id; ?>);"
                                                    id="remove_comp<?= $fatura->id; ?>" class="btn btn-sm btn-danger"
                                                    title="Remover">
                                                <i class="fa fa-trash"></i>
                                            </button>

                                        </td>
                                    </tr>

                                <?php }
                            } ?>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

        </main>
    </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
        crossorigin="anonymous"></script>

<script>
    $(document).ready(function () {


        $('#table_users2').DataTable({
            "order": [[0, "asc"]]
        });

    });


    function aceita_comp(fat, user) {

        $("#btn_aceita_comp" + fat).prop('disabled', true);
        $("#btn_aceita_comp" + fat).html('<i class="fa fa-refresh fa-spin" ></i>');

        $.post('index.php?page=comprovantes', {aceita_comp: true, fat: fat, user: user}, function (data) {
            var resposta = JSON.parse(data);
            if (resposta.success) {
                alert('Comprovante Aceito');
                location.reload();
            } else {
                alert('Erro ao aceitar comprovante');
                location.reload();
            }
        });
    }


    function remove_comp(fat) {
        $("#remove_comp" + fat).prop('disabled', true);
        $("#remove_comp" + fat).html('<i class="fa fa-refresh fa-spin" ></i>');

        $.post('index.php?page=comprovantes', {remove_comp: true, fat: fat}, function (data) {
            var resposta = JSON.parse(data);
            if (resposta.success) {
                alert('Comprovante removido');
                location.reload();
            } else {
                alert('Erro ao remover comprovante');
                location.reload();
            }
        });
    }

    function rejeita_comp(fat, user) {

        $("#btn_rejeita_comp" + fat).prop('disabled', true);
        $("#btn_rejeita_comp" + fat).html('<i class="fa fa-refresh fa-spin" ></i>');

        $.post('index.php?page=comprovantes', {rejeita_comp: true, fat: fat, user: user}, function (data) {
            var resposta = JSON.parse(data);
            if (resposta.success) {
                alert('Comprovante Recusado');
                location.reload();
            } else {
                alert('Erro ao recusar comprovante');
                location.reload();
            }
        });
    }


    function view_fatura(fat, user) {
        $.get('index.php?page=faturas-user&user=' + user + '&dados_fatura=' + fat, function (data) {
            var fatura_res = JSON.parse(data);
            $("#id").val(fatura_res.id);
            $("#forma").val(fatura_res.forma);
            $("#id_fat").val(fatura_res.id);
            $("#valor").val(fatura_res.valor);
            $("#status").val(fatura_res.status);
            $("#data").val(fatura_res.data);
        });
    }


</script>


</body>
</html>
