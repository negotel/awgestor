<?php

  $financeiro_class = new Financeiro();


    if($plano_usergestor->financeiro_avan == 0){
       header('Location: cart?upgrade');
      exit;
    }
    
    

   // listar Movimentacoes
   $movimentacao  = $financeiro_class->list($_SESSION['SESSION_USER']['id']);
   $percentual    = explode('|',$financeiro_class->percentual($_SESSION['SESSION_USER']['id']));
   $projecao      = json_decode($financeiro_class->projecao($_SESSION['SESSION_USER']['id']));
   $movimentado_y = $financeiro_class->movimentado_ano($_SESSION['SESSION_USER']['id']);
   $movimentado_m = $financeiro_class->movimentado_mes($_SESSION['SESSION_USER']['id']);

 ?>



<!-- Head and Nav -->
<?php include_once 'inc/head-nav.php'; ?>


    <!-- NavBar -->
    <?php include_once 'inc/nav-bar.php'; ?>

    <main class="page-content">
    
    <div class="container">
        
       <div class="row">
            
      <div class="col-md-12">
        <h1 class="h2">Financeiro Avançado <i class="fa fa-line-chart" ></i></h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group mr-2">
            <button onclick="location.href='financeiro';" type="button" class="btn btn-sm btn-outline-secondary"><i class="fa fa-arrow-left" ></i> Voltar</button>
          </div>
        </div>
      </div>
      <?php
       if(isset($_SESSION['INFO'])){
         echo '<div id="msg_hide" class="alert alert-secondary">'.$_SESSION['INFO'].'</div>';
         unset($_SESSION['INFO']);
       }
       ?>


       <div style="margin-bottom:10px;" class="col-md-12">
         <div class="row">
             
             <div style="margin-top:10px!important;margin-bottom:10px!important;" class="col-md-12" style="margin-bottom:10px;">
                 <div class="btn-group">
                     <button onclick="$('#modalProjecao').modal('show');" class="btn btn-primary btn-sm" >Projeção</button>
                 </div>
             </div>

           <div class="col-md-4" >
              <div class="card">
                <div class="text-center card-head">
                  <span class="badge badge-secondary" >Movimentado este ano: <?= date('Y'); ?> </span>
                </div>
                <div class="card-body">

                  <div class="row">
                      <div class="col-md-6">
                        <h4><?= $moeda->simbolo; ?> <?= $movimentado_y; ?></h4>
                      </div>
                      <div class="col-md-6">
                        <h2 class="" ><i class="fa fa-exchange" ></i></h2>
                      </div>
                  </div>

                </div>
              </div>
           </div>

           <div class="col-md-4" >
              <div class="card">
                <div class="text-center card-head">
                  <span class="badge badge-secondary" >Movimentado este mês: <?= $financeiro_class->text_mes(date('m'),true); ?></span>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6">
                          <h4><?= $moeda->simbolo; ?> <?= $movimentado_m; ?></h4>
                        </div>
                        <div class="col-md-6">
                          <h2 class="" ><i class="fa fa-bar-chart" ></i></h2>
                        </div>
                    </div>

                </div>
              </div>
           </div>


           <div class="col-md-4" >
              <div class="card">
                <div class="text-center card-head">
                  <span class="badge badge-secondary" >Comparado com <?= $percentual[2]; ?>  <i class="fa fa-percent" ></i> </span>
                </div>
                <div class="card-body">

                  <div class="row">
                      <div class="col-md-6">
                        <h4>% <?= str_replace('.',',',$percentual[0]); ?></h4>
                      </div>
                      <div class="col-md-6">
                        <h2><?= $percentual[1]; ?></h2>
                      </div>

                  </div>

                </div>
              </div>
           </div>


         </div>
       </div>

       <div class="container">
          <div class="row" id="panel_grap" >
              <div id="gif_load" class="text-center col-md-12">
                  <img width="150" src="img/load_financeiro.gif" alt="">
              </div>


              <?php

               $ar = $financeiro_class->graph_order($_SESSION['SESSION_USER']['id']);

              foreach ($ar as $key => $value) {

              ?>

              <div id="grap_<?= $value;?>" class="col-md-6">
                <div style="border:1px solid #6610f2; display: none; margin-bottom:10px;" class="chart<?= $value;?>">
                  <i onclick="print_gra('chart<?= $value;?>');" style="cursor:pointer;margin:3px;color:#6610f2;" class="fa fa-print" ></i>
                </div>
              </div>

            <?php } ?>

          </div>
       </div>
        
        </div>
        </div>



    </main>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalProjecao" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Projeção monetária para o próximo mês</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="text-center modal-body">
        <div class="row" >
            <?php  if($projecao->erro == false){ ?>
                <div class="col-md-12" >
                       <?php  if($projecao->projecao != false){ ?>
                            <h3><?= $moeda->simbolo; ?> <?= $projecao->projecao; ?></h3>
                         <?php }else{ ?>
                             <h3><?= $moeda->simbolo; ?> 0,00</h3>
                         <?php } ?>
                        <?php  if($projecao->projecao != false){ ?>
                            <h3><?= $projecao->mes; ?></h3>
                            <p class="text-left alert alert-info" >
                                Nós calculamos seus ganhos dos últimos 3 meses e fizemos uma projeção baseado em sua média. <br />
                                Este valor não é relevante para uso legal.
                            </p>
                         <?php }else{ ?>
                            <p class="text-left alert alert-warning" >
                                <?= $projecao->msg; ?>
                            </p>
                         <?php } ?>
                </div>
             <?php }else{ ?>
                <p>DESCULPE, OCORREU UM ERRO. ENTRE EM CONTATO COM O SUPORTE, OU VOLTE MAIS TARDE.</p>
             <?php } ?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

<input type="hidden" name="dados_charts_1" id="dados_charts_1" value="">
<input type="hidden" name="dados_charts_2" id="dados_charts_2" value="">
<input type="hidden" name="dados_charts_3" id="dados_charts_3" value="">
<input type="hidden" name="dados_charts_4" id="dados_charts_4" value="">

<input type="hidden" name="dados_charts_2_dias" id="dados_charts_2_dias" value="">
<input type="hidden" name="dados_charts_3_anos" id="dados_charts_3_anos" value="">

<script src="js/financeiro.js" ></script>


 <!-- footer -->
 <?php include_once 'inc/footer.php'; ?>
