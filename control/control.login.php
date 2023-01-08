<?php

@session_start();

date_default_timezone_set('America/Sao_Paulo');
require_once "../config/settings.php";

/*
 * Control Login
 */

$KEYSECRET_RECAPTCHA = "6LdlwbEaAAAAAMeB5rgyitMHi3R3vn6cmUust5xD";

if (isset($_POST['token'])) {
    $captcha_data = $_POST['token'];
    $continue = true;

    $resposta = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $KEYSECRET_RECAPTCHA . "&response=" . $captcha_data . "&remoteip=" . $_SERVER['REMOTE_ADDR']));

    if ($resposta->success) {
        $continue = true;
    } else {

        $data = new stdClass();
        $data->erro = true;
        $data->msg = "reCaptcha incorreto";

        return json_encode($data);
        exit();
    }


} else {
    $data = new stdClass();
    $data->erro = true;
    $data->msg = "Complete o reCaptcha";

    return json_encode($data);
    exit();

}


if (isset($_POST['email']) && isset($_POST['senha'])) {

    $email = $_POST['email'];
    $senha = $_POST['senha'];


    if ($email != "" && $senha != "") {

        require_once '../class/Conn.class.php';
        require_once '../class/Login.class.php';
        require_once '../class/Logs.class.php';

        $login = new Login();
        $logs = new Logs();

        $request = [
            'email' => $email,
            'pass' => $senha
        ];


        $log = $login->login($request);

        $obj = json_decode($log);

        if ($obj->erro == false) {

            if (isset($_POST['parceiro'])) {

                $_SESSION['AFILIADO'] = (array)$obj;
                $_SESSION['GESTOR']['plano'] = $obj->id_plano;

            } else {
                if (isset($_SESSION['SESSION_CVD'])) {
                    $logs->log($obj->id, 'Um convidado acessou a conta');
                } else {
                    $logs->log($obj->id, 'Efetuou login');
                }
                $obj = json_decode($log);

                $_SESSION['GESTOR']['plano'] = $obj->id_plano;
            }


        }


        echo $log;

    }


}


?>
