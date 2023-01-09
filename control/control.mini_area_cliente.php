<?php
require_once "../config/settings.php";
if (isset($_POST['type'])) {

    $type = trim($_POST['type']);

    $json = new stdClass();

    require_once '../class/Conn.class.php';
    require_once '../class/User.class.php';
    require_once '../class/Logs.class.php';
    require_once '../class/Gestor.class.php';
    require_once '../class/Clientes.class.php';

    $logs = new Logs();
    $gestor = new Gestor();
    $user = new User();
    $clientes = new Clientes();

    if ($type == "create") {

        $id_us = trim($_POST['idu']);
        $dados_u = $user->dados($id_us);

        if ($dados_u) {

            $plano_us = $gestor->plano($dados_u->id_plano);

            if ($plano_us->mini_area_cliente == 1) {

                $area_c = new stdClass();
                $area_c->nome_area = 'Área do cliente';
                $area_c->logo_area = 'none_area_cliente.png';
                $area_c->slug_area = 'clientes_' . $id_us;
                $area_c->situ_area = 1;
                $area_c->text_suporte = "Escreva aqui como seu cliente deve entrar em contato com você";
                $area_c->id_user = $id_us;


                if ($clientes->create_area_cli($area_c)) {

                    $json->erro = false;
                    $json->msg = "Área do cliente criada com sucesso";
                    echo json_encode($json);

                } else {

                    $json->erro = true;
                    $json->msg = "Aconteceu algum erro, entre em contato com o suporte";
                    echo json_encode($json);

                }

            } else {

                $json->erro = true;
                $json->msg = "Faça upgrade para usar está função";
                echo json_encode($json);

            }

        } else {

            $json->erro = true;
            $json->msg = "Parece que você não é usuario";
            echo json_encode($json);

        }

    }


} else {
    $json->erro = true;
    $json->msg = "Request is required";
    echo json_encode($json);
}


?>
