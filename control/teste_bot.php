<?php

  @session_start();

  if(isset($_SESSION['SESSION_USER']) && isset($_POST)){

       if(isset($_POST['key'])){

           require_once '../class/Conn.class.php';
           require_once '../class/ChatBot.class.php';



           if(isset($_POST['msg'])){
               $key = $_POST['key'];
               $msg = trim($_POST['msg']);
               $num = 'Testing';

               $reply = new ChatBot();

               $res = $reply->getReply($key,$msg,$num);

               if($res){
                   echo '{"success":true,"msg":"'.$res.'"}';
               }else{
                   $reply->removeSession($num);
               }
           }

       }
  }
