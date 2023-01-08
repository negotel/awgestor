<?php

    date_default_timezone_set('America/Sao_Paulo');
    
    if(isset($_GET['year'])){
        $_SESSION['year'] = $_GET['year'];
    }

     $financeiro_class = new Financeiro();

     if($plano_usergestor->financeiro == 0){
        header('Location: cart?upgrade');
       exit;
     }


   // listar Movimentacoes
   if(isset($_GET['limit'])){
     $movimentacao = $financeiro_class->list($_SESSION['SESSION_USER']['id'],$_GET['limit']);
   }else{
     $movimentacao = $financeiro_class->list($_SESSION['SESSION_USER']['id']);
   }

   $val = $financeiro_class->soma_mes_atual($_SESSION['SESSION_USER']['id']);
   $valores_mov  = explode('|',$val);

   // soma caixa atual
   $cx_at = ( $financeiro_class->convertMoney(1,$valores_mov[0]) - $financeiro_class->convertMoney(1,$valores_mov[1]) );

 ?>



<!-- Head and Nav -->
<?php include_once 'inc/head-nav.php'; ?>

<div style="margin-top:50px !important;" class="container-fluid">
  <div class="row">

    <!-- NavBar -->
    <?php include_once 'inc/nav-bar.php'; ?>

    <main class="page-content">
    
    <div class="container">
        
        <div class="row">
            
              <div class="col-md-12">
                <h1 class="h2">Financeiro</h1>
                <div style="margin-bottom:10px!important;" class="btn-toolbar mb-2 mb-md-0">
                  <div class="btn-group mr-2">
                    <button onclick="location.href='graphics';" type="button" class="btn btn-sm btn-outline-secondary"><i class="fa fa-line-chart" ></i> Avançado <?php if($plano_usergestor->financeiro_avan == 0){ echo "<i class='text-primary fa fa-star' ></i>"; }?></button>
                     &nbsp;&nbsp;
                    <button <?php if($plano_usergestor->financeiro_avan == 0){ echo "onclick=\"alert('Faça upgrade');location.href='cart?upgrade';\""; }else{ echo "onclick=\"$('#modal_export_financeiro').modal('show');\""; } ?>  type="button" class="btn btn-sm btn-outline-secondary"><i class="fa fa-download" ></i> Exportar <?php if($plano_usergestor->financeiro_avan == 0){ echo "<i class='text-primary fa fa-star' ></i>"; }?></button>
                    <button onclick="$('#modal_import').modal('show');" type="button" class="btn btn-sm btn-outline-secondary"><i class="fa fa-upload" ></i> Importar</button>
                    <button onclick="modal_add_mov();" type="button" class="btn btn-sm btn-outline-secondary"><i class="fa fa-plus" ></i> Adicionar movimentação</button>
                  </div>
                </div>
              </div>
              <?php
               if(isset($_SESSION['INFO'])){
                 echo '<div id="msg_hide" class="alert alert-secondary">'.$_SESSION['INFO'].'</div>';
                 unset($_SESSION['INFO']);
               }
               ?>
        
        
               <div style="" class="col-md-12">
                 <div class="row">
        
                   <div class="col-md-4" >
                      <div class="card">
                        <div class="text-center card-head">
                          <span class="badge badge-secondary" >Valor Atual: <i class="fa fa-calendar" ></i> <?= $financeiro_class->text_mes(date('m'),true); ?></span>
                        </div>
                        <div class="card-body">
        
                          <div class="row">
                              <div class="col-md-6">
                                <h4><?= $moeda->simbolo; ?> <?= $financeiro_class->convertMoney(2,$cx_at); ?></h4>
                              </div>
                              <div class="col-md-6">
                                <h2 class="text-secondary" ><i class="fa fa-bank" ></i></h2>
                              </div>
                          </div>
        
                        </div>
                      </div>
                   </div>
        
                   <div class="col-md-4" >
                      <div class="card">
                        <div class="text-center card-head">
                          <span class="badge badge-secondary" >Entrada: <i class="fa fa-calendar" ></i> <?= $financeiro_class->text_mes(date('m'),true); ?></span>
                        </div>
                        <div class="card-body">
        
                          <div class="row">
                              <div class="col-md-6">
                                <h4><?= $moeda->simbolo; ?> <?= $valores_mov[0]; ?></h4>
                              </div>
                              <div class="col-md-6">
                                <h2 class="text-success" ><i class='fa fa-arrow-up' ></i></h2>
                              </div>
                          </div>
        
                        </div>
                      </div>
                   </div>
        
                   <div class="col-md-4" >
                      <div class="card">
                        <div class="text-center card-head">
                          <span class="badge badge-secondary" >Saída: <i class="fa fa-calendar" ></i> <?= $financeiro_class->text_mes(date('m'),true); ?></span>
                        </div>
                        <div class="card-body">
        
                            <div class="row">
                                <div class="col-md-6">
                                  <h4><?= $moeda->simbolo; ?> <?= $valores_mov[1]; ?></h4>
                                </div>
                                <div class="col-md-6">
                                  <h2 class="text-danger" ><i class='fa fa-arrow-down' ></i></h2>
                                </div>
                            </div>
        
                        </div>
                      </div>
                   </div>
        
                 </div>
               </div>
        
        
              <div class="table-responsive">
                <table class="table table-striped table-sm">
                  <thead>
        
                    <select onchange="location.href='?limit='+(this.options[this.selectedIndex].value);" style="margin-bottom:5px;border:none;" class="" name="limit_select">
                        <option value="20">20 Registros</option>
                        <option <?php if(isset($_GET['limit'])){ if($_GET['limit'] == 50){ echo "selected"; } } ?> value="50">50 Registros</option>
                        <option <?php if(isset($_GET['limit'])){ if($_GET['limit'] == 100){ echo "selected"; } } ?> value="100">100 Registros</option>
                        <option <?php if(isset($_GET['limit'])){ if($_GET['limit'] == 200){ echo "selected"; } } ?> value="200">200 Registros</option>
                        <option <?php if(isset($_GET['limit'])){ if($_GET['limit'] == 300){ echo "selected"; } } ?> value="300">300 Registros</option>
                    </select>
                    &nbsp;
                    <select onchange="location.href='?year='+(this.options[this.selectedIndex].value);" style="margin-bottom:5px;border:none;" class="" name="limit_select">
        
                        <option <?php if(isset($_GET['year'])){ if($_GET['year'] == date('Y') ){ echo "selected"; } } ?> value="<?= date('Y'); ?>"><?= date('Y'); ?></option>
        
                        <?php for ($i=1; $i < 11; $i++) {
        
        
                          $y[$i] = date('Y')-$i;
        
                        ?>
        
                        <option <?php if(isset($_GET['year']) || isset($_SESSION['year'])){ if($_GET['year'] == $y[$i] || $_SESSION['year'] == $y[$i]){ echo "selected"; } } ?> value="<?= $y[$i]; ?>"><?= $y[$i]; ?></option>
        
                        <?php } ?>
        
                    </select>
        
                    <tr>
                      <th>Valor</th>
                      <th>Tipo</th>
                      <th>Data</th>
                      <th>Nota</th>
                      <th>Editar</th>
                    </tr>
                  </thead>
                  <tbody id="tbody_clientes" class="" >
                    <?php
        
                       if($movimentacao){
        
                         while($mov = $movimentacao->fetch(PDO::FETCH_OBJ)){
        
                           $explo_data_mov = explode('/',$mov->data);
        
                           $year = isset($_GET['year']) ? $_GET['year'] : date('Y');
                           
                           $year = isset($_SESSION['year']) ? $_SESSION['year'] : $year;
                           
                           
        
        
                           if($explo_data_mov[2] == $year){
        
                               if($mov->tipo == '1'){
                                 $tipo = "<i class='text-success fa fa-arrow-up' ></i> <span class='badge badge-success' >Entrada</span>";
                               }else{
                                 $tipo = "<i class='text-danger fa fa-arrow-down' ></i> <span class='badge badge-danger' >Saída</span>";
                               }
        
        
                    ?>
        
        
                    <tr class="trs " >
                      <td><?php if($mov->tipo == '2'){ echo '-';} ?> <?= $moeda->simbolo; ?> <?= $mov->valor; ?></td>
                      <td><?= $tipo; ?></td>
                      <td><?= $mov->data.' - '.$mov->hora;?></td>
                      <td><a style="cursor:pointer;" class="text-info" onclick="ver_nota_completa(<?= $mov->id; ?>);" ><?= substr($mov->nota,0,20).' <span style="font-size:10px;" >[... ver mais]</span> '; ?></a></td>
                      <td>
                        <button onclick="edite_movimentacao(<?= $mov->id; ?>);" title="EDITAR" type="button" class="btn-outline-info btn btn-sm"> <i class="fa fa-pencil" ></i> </button>
                        <button onclick="modal_del_mov(<?= $mov->id; ?>);" title="REMOVER" type="button" class="btn-outline-danger btn btn-sm"> <i class="fa fa-trash" ></i> </button>
        
                      </td>
                    </tr>
        
                  <?php } } }else{ ?>
        
                    <tr>
                      <td class="text-center" colspan="6" >Nenhuma movimentação registrada</td>
                    </tr>
        
        
                  <?php } ?>
        
                  </tbody>
                </table>
        
        
              </div>
              </div>
            </main>
  </div>
