<?php

  if(isset($_GET['limit'])){
    $limit = $_GET['limit'] == "all" ? false : $_GET['limit'];
  }else{
    $limit = 10000;
  }

   // listar clientes

   $clientes_class = new Clientes();
   $planos_class   = new Planos();


   // list clientes
   $clientes = $clientes_class->list_clientes($_SESSION['SESSION_USER']['id'],$limit);

   if(!isset($whatsapi_class)){
        $whatsapi_class = new Whatsapi();
    }




   $clientes = $clientes_class->list_clientes($_SESSION['SESSION_USER']['id'],$limit);

   $list_categorias_1 = $clientes_class->list_categorias_clientes($_SESSION['SESSION_USER']['id']);
   $list_categorias_2 = $clientes_class->list_categorias_clientes($_SESSION['SESSION_USER']['id']);
   $list_categorias_3 = $clientes_class->list_categorias_clientes($_SESSION['SESSION_USER']['id']);


   $planos   = $planos_class->list($_SESSION['SESSION_USER']['id']);
   $planos2  = $planos_class->list($_SESSION['SESSION_USER']['id']);
   $planos3  = $planos_class->list($_SESSION['SESSION_USER']['id']);

   $num_cli = 0;

   $count_cli = $clientes_class->count_clientes($_SESSION['SESSION_USER']['id']);
    if($count_cli){
        $num_cli = $count_cli;
    }

    $wsapi = $whatsapi_class->verific_device_situ($_SESSION['SESSION_USER']['id']);
    $array_clis_comp = $clientes_class->list_fats_comp($_SESSION['SESSION_USER']['id']);

 ?>

 
<?php include_once 'inc/head-nav.php'; ?>
<?php include_once 'inc/sidebar.php'; ?>

<style>

    .emoji-wysiwyg-editor{
        min-height:224px;
    }

    .dataTables_filter{
        display:none;
    }

    .dataTables_paginate  .paginate_button {
        background-color: #7922ff!important;
        padding: 0px!important;
        width: 100;
        margin-bottom: 12px!important;
       }

    .paging_simple_numbers .paginate_button{
        background-color: #7922ff!important;
    }

    @media screen and (min-width: 500px) {
        #table_clientes th:last-child,
        #table_clientes td:last-child {
          display: none;
        }
    }

    input[type="color"] {
    	-webkit-appearance: none;
    	border: none;
    	width: 32px;
    	height: 32px;
    }
    input[type="color"]::-webkit-color-swatch-wrapper {
    	padding: 0;
    }
    input[type="color"]::-webkit-color-swatch {
    	border: none;
    }


    .modal label{
         margin-left: 10px;
        font-size: 14px;
        color: gray;
        margin-bottom: 0px;

    }
</style>

