<?php


 /**
  *
  */
 class ChatBot extends Conn
 {

   function __construct()
   {
     $this->conn = new Conn();
     $this->pdo  = $this->conn->pdo();
   }

     public function getReplyById($id,$chatbot){

         $query = $this->pdo->query("SELECT * FROM `reply_chatbot` WHERE id='$id' AND id_chat='$chatbot' ");
         $fetch = $query->fetchAll(PDO::FETCH_OBJ);

         if(count($fetch)>0){

             $query = $this->pdo->query("SELECT * FROM `reply_chatbot` WHERE id='$id' AND id_chat='$chatbot' ");
             $fetch = $query->fetch(PDO::FETCH_OBJ);

             return $fetch;

         }else{
             return false;
         }


     }

    public function getchatbotByUser($user){

        $query = $this->pdo->query("SELECT * FROM `chatbot` WHERE id_user='$user' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);

        if(count($fetch)>0){

            $query = $this->pdo->query("SELECT * FROM `chatbot` WHERE id_user='$user' ");
            $fetch = $query->fetch(PDO::FETCH_OBJ);

            return $fetch;

        }else{
            return false;
        }


    }

    public function remove_reply($id){
        $query = $this->pdo->prepare("DELETE FROM `reply_chatbot` WHERE id= :id ");
        $query->bindValue(':id',$id);
        if($query->execute()){
            return true;
        }else{
            return false;
        }

    }

  public function add_reply($dados){

       $query = $this->pdo->prepare("INSERT INTO `reply_chatbot` (msg,reply,id_chat,sender_info,info) VALUES (:msg,:reply,:id_chat,:sender_info,:info) ");
       $query->bindValue(':msg',$dados->msg);
       $query->bindValue(':reply',$dados->reply);
       $query->bindValue(':id_chat',$dados->id_chat);
       $query->bindValue(':sender_info',$dados->sender_info);
       $query->bindValue(':info',$dados->info);

       if($query->execute()){
           return true;
       }else{
           return false;
       }

    }

    public function edit_reply($dados){

       $query = $this->pdo->prepare("UPDATE `reply_chatbot` SET  `msg`=:msg,`reply`=:reply,`sender_info`=:sender_info,`info`=:info WHERE `id`=:id AND `id_chat`=:id_chat");
       $query->bindValue(':msg',$dados->msg);
       $query->bindValue(':reply',$dados->reply);
       $query->bindValue(':sender_info',$dados->sender_info);
       $query->bindValue(':info',$dados->info);
       $query->bindValue(':id_chat',$dados->id_chat);
       $query->bindValue(':id',$dados->id);



       if($query->execute()){
           return true;
       }else{
           return false;
       }

    }

    public function getchatbotByKey($key){

        $query = $this->pdo->query("SELECT * FROM `chatbot` WHERE keychat='$key' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);

        if(count($fetch)>0){

            $query = $this->pdo->query("SELECT * FROM `chatbot` WHERE keychat='$key' ");
            $fetch = $query->fetch(PDO::FETCH_OBJ);

            return $fetch;

        }else{
            return false;
        }

    }

      public function getchatbotById($id){

        $query = $this->pdo->query("SELECT * FROM `chatbot` WHERE id='$id' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);

        if(count($fetch)>0){

            $query = $this->pdo->query("SELECT * FROM `chatbot` WHERE id='$id' ");
            $fetch = $query->fetch(PDO::FETCH_OBJ);

            return $fetch;

        }else{
            return false;
        }

    }

    public function generateChave($user){

        //$chave = sha1(uniqid("").$user);
        $chave = $user;

        if(self::getchatbotByUser($user)){
            // update
             if($this->pdo->query("UPDATE `chatbot` SET keychat='$chave' WHERE id_user='$user') ")){
                return $chave;
            }else{
                return false;
            }
        }else{
            // insert
            if($this->pdo->query("INSERT INTO `chatbot` (keychat,id_user) VALUES ('$chave','$user') ")){
                return $chave;
            }else{
                return false;
            }
        }

    }

      public function search_history_chat($num,$key){

          $query = $this->pdo->query("SELECT * FROM `session_chatbot` WHERE senderName='{$num}' AND chatbot_key='$key' ");
          $fetch = $query->fetchAll(PDO::FETCH_OBJ);
          if(count($fetch)>0){

            $query = $this->pdo->query("SELECT * FROM `session_chatbot` WHERE senderName='{$num}' AND chatbot_key='$key' LIMIT 1 ");
            $fetch = $query->fetch(PDO::FETCH_OBJ);
            return $fetch;

          }else{
            return false;
          }

        }

      public function get_chats_messages($key){
          $query = $this->pdo->query("SELECT * FROM `session_chatbot` WHERE chatbot_key='{$key}'");
          $fetch = $query->fetchAll(PDO::FETCH_OBJ);
          if(count($fetch)>0){

            $query = $this->pdo->query("SELECT * FROM `session_chatbot` WHERE chatbot_key='{$key}' ORDER BY time_init DESC");
            return $query;

          }else{
            return false;
          }
      }


      public function get_replys_chat_bot($user){

         $chatbot = self::getchatbotByUser($user);

          if($chatbot){

                  $query = $this->pdo->query("SELECT * FROM `reply_chatbot` WHERE id_chat='{$chatbot->id}' ");
                  $fetch = $query->fetchAll(PDO::FETCH_OBJ);
                  if(count($fetch)>0){

                    $query = $this->pdo->query("SELECT * FROM `reply_chatbot` WHERE id_chat='{$chatbot->id}'");
                    return $query;

                  }else{
                    return false;
                  }

          }else{
              return false;
          }
      }


       public function modify_session($key,$num){

           $data = time();

          // verificar se ja possui session
          if(self::search_history_chat($num,$key)){
            // se possui atualiza
            $query = "UPDATE `session_chatbot` SET time_init='$data' WHERE chatbot_key='$key' AND senderName='$num'";
          }else{
            // se nao cria
            $query = "INSERT INTO `session_chatbot` (chatbot_key,senderName,msgs,time_init,id_cliente) VALUES ('$key','$num','','$data','0') ";
          }

          if($this->pdo->query($query)){
            return true;
          }else{
            return false;
          }


        }

    public function removeSession($num){
        $query = $this->pdo->prepare("DELETE FROM `session_chatbot` WHERE senderName= :senderName ");
        $query->bindValue(':senderName',$num);
        if($query->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function getClientByDono($id_user,$num){

          $query = $this->pdo->query("SELECT * FROM `clientes` WHERE telefone='{$num}' AND id_user='$id_user' ");
          $fetch = $query->fetchAll(PDO::FETCH_OBJ);
          if(count($fetch)>0){

            $query = $this->pdo->query("SELECT * FROM `clientes` WHERE telefone='{$num}' AND id_user='$id_user' LIMIT 1 ");
            $fetch = $query->fetch(PDO::FETCH_OBJ);
            return $fetch;

          }else{
            return false;
          }

    }

       public function getDonoById($id_user){

          $query = $this->pdo->query("SELECT * FROM `user` WHERE id='{$id_user}'");
          $fetch = $query->fetchAll(PDO::FETCH_OBJ);
          if(count($fetch)>0){

            $query = $this->pdo->query("SELECT * FROM `user` WHERE id='{$id_user}' LIMIT 1 ");
            $fetch = $query->fetch(PDO::FETCH_OBJ);
            return $fetch;

          }else{
            return false;
          }

        }

     public function remove_historic($id,$user){
         $chatbot = self::getchatbotById($id);

         if($chatbot){
             if($chatbot->id_user == $user){
                 $key = $chatbot->keychat;
                 if($this->pdo->query("DELETE FROM `session_chatbot` WHERE chatbot_key='$key' ")){
                     return true;
                 }else{
                     return false;
                 }
             }else{
                 return false;
             }
         }else{
             return false;
         }

     }

     public function vencimento($vencimento){

        $ven_user = "";

        // verificar data do vencimento
        $explodeData_user  = explode('/',$vencimento);
        $explodeData2_user = explode('/',date('d/m/Y'));
        $dataVen_user      = $explodeData_user[2].$explodeData_user[1].$explodeData_user[0];
        $dataHoje_user     = $explodeData2_user[2].$explodeData2_user[1].$explodeData2_user[0];

        if($dataVen_user == $dataHoje_user){
            $ven_user = "ven_today";
        }else if($dataHoje_user > $dataVen_user){

           if($vencimento == "00/00/0000"){
             $ven_user = "vencido";
           }else{
             $ven_user = "vencido";
           }

        }

        return $ven_user;

      }

    public function getReply($key,$msg,$num){

        $chatbot = self::getchatbotByKey($key);


        if($chatbot){

            $idchat = $chatbot->id;

            $dono  = self::getDonoById($chatbot->id_user);

            if($dono == false){
                return false;
            }

            if(self::vencimento($dono->vencimento) == 'vencido'){
                return false;
            }

            self::modify_session($key,$num);
            $session =  self::search_history_chat($num,$key);


            $id_session = $session->id;

            $cliente  = self::getClientByDono($chatbot->id_user,$num);

            if($cliente == false){
                $idcliente = "";
            }else{
                $idcliente = $cliente->id;
            }

              $query = $this->pdo->query("SELECT * FROM `reply_chatbot` WHERE msg='{$msg}' AND id_chat='{$idchat}' ");
              $fetch = $query->fetchAll(PDO::FETCH_OBJ);
              if(count($fetch)>0){

                $query = $this->pdo->query("SELECT * FROM `reply_chatbot` WHERE msg='{$msg}' AND id_chat='{$idchat}' LIMIT 1 ");
                $fetch = $query->fetch(PDO::FETCH_OBJ);
                $reply = $fetch;

                if($reply->sender_info != 'false'){

                   if($reply->sender_info == "senderNotas"){
                       if($cliente){
                           $msgToReply = $cliente->notas;
                       }else{
                           $msgToReply = "Desculpe, você não está registrado em nosso sistema.";
                       }
                   }else if($reply->sender_info == "senderEmail"){
                       if($cliente){
                           $msgToReply = 'Seu email é: '.$cliente->email;
                       }else{
                           $msgToReply = "Desculpe, você não está registrado em nosso sistema.";
                       }
                   }else if($reply->sender_info == "senderSenha"){
                       if($cliente){
                           $msgToReply = 'Sua senha é: '.$cliente->senha;
                       }else{
                           $msgToReply = "Desculpe, você não está registrado em nosso sistema.";
                       }
                   }else if($reply->sender_info == "senderVencimento"){
                       if($cliente){
                           $msgToReply = 'Olá sua data de vencimento é: '.$cliente->vencimento;
                       }else{
                           $msgToReply = "Desculpe, você não está registrado em nosso sistema.";
                       }
                   }else if($reply->sender_info == "senderTeste"){

                          $jsonP = json_decode($reply->info);

                          $painel = $jsonP->painel;

                          $query = $this->pdo->query("SELECT * FROM `dados_painel` WHERE id='{$painel}' ");
                          $fetch = $query->fetchAll(PDO::FETCH_OBJ);
                          if(count($fetch)>0){

                            $query = $this->pdo->query("SELECT * FROM `dados_painel` WHERE id='{$painel}'");
                            $fetch = $query->fetch(PDO::FETCH_OBJ);
                            $painelTeste = $fetch;

                            $pacote = $jsonP->pacote;

                            $email = "{$num}@c.us";
                            $nome  = $num;

                            if($cliente){
                                $email = $cliente->email;
                                $nome = $cliente->nome;
                            }

                            $nome = urlencode($nome);

                            $response = file_get_contents("<?=SET_URL_PRODUCTION?>/painel/api.php?chave={$painelTeste->chave}&bot=1&package={$pacote}&email={$email}&nome={$nome}&whatsapp={$num}&gerateste");

                            $json = json_decode($response);

                            	if($json->erro){
                					$msgToReply = "Desculpe, não consegui gerar um teste para você no momento. Talvez você já tenha gerado um teste anteriormente.";
                				}else{
                					$msgToReply = $json->tema;
                			   	}


                          }else{
                              $msgToReply = "Desculpe, não podemos gerar um teste no momento";
                          }

                   }else{
                       $msgToReply = "Desculpe, não entendi";
                   }

                }else{
                    $msgToReply = $reply->reply;
                }


                if($session->msgs != ""){
                 $msgs_history = json_decode($session->msgs,true);
                }else{
                    $msgs_history['session']['id'] = $session->id;
                }

                $msgs_history['session']['msg'][uniqid("")] = array(
                  'data' => time(),
                  'receive' => base64_encode($msg),
                  'send' => base64_encode($msgToReply)
                );

                $jsonMsgs = json_encode($msgs_history, JSON_UNESCAPED_UNICODE);

                $this->pdo->query("UPDATE `session_chatbot` SET msgs='$jsonMsgs', senderName='$num' WHERE id='$id_session'");

                return $msgToReply;


              }else{
                return false;
              }

        }else{
            return false;
        }

    }






 }







?>
