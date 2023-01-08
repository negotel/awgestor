<?php

 if($plano_usergestor->chatbot != 1){
     echo '<script>location.href="cart?upgrade"</script>';
     exit;
 }


 $chatbot = new ChatBot();
 $getChatbot = $chatbot->getchatbotByUser($user->id);

 $chatbot_id = 0;

 if($getChatbot){
     $replys = $chatbot->get_replys_chat_bot($user->id);
     $chatbot_id = $getChatbot->id;
 }

 $ApiPainel = new ApiPainel();
 $paineis   = $ApiPainel->credenciais($_SESSION['SESSION_USER']['id'],false);
 $paineis2  = $ApiPainel->credenciais($_SESSION['SESSION_USER']['id'],false);


?>



<!-- Head and Nav -->
<?php include_once 'inc/head-nav.php'; ?>
 

<?php include_once 'inc/head-nav.php'; ?>
<?php include_once 'inc/sidebar.php'; ?>

<input type="hidden" id="chatbot_id" value="<?= $chatbot_id; ?>" />

 <section class="main_content dashboard_part">
 <?php include_once 'inc/nav.php'; ?>

    <div class="main_content_iner ">

        <div class="container-fluid plr_30 body_white_bg pt_30">

            <div class="row justify-content-center">
                 <div class="single_element">
                        <div class="quick_activity">
                            <div class="row">

                                      <div class="col-lg-12">
                                            <h2 class="h2"> <i style="cursor:pointer;font-size:20px;" onclick="location.href='chatbot';" class="fa fa-arrow-left "></i> Configurações Chat Bot</h2><br />
                                            <div style="margin-bottom:10px!important;" class="btn-toolbar mb-2 mb-md-0">
                                              <div class="btn-group mr-2">
                                                <a target="_blank" href="https://youtu.be/b4ZWGyb-dfA" class="btn btn-sm btn-outline-primary"><i class="fa fa-play" ></i> Assistir Tutorial</a>
                                                <?php if($getChatbot){ ?>
                                                 <button onclick="$('#modal_add_reply').modal('show');" type="button" class="btn btn-sm btn-outline-primary"><i class="fa fa-plus" ></i> Nova Resposta</button>
                                                 <button onclick="$('#testing_bot').modal('show');" type="button" class="btn btn-sm btn-outline-primary"><i class="fa fa-bug" ></i> Testar Bot</button>

                                                <?php } ?>
                                              </div>
                                            </div>
                                          </div>


                                         <div class="col-12">
                                             <div class="QA_section">

                                                <?php  if($getChatbot == false){ ?>

                                                <div class="text-center col-md-12">
                                                    <img width="300" src="<?=SET_URL_PRODUCTION?>/painel/img/init_settings_bot.png" />
                                                    <br /><br />
                                                    <button onclick="$('#primeiros_passos_bot').modal('show');" class="btn btn-lg btn-primary" >Primeiros passos <i class="fa fa-fast-forward"></i> </button>
                                                </div>

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
                                                                </ol>

                                                              </p>

                                                           </div>



                                                     </div>

                                                     <div class="modal-footer">
                                                       <a target="_blank" href="https://youtu.be/b4ZWGyb-dfA" id="btn_add_cvd" class="btn btn-info"> <i class="fa fa-play"></i> Assistir um tutorial</a>
                                                       <a target="_blank" href="<?=SET_URL_PRODUCTION?>/contato" id="btn_add_cvd" class="btn btn-secondary">Suporte</a>
                                                       <button type="button" onclick="consegui();" id="btn_add_cvd" class="btn btn-primary">Consegui</button>
                                                     </div>


                                                     </div>
                                                   </div>
                                                 </div>
                                                </div>


                                                <?php }else{ ?>

                                                <div class="QA_table ">
                                                    <!-- table-responsive -->
                                                    <table class="table lms_table_active">
                                                        <thead>
                                                            <tr>
                                                              <th><i class="fa fa-share"></i> Recebe</th>
                                                              <th><i class="fa fa-reply"></i> Responde</th>
                                                              <th>Opções</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="" class="" >

                                                           <?php if($replys){
                                                                while($reply = $replys->fetch(PDO::FETCH_OBJ)){
                                                            ?>

                                                               <tr>
                                                                  <td><i style="font-size:9px;color:gray;" class="fa fa-share"></i> <?= substr($reply->msg,0,100); ?><?php if(strlen($reply->msg)>100){ echo "...";}?></td>
                                                                  <td><i style="font-size:9px;color:gray;" class="fa fa-reply"></i> <?= substr($reply->reply,0,100); ?><?php if(strlen($reply->reply)>100){ echo "...";}?></td>
                                                                  <td width="200" class="text-center" >
                                                                    <button onclick="location.href='edit_reply_bot?reply=<?= $reply->id; ?>';" title="EDITAR" type="button" class="btn btn-sm btn-outline-info"  id="btn_edit_reply_<?= $reply->id; ?>"> <i  id="_btn_edit_reply_<?= $reply->id; ?>" class="fa fa-edit" ></i></button>
                                                                    <button onclick="deletar_reply(<?= $reply->id; ?>);" title="DELETAR" type="button" class="btn btn-sm btn-outline-danger"  id="btn_remove_reply_<?= $reply->id; ?>"> <i  id="_btn_remove_reply_<?= $reply->id; ?>" class="fa fa-trash" ></i></button>
                                                                  </td>
                                                                </tr>


                                                            <?php } }else{ ?>
                                                                 <tr class="text-center">
                                                                   <td colspan="3">Não há nenhuma resposta adicionada. Comece agora mesmo a criar suas respostas.</td>
                                                                </tr>

                                                            <?php } } ?>

                                                          </tbody>
                                                      </table>
                                                </div>



                                            </div>
                                     </div>

                            </div>
                        </div>
                </div>
            </div>
        </div>

    </div>



 </section>