<section class="main_content dashboard_part">
<?php include_once 'inc/nav.php'; ?>
    <div class="main_content_iner ">
        <div class="container-fluid plr_30 body_white_bg pt_30">
            <div style="margin-bottom:20px;" class="row justify-content-center">
                <div class="col-12">
                    <div class="QA_section">
                        <div style="margin-bottom:0px;" class="white_box_tittle list_header">
                            <h4>Categorias</h4>
                            <div class="box_right d-flex lms_block">
                                <div class="add_button ml-10">
                                      <div class="btn-group col-md-12">
                                            <button onclick="list_categorias_cards();$('#modal_categorias').modal();" class="btn btn-outline-success" >Nova / Editar Categoria</button>
                                      </div>
                                </div>
                            </div>
                        </div>
                          <div class="row" style="padding-bottom:10px;" >
                              <input type="hidden" value="<?php if(isset($_GET['cate_list'])){ echo $_GET['cate_list']; }else{ echo 'no';} ?>" id="setGetCate" />
                            <?php if($list_categorias_3){

                                 $color_text['danger'] = "white";
                                 $color_text['primary'] = "white";
                                 $color_text['secondary'] = "white";
                                 $color_text['info'] = "white";
                                 $color_text['warning'] = "black";
                                 $color_text["marrom"] = "white";
                                 $color_text["green"] = "white";
                                 $color_text["roxo"] = "white";
                                 $color_text["verde2"] = "white";

                                 $cores['danger'] = "#ec3541";
                                 $cores['primary'] = "#0048ff";
                                 $cores['secondary'] = "#dddddd";
                                 $cores['info'] = "#2d87ce";
                                 $cores['warning'] = "#fb9100";
                                 $cores['marrom'] = "#6d2b19";
                                 $cores['green'] = "#2bad18";
                                 $cores['roxo'] = "#7922ff";
                                 $cores['verde2'] = "#04fbb1";



                              ?>

                               <?php while($categ = $list_categorias_3->fetch(PDO::FETCH_OBJ)){

                               if(isset($cores[$categ->cor])){
                                     $back = $cores[$categ->cor];
                                 }else{
                                     $back = $categ->cor;
                                 }

                               ?>

                                <span onclick="var newUrl = updateQuerystring('cate_list', <?= $categ->id; ?>);location.href=newUrl;" style="cursor:pointer;text-align:center;border-radius: 13px;padding:5px;margin:5px;min-height: 15px;background-color: <?= $back; ?>" class="etiqueta_cate_name_<?= $categ->id; ?> etiqueta_cate1_<?= $categ->id; ?> text-white"><?= $categ->nome; ?></span>

                              <?php } } ?>
                          </div>
                    </div>
                </div>
            </div>
          </div>

          <div class="container-fluid plr_30 body_white_bg pt_30">
            <div class="row justify-content-center">
             <div style="margin-bottom:10px;" class="col-md-12 text-right">
                    <div class="btn-toolbar mb-2 mb-md-0">
                      <div class="btn-group mr-2">
                        <button onclick="location.href='painel_cliente_conf';" type="button" class="btn btn-sm btn-outline-primary"><i class="fa fa-user" ></i> <?= $idioma->area_cliente; ?> <?php if( isset($plano_usergestor->mini_area_cliente) ){ if($plano_usergestor->mini_area_cliente == 0){ echo "<i class='fa fa-star text-primary' ></i>";} } ?></button>
                        <button onclick="modal_import_clientes();" type="button" class="btn btn-sm btn-outline-primary"><i class="fa fa-upload" ></i> <?= $idioma->importar; ?></button>
                        <button onclick="location.href='../control/control.export_clientes.php';" type="button" class="btn btn-sm btn-outline-primary"><i class="fa fa-download" ></i> <?= $idioma->exportar; ?></button>
                        <button onclick="modal_add_cli();" type="button" class="btn btn-sm btn-outline-primary"><i class="fa fa-plus" ></i> <?= $idioma->adicionar_novo; ?></button>
                      </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="QA_section">
                        <div class="white_box_tittle list_header">
                            <h4>Clientes</h4>
                            <div class="box_right d-flex lms_block">
                                <div class="serach_field_2">
                                    <div class="search_inner">
                                        <form Active="#">
                                            <div class="search_field">
                                                <input id="busca_user_ipt" type="text" placeholder="Pesquisar cliente">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="add_button ml-10">
                                      <div class="btn-group col-md-12">
                                         <select onchange="var newUrl = updateQuerystring('set', (this.options[this.selectedIndex].value));location.href=newUrl;" class="form-control" style="margin-bottom: 0px!important;" >
                                             <option <?php if(isset($_GET['set'])){ if($_GET['set'] == "ativos"){ echo "selected"; } }  ?> value="ativos">Clientes Ativos</option>
                                             <option <?php if(isset($_GET['set'])){ if($_GET['set'] == "inativos"){ echo "selected"; } }  ?> value="inativos">Clientes Inadimplentes</option>
                                         </select>

                                         <input type="hidden" value="<?php if(isset($_GET['set'])){ echo $_GET['set']; }else{ echo 'ativos';} ?>" id="setGetClients" />

                                      </div>
                                </div>
                            </div>
                        </div>

                          <div class="QA_table" >
                            <!-- table-responsive -->
                            <table  style="padding-bottom: 162px;" id="table_clientes" class="table ">
                                <thead>
                                   <tr>
                                        <th style="min-width: 87px;" scope="col">Nome</th>
                                        <th scope="col">Vencimento</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Whatsapp</th>
                                        <th scope="col">Plano</th>
                                        <th scope="col">Opções</th>
                                        <th scope="col">Data Convert</th>
                                    </tr>
                                </thead>
                                <tbody>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




