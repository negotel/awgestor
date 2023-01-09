<?php

if (!isset($_SESSION['ADMIN_LOGADO'])) {
    echo '<script>location.href="index.php?page=login";</script>';
    die;
}


$whatsapi_class = new Whatsapi();
$comprovantes_class = new Comprovantes();
$gestor_class = new Gestor();
$user_class = new User();
$clientes_class = new Clientes();
$financeiro_class = new Financeiro();

$traffic_class = new Traffic();
$num_traffic = $traffic_class->count_traffic_prossing();

$flyers_class = new Flyer();
$num_flyers = $flyers_class->count_flyer_prossing();


$vendas_hj_fetch = $financeiro_class->vendas_day_admin(date('d/m/Y'));
$vendas_ontem = $financeiro_class->vendas_day_admin(date('d/m/Y', strtotime('-1 days', strtotime(date('d-m-Y')))));


$list_planos = $gestor_class->list_planos();
$list_planos2 = $gestor_class->list_planos();

$list_users2 = $user_class->list_users();
$list_users3 = $user_class->list_users();

$paises_ddi = json_decode(file_get_contents('https://raw.githubusercontent.com/luannsr12/ddi-json-flag/main/data2.json'), true);


// user pais
$user_pais = array();
while ($usersPais = $list_users3->fetch(PDO::FETCH_ASSOC)) {

    if (!isset($user_pais[$usersPais['ddi']])) {
        $user_pais[$usersPais['ddi']] = 1;
    } else {
        $user_pais[$usersPais['ddi']]++;
    }

}


// vendas hj
$value_vendas_hj['total'] = 0;
$value_vendas_hj['valor'] = 0;
if ($vendas_hj_fetch) {
    foreach ($vendas_hj_fetch as $key => $value) {
        $value_vendas_hj['total']++;
        $value_vendas_hj['valor'] += $financeiro_class->convertMoney(1, $value->valor);
    }
}

// vendas ontem
$value_vendas_ontem['total'] = 0;
$value_vendas_ontem['valor'] = 0;
if ($vendas_ontem) {
    foreach ($vendas_ontem as $key => $value) {
        $value_vendas_ontem['total']++;
        $value_vendas_ontem['valor'] += $financeiro_class->convertMoney(1, $value->valor);
    }
}


$num_fila_zap = $whatsapi_class->count_fila();
$num_comprovantes = $comprovantes_class->count_comp();


$list_contatos3 = $gestor_class->list_contatos();

if ($list_users2) {
    $num_users = count($list_users2->fetchAll(PDO::FETCH_OBJ));
} else {
    $num_users = 0;
}

if ($list_contatos3) {
    $num_contatos = count($list_contatos3->fetchAll(PDO::FETCH_OBJ));
} else {
    $num_contatos = 0;
}

if (isset($_GET['delete_user'])) {
    if ($user_class->delete_user($_GET['delete_user'])) {
        $msg_hide = "Usuario deletado";
        $color = "success";
    } else {
        $msg_hide = "Erro ao deletar usuario";
        $color = "danger";
    }

    echo '<script>location.href="?page=home&color_msg_hide=' . $color . '&msg_hide=' . $msg_hide . '";</script>';
}


if (isset($_POST['edite_user'])) {
    $dados = json_decode($_POST['dados']);

    if ($user_class->update_user_admin($dados->nome, $dados->email, $dados->telefone, $dados->senha, $dados->vencimento, $dados->id, $dados->id_plano)) {
        echo json_encode(array('success' => true));
        die;
    } else {
        echo json_encode(array('success' => false));
        die;
    }
}

if (isset($_GET['dados_user'])) {
    $user = $user_class->dados($_GET['dados_user']);
    echo json_encode($user);
    die;
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

    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/docs/4.5/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"
          integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <!-- Gestor Lite notify -->
    <script>
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js  = d.createElement(s); js.id = id;
            memberidGl = 1;
            js.src = 'https://localhost/gestolite/painel/notify-gestor/notify-gestorlite.js?v=9';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'notify-gestor-lite'));
    </script>
    <!-- Gestor Lite notify -->

    <meta name="theme-color" content="#563d7c">

    <link href="<?= SET_URL_PRODUCTION ?>/img/favicon.ico" rel="shortcut icon"/>

    <!-- Custom styles for this template -->
