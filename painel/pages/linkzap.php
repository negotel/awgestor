<?php
    echo '<script>location.href="home";</script>';
 die;
   $linkzap_class = new Linkzap();
   $financeiro_class = new Financeiro();

   $links = $linkzap_class->list_links($user->id);
   
   $origens_populares = $linkzap_class->get_reference_plus($user->id);
   $origens_os = $linkzap_class->get_reference_os_plus($user->id);
   $origens_city = $linkzap_class->get_reference_city_plus($user->id);
   $origens_device = $linkzap_class->get_reference_device_plus($user->id);

   $get_cliques_mes = $linkzap_class->get_num_cliques_mes($user->id);
   $count_links = $linkzap_class->count_links($user->id,0,true);
   
   
 ?>



<!-- Head and Nav -->
<?php include_once 'inc/head-nav.php'; ?>

    <!-- NavBar -->
    <?php include_once 'inc/nav-bar.php'; ?>

     <main class="page-content">
    
<div class="">
            
            <div style="padding: 10px;-webkit-box-shadow: 0px 0px 16px -2px rgb(0 0 0 / 84%);box-shadow: 0px 0px 16px -2px rgb(0 0 0 / 84%);width: 99%;" class="card row" >
            
      <div class="col-md-12">
        <h1 class="h2">Monitoramento de link</h1>
        <div style="margin-bottom:10px!important;" class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group mr-2">
            <!--<button onclick="location.href='graphics_linkzap';" type="button" class="btn btn-sm btn-outline-secondary"><i class="fa fa-line-chart" ></i> Ver Gráficos</button>-->
            <button onclick="modal_add_linkzap();" type="button" class="btn btn-sm btn-outline-secondary"><i class="fa fa-plus" ></i> Adicionar Link</button>
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

           <div class="col-md-3" >
              <div class="card">
                <div class="text-center card-head">
                  <span class="badge badge-secondary" >Cliques este mês: <i class="fa fa-calendar" ></i> <?= $financeiro_class->text_mes(date('m'),true); ?></span>
                </div>
                <div class="card-body">

                  <div class="row">
                      <div class="col-md-6">
                        <h4><?php echo $get_cliques_mes[0]->num ? $get_cliques_mes[0]->num : 0; ?></h4>
                      </div>
                      <div class="col-md-6">
                        <h2 class="text-primary" ><i class="fa fa-mouse-pointer" ></i></h2>
                      </div>
                  </div>

                </div>
              </div>
           </div>

           <div class="col-md-3" >
              <div class="card">
                <div class="text-center card-head">
                  <span class="badge badge-secondary" >Links</span>
                </div>
                <div class="card-body">

                  <div class="row">
                      <div class="col-md-6">
                        <h4><?= $count_links; ?></h4>
                      </div>
                      <div class="col-md-6">
                        <h2 class="text-primary" ><i class='fa fa-link' ></i></h2>
                      </div>
                  </div>

                </div>
              </div>
           </div>
           
            <div class="col-md-6" >
              <img src="img/monitoramento-whatsapp.png" />
           </div>
           
         </div>
       </div>
       
       <div class="">
            <div class="row">
                <div class="col-md-6">
                      <?php if($origens_os){ ?>
                      
                        <table class="table table-sm table-bordered">
                          <thead>
                            <tr>
                              <th scope="col"><i class="fa fa-sitemap" ></i> Aceso</th>
                              <th scope="col"> <i class="fa fa-globe" ></i> OS</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php while($lnk = $origens_os->fetch(PDO::FETCH_OBJ)){ ?>
                            <tr>
                              <td><?= $lnk->NrVezes; ?></th>
                              <td> <i class="fa fa-<?= strtolower($lnk->os); ?>"></i> <?= $lnk->os; ?></td>
                            </tr>
                            <?php } ?>
                           
                          </tbody>
                        </table>
                      
                      <?php } ?>
                      
                </div>
                <div class="col-md-6">
                    
                   <?php if($origens_populares){ ?>
                      
                        <table class="table table-sm table-bordered">
                          <thead>
                            <tr>
                              <th scope="col"><i class="fa fa-mouse-pointer" ></i> Cliques</th>
                              <th scope="col"> <i class="fa fa-globe" ></i> Origem</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php while($lnk = $origens_populares->fetch(PDO::FETCH_OBJ)){ ?>
                            <tr>
                              <td><?= $lnk->NrVezes; ?></th>
                              <td><?= $lnk->origem; ?></td>
                            </tr>
                            <?php } ?>
                           
                          </tbody>
                        </table>
                      
                      <?php } ?>
                      
                      
                </div>
                
                <div class="col-md-6">
                    
                   <?php if($origens_city){ ?>
                      
                        <table class="table table-sm table-bordered">
                          <thead>
                            <tr>
                              <th scope="col"><i class="fa fa-exchange" ></i> Acesso</th>
                              <th scope="col"> <i class="fa fa-map-marker" ></i> Cidade</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php while($lnk = $origens_city->fetch(PDO::FETCH_OBJ)){ ?>
                            <tr>
                              <td><?= $lnk->NrVezes; ?></th>
                              <td><?= $lnk->cidade; ?></td>
                            </tr>
                            <?php } ?>
                           
                          </tbody>
                        </table>
                      
                      <?php } ?>
                      
                      
                </div>
                
                 <div class="col-md-6">
                    
                   <?php if($origens_device){ ?>
                      
                        <table class="table table-sm table-bordered">
                          <thead>
                            <tr>
                              <th scope="col"><i class="fa fa-exchange" ></i> Acesso</th>
                              <th scope="col"> <i class="fa fa-microchip" ></i> Dispositivo</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php while($lnk = $origens_device->fetch(PDO::FETCH_OBJ)){ ?>
                            <tr>
                              <td><?= $lnk->NrVezes; ?></th>
                              <td><?php if($lnk->dispositivo != "Desktop"){ echo "<i class='fa fa-mobile fa-lg' ></i> Mobile"; }else{echo "<i class='fa fa-desktop' ></i> Desktop";} ?></td>
                            </tr>
                            <?php } ?>
                           
                          </tbody>
                        </table>
                      
                      <?php } ?>
                      
                      
                </div>
                
            </div>
       </div>


      <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm">
          <thead>


            <tr>
              <th>Whatsapp</th>
              <th>Nome</th>
              <th>Slug</th>
              <th>Cliques</th>
              <th>Link</th>
              <th>Opções</th>
            </tr>
          </thead>
          <tbody id="" class="" >
            <?php

               if($links){

                 while($link = $links->fetch(PDO::FETCH_OBJ)){

            ?>


            <tr class="" >
              <td><?= $link->numero; ?></td>
              <td><?= $link->nome; ?></td>
              <td><?= $link->slug; ?></td>
              <td><?= $link->cliques; ?></td>
              <td><a onclick="copyToClipboard(<?= $link->id; ?>);" style="cursor:pointer;" class="text-info" >https://linkzap.me/<?= $link->slug; ?></a> <i id="icon_copy_<?= $link->id; ?>" onclick="copyToClipboard(<?= $link->id; ?>);" style="cursor:pointer;" class="fa fa-copy"></i> 
              <small id="info_copy_<?= $link->id; ?>" style="font-size:10px;display:none;" class="text-success">Copiado</small>
              </td>
              <input type="hidden" value="https://linkzap.me/<?= $link->slug; ?>" id="linkzap_<?= $link->id; ?>" />
              <td>
                <button onclick="edite_linkzap(<?= $link->id; ?>);" title="EDITAR" type="button" class="btn-outline-info btn btn-sm"> <i class="fa fa-pencil" ></i> </button>
                <button onclick="modal_del_linkzap(<?= $link->id; ?>);" title="REMOVER" type="button" class="btn-outline-danger btn btn-sm"> <i class="fa fa-trash" ></i> </button>

              </td>
            </tr>

          <?php } }else{ ?>

            <tr>
              <td class="text-center" colspan="6" >Nenhum link registrado</td>
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
<div class="modal fade" id="modal_del_linkzap" tabindex="-1" role="dialog" aria-labelledby="TituloModalLongoExemplo" aria-hidden="true">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="titutlo_modal_del_mov">Deseja realmente deletar?</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body" id="body_modal_del_linkzap" >
       <input type="hidden" name="input_id_del_linkzap" id="input_id_del_linkzap" value="">

       <h4>Muita calma nesta hora !</h4>
       <p>
         Você realmente deseja deletar este link ?
       </p>
       <p>
           Todos os lugares aonde você divulgou o link, não irá mais funcionar.
       </p>
     </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      <button onclick="del_link();" type="button" id="btn_del_linkzap" class="btn btn-primary">Deletar</button>
    </div>
  </div>
</div>
</div>




<!--  Modal edite linkzap -->
<div class="modal fade" id="modal_edite_linkzap" tabindex="-1" role="dialog" aria-labelledby="TituloModalLongoExemplo" aria-hidden="true">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="Titutlo_modal_add_cliente">Adicionar Link</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body" id="body_modal_add_mov" >

          <div class="row">
              
              <input type="hidden" value="" id="id_link_edite" />

           <div class="col-md-12">
             <input type="text" class="form-control margin" id="nome_link_edite" placeholder="Nome (Somente você verá)">
           </div>

           <div class="col-md-12">
             <input type="text" value="" class="form-control margin" id="numero_link_edite" name="numero_link" placeholder="Ex: 5511999999999">
           </div>

           <div class="col-md-12 margin">
             <textarea name="msg_link" id="msg_link_edite" class="form-control" rows="3" cols="80" placeholder="Mensagem pré definida" ></textarea>
           </div>
        
           <div class="col-md-12">
             <div class="input-group">
             <div class="input-group-append">
                <span class="input-group-text" id="basic-addon2">https://linkzap.me/</span>
              </div>
              <input type="text" name="slug_link_edite" id="slug_link_edite" class="form-control" placeholder="Slug (Apelido)" aria-describedby="basic-addon2">
              <input type="hidden" name="slug_link_edite_h" id="slug_link_edite_h" class="form-control" aria-describedby="basic-addon2">
              
            </div>
            <small class="text-danger" id="info_slug_edite"></small>

           </div>


     </div>

     <span>Todos os campos são obrigatórios</span>
     <div class="modal-footer">
       <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
       <button type="button" onclick="edite_linkzap_form();" id="btn_edite_linkzap" class="btn btn-primary">Editar</button>

     </div>


   </div>
 </div>
</div>
</div>


<!--  Modal add linkzap -->
<div class="modal fade" id="modal_add_linkzap" tabindex="-1" role="dialog" aria-labelledby="TituloModalLongoExemplo" aria-hidden="true">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="Titutlo_modal_add_cliente">Adicionar Link</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body" id="body_modal_add_mov" >

          <div class="row">

           <div class="col-md-12">
             <input type="text" class="form-control margin" id="nome_link" placeholder="Nome (Somente você verá)">
           </div>

           <div class="col-md-12">
             <input type="text" value="" class="form-control margin" id="numero_link" name="numero_link" placeholder="Ex: 5511999999999">
           </div>

           <div class="col-md-12 margin">
             <textarea name="msg_link" id="msg_link" class="form-control" rows="3" cols="80" placeholder="Mensagem pré definida" ></textarea>
           </div>
        
           <div class="col-md-12">
             <div class="input-group">
             <div class="input-group-append">
                <span class="input-group-text" id="basic-addon2">https://linkzap.me/</span>
              </div>
              <input type="text" name="slug_link" id="slug_link" class="form-control" placeholder="Slug (Apelido)" aria-describedby="basic-addon2">
              
            </div>
            <small class="text-danger" id="info_slug"></small>

           </div>


     </div>

     <span>Todos os campos são obrigatórios</span>
     <div class="modal-footer">
       <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
       <button type="button" onclick="add_linkzap();" id="btn_add_linkzap" class="btn btn-primary">Adicionar</button>

     </div>


   </div>
 </div>
</div>
</div>

 <!-- footer -->
 <?php include_once 'inc/footer.php'; ?>