<!--  Modal Import clientes -->
<div class="modal fade" id="modal_import_clientes" tabindex="-1" role="dialog" aria-labelledby="TituloModalLongoExemplo" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="TituloModalLongoExemplo"><?= $idioma->import_clis_para_gestor_lite; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">


       <form enctype="multipart/form-data" id="form_import_json_clientes"  action="../control/control.import_json_clientes.php" method="POST">

         <div class="form-group text-center" >

             <div class="form-group">
                 <label>Selecione a plataforma</label>
                 <select class="form-control" name="type">
                     <option value="gestor" >Gestor Lite</option>
                     <option value="xtream" >Xtream UI</option>
                 </select>
             </div>

            <div class="form-group">
               <input onchange="$('#selecionado_msg').show('200');$('#btn_import').show('200');" id="import_cliente_json" type="file" name="import_cliente_json" class="" style="display:none;" />
               <label for="import_cliente_json" class="btn btn-primary" ><?= $idioma->selecionar_arquivo; ?> <i class="fa fa-desktop" ></i> </label>
               <br />
               <span id="selecionado_msg" style="display:none;" class="text-success" ><?= $idioma->selecionado; ?> <i class="fa fa-check" ></i> </span>
            </div>


         </div>


      </form>


      </div>


      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $idioma->cancelar; ?></button>
        <button type="button" onclick="$('#form_import_json_clientes').submit();$('#btn_import').prop('disabled', true);$('#btn_import').html('<i class=\'fa fa-refresh fa-spin\' ></i> Aguarde');" id="btn_import" style="display:none;" class="btn btn-primary"><?= $idioma->importar; ?></button>
      </div>


    </div>
  </div>
</div>