</div>


<!--  Modal view nota movimentacao -->
<div class="modal fade" id="modal_view_mov" tabindex="-1" role="dialog" aria-labelledby="TituloModalLongoExemplo" aria-hidden="true">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="titutlo_modal_view_mov">Ver nota</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body" id="body_modal_view_mov" ></div>
  </div>
</div>
</div>

<?php if($plano_usergestor->financeiro_avan == 1){ ?>

<!--  Modal export dados -->
<div class="modal fade" id="modal_export_financeiro" tabindex="-1" role="dialog" aria-labelledby="TituloModalLongoExemplo" aria-hidden="true">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="titutlo_modal_export_financeiro">Escolha o periodo</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body" id="body_modal_export_financeiro" >
       <form class="" action="../control/control.export_dados_financeiros.php" id="form_export" method="post">

             <div class="row">
               <div class="col-md-12">
                 <p>Escolha o periodo para exportar os dados financeiros</p>
               </div>
                     <div class="col-md-5">
                       <div class="form-group">
                         <input type="date" id="data1" max="<?= date('Y-m-d'); ?>" name="data1" class="form-control" placeholder="Data 1" value="">
                       </div>
                     </div>
                     <div class="col-md-2">
                       Até
                     </div>
                     <div class="col-md-5">
                       <div class="form-group">
                         <input type="date" id="data2" value="<?= date('Y-m-d'); ?>" max="<?= date('Y-m-d'); ?>" name="data2" class="form-control" placeholder="Data 2" value="">
                       </div>
                     </div>
                     <div class="col-md-12">
                       <div class="form-group">
                          <select class="form-control" name="type_export" id="type_export" >
                            <option value="pdf">Exportar em PDF</option>
                            <option value="json">Exportar em JSON</option>
                            <option value="txt">Exportar em TXT</option>
                            <option value="xls">Exportar em XLS</option>
                          </select>
                       </div>
                     </div>

                 <div class="col-md-12">
                   <div class="form-group">
                     <button onclick="$('#form_export').submit();" id="btn_export_dados_financeiros" style="width:100%;" type="button" class="btn btn-primary" name="button">Exportar</button>
                   </div>
                 </div>
               </div>

         </form>
     </div>
  </div>
</div>
</div>
<?php } ?>

