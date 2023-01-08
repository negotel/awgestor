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


$num_fila_zap = $whatsapi_class->count_fila();
$num_comprovantes = $comprovantes_class->count_comp();

$atualizacoes = $gestor_class->get_updates();

$list_contatos3 = $gestor_class->list_contatos();
if ($list_contatos3) {
    $num_contatos = count($list_contatos3->fetchAll(PDO::FETCH_OBJ));
} else {
    $num_contatos = 0;
}


if (isset($_POST['add_att'])) {
    $nome = $_POST['nome'];
    $texto = $_POST['texto'];
    $insert = $gestor_class->insert_update($nome, $texto);
}

if (isset($_POST['remove_att'])) {
    $id = $_POST['id'];
    $gestor_class->remove_att($id);
}

?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <link href="<?= SET_URL_PRODUCTION ?>/img/favicon.ico" rel="shortcut icon"/>

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
                <h1 class="h2">Atualizazções Gestor lite</h1>
                <button class="btn btn-info btn-sm" onclick="$('#modal_add_att').modal('show');">Adicionar</button>
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
                    <h4>Atualizações</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_users2" class="">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nome</th>
                                <th>Texto</th>
                                <th>Data</th>
                                <th>Opção</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php if ($atualizacoes) {

                                while ($att = $atualizacoes->fetch(PDO::FETCH_OBJ)) {

                                    ?>

                                    <textarea style="display:none;"
                                              id="texto_att_<?= $att->id; ?>"><?= $att->texto; ?></textarea>

                                    <tr>
                                        <td><?= $att->id; ?></td>
                                        <td><?= $att->nome; ?></td>
                                        <td><span class="text-info" style="cursor:pointer;"
                                                  onclick="view_texto(<?= $att->id; ?>);"><?= substr($att->texto, 0, 50) . '...'; ?></span>
                                        </td>
                                        <td><?= $att->data; ?></td>
                                        <td>

                                            <button onclick="remove_att(<?= $att->id; ?>);"
                                                    id="btn_remove_att_<?= $att->id; ?>" class="btn btn-sm btn-danger"
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

<!-- Modal -->
<div class="modal fade" id="modal_texto_att" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Texto Atualização</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="body_text_att">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal_add_att" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Adicionar Atualização</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="">
                <div class="form-group">
                    <input type="text" placeholder="Nome atualização" class="form-control" id="nome_att"/>
                </div>
                <div class="form-group">
                    <textarea class="form-control" id="texto_att" placeholder="Informe as novidades"
                              rows="5"></textarea>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-success" id="btn_add_att" onclick="add_att();">Adicionar</button>
            </div>
        </div>
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
            "order": [[0, "desc"]]
        });

    });


    function view_texto(id) {
        var texto = $("#texto_att_" + id).val();
        $("#body_text_att").html(texto);
        $("#modal_texto_att").modal('show');

    }

    function add_att() {
        var nome = $("#nome_att").val();
        var texto = $("#texto_att").val();

        if (nome != "" && texto != "") {


            $.post('index.php?page=atualizacoes', {add_att: true, nome: nome, texto: texto}, function (data) {
                location.href = "";
            });


        } else {
            alert("Informe Nome e Texto, Por favor meu jovem!");
            return false;
        }
    }


    function remove_att(id) {
        $.post('index.php?page=atualizacoes', {remove_att: true, id: id}, function (data) {
            location.href = "";
        });
    }


</script>


</body>
</html>