<!--  Modal teste bot -->
<div class="modal fade" id="testing_bot" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="Titutlo_modal_add_cliente">Testar Chatbot</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body" id="body_modal_add_mov" >

          <div class="row">

           <div class="col-md-12">
              <h4>
                 <i class="fa fa-hand-paper" ></i> Um momento. Qual App vai usar?
              </h4>
           </div>



           <div class="col-md-12">
               <hr>
              <div class="row text-center">
                  <div class="col-md-4" style="cursor:pointer;" ><img width="50" src="https://play-lh.googleusercontent.com/5VIwDAL7LuQReE0M00kBnoQe8m5vFnaFz3AeOFN0bHZismKFz67PBoEVAAYZjfe9ntc=s180-rw" onclick="location.href='teste_bot?app=autoresponder';" /> <h5>Auto Responder  </h5></div>
                  <div class="col-md-4" style="cursor:pointer;" ><img width="50" src="https://play-lh.googleusercontent.com/HW8i-_rPmznO-b-aKWcR5sKd6Uz0W0sB-6yN1GT2KBqW0KZSNfETydLvfMymaCZLDkk=s180-rw" onclick="location.href='teste_bot?app=autoreply';" /> <h5>Auto Reply  </h5></div>
                  <div class="col-md-4" style="cursor:pointer;" ><img width="50" src="https://play-lh.googleusercontent.com/7LtNmW5FOs_pZfV8U6Iw6oz89tI3EHr1x90iubAO_-HHdP4HndAMh0YexiBHmpRzW2-3=s180-rw" onclick="location.href='teste_bot?app=whatsauto';" /> <h5>Whats Auto  </h5></div>
              </div>
           </div>


     </div>

     <div class="modal-footer">
       <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
     </div>


   </div>
 </div>
</div>
</div>