<!--  Modal view delete movimentacao -->
<div class="modal fade" id="modal_del_mov" tabindex="-1" role="dialog" aria-labelledby="TituloModalLongoExemplo" aria-hidden="true">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="titutlo_modal_del_mov">Deseja realmente deletar?</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body" id="body_modal_del_mov" >
       <input type="hidden" name="input_id_del_mov" id="input_id_del_mov" value="">

       <h4>Muita calma nesta hora !</h4>
       <p>
         Você realmente deseja deletar está movimentação ?
       </p>
     </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      <button onclick="del_mov();" type="button" id="btn_del_mov" class="btn btn-primary">Deletar</button>
    </div>
  </div>
</div>
</div>


<!--  Modal import -->
<div class="modal fade" id="modal_import" tabindex="-1" role="dialog" aria-labelledby="TituloModalLongoExemplo" aria-hidden="true">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="titutlo_modal_del_mov">Vamos começar a importar?</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body" id="body_import" >
        <form id="form_import" method="POST" action="<?=SET_URL_PRODUCTION?>/control/import-xlsx/" enctype="multipart/form-data" >
               <div class="form-group">
                    <select name="type_import" class="form-control" >
                        <option>Selecione a plataforma</option>
                        <option value="zeropaper" >ZeroPaper</option>
                    </select>
                </div>
                 <div class="form-group">
                    <input type="file" name="file_import" />
                    <br />
                    <small>Importe arquivos <b>.xlsx</b> </small>
                </div>
        </form>
     </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      <button onclick="$('#form_import').submit();" type="button" id="btn_import" class="btn btn-primary">Importar</button>
    </div>
  </div>