<!--  Modal edite clientes -->
<div class="modal fade" id="modal_edite_cliente" tabindex="-1" role="dialog" aria-labelledby="TituloModalLongoExemplo" aria-hidden="true">
 <div class="modal-dialog modal-lg" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="Titutlo_modal_edite_cliente"><?= $idioma->editar_cliente; ?></h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body" id="body_modal_edite_cli" >

       <input type="hidden" name="id_cli" id="id_cli">

          <div class="row">

            <?php


             if(@$plano_usergestor->mini_area_cliente == 1){

            ?>

           <div class="col-md-12">
             <label>Nome <b class="text-danger" >*</b></label>
             <input type="text" class="form-control margin" id="nome_cli" placeholder="<?= $idioma->nome; ?>">
           </div>

           <div class="col-md-5">
             <label>Senha <b class="text-danger" >*</b></label>
             <input type="text" class="form-control margin" id="senha_cli" placeholder="<?= $idioma->senha; ?>">
           </div>

           <div class="col-md-7">
              <label>Email</label>
              <input type="hidden" id="email_cli_atual" value="">
             <input type="text" class="form-control margin" id="email_cli" placeholder="<?= $idioma->email; ?> [Opcional]">
             <small id="response_email_cli" ></small>
           </div>

         <?php }else{ ?>

           <div class="col-md-5">
             <label>Nome <b class="text-danger" >*</b></label>
             <input type="text" class="form-control margin" id="nome_cli" placeholder="<?= $idioma->nome; ?>">
           </div>

           <div class="col-md-7">
             <label>Email </label>
             <input type="hidden" id="email_cli_atual" value="">
             <input type="text" class="form-control margin" id="email_cli" placeholder="<?= $idioma->email; ?> [Opcional]">
             <small id="response_email_cli" ></small>
           </div>

         <?php } ?>



           <div class="col-md-6">
             <label>Telefone <b class="text-danger" >*</b></label>
             <input type="text" class="form-control margin" id="telefone_cli" placeholder="DDI+DDD+NUM">
           </div>

           <div class="col-md-6">
             <label>Data Vencimento <b class="text-danger" >*</b></label>
             <input min="<?= date('Y-m-d'); ?>" type="date" class="form-control margin" id="vencimento_cli" placeholder="<?= $idioma->vencimento; ?>">
           </div>

           <div class="col-md-6 ">
             <label>Categoria</label>
             <select class="form-control" name="categoria_cli_atual" id="categoria_cli_atual" >
               <option value="0" >Selecionar uma categoria</option>
               <?php if($list_categorias_2){
                    while($cate = $list_categorias_2->fetch(PDO::FETCH_OBJ)){
                 ?>
               <option value="<?= $cate->id; ?>" ><?= $cate->nome; ?></option>
               <?php } }else{ ?>
                <option value="0" >Nenhuma categoria cadastrada</option>
               <?php } ?>
             </select>
             <small>Determine a categoria deste cliente</small>
           </div>

           <div class="col-md-6">
             <label>Id Externo</label>
             <input type="text" class="form-control margin" maxlength="11" id="identificador_externo_cli" placeholder="ID Externo [Opcional]">
           </div>


           <div class="col-md-12 margin">
             <label>Notificação Whatsapp <b class="text-danger" >*</b></label>
             <select class="form-control" name="recebe_zap_cli" id="recebe_zap_cli" >
               <option value="1" ><?= $idioma->notificas_via_zap; ?></option>
               <option value="0" ><?= $idioma->nao_notificar_zap; ?></option>
             </select>
           </div>

           <div class="col-md-12 margin">
             <label>Plano <b class="text-danger" >*</b></label>
             <select class="form-control" name="plano_cli" id="plano_cli" >
               <option value="0" ><?= $idioma->selecionar_plano; ?></option>

               <?php

                if($planos){
                  while ($plano = $planos->fetch(PDO::FETCH_OBJ)){

               ?>

              <option value="<?= $plano->id; ?>" ><?= $plano->nome; ?></option>

            <?php } }else{  ?>

               <option value="" ><?= $idioma->nenhum_plano_cadastrado; ?></option>

             <?php } ?>


             </select>
           </div>



           <div class="col-md-12 margin">
             <label>Notas <b class="text-danger" >*</b> </label>
             <textarea name="notas" id="notas_cli" class="form-control" rows="3" cols="80" placeholder="<?= $idioma->notas; ?>" ></textarea>
           </div>



     </div>


     <div class="modal-footer">
       <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $idioma->fechar; ?></button>
       <button onclick="save_cli();" type="button" id="btn_save_cli" class="btn btn-primary"><?= $idioma->salvar; ?></button>
     </div>


   </div>
 </div>
</div>
</div>



