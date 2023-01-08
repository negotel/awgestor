<?php

 if($plano_usergestor->chatbot != 1){
     echo '<script>location.href="cart?upgrade"</script>';
     exit;
 }

 $chatbot = new ChatBot();
 $getChatbot = $chatbot->getchatbotByUser($user->id);


 if($getChatbot){
     $chats = $chatbot->get_chats_messages($getChatbot->keychat);
 }


?>



<!-- Head and Nav -->
<?php include_once 'inc/head-nav.php'; ?>

<link href="<?=SET_URL_PRODUCTION?>/painel/css/chatbot.css" rel="stylesheet">

    
<?php include_once 'inc/head-nav.php'; ?>
<?php include_once 'inc/sidebar.php'; ?>


<section class="main_content dashboard_part">
<?php include_once 'inc/nav.php'; ?>

 <div class="main_content_iner ">
        <div class="container-fluid plr_30 body_white_bg pt_30">
            <div class="row justify-content-center">
                 <div class="single_element">
                        <div class="quick_activity">
                            <div class="row">

                                <!-- title and btns -->
                                <div class="col-md-6">
                                    <h2 class="h2">Chat Bot</h2><br />
                                </div>
                                <div style="right:0;" class="col-md-6">
                                    <div class="btn-toolbar mb-2 mb-md-0">
                                      <div class="btn-group mr-2">
                                       <?php if($getChatbot){ ?>
                                        <button onclick="$('#primeiros_passos_bot').modal('show');" type="button" class="btn btn-sm btn-outline-primary"><i class="fa fa-fast-forward" ></i> Passo-a-passo</button>
                                        <a target="_blank" href="https://youtu.be/b4ZWGyb-dfA" class="btn btn-sm btn-outline-primary"><i class="fa fa-play" ></i> Assistir Tutorial</a>
                                        <button onclick="location.href='settings_chatbot';" type="button" class="btn btn-sm btn-outline-primary"><i class="fa fa-cog" ></i> Configurar</button>
                                        <?php } ?>
                                      </div>
                                    </div>
                                </div>
                                <!--end title and btns -->



                                <!-- chabot -->
                                    <div class="col-md-12">
                                        <div style="padding: 10px;" class="row">
                                            <div class="col-md-3">

                                                <div class="row list_contacts" style="overflow-y:scroll;max-height:500px;margin-top:25px;">

                                                    <?php if($getChatbot == false){ ?>
                                                        <div class="col-md-12 text-center"><p class="text-center" ><button class="btn btn-lg btn-primary" onclick="location.href='settings_chatbot';" >Primeiros passos</button></p></div>
                                                    <?php } ?>

                                                    <?php

                                                        if($chats){
                                                            while($chat = $chats->fetch(PDO::FETCH_OBJ)){
                                                            $isClient = $chatbot->getClientByDono($user->id,$chat->senderName);

                                                            $name = $chat->senderName;

                                                            if($isClient){
                                                                $name = explode(' ',$isClient->nome)[0];
                                                            }
                                                    ?>

                                                    <!-- repeat -->
                                                    <div onclick="organize_messages(<?= $chat->id; ?>,'<?= $name;?>');" class="card col-md-12" style="cursor:pointer;padding-bottom:5px;padding-top:5px;">
                                                        <input type="hidden" value='<?= base64_encode($chat->msgs); ?>' id="json_<?= $chat->id; ?>" />
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="msg-img" style="background-image: url(<?=SET_URL_PRODUCTION?>/painel/img/profile_chat.svg)" ></div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <b> <i class="fa fa-whatsapp"></i> <?= $name; ?></b>
                                                                <br />
                                                                <small><?= date('d/m/Y', $chat->time_init).' ás '.date('H:i', $chat->time_init);?></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } }else{ ?>

                                                    <p class="text-center" style="margin-top:100px;font-size:10px;color:gray;">
                                                        Ainda não há interações com o chatbot. Certifique-se que o mesmo está ativo em seu aplicativo. <br />
                                                        Verifique também se possui respostas para o bot. Basta clicar em <b> <i class="fa fa-cog"></i> Configurar</b>
                                                    </p>


                                                <?php } ?>

                                                </div>

                                            </div>
                                            <div class="col-md-9">
                                                 <section class="msger" style="background: #7922ff!important;">

                                                      <header style="border-bottom: none;background: #7922ff;color: #fff;border-radius: 13px;" class="msger-header">
                                                        <div class="msger-header-title">
                                                          <i class="fas fa-comment-alt"></i> Cortesia de Gestor Lite
                                                        </div>
                                                        <div class="msger-header-options">
                                                          <span onclick="remove_historic();" style="cursor:pointer;font-size:20px;" ><i class="fa fa-leaf"></i></span>
                                                            &nbsp;
                                                          <span onclick="location.href='settings_chatbot';" style="cursor:pointer;font-size:20px;" ><i class="fa fa-cog"></i></span>
                                                        </div>
                                                      </header>

                                                      <main <?php if($user->dark == 1){?> style="background-color: #251838!important;" <?php } ?> class="msger-chat">
                                                              <center><img width="300" src="<?=SET_URL_PRODUCTION?>/painel/img/robot_default.png" /></center>
                                                      </main>

                                                      <!-- <form class="msger-inputarea">
                                                        <input type="text" class="msger-input" placeholder="Enter your message...">
                                                        <button type="submit" class="msger-send-btn">Send</button>
                                                      </form> -->

                                                    </section>

                                            </div>
                                        </div>
                                      </div>
                </div>
              </div>


            </div>
        </div>
  </div>