</div>
</div>


<!--  Modal edite movimentacao -->
<div class="modal fade" id="modal_edite_mov" tabindex="-1" role="dialog" aria-labelledby="TituloModalLongoExemplo" aria-hidden="true">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="Titutlo_modal_edite_mov">Editar movimentação</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body" id="body_modal_edite_mov" >

       <input type="hidden" name="id_mov" id="id_mov">

          <div class="row">

           <div class="col-md-5">
             <input type="text" class="form-control margin" id="valor_mov" placeholder="Valor">
           </div>

           <div class="col-md-7">
             <input type="date" class="form-control margin" id="data_mov" max="<?= date('Y-m-d'); ?>" placeholder="Data">
           </div>

           <div class="col-md-6">
             <input type="time" value="<?= date('H:i'); ?>" class="form-control margin" id="hora_mov" placeholder="Hora">
           </div>

           <div class="col-md-12 margin">
             <select class="form-control" name="tipo_mov" id="tipo_mov" >

               <option value="1" >Entrada</option>
               <option value="2" >Saída</option>

             </select>
           </div>


           <div class="col-md-12 margin">
             <textarea name="notas" id="nota_mov" class="form-control" rows="3" cols="80" placeholder="Nota" ></textarea>
           </div>



     </div>


     <div class="modal-footer">
       <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
       <button onclick="save_mov();" type="button" id="btn_save_mov" class="btn btn-primary">Salvar</button>
     </div>


   </div>
 </div>
</div>
</div>


<!--  Modal add mov -->
<div class="modal fade" id="modal_add_mov" tabindex="-1" role="dialog" aria-labelledby="TituloModalLongoExemplo" aria-hidden="true">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="Titutlo_modal_add_cliente">Adicionar Movimentação</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body" id="body_modal_add_mov" >

          <div class="row">

           <div class="col-md-5">
             <input type="text" class="form-control margin" id="valor_mov_add" placeholder="Valor">
           </div>


           <div class="col-md-6">
             <input type="time" value="<?= date('H:i'); ?>" class="form-control margin" id="hora_mov_add" placeholder="Hora">
           </div>

           <div class="col-md-6">
             <input type="date" max="<?= date('Y-m-d'); ?>" value="<?= date('Y-m-d'); ?>" class="form-control margin" id="data_mov_add" placeholder="Data">
           </div>

           <div class="col-md-12 margin">
             <select class="form-control" name="tipo_mov_add" id="tipo_mov_add" >

               <option value="1" >Entrada</option>
               <option value="2" >Saída</option>

             </select>
           </div>


           <div class="col-md-12 margin">
             <textarea name="notas" id="nota_mov_add" class="form-control" rows="3" cols="80" placeholder="Notas" ></textarea>
           </div>



     </div>

     <span>Todos os campos são obrigatórios</span>
     <div class="modal-footer">
       <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
       <button type="button" onclick="add_mov();" id="btn_add_mov" class="btn btn-primary">Adicionar</button>

     </div>


   </div>
 </div>
</div>
</div>




 <!-- footer -->
 <?php include_once 'inc/footer.php'; ?>