<!--  Modal add clientes -->
<div class="modal fade" id="modal_add_cli" tabindex="-1" role="dialog" aria-labelledby="TituloModalLongoExemplo" aria-hidden="true">
 <div class="modal-dialog modal-lg" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="Titutlo_modal_add_cliente"><?= $idioma->adicionar_cliente; ?></h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body" id="body_modal_add_cli" >

       <input type="hidden" name="id_cli_add" id="id_cli_add">

          <div class="row">

            <?php

             if(@$plano_usergestor->mini_area_cliente == 1){

            ?>

           <div class="col-md-12">
              <label>Nome <b class="text-danger" >*</b></label>
             <input type="text" class="form-control margin" id="nome_cli_add" placeholder="<?= $idioma->nome; ?>">
           </div>

           <div class="col-md-5">
             <label>Senha <b class="text-danger" >*</b></label>
             <input type="text" class="form-control margin" id="senha_add" placeholder="<?= $idioma->senha; ?>">
           </div>

           <div class="col-md-7">
             <label>Email</label>
             <input type="text" class="form-control margin" id="email_cli_add" placeholder="Email [Opcional]">
             <small id="response_email_add" ></small>
           </div>

         <?php }else{ ?>

           <div class="col-md-5">
             <label>Nome <b class="text-danger" >*</b></label>
             <input type="text" class="form-control margin" id="nome_cli_add" placeholder="<?= $idioma->nome; ?>">
           </div>

           <div class="col-md-7">
              <label>Email</label>
             <input type="text" class="form-control margin" id="email_cli_add" placeholder="<?= $idioma->email; ?> [Opcional]">
             <small id="response_email_add" ></small>
           </div>

         <?php } ?>

           <div class="col-md-6">
             <label>Telefone (Com DDI). <a href="https://www.youtube.com/watch?v=VgU5Rvzsfs4" target="_blank" >Veja aqui</a> <b class="text-danger" >*</b></label>
             <input type="text" class="form-control margin" id="telefone_cli_add" placeholder="DDI+DDD+NUM">
           </div>

           <div class="col-md-6">
             <label>Vencimento <b class="text-danger" >*</b></label>
             <input min="<?= date('Y-m-d'); ?>" type="date" class="form-control margin" id="vencimento_cli_add" placeholder="<?= $idioma->vencimento; ?>">
           </div>

          <div class="col-md-6">
              <label>Categoria</label>
             <select class="form-control" name="categoria_cli_add" id="categoria_cli_add" >
               <option value="0" >Selecionar uma categoria</option>
               <?php if($list_categorias_1){
                    while($cate = $list_categorias_1->fetch(PDO::FETCH_OBJ)){
                 ?>
               <option value="<?= $cate->id; ?>" ><?= $cate->nome; ?></option>
               <?php } }else{ ?>
                <option value="0" >Nenhuma categoria cadastrada</option>
               <?php } ?>
             </select>
           </div>

            <div class="col-md-6">
             <label>Id Externo</label>
             <input type="text" class="form-control margin" maxlength="15" name="identificador_externo_cli_add" id="identificador_externo_cli_add" placeholder="ID Externo [Opcional] ">
           </div>


           <div class="col-md-12 margin">
             <label>Notitificações Whatsapp <b class="text-danger" >*</b></label>
             <select class="form-control" name="recebe_zap_add" id="recebe_zap_add" >
               <option value="1" ><?= $idioma->notificas_via_zap; ?></option>
               <option value="0" ><?= $idioma->nao_notificar_zap; ?></option>
             </select>
           </div>






           <div class="col-md-12 margin">
             <label>Plano <b class="text-danger" >*</b></label>
             <select class="form-control" name="plano_cli" id="plano_cli_add" >
               <option value="0" ><?= $idioma->selecionar_plano; ?></option>

               <?php

                if($planos2){
                  while ($plano2 = $planos2->fetch(PDO::FETCH_OBJ)){

               ?>

              <option value="<?= $plano2->id; ?>" ><?= $plano2->nome; ?></option>

            <?php } }else{  ?>

               <option value="" ><?= $idioma->nenhum_plano_cadastrado; ?></option>

             <?php } ?>


             </select>
           </div>


           <div class="col-md-12 margin">
             <label>Notas <b class="text-danger" >*</b></label>
             <textarea name="notas" id="notas_cli_add" class="form-control" rows="3" cols="80" placeholder="<?= $idioma->notas; ?>" ></textarea>
           </div>



     </div>

     <div class="modal-footer">
       <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $idioma->fechar; ?></button>
       <button type="button" onclick="add_cli();" id="btn_add_cli" class="btn btn-primary"><?= $idioma->adicionar; ?></button>

     </div>


   </div>
 </div>
</div>
</div>


