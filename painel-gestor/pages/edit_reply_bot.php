<?php

 if($plano_usergestor->chatbot != 1){
     echo '<script>location.href="cart?upgrade"</script>';
     exit;
 }

 if (!isset($_GET['reply'])) {
   echo '<script>location.href="settings_chatbot"</script>';
   exit;
 }else {

   $chatbot = new ChatBot();
   $getChatbot = $chatbot->getchatbotByUser($user->id);

    $chatbot_id = 0;

    if($getChatbot){
        $chatbot_id = $getChatbot->id;
    }

    if($chatbot_id == 0){
      echo '<script>location.href="settings_chatbot"</script>';
      exit;
    }else{
      $id_reply   = trim($_GET['reply']);
      $reply_info = $chatbot->getReplyById($id_reply,$chatbot_id);

      if(!$reply_info){
        echo '<script>location.href="settings_chatbot"</script>';
        exit;
      }
    }

 }




 $ApiPainel = new ApiPainel();
 $paineis   = $ApiPainel->credenciais($_SESSION['SESSION_USER']['id'],false);
 $paineis2  = $ApiPainel->credenciais($_SESSION['SESSION_USER']['id'],false);


?>



<!-- Head and Nav -->
<?php include_once 'inc/head-nav.php'; ?>


<body class="crm_body_bg">

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
                                            <h2 style="margin-left: 10px;" class="h2"> <i style="cursor:pointer;font-size:20px;" onclick="location.href='settings_chatbot';" class="fa fa-arrow-left "></i> Você está editando uma resposta ChatBot</h2><br />
                                          </div>


                                         <div class="col-12">
                                             <div style="padding-bottom:100px;" class="QA_section">

                                                  <button style="width: 100%;" onclick="$('#modal_add_reply').modal('show');" type="button" class="btn btn-lg btn-primary" name="button">
                                                    EDITAR
                                                  </button>

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





<!--  Modal add reply -->
<div class="modal fade" id="modal_add_reply" tabindex="-1" role="dialog" aria-labelledby="TituloModalLongoExemplo" aria-hidden="true">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="Titutlo_modal_add_cliente">Editar resposta</h5>
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
             <textarea class="form-control" placeholder="Receber" id="recebe" ><?= $reply_info->msg;?></textarea>
             &nbsp;&nbsp;<small>Mensagem recebida</small>
           </div>

           <input type="hidden" id="id_reply" name="" value="<?= $id_reply; ?>">

           <div class="form-group col-md-12">
              <select id="type_response" onchange="type_responde($('#type_response').val());" class="form-control">
                  <option value="" >Selecione</option>
                  <option value="texto" >Responder com Texto</option>
                  <option value="dados" >Responder com dados do painel</option>
                  <option value="teste" >Responder com um teste</option>
              </select>
           </div>


           <div style="display:none;" id="dados_painel_div" class="form-group col-md-12">
              <select id="dados_response" class="form-control">
                  <option value="" >Selecione</option>
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
             <textarea class="form-control" placeholder="Responde" id="responde" ><?= $reply_info->reply;?></textarea>
             &nbsp;&nbsp;<small>Mensagem que o bot responde</small>
           </div>





     </div>

     <div class="modal-footer">
       <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $idioma->fechar; ?></button>
       <button type="button" onclick="edit_reply('texto');" id="btn_add_reply_texto" class="btn btn-primary"><?= $idioma->adicionar; ?></button>
       <button type="button" onclick="edit_reply('dados');" id="btn_add_reply_dados" style="display:none;" class="btn btn-primary"><?= $idioma->adicionar; ?></button>
       <button type="button" onclick="edit_reply('teste');" id="btn_add_reply_teste" style="display:none;" class="btn btn-primary"><?= $idioma->adicionar; ?></button>
     </div>


   </div>
 </div>
</div>
</div>


 <!-- footer -->
 <?php include_once 'inc/footer.php'; ?>
