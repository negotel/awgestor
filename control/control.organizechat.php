<?php

header('Content-Type: text/html; charset=utf-8');


/*Organize chat messages*/

@session_start();
require_once "../config/settings.php";
require_once '../class/Conn.class.php';
require_once '../class/User.class.php';

$user_class = new User();

$user = $user_class->dados($_SESSION['SESSION_USER']['id']);

if (isset($_POST['messages'])) {

    $messages = base64_decode($_POST['messages']);
    $messages = json_decode($messages);

    $msgs = $messages->session->msg;


    foreach ($msgs as $key => $msg) { ?>


        <div class="msg left-msg">
            <div class="msg-img"
                 style="background-image: url(<?= SET_URL_PRODUCTION ?>/painel/img/profile_chat.svg)"></div>

            <div class="msg-bubble">
                <div <?php if ($user == 1) {
                    echo "style='color:#7922ff;'";
                } ?> class="msg-info">
                    <div class="msg-info-name"><?= $_POST['name']; ?></div>
                    <div class="msg-info-time"><?= date('d/m/Y H:i', $msg->data); ?></div>
                </div>

                <div <?php if ($user == 1) {
                    echo "style='color:#7922ff;'";
                } ?> class="  msg-text">
                    <?= base64_decode($msg->receive); ?>
                </div>
            </div>
        </div>


        <div class="msg right-msg">
            <div class="msg-img"
                 style="background-image: url(<?= SET_URL_PRODUCTION ?>/painel/img/PROFILE_BOT.svg)"></div>

            <div class="msg-bubble">
                <div class="msg-info">
                    <div class="msg-info-name">BOT</div>
                    <div class="msg-info-time"><?= date('d/m/Y H:i', $msg->data); ?></div>
                </div>

                <div class="msg-text">
                    <?= base64_decode($msg->send); ?>
                </div>
            </div>
        </div>


    <?php }


}


?>