<?php
 
 
  $planos_class = new Planos();
  $gateways_class = new Gateways();
 
 
  $planos = $planos_class->list($_SESSION['SESSION_USER']['id']);
  
     $mp_credenciais = new stdClass;
     $mp_credenciais->client_id = '';
     $mp_credenciais->client_secret = '';
     $plano_gate = 0;
  
 if($plano_usergestor->gateways){
     $plano_gate = 1;
     $mp_credenciais = $gateways_class->dados_mp_user($_SESSION['SESSION_USER']['id']);
 }

?>



<!-- Head and Nav -->
<?php include_once 'inc/head-nav.php'; ?>


    <!-- NavBar -->
    <?php include_once 'inc/nav-bar.php'; ?>

    <main class="page-content">
    
    <div class="">
            
            <div style="padding: 10px;-webkit-box-shadow: 0px 0px 16px -2px rgb(0 0 0 / 84%);box-shadow: 0px 0px 16px -2px rgb(0 0 0 / 84%);width: 99%;" class="card row" >
            
      <div class="col-md-12">
        <h1 class="h2"><?= $idioma->planos; ?> <i class="fa fa-diamond" ></i> </h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group mr-2">
            <button onclick="modal_add_plano();" type="button" class="btn btn-sm btn-outline-secondary"><i class="fa fa-plus" ></i> <?= $idioma->adicionar_novo; ?></button>
          </div>
        </div>
      </div>
      <?php
      if(isset($_SESSION['INFO'])){
        echo '<div id="msg_hide" class="alert alert-secondary">'.$_SESSION['INFO'].'</div>';
        unset($_SESSION['INFO']);
      }
      ?>
      <div class='col-md-12'>
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th>ID</th>
              <th><?= $idioma->valor; ?></th>
              <th><?= $idioma->nome; ?></th>
              <th><?= $idioma->dias; ?></th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>

            <?php

              if($planos){

                while ($plano = $planos->fetch(PDO::FETCH_OBJ)) {


              ?>



            <tr>
              <td><?= $plano->id; ?></td>
              <td>R$ <?= $plano->valor; ?> </td>
              <td><?= $plano->nome; ?></td>
              <td><?= $plano->dias; ?> <?= $idioma->dias; ?></td>
              <td>
                <button onclick="modal_edite_plano(<?= $plano->id; ?>);" title="<?= $idioma->editar; ?>" type="button" class="btn-outline-info btn btn-sm btn-outline-secondary"> <i class="fa fa-pencil" ></i> </button>
                <button onclick="modal_del_plano(<?= $plano->id; ?>);" title="<?= $idioma->excluir; ?>" type="button" class="btn-outline-danger btn btn-sm  "> <i class="fa fa-trash" ></i> </button>
                
           
                <?php if($plano_usergestor->link_pay){ ?>
                  <button onclick="modal_link_plano('https://glite.me/p/<?= str_replace('=','',base64_encode($plano->id)); ?>');" title="Link de pagamento" type="button" class="btn-outline-primary btn btn-sm  "> <i class="fa fa-link" ></i> </button>

                  <button onclick="modal_img_plano(<?= $plano->id; ?>,'<?= $plano->banner_link; ?>');" title="Banner Plano" type="button" class="btn-outline-secondary btn btn-sm  "> <i class="fa fa-picture-o" ></i> </button>
               
                <?php } ?>

              </td>
            </tr>



          <?php } }else{ ?>

            <tr>
              <td class="text-center" colspan="5" ><?= $idioma->nenhum_plano_encontrado; ?></td>
            </tr>
          <?php } ?>


          </tbody>
        </table>
      </div>
      </div>
      </div>
      </div>
    </main>
  </div>
</div>


<!--  Modal add imagem plano  -->
<div class="modal fade" id="modal_add_img" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="">Editar/Adicionar Banner ao plano</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body">

        <form action="../control/control.sendimgapi.php" id="sendImg" method="POST" enctype="multipart/form-data">
            
             <div class="form-group">
                <img src="" id="img_atual" width="100%" />
            </div>
            
            <input type="hidden" value="" id="idplano_img" name="idplano_img" />
            
            <div class="text-center form-group">
                <p>
                    <i class="fa fa-warning"></i> A imagem deve ser 906px por 134px. <br />
                    Largura: 906 pixel <br />
                    Altura: 134 pixel
                </p>
            </div>
            
            <div class="text-center form-group">
                <input type="file" name="img_plano" id="img_plano" style="display:none;" />
                <label class="btn btn-success btn-lg" for="img_plano" >Selecionar imagem</label>
            </div>
            
             <div class="text-center form-group">
                <p id="response_imgadd"></p>
            </div>
            
        </form>


     </div>


     <div class="modal-footer">
       <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $idioma->fechar; ?></button>
       <button type="button" onclick="$('#sendImg').submit();" id="btn_add_img_plano"  class="btn btn-primary">Enviar</button>
     </div>


   </div>
 </div>
</div>

<!--  Modal add plano  -->
<div class="modal fade" id="modal_add_plano" tabindex="-1" role="dialog" aria-labelledby="title_modal_template_zap" aria-hidden="true">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="title_modal_template_zap"><?= $idioma->adicionar_plano; ?></h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body">


       <div class="form-group text-center" >

         <input placeholder="<?= $idioma->nome_plano; ?>" type="text" name="nome_plano_add" id="nome_plano_add" class="form-control" value="" >

       </div>

       <div class="form-group text-center" >

         <input placeholder="<?= $idioma->valor_plano; ?>" type="text" name="valor_plano_add" id="valor_plano_add" class="form-control" value="" >

       </div>

       <div class="form-group text-center" >

         <input placeholder="<?= $idioma->dias_validade; ?>" type="number" min="1" name="dias_plano_add" id="dias_plano_add" class="form-control" value="">

       </div>


        <div class="form-group" >

          <textarea placeholder="Template do whatsapp" name="template_zap_add" id="template_zap_add" class="form-control" rows="8" cols="80">{primeiro_nome_cliente} seu plano vence {vencimento_cliente},