<!--  Modal add reply -->
<div class="modal fade" id="modal_add_reply" tabindex="-1" role="dialog" aria-labelledby="TituloModalLongoExemplo" aria-hidden="true">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="Titutlo_modal_add_cliente">Adicionar uma nova resposta</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body" id="body_modal_add_cvd" >


          <div class="row">

            <div class="col-md-12">
              <span id="res_add" ></span>
           </div>

           <div class="form-group col-md-12">
             <textarea class="form-control" placeholder="Receber" id="recebe" ></textarea>
             &nbsp;&nbsp;<small>Mensagem recebida</small>
           </div>


           <div class="form-group col-md-12">
              <select id="type_response" onchange="type_responde($('#type_response').val());" class="form-control">
                  <option value="texto" >Responder com Texto</option>
                  <option value="dados" >Responder com dados do painel</option>
                  <option value="teste" >Responder com um teste</option>
              </select>
           </div>


           <div style="display:none;" id="dados_painel_div" class="form-group col-md-12">
              <select id="dados_response" class="form-control">
                  <option value="senderEmail" >Responder com Email do cliente</option>
                  <option value="senderSenha" >Responder com Senha do cliente</option>
                  <option value="senderVencimento" >Responder com data de vencimento do cliente</option>
                  <option value="senderNotas" >Responder com notas do cliente</option>
              </select>
              &nbsp;<small>O dados será enviado caso o cliente seja registrado com o mesmo número em sua lista de clientes</small>
           </div>

                <?php

                    if($paineis2){
                        while($painel = $paineis2->fetch(PDO::FETCH_OBJ)){
                            if($painel->situ_teste != 0){

                                $nomePainel = $painel->api;

                               if(isset($painel->label)){
                                   if($painel->label != ""){
                                    $nomePainel = $painel->label;
                                   }
                               }


                                echo '<input type="hidden" value="'.$painel->chave.'" id="chave_'.$painel->id.'" >';

                            }
                        }
                    }

                  ?>


             <div style="display:none;" id="paineis_integrados" class="form-group col-md-12">
              <select id="painel" onchange="select_pacote(this)"; class="form-control">
                  <?php

                   echo '<option value="" >Selecionar painel</option>';

                    if($paineis){
                        while($painel = $paineis->fetch(PDO::FETCH_OBJ)){
                            if($painel->situ_teste != 0){

                                $nomePainel = $painel->api;

                               if(isset($painel->nome)){
                                   if($painel->nome != ""){
                                    $nomePainel = $painel->nome;
                                   }
                               }


                                echo '<option value="'.$painel->id.'" >'.$nomePainel.'</option>';

                            }
                        }
                    }else{
                        echo '<option>Nenhum painel integrado</option>';
                    }
                  ?>
              </select>
              &nbsp;<small>O texto do teste gerado é configurado em <b>Integrações</b></small>
           </div>

             <div style="display:none;" id="div_pacote_teste" class="form-group col-md-12">
              <select id="pacote_teste" onchange="pacote_teste(this)"; class="form-control">
                  <option value="" >Aguarde.. </option>
              </select>
           </div>



            <div id="div_responde" class="form-group col-md-12">
             <textarea class="form-control" placeholder="Responde" id="responde" ></textarea>
             &nbsp;&nbsp;<small>Mensagem que o bot responde</small>
           </div>





     </div>

     <div class="modal-footer">
       <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $idioma->fechar; ?></button>
       <button type="button" onclick="add_reply('texto');" id="btn_add_reply_texto" class="btn btn-primary"><?= $idioma->adicionar; ?></button>
       <button type="button" onclick="add_reply('dados');" id="btn_add_reply_dados" style="display:none;" class="btn btn-primary"><?= $idioma->adicionar; ?></button>
       <button type="button" onclick="add_reply('teste');" id="btn_add_reply_teste" style="display:none;" class="btn btn-primary"><?= $idioma->adicionar; ?></button>
     </div>


   </div>
 </div>
</div>
</div>


 <!-- footer -->
 <?php include_once 'inc/footer.php'; ?>
