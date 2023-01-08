<?php

   $linkzap_class = new Linkzap();
   $financeiro_class = new Financeiro();

   $links = $linkzap_class->list_links($user->id);

   $origens_populares = $linkzap_class->get_reference_plus($user->id);
   $origens_os = $linkzap_class->get_reference_os_plus($user->id);
   $origens_city = $linkzap_class->get_reference_city_plus($user->id);
   $origens_device = $linkzap_class->get_reference_device_plus($user->id);

   $get_cliques_mes = $linkzap_class->get_num_cliques_mes($user->id);
   $count_links = $linkzap_class->count_links($user->id,0,true);


   $get_engajamento = $linkzap_class->get_engajamento($user->id);
   $get_engajamento_today = $linkzap_class->get_engajamento($user->id,true);

   $label_os = "";
   $value_os = "";

   if($count_links>0){
       while(@$os = $origens_os->fetch(PDO::FETCH_OBJ)){
           $label_os .= $os->os.",";
           $value_os .= $os->NrVezes.",";
       }
      $data_chart_os = rtrim($value_os,',').'|'.rtrim($label_os,',');
   }else{
       $data_chart_os = "0,0,0,0,0,0,0|0,0,0,0,0,0,0";
   }



   $label_or = "";
   $value_or = "";
   if($count_links>0){
       while(@$or = $origens_populares->fetch(PDO::FETCH_OBJ)){
            $label_or .= $or->origem.",";
            $value_or .= $or->NrVezes.",";
       }

       $data_chart_or = rtrim($value_or,',').'|'.rtrim($label_or,',');
   }else{
       $data_chart_or = "0,0,0,0,0,0,0|0,0,0,0,0,0,0";
   }

   $label_ct = "";
   $value_ct = "";

   if($count_links>0){
       while(@$ct = $origens_city->fetch(PDO::FETCH_OBJ)){
            $label_ct .= $ct->cidade.",";
            $value_ct .= $ct->NrVezes.",";
       }

       $data_chart_ct = rtrim($value_ct,',').'|'.rtrim($label_ct,',');
   }else{
       $data_chart_ct = "0,0,0,0,0,0,0|0,0,0,0,0,0,0";
   }

   $label_dv = "";
   $value_dv = "";


  if($count_links>0){
       while(@$dv = $origens_device->fetch(PDO::FETCH_OBJ)){
            $label_dv .= $dv->dispositivo.",";
            $value_dv .= $dv->NrVezes.",";
       }

       $data_chart_dv = rtrim($value_dv,',').'|'.rtrim($label_dv,',');
   }else{
       $data_chart_dv = "0,0,0,0,0,0,0|0,0,0,0,0,0,0";
   }

 ?>

   