<!--  Modal send_zap clientes -->
<div class="modal fade" id="modal_send_zap" tabindex="-1" role="dialog" aria-labelledby="Titutlo_modal_send_zap" aria-hidden="true">
 <div class="modal-dialog modal-lg" role="document">
   <div class="modal-content">
     <div class="modal-header bg-success">
           <h5 class="modal-title text-white" id="Titutlo_modal_send_zap">Reenviar Cobrança por whatsapp <i class="fa fa-whatsapp"></i></h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body" id="body_modal_send_zap" >

        <?php if($wsapi){ ?>

           <input type="hidden" name="id_cli_send" id="id_cli_send">

              <div class="row">

               <div class="col-md-12 margin">
                             <p class="alert alert-danger">
                                   <b><i class="fa fa-warning text-danger" ></i> Atenção</b>. Não envie SPAM, e envie no máximo 5 mensagens por hora. <br />
                                   Se nosso sistema identificar uso indevido desta ferramenta sua conta será bloqueada sem aviso prévio. <br />
                                   Lembre-se, o sistema já faz o envio automático das mensagens, portanto não há necessidades de <b>enviar</b> cobranças, mas sim <b>reenviar</b>
                               </p>

                   <p class="alert alert-secondary">
                       Agende uma mansagem para envio ao cliente <b id="nome_cli_send"></b>. <br />
                       As mensagens são enviadas dentro de 5min.
                   </p>

                   <center id="msg_send_zap_aguarde" style="margin-top:20px;">
                       <h4>Aguarde <i class="fa fa-refresh fa-spin"></i></h4>
                   </center>

              <div id="form_send_zap" style="display:none;" >
                  <div class="form-group">
                      <input type="text" value="" disabled style="cursor:no-drop;" id="nome_cli_send1" class="form-control">
                  </div>

                  <div class="form-group">
                      <input type="text" value="" disabled style="cursor:no-drop;" id="zap_cli" class="form-control">
                  </div>

                  <div class="form-group">
                      <textarea data-emojiable="true" data-emoji-input="unicode" placeholder="Texto da mensagem" class="form-control textarea-control" rows="10" id="texto_to" ></textarea>
                  </div>
              </div>

               </div>

            </div>
         <div class="modal-footer">

           <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $idioma->cancelar; ?></button>
           <button style="disaply:none;" type="button" onclick="agenda_envio();" id="btn_send_zap" class="btn btn-success">Agendar Envio</button>

         </div>


    <?php }else{ ?>


        <div class="row">

            <div class="col-md-12">

                <p class="alert-warning alert" >

                    Para usar o envio automático e o envio agendado. Você deve ativar uma API do whatsapp. <br />
                    Acesse <a href="whatsapi">WhatsAPI</a> para ativar uma API. <br />
                    Se possui dúvidas, pode ler nosso artigo. <a href="https://kb.gestorlite.com/base-de-conhecimento/como-enviar-mensagens-automaticas-por-whatsapp/" target="_blank" >Ler artigo</a>

                </p>

            </div>

        </div>

    <?php } ?>

   </div>
 </div>
</div>
</div>


<!--  Modal del clientes -->
<div class="modal fade" id="modal_del_cli" tabindex="-1" role="dialog" aria-labelledby="Titutlo_modal_del_cliente" aria-hidden="true">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header bg-danger">
       <h5 class="modal-title text-white" id="Titutlo_modal_del_cliente"><?= $idioma->deletar_cliente; ?></h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body" id="body_modal_del_cli" >

       <input type="hidden" name="id_del_add" id="id_del_add">

          <div class="row">

           <div class="col-md-12 text-center margin">

             <h4><?= $idioma->deseja_deletar_cliente; ?></h4>

           </div>

     </div>
     <div class="modal-footer">

       <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $idioma->cancelar; ?></button>
       <button type="button" onclick="del_cli();" id="btn_del_cli" class="btn btn-primary"><?= $idioma->deletar; ?></button>

     </div>


   </div>
 </div>
</div>
</div>