*R$ {plano_valor}* - {plano_nome}.

Para que você não fique sem assistir
o que acha de renovar com a gente?

Caso tenha esquecido sua senha para login:

Email: {email_cliente}
Senha: {senha_cliente}

{plano_link}</textarea>
<small>Compatível com emojis <a target="_blank" href="https://getemoji.com/" ><i class="fa fa-external-link"></i></a></small>
          <br />
          <button class="btn btn-outline-info btn-sm" type="button" onclick="preview_zap_planos2();" name="button">Preview <i class="fa fa-eye" ></i></button>

        </div>
        <div class="form-group" >

        <span><a target="_blank" href="gatilhos" ><?= $idioma->ver_gatilhos_textos; ?> <i class="fa fa-external-link" ></i> </a></span>

        </div>

     </div>


     <div class="modal-footer">
       <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $idioma->fechar; ?></button>
       <button type="button" onclick="add_plano_edit();" id="btn_add_plano"  class="btn btn-primary"><?= $idioma->adicionar; ?></button>
     </div>


   </div>
 </div>
</div>


<!--  Modal edite plano  -->
<div class="modal fade" id="modal_edite_plano" tabindex="-1" role="dialog" aria-labelledby="title_modal_template_zap" aria-hidden="true">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="title_modal_template_zap"><?= $idioma->editar_plano; ?></h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body">

       <input type="hidden" name="id_plano_edit" id="id_plano_edit" class="form-control" value="" >


       <div class="form-group text-center" >

         <input placeholder="<?= $idioma->nome_plano; ?>" type="text" name="nome_plano_edit" id="nome_plano_edit" class="form-control" value="" >

       </div>

       <div class="form-group text-center" >

         <input placeholder="<?= $idioma->valor_plano; ?>" type="text" name="valor_plano_edit" id="valor_plano_edit" class="form-control" value="" >

       </div>

       <div class="form-group text-center" >

         <input placeholder="<?= $idioma->dias_validade; ?>" type="number" min="1" name="dias_plano_edit" id="dias_plano_edit" class="form-control" value="">

       </div>


        <div class="form-group" >

          <textarea placeholder="Template do whatsapp" name="template_zap" id="template_zap" class="form-control" rows="8" cols="80"></textarea>
          <small>Compatível com emojis <a target="_blank" href="https://getemoji.com/" ><i class="fa fa-external-link"></i></a></small>
          <br />
          <button class="btn btn-outline-info btn-sm" type="button" onclick="preview_zap_planos();" name="button">Preview <i class="fa fa-eye" ></i></button>

        </div>
        <div class="form-group" >

        <span><a target="_blank" href="gatilhos" ><?= $idioma->ver_gatilhos_textos; ?> <i class="fa fa-external-link" ></i> </a></span>

        </div>

     </div>


     <div class="modal-footer">
       <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $idioma->fechar; ?></button>
       <button type="button" onclick="save_plano_edit();" id="btn_save_plano"  class="btn btn-primary"><?= $idioma->salvar; ?></button>
     </div>


   </div>
 </div>
</div>

<?php if($plano_usergestor->link_pay){ ?>

<!--  Modal link plano -->
<div class="modal fade" id="modal_link_plano" tabindex="-1" role="dialog" aria-labelledby="Titutlo_modal_link_plano" aria-hidden="true">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header bg-info">
       <h5 class="modal-title text-white" id="Titutlo_modal_link_pay">Link de pagamento</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body" id="body_modal_del_plano" >

          <div class="row">
        

           <div class="col-md-12 margin">
               <p>
                  <i class="fa fa-warning text-warning"></i> Atulizamos os requisitos para ter link de pagamento
               </p>
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="Link de pagamento" id="input_link_plano" value="" >
                  <div class="input-group-append">
                    <a class="btn btn-outline-secondary" target="_blank" href="#" id="abrir_link_pay" >Abrir <i class="fa fa-external-link" ></i></a>
                  </div>
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
<?php } ?>

<!--  Modal del plano -->
<div class="modal fade" id="modal_del_plano" tabindex="-1" role="dialog" aria-labelledby="Titutlo_modal_del_cliente" aria-hidden="true">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header bg-danger">
       <h5 class="modal-title text-white" id="Titutlo_modal_del_cliente"><?= $idioma->delete_plano; ?></h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body" id="body_modal_del_plano" >

       <input type="hidden" name="id_del_plano" id="id_del_plano">

          <div class="row">

           <div class="col-md-12 text-center margin">

             <h5><?= $idioma->deseja_deletar_plano; ?></h5>
             <p><?= $idioma->cliente_nenhum_usa_o_plano_para_deletar; ?></p>
           </div>

         </div>

       <div class="modal-footer">

         <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $idioma->cancelar; ?></button>
         <button type="button" onclick="del_plano();" id="btn_del_plano" class="btn btn-primary"><?= $idioma->deletar; ?></button>

       </div>


   </div>
 </div>
</div>
</div>

<script>
    function modal_link_plano(link){
        $("#modal_link_plano").modal('show');
        $('#input_link_plano').val(link);
        $("#abrir_link_pay").attr('href', link);
    }
</script>


 <!-- footer -->
 <?php include_once 'inc/footer.php'; ?>