<?php include_once 'inc/head-nav.php'; ?>
<?php include_once 'inc/sidebar.php'; ?>


  <section class="main_content dashboard_part">
    <?php include_once 'inc/nav.php'; ?>

    <div class="main_content_iner ">

        <div class="container-fluid plr_30 body_white_bg pt_30">

            <div class="row justify-content-center">



                <div class="col-lg-12">
                    
                    <p class="alert alert-info" >
                        No momento o link de whatsapp está offline, mas logo iremos corrigir o mesmo.
                    </p>

                    <div class="single_element">
                        <div class="quick_activity">

                            <div class="row">
                                <div class="col-12">

                                    <div class="quick_activity_wrap">

                                        <div class="single_quick_activity">
                                            <h4>Cliques no mês de <?= $financeiro_class->text_mes(date('m'),true); ?></h4>
                                            <h3><span class="counter"><?= $get_cliques_mes[0]->num ? $get_cliques_mes[0]->num : 0; ?></span> <small style="font-size: 15px;">clicks</small> </h3>
                                        </div>

                                        <div class="single_quick_activity">
                                            <h4>Quantidade de links</h4>
                                            <h3><span class="counter"><?= $count_links; ?></span> <small style="font-size: 15px;">clicks</small> </h3>
                                        </div>


                                         <div class="single_quick_activity">
                                            <h4>Engajamento Geral últimos 3 dias</h4>
                                            <h3><span class="counter"><?= $get_engajamento; ?></span> <small style="font-size: 15px;">clicks</small> </h3>
                                        </div>

                                        <div class="single_quick_activity">
                                            <h4>Engajamento Geral Hoje</h4>
                                            <h3><span class="counter"><?= $get_engajamento_today; ?></span> <small style="font-size: 15px;">clicks</small> </h3>
                                        </div>


                                    </div>

                                </div>
                            </div>

                        </div>
                  </div>

                </div>



            <div class="col-12">
                <div class="QA_section">
                    <div class="white_box_tittle list_header">
                        <h4>Seus Links</h4>
                        <div class="box_right d-flex lms_block">
                            <div class="serach_field_2">

                            </div>
                            <div class="add_button ml-10">
                                <a href="#" data-toggle="modal" onclick="modal_add_linkzap();" data-target="#addcategory" class="btn_1">Adicionar novo</a>
                            </div>
                        </div>
                    </div>

                    <div class="QA_table ">
                        <!-- table-responsive -->
                        <table class="table lms_table_active">
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
                                        <button onclick="edite_linkzap(<?= $link->id; ?>);" title="EDITAR" type="button" class="btn-outline-info btn btn-sm"> <i class="fa fa-edit" ></i> </button>
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


                <div class="col-lg-6 col-xl-6">
                    <div class="white_box mb_30 min_430">
                        <div class="box_header  box_header_block">
                            <div class="main-title">
                                <h3 class="mb-0" >Por sistemas operacionais</h3>
                            </div>
                        </div>
                        <input type="hidden" value="<?= $data_chart_os; ?>" id="value_chart_link" />
                        <canvas height="200" id="link1-sale-chart"></canvas>
                    </div>
                </div>

                <div class="col-lg-6 col-xl-6">
                    <div class="white_box mb_30 min_430">
                        <div class="box_header  box_header_block">
                            <div class="main-title">
                                <h3 class="mb-0" >Origem dos clicks</h3>
                            </div>
                        </div>
                        <input type="hidden" value="<?= $data_chart_or; ?>" id="value_chart_link2" />
                        <canvas height="200" id="link2-sale-chart"></canvas>
                    </div>
                </div>

                 <div class="col-lg-6 col-xl-6">
                    <div class="white_box mb_30 min_430">
                        <div class="box_header  box_header_block">
                            <div class="main-title">
                                <h3 class="mb-0" >Cidades</h3>
                            </div>
                        </div>
                        <input type="hidden" value="<?= $data_chart_ct; ?>" id="value_chart_link3" />
                        <canvas height="200" id="link3-sale-chart"></canvas>
                    </div>
                </div>

                <div class="col-lg-6 col-xl-6">
                    <div class="white_box mb_30 min_430">
                        <div class="box_header  box_header_block">
                            <div class="main-title">
                                <h3 class="mb-0" >Dispositivos</h3>
                            </div>
                        </div>
                        <input type="hidden" value="<?= $data_chart_dv; ?>" id="value_chart_link4" />
                        <canvas height="200" id="link4-sale-chart"></canvas>
                    </div>
                </div>

            </div>

        </div>
    </div>

    </section>


<!--  Modal view delete link -->
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
             <div style="height: 100%!important;" class="input-group-append">
                <span  class="input-group-text" id="basic-addon2">https://linkzap.me/</span>
              </div>
              <input style="min-height: 0px!important;" type="text" name="slug_link_edite" id="slug_link_edite" class="form-control" placeholder="Slug (Apelido)" aria-describedby="basic-addon2">
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
             <div style="height: 100%!important;" class="input-group-append">
                <span class="input-group-text" id="basic-addon2">https://linkzap.me/</span>
              </div>
              <input style="min-height: 0px!important;" type="text" name="slug_link" id="slug_link" class="form-control" placeholder="Slug (Apelido)" aria-describedby="basic-addon2">

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
