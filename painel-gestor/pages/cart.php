<?php

  if(isset($_SESSION['PLANO_SELECT'])){
    unset($_SESSION['PLANO_SELECT']);
  }

  if(isset($_SESSION['pre_cadastro'])){
    echo '<script>location.href="<?=SET_URL_PRODUCTION?>/painel/pagamentos";</script>';
  }

  $gestor_class = new Gestor();
  $planos_gestor = $gestor_class->list_planos();



?>


<!-- Head and Nav -->
<?php include_once 'inc/head-nav.php'; ?>


    <!-- NavBar -->
    <?php include_once 'inc/nav-bar.php'; ?>

    <main class="page-content">
    
    <div class="container">
        
        <div class="row">
            
            
      <div class="col-md-12">
        <h1 class="h2">Planos Gestor Lite</h1>
      </div>

       <?php if(isset($_GET['upgrade'])){ ?>
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                <div class="alert alert-info">
                  Faça Upgrade para usar está função.
                </div>
              </div>
            </div>
          </div>
       <?php }?>

        <div class="col-md-12">
            <div class="row">

              <?php

                  if($planos_gestor){
                    while ($plano = $planos_gestor->fetch(PDO::FETCH_OBJ)) {
               ?>

              <div  class="col-md-4">
                <div class="card" style="overflow:hidden;" >
                  <?php   if($plano->popular == 1){ ?>
                      <div class="popularClass"><i class="fa fa-star" ></i> POPULAR</div>
                  <?php } ?>
                   <div style="margin-top:10px;" class="text-center card-head">
                     <h4>R$ <?= $plano->valor; ?></h4>
                   </div>

                    <div class="card-body">
                      <h3><?= $plano->nome; ?></h3>
                      <?= $plano->text; ?>
                    </div>
                    <div class="card-footer">
                      <?php if(isset($plano_usergestor->limit_cli)){ ?>
                        <?php if($plano_usergestor->limit_cli > $plano->limit_cli){  ?>
                          <button id="button_<?= $plano->id; ?>" onclick="downgrade_plano(<?= $plano->id; ?>);" style="width:100%;" class="<?php if($plano->popular == 1){ echo "active"; } ?> btn btn-outline-primary button_pay" >Contratar</button>
                        <?php }else{ ?>
                          <button id="button_<?= $plano->id; ?>" onclick="checkout(<?= $plano->id; ?>);" style="width:100%;" class="<?php if($plano->popular == 1){ echo "active"; } ?> btn btn-outline-primary button_pay" >Contratar</button>
                        <?php } }else{ ?>
                          <button id="button_<?= $plano->id; ?>" onclick="checkout(<?= $plano->id; ?>);" style="width:100%;" class="<?php if($plano->popular == 1){ echo "active"; } ?> btn btn-outline-primary button_pay" >Contratar</button>
                        <?php } ?>
                        <small><a href="<?=SET_URL_PRODUCTION?>/faq?wpp&text=" target="_blank" > <i class="fa fa-whatsapp"></i> Tire suas dúvidas</a></small>
                    </div>
                </div>
              </div>

            <?php } }else{ ?>
              <div class="text-center col-md-12">
                <p>
                  ERRO: Entre em contato com o suporte.
                </p>
              </div>
            <?php } ?>



            </div>
        </div>
</div>
</div>

    </main>
  </div>
</div>


<!--  Modal pay -->
<div class="modal fade" id="modal_payment" tabindex="-1" role="dialog" aria-labelledby="Titutlo_modal_payment" aria-hidden="true">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="Titutlo_modal_payment">Ta quase lá <?= explode(' ',$user->nome)[0]; ?></h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body" id="body_modal_payment" >

          <div class="row">

           <div class="col-md-12 text-center margin">

             <h4>Ótimo, sua fatura foi gerada! Agora é só pagar...</h4>

             <a style="width:100%" id="btn_mp" href="#" class="btn btn-info" >Pagar</a>
             <br />
             <small>Pagamento seguro <i class="fa fa-lock" ></i> </small>
             <br />
             <img width="100%" src="../libs/MercadoPago/img/mercado-pago-logo.png" alt="">

           </div>

          </div>

     </div>

   </div>
 </div>
</div>

<!--  Modal downgrade -->
<div class="modal fade" id="modal_downgrade" tabindex="-1" role="dialog" aria-labelledby="Titutlo_modal_downgrade" aria-hidden="true">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header text-white bg-danger">
       <h5 class="modal-title" id="Titutlo_modal_downgrade">Você está prestes a fazer um downgrade</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body" id="body_modal_downgrade" >

          <div class="row">
              
              
           <div class="col-md-12" >
               <p class="alert alert-danger">
                <b>Atenção</b>:  Faça download de seus clientes antes do downgrade.
               </p>
           </div>

           <div class="col-md-12 margin">

             <h4>Leia as informações a seguir com atenção</h4>
             <p>
               Ao fazer Downgrade você :
             </p>
              <ul>
                <li>Se você possui mais cliente do que o permitido eles serão exluidos</li>
                <li>Clientes serão excluidos para cumprir a cota do plano desejado</li>
                <li>Exemplo: Se você possui 100 clientes e o plano desejado permite 50, os outros 50 serão deletados</li>
              </ul>
           </div>

          </div>
          <input type="hidden" id="id_plano" name="id_plano" value="">

     </div>
     <div class="modal-footer">
       <button type="button" class="btn btn-outline-secondary" data-dismiss="modal" name="btn_cancel">Cancelar</button>
       <button type="button" onclick="location.href='../control/control.export_clientes.php';" class="btn btn-outline-info" name="btn_export">Exportar clientes</button>
       <button type="button" onclick="check_down();" id="btn_down_confirm" class="btn btn-outline-success" name="button">Continuar <span id="count_sec"></span> </button>
     </div>

   </div>
 </div>
</div>


 <!-- footer -->
 <?php include_once 'inc/footer.php'; ?>