<!--    <link href="--><?//= SET_URL_PRODUCTION ?><!--/painel/css/dashboard.css" rel="stylesheet">-->
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

</head>
<body>
<?php require_once 'inc/nav.php'; ?>
<div class="container-fluid">
    <div class="row">
        <?php require_once 'inc/menu.php'; ?>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><i class="fa fa-users"></i> Clientes <?= $num_users; ?></h1>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Exportar clientes: </label>
                        <select onchange="export_type();" id="export_type" class="form-control form-control-sm">
                            <option value="">Selecionar</option>
                            <optgroup label="Geral">
                                <option value="&type=vencidos">Clientes Vencidos</option>
                                <option value="&type=vencidos&patrao">Clientes Patrão vencidos</option>
                            </optgroup>

                            <optgroup label="Mail Wizz">
                                <option value="&type=marketing_mail_all_mailwizz">Todos clientes Marketing Mail</option>
                            </optgroup>

                            <optgroup label="Marketing Mail">
                                <option value="&type=vencidos&patrao&mail">Clientes Patrão vencidos Marketing Mail
                                </option>
                                <option value="&type=marketing_mail_all">Todos clientes Marketing Mail</option>
                                <option value="&type=marketing_mail_vencidos">Clientes Vencidos Marketing Mail</option>
                                <?php

                                while ($plano = $list_planos->fetch(PDO::FETCH_OBJ)) {
                                    echo '<option value="&type=marketing_mail_plano&idp=' . $plano->id . '&nameP=' . $plano->nome . '" >Clientes Plano ' . $plano->nome . ' Marketing Mail</option>';
                                }

                                ?>


                            </optgroup>

                        </select>
                    </div>

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

            <script>
                function export_type() {
                    var type = $("#export_type").val();

                    if (type != "") {
                        location.href = "?page=exporta_clientes" + type;
                    }

                }
            </script>


            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div style="margin-bottom:10px;" class="col-md-12">
                                <div class="card">
                                    <div class="card-head text-center">
                                        <h4>Vendas hoje: <?= date('d/m/Y'); ?></h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h3>
                                                    R$ <?= $financeiro_class->convertMoney(2, $value_vendas_hj['valor']); ?></h3>
                                            </div>
                                            <div class="col-md-6">
                                                <h3><?= $value_vendas_hj['total']; ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <?php

                                        if ($value_vendas_hj['valor'] > $value_vendas_ontem['valor']) {
                                            $valor = $value_vendas_hj['valor'] - $value_vendas_ontem['valor'];
                                            echo "<b><span class='text-success' >+ R$ " . $financeiro_class->convertMoney(2, $valor) . "</span> a mais que ontem</b>";
                                        } else if ($value_vendas_ontem['valor'] > $value_vendas_hj['valor']) {
                                            $valor = $value_vendas_ontem['valor'] - $value_vendas_hj['valor'];
                                            echo "<b><span class='text-danger' >- R$ " . $financeiro_class->convertMoney(2, $valor) . "</span> a menos que ontem</b>";
                                        }

                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-head text-center">
                                        <h4>Últimas vendas</h4>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-sm">
                                            <thead>
                                            <tr>
                                                <th scope="col">Valor</th>
                                                <th scope="col">Data</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i = 1;
                                            if ($vendas_hj_fetch) {
                                                foreach ($vendas_hj_fetch as $key => $value) { ?>
                                                    <tr>
                                                        <th class="text-success">+ R$ <?= $value->valor; ?></th>
                                                        <td><?= $value->data; ?></td>
                                                    </tr>
                                                    <?php $i++;
                                                    if ($i > 4) {
                                                        break;
                                                    }
                                                }
                                            }
                                            ?>
                                            <?php if ($i == 1) { ?>
                                                <tr>
                                                    <td colspan="2" class="text-center">Nenhuma venda hoje</td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>

                        </div>


                    </div>
                    <div class="col-md-6">


                        <div class="card">
                            <div class="row">
                                <div class="card-body">
                                    <table class="table table-striped table-bordered table-sm">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">País</th>
                                            <th scope="col">Clientes</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($user_pais as $key => $value) {

                                            $img = str_replace('23px', '80px', str_replace('22px', '80px', $paises_ddi[$key]['img']));
                                            $pais_name = $paises_ddi[$key]['pais'];

                                            if ($key == 1) {
                                                $img = "https://upload.wikimedia.org/wikipedia/commons/thumb/a/a4/Flag_of_the_United_States.svg/80px-Flag_of_the_United_States.svg.png";
                                                $pais_name = 'Estados Unidos';
                                            }

                                            ?>

                                            <tr>
                                                <td><img width="20" src="<?= $img; ?>"/></td>
                                                <td><?= $pais_name; ?></td>
                                                <td><?= $value; ?></td>
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

            <div class="" style="margin-top:20px;margin-bottom:200px;">
                <div class="card">
                    <div class="card-head text-center">
                        <h4>Usuários</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table_users" class="">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Telefone</th>
                                    <th>Plano</th>
                                    <th>Vencimento</th>
                                    <th>Clientes</th>
                                    <th>Opção</th>
                                </tr>
                                </thead>

                                <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Telefone</th>
                                    <th>Plano</th>
                                    <th>Vencimento</th>
                                    <th>Clientes</th>
                                    <th>Opção</th>
                                </tr>
                                </tfoot>


                            </table>

                        </div>

                    </div>
                </div>


            </div>
        </main>
    </div>
</div>

<!-- Modal edita user -->
<div class="modal fade" id="edita_user_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" value="" name="id_user_edite" id="id_user_edite"/>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Nome" value="" name="nome" id="nome"/>
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" placeholder="Email" value="" name="email" id="email"/>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Telefone" value="" name="telefone"
                           id="telefone"/>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Senha" value="" name="senha" id="senha"/>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Vencimento" value="" name="vencimento"
                           id="vencimento"/>
                </div>
                <div class="form-group">
                    <select class="form-control" id="id_plano" name="id_plano">
                        <?php

                        while ($plano = $list_planos2->fetch(PDO::FETCH_OBJ)) {
                            echo '<option value="' . $plano->id . '" >' . $plano->nome . '</option>';
                        }

                        ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" onclick="save_user();">Salvar</button>
            </div>
        </div>
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
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="<?= SET_URL_PRODUCTION ?>/painel/js/popper.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

<script>


    $(document).ready(function () {

        // $.fn.dataTable.moment('DD/MM/YYYY');


        $('#table_users').DataTable({
            "order": [[0, "desc"]],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "scripts/post.php",
                "type": "POST"
            },
            "columns": [
                {"data": "id"},
                {"data": "nome"},
                {"data": "email"},
                {"data": "telefone"},
                {"data": "id_plano"},
                {"data": "vencimento"},
                {"data": "clientes"},
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

    function dados_edite_user(user) {
        $.get('index.php?page=home&dados_user=' + user, function (data) {
            var dados_u = JSON.parse(data);
            $("#nome").val(dados_u.nome);
            $("#email").val(dados_u.email);
            $("#telefone").val(dados_u.telefone);
            $("#senha").val(dados_u.senha);
            $("#id_plano").val(dados_u.id_plano);
            $("#vencimento").val(dados_u.vencimento);
            $("#id_user_edite").val(dados_u.id);

            $("#edita_user_modal").modal('show');
        });
    }

    function save_user() {

        var dados_user_save = new Object();

        dados_user_save.nome = $("#nome").val();
        dados_user_save.email = $("#email").val();
        dados_user_save.telefone = $("#telefone").val();
        dados_user_save.senha = $("#senha").val();
        dados_user_save.vencimento = $("#vencimento").val();
        dados_user_save.id = $("#id_user_edite").val();
        dados_user_save.id_plano = $("#id_plano").val();

        var json_dados = JSON.stringify(dados_user_save);

        $.post('index.php?page=home', {edite_user: true, dados: json_dados}, function (data) {
            var resposta = JSON.parse(data);
            if (resposta.success) {
                alert('Usuario atualizado');
            } else {
                alert('Erro ao atualizar usuario');
            }
        });
    }


</script>


</body>
</html>
