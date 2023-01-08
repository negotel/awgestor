<?php


  $clientes_class = new Clientes();

  $area_cli_conf   = $clientes_class->area_cli_conf($_SESSION['SESSION_USER']['id']);
  $indicacoescli   = $clientes_class->get_indicacoesByuser($_SESSION['SESSION_USER']['id']);
  
   if($plano_usergestor->mini_area_cliente == 0){
       echo "<script>location.href='cart?upgrade';</script>";
       die;
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
              <div class="row">
                <?php
                 if(isset($_SESSION['INFO'])){
                   echo '<div id="msg_hide" class="alert alert-secondary">'.$_SESSION['INFO'].'</div>';
                   unset($_SESSION['INFO']);
                 }
                 ?>
    
                 <?php if($area_cli_conf){ ?>
    
                       <div class="col-md-12" >
                            <div style="margin-top:40px;" class="row">
                                <div class="col-md-12">
                                    <h3>Clientes que indicaram seus produtos</h3>
                                </div>
                            </div>
                             <div class="row">
                               <div class="table-responsive">
    
                                   <table class="table table-striped table-sm">
                                     <thead>
                                       <tr>
                                         <th></th>
                                         <th>Identificador</th>
                                         <th>Cliente</th>
                                         <th>Email Cliente</th>
                                         <th>Quantidade</th>
                                       </tr>
                                     </thead>
                                     <tbody id="tbody_avisos_painel_cli" class="" >
                                       <form class="" id="form_checkbox" action="../control/control.delete_clientes.php" method="POST">
                                       <?php
            
                                          if($indicacoescli){
                                              
                                            $i =1;
            
                                            while($indicacao = $indicacoescli->fetch(PDO::FETCH_OBJ)){
                                            
                                            $cliente = $clientes_class->dados($indicacao->id_cliente);
                                            
                                            $icon = '<i style="color:#dbbb3f;font-size:20px;" class="fa fa-stop"></i> <span style="font-size:9px;">'.$i.'th</span>';
                                            if($i == 1){
                                                $icon = '<i style="color:#dbbb3f;font-size:20px;" class="fa fa-trophy"></i> <span style="font-size:9px;">'.$i.'th</span>';
                                            }else if($i == 2){
                                                $icon = '<i style="color:#938f8f;font-size:20px;" class="fa fa-trophy"></i> <span style="font-size:9px;">'.$i.'th</span>';
                                            }else if($i == 3){
                                                $icon = '<i style="color:#7b6844;font-size:20px;" class="fa fa-trophy"></i> <span style="font-size:9px;">'.$i.'th</span>';
                                            }
                                       ?>
            
            
                                       <tr class="trs " >
                                         <td><?= $icon;?></td>
                                         <td>#<?= $indicacao->id;?></td>
                                         <td><?= $cliente->nome; ?></td>
                                         <td><?= $cliente->email; ?></td>
                                         <td><?= $indicacao->qtd; ?></td>
                                       </tr>
            
                                     <?php $i++; } }else{ ?>
            
                                       <tr>
                                         <td class="text-center" colspan="5" >Nenhuma indicação ainda</td>
                                       </tr>
            
            
                                     <?php } ?>
            
                                       </form>
                                     </tbody>
                                   </table>
            
    
                                 </div>
                         
                             </div>
                             
                       </div>
                   </div>
               </div>
        

    
           <?php } ?>






              <div class="col-md-12 card" style="padding:20px;">
                <?php if($area_cli_conf){ ?>
                <?php }else{ ?>
                  <center>
                    <p><?= $idioma->nao_gerou_area_cli; ?></p>
                    <a type="button" class="btn btn-outline-primary" href="painel_cliente_conf" ><i class="fa fa-refresh" ></i> <?= $idioma->gerar_area_cli; ?></button>
                  </center>
                <?php } ?>
              </div>
          </div>

           </div>
           </div>
        </main>
    


 <!-- footer -->
 <?php include_once 'inc/footer.php'; ?>
