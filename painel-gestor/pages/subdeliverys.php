<?php

   $get_subdeliverys = $delivery_class->get_subdeliverysNEnviados($id,$user->id);

   
   if($get_subdeliverys == 'negado'){
       echo '<script>location.href="delivery-aut";</script>';
   }


 ?>



<!-- Head and Nav -->
<?php include_once 'inc/head-nav.php'; ?>



    <!-- NavBar -->
    <?php include_once 'inc/nav-bar.php'; ?>

     <main class="page-content">
    
    <div class="container">
        
       <div class="row">
           
      <div class="col-md-12">
        <h1 class="h2"> <i class="fa-paper-plane-o fa"></i> Entrega automática <small style="font-size:12px;" class="badge badge-success"> <i class="fa fa-lock" ></i> Strong Cryptography</small></h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group mr-2">
            <button style="margin-bottom:10px;" onclick="modal_add_Subdelivery();" type="button" class="btn btn-sm btn-outline-secondary"><i class="fa fa-plus" ></i> Novo Produto</button>
          </div>
        </div>
      </div>
      <div class="">
          <p>
              Cadastre produtos para este pacote. O produto será enviado assim que você vender o plano vinculado ao pacote
          </p>
      </div>
      <?php
       if(isset($_SESSION['INFO'])){
         echo '<div id="msg_hide" class="alert alert-secondary">'.$_SESSION['INFO'].'</div>';
         unset($_SESSION['INFO']);
       }
       ?>

      <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm">
          <thead>


            <tr>
              <th>ID</th>
              <th>Conteúdo</th>
              <th>Opções</th>
            </tr>
          </thead>
          <tbody id="" class="" >
            <?php

               if($get_subdeliverys){

                 while($delivery = $get_subdeliverys->fetch(PDO::FETCH_OBJ)){

            ?>


            <tr class="" >
              <td><?= $delivery->id; ?></td>
              <td><?php if($delivery->reverse == 1){ echo "<i title='Não será removido' style='cursor:pointer;color:gray;' class='fa fa-recycle'></i> ";} ?><?= substr($delivery->content,0,100); ?></td>
              <td>
                <button onclick="edite_subdelivery(<?= $delivery->id; ?>);" title="EDITAR" type="button" class="btn-outline-info btn btn-sm"> <i class="fa fa-pencil" ></i> </button>
                <button onclick="modal_del_subdelivery(<?= $delivery->id; ?>);" title="REMOVER" type="button" class="btn-outline-danger btn btn-sm"> <i class="fa fa-trash" ></i> </button>

              </td>
            </tr>

          <?php } }else{ ?>

            <tr>
              <td class="text-center" colspan="6" >Nenhum Produto Registrado</td>
            </tr>


          <?php } ?>

          </tbody>
        </table>


      </div>
       </div>
        </div>
    </main>
  </div>
</div>


<!--  Modal view delete movimentacao -->
<div class="modal fade" id="modal_del_subdelivery" tabindex="-1" role="dialog" aria-labelledby="TituloModalLongoExemplo" aria-hidden="true">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="titutlo_modal_del_mov">Deseja realmente deletar?</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body" id="body_modal_del_delivery" >
       <input type="hidden" name="input_id_del_subdelivery" id="input_id_del_subdelivery" value="">
       <input type="hidden" name="deliveryId" id="deliveryId" value="<?= $_GET['id']?>"

       <h4>Muita calma nesta hora !</h4>
       <p>
         Você realmente deseja deletar este produto ?
       </p>

     </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      <button onclick="del_subdelivery();" type="button" id="btn_del_subdelivery" class="btn btn-primary">Deletar</button>
    </div>
  </div>
</div>
</div>




<!--  Modal edite delivery -->
<div class="modal fade" id="modal_edite_subdelivery" tabindex="-1" role="dialog" aria-labelledby="TituloModalLongoExemplo" aria-hidden="true">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="Titutlo_modal_add_cliente">Editar Delivery</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body" id="body_modal_edite_subdelivery" >

          <div class="row">

           <input type="hidden" value="" id="id_subdelivery_edite" />
           <input type="hidden"  value="<?= $_GET['id']; ?>" id="deliveryIdEdit" />
           
            <div class="col-md-12 form-group">
             <textarea name="content_subdelivery_edite" id="content_subdelivery_edite" class="form-control" rows="3" cols="30" placeholder="Conteúdo" ></textarea>
            </div>
            
             
            <div class="col-md-12 form-group">
                <select class="form-control" id="reverse_subdelivery_edite" name="reverse_subdelivery_edite" >
                    <option value="0" >Deletar após envio</option>
                    <option value="1" >Não deletar após envio</option>
                </select>
            </div>
    
            
        </div>

     <span>Todos os campos são obrigatórios</span>
     <div class="modal-footer">
       <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
       <button type="button" onclick="edite_subdelivery_form();" id="btn_edite_subdelivery" class="btn btn-primary">Editar</button>

     </div>


   </div>
 </div>
</div>
</div>


<!--  Modal add delivery -->
<div class="modal fade" id="modal_add_Subdelivery" tabindex="-1" role="dialog" aria-labelledby="TituloModalLongoExemplo" aria-hidden="true">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="Titutlo_modal_add_cliente">Adicionar Sub Delivery</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body" id="body_modal_add_mov" >

       <div class="row ">

        <div class="col-md-12 form-group">
          <label>Conteúdo</label>
          <textarea name="content_subdelivery" id="content_subdelivery" class="form-control" rows="3" cols="30" placeholder="Ex: Link de um produto digital, ou uma licença" ></textarea>
        </div>
        
        <div class="col-md-12 form-group">
            <label>Remover o produto após o envio?</label>
            <select class="form-control" id="reverse" name="reverse" >
                <option value="0" >Deletar após envio</option>
                <option value="1" >Não deletar após envio</option>
            </select>
        </div>
    
        <input type="hidden" value="<?= $_GET['id'] ?>" id="idDelivery" />

     </div>

     <div class="modal-footer">
       <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
       <button type="button" onclick="add_subdelivery();" id="btn_add_subdelivery" class="btn btn-primary">Adicionar</button>

     </div>


   </div>
 </div>
</div>
</div>

 <!-- footer -->
 <?php include_once 'inc/footer.php'; ?>