<!--  Modal del clientes -->
<div class="modal fade" id="modal_categorias" tabindex="-1" role="dialog" aria-labelledby="Titutlo_modal_del_cliente" aria-hidden="true">
 <div class="modal-dialog modal-lg" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title " id="Titutlo_modal_del_cliente">Categorias de clientes</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body" id="body_modal_categorias" >


      <div class="row">
          <div class="col-md-12">
              <p class="alert alert-danger" id="msg_return_categoria" style="display:none;"></p>
          </div>
          <div class="col-md-12 border-bottom">
              <button onclick="add_categoria();" id="btn_add_categoria" class="btn btn-outline-secondary btn-sm" style="width:100%;" > <i class="fa fa-plus"></i> Nova categoria</button>
          </div>

           <div class="col-md-12 text-center margin">
                <div id="div_list_categorias" class="row" style="margin:10px;">
                </div>
           </div>

     </div>
     <div class="modal-footer">
        <p>
            As cores das categorias são geradas aleatóriamente.
        </p>
       <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $idioma->fechar; ?></button>

     </div>


   </div>
 </div>
</div>
</div>



<?php if(@$plano_usergestor->faturas_cliente == 1){ ?>
<!--  Modal faturas cliente -->
<div class="modal fade"  data-backdrop="static" id="modal_fat_cli" tabindex="-1" role="dialog" aria-labelledby="Titutlo_modal_del_cliente" aria-hidden="true">
 <div class="modal-dialog modal-lg" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="Titutlo_modal_fat_cli"><?= $idioma->faturas_cliente; ?></h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body" id="body_modal_fat_cli" >

       <input type="hidden" id="id_cli_fat" >
       <input type="hidden" id="nome_cli_fat" >
       <input type="hidden" id="email_cli_fat" >

       <div style="margin-bottom:10px;" class="row">
         <div class="col-md-3 text-left">
           <button onclick="modal_create_fat();" type="button" class="btn btn-sm btn-outline-success" name="button"><i class="fa fa-plus" ></i> Nova Fatura</button>
         </div>
         <div class="col-auto my-1">
          <div class="custom-control custom-checkbox mr-sm-2">
            <input onclick="status_lanca_finan();" value="1" <?php if($user->lancar_finan == 1){ echo "checked"; } ?> type="checkbox" id="lancar_finan_status" name="lancar_finan_status" class="custom-control-input">
            <input type="hidden" id="status_lanca_finan" value="<?= $user->lancar_finan; ?>" />
            <label class="custom-control-label" for="lancar_finan_status">Lançamento automático financeiro</label>
          </div>
          <div class="custom-control custom-checkbox mr-sm-2">
            <input onclick="status_vencimento_flex();" value="1" <?php if($user->vencimento_flex == 1){ echo "checked"; } ?> type="checkbox" id="vencimento_flex_status" name="vencimento_flex_status" class="custom-control-input">
            <input type="hidden" id="status_vencimento_flex" value="<?= $user->vencimento_flex; ?>" />
            <label class="custom-control-label" for="vencimento_flex_status">Vencimentos Flexíveis</label> | <a href="https://youtu.be/FmI-DDg96ZQ" target="_blank" ><i class="fa fa-question"></i></a>
          </div>

        </div>

        <div class="col-auto my-1">
          <div class="custom-control custom-checkbox mr-sm-2">
            <input onclick="status_gera_fat_cli();" value="1" <?php if($user->gera_fat_cli == 1){ echo "checked"; } ?> type="checkbox" id="gera_fat_cli" name="gera_fat_cli" class="custom-control-input">
            <input type="hidden" id="status_gera_fat_cli" value="<?= $user->gera_fat_cli; ?>" />
            <label class="custom-control-label" for="gera_fat_cli">Gerar faturas automáticas</label>
          </div>
        </div>
       </div>

        <div class="table-responsive" >
                 <table class="table">
                   <span id="response_msg_fat_"></span>
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col"><?= $idioma->valor; ?></th>
                      <th scope="col"><?= $idioma->data; ?></th>
                      <th scope="col"><?= $idioma->plano; ?></th>
                      <th scope="col"><?= $idioma->status; ?></th>
                      <th scope="col"><?= $idioma->deletar; ?></th>
                    </tr>
                  </thead>

                  <tbody id="tbody_faturas" >

                  </tbody>
                </table>
        </div>

      </div>

     <div class="modal-footer">
       <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $idioma->fechar; ?></button>
     </div>
    </div>

   </div>
 </div>

 <!--  Modal create faturas cliente -->
 <div class="modal fade " data-backdrop="static" id="modal_create_fat" tabindex="-1" role="dialog" aria-labelledby="Titutlo_modal_del_cliente" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="Titutlo_modal_fat_cli"><?= $idioma->nova_fatura_cliente; ?></h5>
        </div>
        <div class="modal-body" id="body_modal_add_fat" >

          <input type="hidden" name="id_cli_new_fat" id="id_cli_new_fat"  value=""  >
          <input type="hidden" name="nome_cli_new_fat" id="nome_cli_new_fat"  value=""  >
          <input type="hidden" name="email_new_fat" id="email_new_fat"  value=""  >

          <div class="row">
            <div style="margin-bottom:5px;" class="col-md-12 text-center">
              <span id="response_msg"></span>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <input type="text" class="form-control" id="nome_cli_view" name="nome_cli_view" value="" disabled  >
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <input type="text" class="form-control" id="email_cli_view" name="email_cli_view" value="" disabled  >
              </div>
            </div>
            <div class="col-md-12 margin">
              <div class="form-group">
                  <select onchange="busca_plano_fat();" class="form-control" name="plano_fat" id="plano_fat" >
                    <option value="" ><?= $idioma->selecionar_plano; ?></option>

                    <?php

                     if($planos3){
                       while ($plano = $planos3->fetch(PDO::FETCH_OBJ)){

                    ?>

                    <option value="<?= $plano->id; ?>" ><?= $plano->nome; ?></option>

                 <?php } }else{  ?>

                    <option value="" ><?= $idioma->nenhum_plano_cadastrado; ?></option>

                  <?php } ?>


                  </select>
              </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <input type="text" class="form-control" name="valor_fat" id="valor_fat_add" value="0,00"  >
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <input type="date" class="form-control" name="data_fat" id="data_fat_add" value="<?= date('Y-m-d'); ?>"  >
            </div>
          </div>
          <div class="col-md-12 margin">
            <select onchange="mostra_move();" class="form-control" name="status_fat" id="status_fat" >
              <option value="Pendente"><?= $idioma->pendente; ?></option>
              <option value="Pago"><?= $idioma->pago; ?></option>
              <option value="Rejeitado"><?= $idioma->rejeitado; ?></option>
              <option value="Devolvido"><?= $idioma->devolvido; ?></option>
            </select>
        </div>
        <div class="col-md-12 margin" id="div_move_fat" style="display:none;" >
            <div class="col-auto my-1">
              <div class="custom-control custom-checkbox mr-sm-2">
                <input value="1" type="checkbox" id="move_fatura" name="move_fatura" class="custom-control-input">
                <label class="custom-control-label" for="move_fatura">Lançar no financeiro</label>
              </div>
            </div>
        </div>
        </div>
      </div>

      <div class="modal-footer">
        <button onclick="cancel_new_fat();" type="button" class="btn btn-secondary" data-dismiss="modal"><?= $idioma->cancelar; ?></button>
        <button onclick="create_fat();" type="button" class="btn btn-primary"><?= $idioma->criar; ?></button>
      </div>
   </div>
  </div>
</div>


 <script>



     function status_gera_fat_cli() {
        var a = $("#status_gera_fat_cli").val();
        $.post("../control/control.status_create_fat_vencimento.php", {
            status: a
        }, function(a) {
            var objResGerarFat = JSON.parse(a);
            $("#status_gera_fat_cli").val(objResGerarFat.statusRes);
        })
    }
 </script>

<?php } ?>

 <script>

 </script>




<?php include_once 'inc/footer.php'; ?>
