<?php

header('Access-Control-Allow-Origin: *');
date_default_timezone_set('America/Sao_Paulo');


if (isset($_REQUEST['key'])) {

    require_once '../p/autoload.php';

    $json = json_decode(file_get_contents('php://input'));


    if (isset($json->senderMessage)) {
        $key = $_REQUEST['key'];
        $msg = $json->senderMessage;
        $num = str_replace(' ', '', str_replace(')', '', str_replace('(', '', str_replace('-', '', str_replace('+', '', $json->senderName)))));

        $reply = new ChatBot();

        $res = $reply->getReply($key, $msg, $num);

        if ($res) {
            echo '{"data":[{"message":"' . $res . '"}]}';
        } else {
            $reply->removeSession($num);
        }
    } else if (isset($json->appPackageName)) {

        $key = $_REQUEST['key'];
        $msg = $json->query->message;
        $num = str_replace(' ', '', str_replace(')', '', str_replace('(', '', str_replace('-', '', str_replace('+', '', $json->query->sender)))));

        $reply = new ChatBot();

        $res = $reply->getReply($key, $msg, $num);

        if ($res) {
            echo '{"replies":[{"message":"' . str_replace('<br />', '\n', nl2br($res)) . '"}]}';
        } else {
            $reply->removeSession($num);

            $messagePadrao = [
                "replies" => [
                    "message" => "Hum...🤔\n
                                Não consegui entender o que você falou, tenta novamente, por favor!"
                ]
            ];

            echo
        }

    } else {

        $json1 = file_get_contents('php://input');
        parse_str($json1, $output);

        if (isset($output['sender'])) {

            $key = $_REQUEST['key'];
            $msg = $output['message'];
            $num = str_replace(' ', '', str_replace(')', '', str_replace('(', '', str_replace('-', '', str_replace('+', '', $output['sender'])))));

            $reply = new ChatBot();

            $res = $reply->getReply($key, $msg, $num);

            if ($res) {
                echo '{"reply":"' . $res . '"}';
            } else {
                $reply->removeSession($num);
            }


        }


    }

}