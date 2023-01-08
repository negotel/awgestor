<?php

   $delivery_class = new Delivery();
   $financeiro_class = new Financeiro();
   $planos_class = new Planos();

   $get_deliverys = $delivery_class->get_deliverys($user->id);
   
   if(isset($_GET['subdeliverys'])){
       if(isset($_GET['id'])){
           $id = trim($_GET['id']);
           include_once 'pages/subdeliverys.php';
           die;
       }
   }

    
    $planos_delivery_add = $planos_class->list($user->id);
    $planos_delivery_edit = $planos_class->list($user->id);
    

 ?>



<!-- Head and Nav -->
<?php include_once 'inc/head-nav.php'; ?>



    <!-- NavBar -->
    <?php include_once 'inc/nav-bar.php'; ?>

      <main class="page-content">
    
    <div class="container">
        
       <div class="row">
           
      <div class="col-md-12">
        <h1 class="h2"> <i class="fa-paper-plane-o fa"></i> Entrega automática <span class="badge badge-danger">BETA</span></h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group mr-2">
            <button style="margin-bottom:10px;" onclick="modal_add_delivery();" type="button" class="btn btn-sm btn-outline-secondary"><i class="fa fa-plus" ></i> Novo Pacote</button>
          </div>
        </div>
      </div>
      <div class="col-md-12">
          <p>
              <small style="font-size:12px;" class="badge badge-success"> <i class="fa fa-lock" ></i> Strong Cryptography</small>
          </p>
          <p>
              Use está ferramenta para enviar produtos digitalmente assim que efetivar uma venda.
          </p>
      </div>
      <?php
       if(isset($_SESSION['INFO'])){
         echo '<div id="msg_hide" class="alert alert-secondary">'.$_SESSION['INFO'].'</div>';
         unset($_SESSION['INFO']);
       }
       ?>
    
    <div class="col-md-12">
      <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm">
          <thead>


            <tr>
              <th style=" width: 12px;" >Status</th>
              <th>Nome</th>
              <th>Plano Vinculado</th>
              <th>Produtos cadastrados </th>
              <th>Opções</th>
            </tr>
          </thead>
          <tbody id="" class="" >
            <?php

               if($get_deliverys){

                 while($delivery = $get_deliverys->fetch(PDO::FETCH_OBJ)){

                   $plano  = $planos_class->plano($delivery->plano_id);
                   $numsub = $delivery_class->count_subdelivery_not_send($delivery->id);

                   $icon_status = "<i class='fa fa-circle text-danger' ></i>";
                   
                   if($delivery->situ == 1){
                       $icon_status = "<i class='fa fa-circle text-success' ></i>";
                   }

            ?>


            <tr class="" >
              <td ><?= $icon_status; ?></td>
              <td><?= $delivery->nome; ?></td>
              <td><?= $plano->nome; ?></td>
              <td><?= $numsub->num; ?></td>
              <td>
                <button onclick="edite_delivery(<?= $delivery->id; ?>);" title="EDITAR" type="button" class="btn-outline-info btn btn-sm"> <i class="fa fa-pencil" ></i> </button>
                <button onclick="modal_del_delivery(<?= $delivery->id; ?>);" title="REMOVER" type="button" class="btn-outline-danger btn btn-sm"> <i class="fa fa-trash" ></i> </button>
                <button onclick="location.href='?subdeliverys&id=<?= $delivery->id; ?>';" title="SUB DELIVERYS" type="button" class="btn-outline-primary btn btn-sm"> <i class="fa fa-list" ></i> </button>

              </td>
            </tr>

          <?php } }else{ ?>

            <tr>
              <td class="text-center" colspan="6" >Nenhum Pacote Registrado</td>
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


<!--  Modal view delete movimentacao -->
<div class="modal fade" id="modal_del_delivery" tabindex="-1" role="dialog" aria-labelledby="TituloModalLongoExemplo" aria-hidden="true">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="titutlo_modal_del_mov">Deseja realmente deletar?</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body" id="body_modal_del_delivery" >
       <input type="hidden" name="input_id_del_delivery" id="input_id_del_delivery" value="">

       <h4>Muita calma nesta hora !</h4>
       <p>
         Você realmente deseja deletar este Pacote ?
       </p>
       <p>
           Todos os produtos ligados a ele serão removidos.
       </p>
     </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      <button onclick="del_delivery();" type="button" id="btn_del_delivery" class="btn btn-primary">Deletar</button>
    </div>
  </div>
</div>
</div>


<!--  Modal msg -->
<div class="modal fade" id="modal_msg" tabindex="-1" role="dialog" aria-labelledby="TituloModalLongoExemplo" aria-hidden="true">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-body" id="body_msg" >
     </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
    </div>
  </div>
</div>
</div>

<!--  Modal edite delivery -->
<div class="modal fade" id="modal_edite_delivery" tabindex="-1" role="dialog" aria-labelledby="TituloModalLongoExemplo" aria-hidden="true">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="Titutlo_modal_add_cliente">Editar Pacote</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body" id="body_modal_edite_delivery" >

          <div class="row">
              
              <input type="hidden" value="" id="id_delivery_edit" />

             <div class="col-md-12 form-group">
                  <label>Nome do pacote</label>
                  <input type="text" class="form-control margin" id="nome_delivery_edit" placeholder="Nome (Somente você verá)">
                </div>
        
                <div class="col-md-12 form-group">
                  <label>Plano vinculado</label>
                  <select class="form-control" id="plano_delivery_edit" name="plano_delivery_edit">
                      <option>Selecione</option>
                      <?php if($planos_delivery_add){ 
                        
                        while($plano = $planos_delivery_edit->fetch(PDO::FETCH_OBJ)){
                      ?>
                        <option value="<?= $plano->id; ?>"><?= $plano->nome; ?></option>
                      <?php } }else{?>
                        <option value="">Nenhum plano cadastrado</option>
                      <?php } ?>
                  </select>
        
                </div>
                
                <div class="col-md-12 form-group">
                  <label>Status do pacote</label>
                  <select class="form-control" id="situ_delivery_edit" name="situ_delivery_edit">
                      <option value="1" >Ativo</option>
                      <option value="0" >Inativo</option>
                  </select>
        
                </div>
        
                <div class="col-md-12 form-group">
                  <label>Mensagem que seu cliente receberá</label>
                  <textarea name="text_delivery_edit" id="text_delivery_edit" class="form-control" rows="3" cols="80" placeholder="Texto da mensagem que será enviado" ></textarea>
                </div>
                <div class="col-md-12 form-group">
                  <p style="font-size:11px;" >
                      Na mensagem que será enviada, utilize o gatilho <b>{delivery}</b> para vincular o produto na mensagem.
                  </p>
                </div>


        </div>

     <div class="modal-footer">
       <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
       <button type="button" onclick="edite_delivery_form();" id="btn_edite_delivery" class="btn btn-primary">Editar</button>

     </div>


   </div>
 </div>
</div>
</div>


<!--  Modal add delivery -->
<div class="modal fade" id="modal_add_delivery" tabindex="-1" role="dialog" aria-labelledby="TituloModalLongoExemplo" aria-hidden="true">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="Titutlo_modal_add_cliente">Adicionar Pacote</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body" id="body_modal_add_mov" >

       <div class="row ">

        <div class="col-md-12 form-group">
          <label>Nome do pacote</label>
          <input type="text" class="form-control margin" id="nome_delivery" placeholder="Nome (Somente você verá)">
        </div>

        <div class="col-md-12 form-group">
          <label>Plano vinculado</label>
          <select class="form-control" id="plano_delivery" name="plano_delivery">
              <option>Selecione</option>
              <?php if($planos_delivery_add){ 
                
                while($plano = $planos_delivery_add->fetch(PDO::FETCH_OBJ)){
              ?>
                <option value="<?= $plano->id; ?>"><?= $plano->nome; ?></option>
              <?php } }else{?>
                <option value="">Nenhum plano cadastrado</option>
              <?php } ?>
          </select>

        </div>

        <div class="col-md-12 form-group">
          <label>Mensagem que seu cliente receberá</label>
          <textarea name="text_delivery" id="text_delivery" class="form-control" rows="5" cols="80" placeholder="Texto da mensagem que será enviado" ><?=  "Oi, tudo bem?\nVocê comprou nosso produto digital, aqui está ele:\n\n{delivery}";?></textarea>
        </div>
        
        <div class="col-md-12 form-group">
          <p style="font-size:11px;" >
              Na mensagem que será enviada, utilize o gatilho <b>{delivery}</b> para vincular o produto na mensagem.
          </p>
        </div>


     </div>

     <div class="modal-footer">
       <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
       <button type="button" onclick="add_delivery();" id="btn_add_delivery" class="btn btn-primary">Adicionar</button>

     </div>


   </div>
 </div>
</div>
</div>

 <!-- footer -->
 <?php include_once 'inc/footer.php'; ?>
