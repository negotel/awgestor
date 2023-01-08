<?php 

  $whatsapi_class = new Whatsapi();
  $list_fila_msgs = $whatsapi_class->list_msgs_fila_user($user->id);
  
  $clientes_class = new Clientes();

?>
<!-- Head and Nav -->
<?php include_once 'inc/head-nav.php'; ?>



    <!-- NavBar -->
    <?php include_once 'inc/nav-bar.php'; ?>

      <main class="page-content">
    
     <div class="container">
        
        <div class="row">
            
      <div class="col-md-12">
        <h2 class="h2">Fila de mensagens <i class="fa fa-whatsapp"></i> </h2>
        <span>Acompanhe as mesagens que estão na fila para serem enviadas</span>
     </div>
     <div class="col-md-12">
     <div class="row">
       
       <div style="margin-top:50px;" class="col-md-12">
         <div class="table-responsive">
            <table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th>Cliente</th>
                  <th>Previsão para envio</th>
                  <th style="width:50%;" >Mensagem</th>
                </tr>
              </thead>
              <tbody>
                  
                  <?php if($list_fila_msgs){ ?>
    
    
                    <?php while($fila = $list_fila_msgs->fetch(PDO::FETCH_OBJ)){ 
                        
                        
                        $nome_cliente = "--------";
                        $zap_cliente = "--------";
                        $cliente_dados = $clientes_class->dados($fila->id_cliente);
                        
                        if($cliente_dados){
                          $nome_cliente  = $cliente_dados->nome;
                          $zap_cliente   = '<i class="fa fa-whatsapp"></i> '.$cliente_dados->telefone;
                        }
                
                    $previsao = $whatsapi_class->calc_previsao_disparo($fila->id);
                    

                    ?>
                    
                    <tr>
                      <td><?= $nome_cliente. ' [ '.$zap_cliente.' ]'; ?></td>
                      <td><?= date('d/m/Y H:i', $previsao);?></td>
                      <td>
                          <?= $fila->msg; ?>
                      </td>
                    </tr>
                    
                    <?php } ?>
    
                <?php }else{ ?>
                
                    <tr>
                      <td colspan="5" class="text-center" >Nada por aqui</td>
                    </tr>
                
                <?php } ?>
    
              </tbody>
            </table>
          </div>
       </div>
     </div>
    </div>
    </div>
    </div>
    </main>
  </div>
</div>



 
 <!-- footer -->
 <?php include_once 'inc/footer.php'; ?>