</section>


<!--  Modal inicio -->
<div class="modal fade" id="primeiros_passos_bot" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="TituloModalLongoExemplo" aria-hidden="true">
     <div class="modal-dialog" role="document">
       <div class="modal-content">
         <div class="modal-header">
           <h5 class="modal-title" id="Titutlo_modal_add_cliente">Vamos começar?</h5>
           <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>
         <div class="modal-body" id="body_modal_inicio" >


              <div class="row">

                <div class="col-md-12" style="margin-left:10px;">

                  <p>
                      Siga o passo-a-passo para iniciar seu chatbot!

                    <ol>



                        <li>
                            Baixe os Aplicativo Compativeis: <br />
                            <br /><small>Para Facebok, Instagram, Telegram, etc.. use o <b>Whats Auto</b></small>
                        </li>
                        <br />
                         <li>
                             <p>Apps Compativeis</p>
                            <a target="_blank" href="https://play.google.com/store/apps/details?id=com.pransuinc.autoreply&hl=pt-pt"><img src="https://play-lh.googleusercontent.com/HW8i-_rPmznO-b-aKWcR5sKd6Uz0W0sB-6yN1GT2KBqW0KZSNfETydLvfMymaCZLDkk=s180-rw" width="50" /></a>
                            <a target="_blank" href="https://play.google.com/store/apps/details?id=com.guibais.whatsauto&hl=pt-pt"><img src="https://play-lh.googleusercontent.com/7LtNmW5FOs_pZfV8U6Iw6oz89tI3EHr1x90iubAO_-HHdP4HndAMh0YexiBHmpRzW2-3=s180-rw" width="50" /></a>
                            <a target="_blank" href="https://play.google.com/store/apps/details?id=tkstudio.autoresponderforwa&hl=pt-pt"><img src="https://play-lh.googleusercontent.com/5VIwDAL7LuQReE0M00kBnoQe8m5vFnaFz3AeOFN0bHZismKFz67PBoEVAAYZjfe9ntc=s180-rw" width="50" /></a>
                        </li>
                        <br />
                        <li>
                            Inicie o app, e de todas as permissões que o app pede.
                        </li>
                        <br />
                        <li>
                            Apague as mensagens padrão que estão no app e clique no ícone <i class="fa fa-plus"></i> para adicionar uma nova resposta.
                        </li>
                        <br />
                        <li>
                            Selecione qual whatsapp está usando para o bot, Wa Bussines para Whatsapp Bussines e etc.
                        </li>
                        <br />
                        <li>
                            Em <b>Received message pattern</b> marque a opção <b>All</b>
                        </li>
                        <br />
                        <li>
                            Role a tela e em <b>Reply message</b>, marque a opção <b>Connect to own server</b>
                        </li>
                        <li>
                            No campo que diz Server URL, coloque o seguinte link: <b class="text-info">https://glite.me/b/m.php?key=<?= $user->id; ?></b>
                        </li>
                        <br />
                        <li>
                            Clique no ícone <i class="fa fa-check"></i> no lado direito inferior para salvar
                        </li>
                        <br />
                        <li>
                            Ative o chatbot clicando no topo a direita <i class="fa fa-toggle-off "></i>
                        </li>
                        <br />
                        <li>
                            No painel Gestor Lite, basta clicar em configurar para adicionar as respostas automáticas.
                        </li>
                    </ol>

                  </p>

               </div>



         </div>

         <div class="modal-footer">
           <a target="_blank" href="https://youtu.be/b4ZWGyb-dfA" id="btn_add_cvd" class="btn btn-info"> <i class="fa fa-play"></i> Assistir um tutorial</a>
           <a target="_blank" href="<?=SET_URL_PRODUCTION?>/contato" id="btn_add_cvd" class="btn btn-secondary">Suporte</a>
         </div>


       </div>
     </div>
    </div>
    </div>


<script>

    function organize_messages(chat,name){
        $(".msger-chat").html('<center><h1 style="margin-top:50px;" ><i class="fa fa-spin fa-spinner"></i></h1></center>');
        var jsonChat = $("#json_"+chat).val();
        $.post('../control/control.organizechat.php',{messages:jsonChat,name:name},function(data){
            if(data == ""){
                $(".msger-chat").html('<center><img width="300" src="<?=SET_URL_PRODUCTION?>/painel/img/robot_default.png" /></center>');
            }else{
               $(".msger-chat").html(data);
            }
             scrollchat();
        });
    }

    function remove_historic(){
        if(window.confirm("Deseja remover todo histórico de mensagens?")){
            $.post('../control/control.chatbot.php',{remove_istoric:true,chat:<?= @$getChatbot->id; ?>},function(data){
                location.href="";
            });
        }
    }

    function scrollchat() {
        $('.msger-chat').scrollTop($('.msger-chat')[0].scrollHeight);
    }

</script>


 <!-- footer -->
 <?php include_once 'inc/footer.php'; ?>
