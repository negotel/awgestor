<?php


  $clientes_class = new Clientes();

  $area_cli_conf   = $clientes_class->area_cli_conf($_SESSION['SESSION_USER']['id']);
  $avisos_area_cli = $clientes_class->avisos_area_cli($_SESSION['SESSION_USER']['id']);
  
   if($plano_usergestor->mini_area_cliente == 0){
       echo "<script>location.href='cart?upgrade';</script>";
       die;
     }

    

 if($clientes_class->isJSON($area_cli_conf->indicacao)){
     $ind = json_decode($area_cli_conf->indicacao);
  }else{
     $ind = new stdClass();
     $ind->status = 0;
     $ind->meses  = 1;
     $ind->qtd    = 5;
     $ind->msg    = "UGFyYWLDqW5zISBWb2PDqiBjb21wbGV0b3UgdG9kYXMgYXMgaW5kaWNhw6fDtWVzLiBTaG93ISEhDQpFbnZpZSB1bWEgbWVuc2FnZW0gcGFyYSBlc3RlIHdoYXRzYXBwICsxMTk5OTk5OTk5OSBjb20gbyBwcmludCBkZXN0YSB0ZWxhLg0KDQpWb2PDqiDDqSBpbmNyw612ZWwh";
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
                <h1 class="h2"><?= $idioma->faca_conf_painel_cliente; ?></h1>
                <?php if($area_cli_conf){ ?>
                <div class="btn-toolbar mb-2 mb-md-0">
                  <div style="margin-bottom:10px;" class="btn-group mr-2">
                    <a href="https://cliente.gestorlite.com/<?= $area_cli_conf->slug_area;?>" target="_blank" type="button" class="btn btn-sm btn-outline-secondary"><i class="fa fa-external-link" ></i> <?= $idioma->acessar_area_clie; ?></a>
                    <button onclick="$('#fidelidade_modal').modal();" type="button" class="btn btn-sm btn-outline-secondary"><i class="fa fa-heart" ></i> Indicações</button>
                    <a href="indicacoes" type="button" class="btn btn-sm btn-outline-secondary"><i class="fa fa-trophy" ></i> Lista de indicações</a>
                    <button onclick="$('#modal_setting_area_cli').modal();" type="button" class="btn btn-sm btn-outline-secondary"><i class="fa fa-cogs" ></i> Configuração</button>
                  </div>
                </div>
              <?php } ?>
              </div>
                    
                    
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
                         <div class="row" style="margin-bottom:10px;" >
                           <div class="col-md-4">
                                <div class="input-group input-group-sm">
                                  <input type="text" class="form-control" value="<?= 'https://glite.me/a/'.str_replace('=','',base64_encode($user->id));?>" placeholder="Link de area cliente" id="input_link_area_cli" value="" >
                                  <div class="input-group-append">
                                    <a onclick="copy_link_a_cli();" class="btn btn-sm btn-outline-secondary" style="cursor:pointer;" id="abrir_link_pay" >Copiar <i class="fa fa-files-o" ></i></a>
                                  </div>
                                </div>
                                <small>(Link área do cliente) Envie este link para seus clientes <b id="msg_return" ></b></small>
                                <script>
                                    function copy_link_a_cli(){
                                         $('#input_link_area_cli').select();
                                         var copiar = document.execCommand('copy');
                                         if(copiar){
                                             $("#msg_return").addClass('text-success');
                                             $("#msg_return").html('| Copiado <i class="fa fa-check" ></i>');
                                             
                                             setTimeout(function(){
                                                 $("#msg_return").html('');
                                             },3000);
                                         }
                                         
                                         
                                    }
                                </script>
                           </div>
                           <div class="col-md-4">
                                <div class="input-group">
                                  <input type="text" class="form-control" value="<?= 'https://glite.me/a/'.str_replace('=','',base64_encode($user->id));?>/c" placeholder="Link de area cliente" id="input_link_area_create" value="" >
                                  <div class="input-group-append">
                                    <a onclick="copy_link_a_cli_create();" class="btn btn-outline-secondary" style="cursor:pointer;" id="" >Copiar <i class="fa fa-files-o" ></i></a>
                                  </div>
                                </div>
                                <small>(Link de cadastro) Envie para um novo cliente <b id="msg_return1" ></b></small>
                                <script>
                                    function copy_link_a_cli_create(){
                                         $('#input_link_area_create').select();
                                         var copiar = document.execCommand('copy');
                                         if(copiar){
                                             $("#msg_return1").addClass('text-success');
                                             $("#msg_return1").html('| Copiado <i class="fa fa-check" ></i>');
                                             
                                             setTimeout(function(){
                                                 $("#msg_return1").html('');
                                             },3000);
                                         }
                                         
                                         
                                    }
                                </script>
                           </div>
                           <div class="col-md-4 text-right">
                             <button type="button" class="btn btn-sm btn-outline-secondary" onclick="$('#modal_add_aviso').modal('show');" name="button"><i class="fa fa-plus" ></i> <?= $idioma->novo_aviso; ?></button>
                           </div>
                         </div>
                         <div class="table-responsive">
    
                           <table class="table table-striped table-sm">
                             <thead>
                               <tr>
                                 <th><?= $idioma->titulo; ?></th>
                                 <th><?= $idioma->texto; ?></th>
                                 <th><?= $idioma->color; ?></th>
                                 <th><?= $idioma->auto_delete; ?></th>
                                 <th></th>
                               </tr>
                             </thead>
                             <tbody id="tbody_avisos_painel_cli" class="" >
                               <form class="" id="form_checkbox" action="../control/control.delete_clientes.php" method="POST">
                               <?php
    
                                  if($avisos_area_cli){
    
                                    while($aviso = $avisos_area_cli->fetch(PDO::FETCH_OBJ)){
    
                               ?>
    
    
                               <tr class="trs " >
                                 <td><?= $aviso->titulo; ?></td>
                                 <td><a style="cursor:pointer;" onclick="modal_text_aviso(<?= $aviso->id;?>);" class="text-info" ><?= substr($aviso->texto,0,20).' - <span style="font-size:10px;" >'.$idioma->ver_mais.'</span>'; ?></a></td>
                                 <td><span class="badge badge-<?= $aviso->color; ?>" ><?= $aviso->color; ?></span></td>
                                 <td><?= $aviso->auto_delete; ?></td>
                                 <td>
                                   <button onclick="modal_edite_aviso(<?= $aviso->id; ?>);" title="<?= $idioma->editar; ?>" type="button" class="btn-outline-info btn btn-sm btn-outline-secondary"> <i class="fa fa-pencil" ></i> </button>
                                   <button onclick="modal_del_aviso(<?= $aviso->id; ?>);" title="<?= $idioma->excluir; ?>" type="button" class="btn-outline-danger btn btn-sm  "> <i class="fa fa-trash" ></i> </button>
                                 </td>
                               </tr>
    
                             <?php } }else{ ?>
    
                               <tr>
                                 <td class="text-center" colspan="6" ><?= $idioma->nenhum_aviso_criado; ?></td>
                               </tr>
    
    
                             <?php } ?>
    
                               </form>
                             </tbody>
                           </table>
    
    
                         </div>
                       </div>
                   </div>
               </div>
        
  


           <!--  Modal view texto aviso -->
           <div class="modal fade" id="modal_text_aviso" tabindex="-1" role="dialog" aria-labelledby="titulo_modal_text_aviso" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="titulo_modal_text_aviso"><?= $idioma->texto_aviso; ?></h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body"  >
                  <p class=""  id="body_modal_text_aviso"></p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">><?= $idioma->fechar; ?></button>
                </div>
              </div>
            </div>
           </div>

           <!--  Modal delete aviso -->
           <div class="modal fade" id="modal_del_aviso" tabindex="-1" role="dialog" aria-labelledby="titulo_modal_del_aviso" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header bg-danger">
                  <h5 class="modal-title text-white" id="titulo_modal_del_aviso"><?= $idioma->deseja_deletar_aviso; ?></h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body" id="body_modal_del_aviso" >
                  <div class="row">
                    <div class="col-md-12" style="margin-bottom:5px;">
                      <p class="text-center" id="msg_response_aviso_del" ></p>
                    </div>
                  </div>
                  <input type="hidden" id="id_del_aviso" name="id_del_aviso" value="">

                  <h2><?= $idioma->nao_ha_volta; ?></h2>
                  <p>
                    <?= $idioma->quer_deletar_aviso; ?>
                  </p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $idioma->cancelar; ?></button>
                  <button type="button" onclick="del_aviso();" id="btn_delete_aviso" class="btn btn-primary" onclick="delete_aviso();" ><?= $idioma->deletar; ?></button>
                </div>
              </div>
            </div>
           </div>



           <!--  Modal edite aviso -->
           <div class="modal fade" id="modal_edite_aviso" tabindex="-1" role="dialog" aria-labelledby="titulo_modal_edite_aviso" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="titulo_modal_edite_aviso"><?= $idioma->editar_aviso; ?></h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body" id="body_modal_edite_aviso">

                  <div class="row">
                    <div class="col-md-12" style="margin-bottom:5px;">
                      <p class="text-center" id="msg_response_aviso" ></p>
                    </div>
                     <div class="col-md-12">
                       <div class="form-group">
                         <input type="text" class="form-control" id="titulo_aviso_edite" placeholder="<?= $idioma->titulo_aviso; ?>" name="titulo_aviso_edite" value="">
                       </div>
                     </div>
                     <div class="col-md-12">
                       <div class="form-group">
                         <textarea class="form-control" name="texto_aviso_edite" id="texto_aviso_edite" rows="5" placeholder="<?= $idioma->texto_aviso; ?>" cols="80"></textarea>
                       </div>
                     </div>
                     <div class="col-md-6">
                       <div class="form-group">
                         <input type="date" class="form-control" name="auto_delete_aviso_edite" id="auto_delete_aviso_edite" value="" min="<?=  date('Y-m-d', strtotime('+1 days', strtotime(date('Y-m-d')))); ?>" >
                         <small><?= $idioma->quando_aviso_some; ?></small>
                       </div>
                     </div>
                     <div class="col-md-6">
                       <div class="form-group">
                          <select class="form-control" id="color_aviso_edite" name="color_aviso_edite">
                            <option value="danger">Danger</option>
                            <option value="warning">Warning</option>
                            <option value="info">Info</option>
                            <option value="success">Success</option>
                            <option value="secondary">Secondary</option>
                          </select>
                          <small>
                            <span class="badge badge-danger" >Danger</span> &nbsp;
                            <span class="badge badge-warning" >Warning</span> &nbsp;
                            <span class="badge badge-info" >Info</span> &nbsp;
                            <span class="badge badge-success" >Success</span> &nbsp;
                            <span class="badge badge-secondary" >Secondary</span>
                          </small>
                       </div>
                     </div>
                  </div>

                  <input type="hidden" id="id_aviso_edite" name="id_aviso_edite" value="">

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $idioma->fechar; ?></button>
                  <button type="button" onclick="save_aviso();" id="btn_save_aviso" class="btn btn-primary" ><?= $idioma->salvar; ?></button>
                </div>
              </div>
            </div>
           </div>
    
    
    

          <!--  Modal settings -->
           <div class="modal fade" id="modal_setting_area_cli" tabindex="-1" role="dialog" aria-labelledby="titulo_modal_ind" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="titulo_modal_add_aviso">Configuração</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body" id="body_modal_amostra">

                  <div class="row">
                      
                    <div class="col-md-12" style="margin-bottom:5px;">
                      <p class="text-center" id="msg_response_amostra" ></p>
                    </div>
                     <div class="col-md-12">
                       <div class="form-group">
                           <label>Deseja mostrar todos os planos para seus clientes em área do cliente?</label>
                         <select id="amostra_planos" name="amostra_planos" class="form-control">
                             <option <?php if($area_cli_conf->planos_amostra == 1){ echo 'selected'; }?> value="1" >Mostrar todos os planos</option>
                             <option <?php if($area_cli_conf->planos_amostra == 0){ echo 'selected'; }?> value="0" >Mostrar apenas o plano contrado</option>
                         </select>
                       </div>
                     </div>

                  </div>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $idioma->fechar; ?></button>
                  <button type="button" onclick="save_planos_amostra();" id="btn_amostra" class="btn btn-primary" ><?= $idioma->salvar; ?></button>
                </div>
              </div>
            </div>
           </div>

    
    
           <!--  Modal indicacoes -->
           <div class="modal fade" id="fidelidade_modal" tabindex="-1" role="dialog" aria-labelledby="titulo_modal_ind" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="titulo_modal_add_aviso">Indicações de clientes</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body" id="body_modal_ind">

                  <div class="row">
                    <div class="col-md-12" style="margin-bottom:5px;">
                      <p class="text-center" id="msg_response_ind" ></p>
                    </div>
                     <div class="col-md-12">
                       <div class="form-group">
                         <select id="status" name="status" class="form-control">
                             <option <?php if($ind->status == 1){ echo 'selected'; }?> value="1" >Ativo</option>
                             <option <?php if($ind->status == 0){ echo 'selected'; }?> value="0" >Inativo</option>
                         </select>
                       </div>
                     </div>
                      <div class="col-md-6">
                       <div class="form-group">
                         <input type="number" class="form-control" name="qtd" id="qtd" value="<?= $ind->qtd; ?>" min="1" >
                         <small>Quantas indicações seu cliente tem que atingir?</small>
                       </div>
                     </div>
                     <div class="col-md-6">
                       <div class="form-group">
                         <input type="number" class="form-control" name="meses" id="meses" value="<?= $ind->meses; ?>" min="1" >
                         <small>Quantos meses vai oferecer ao cliente que atingir a quantidade indicada de indicações?</small>
                       </div>
                     </div>
                     <div class="col-md-12">
                       <div class="form-group">
                           <textarea name="msg" id="msg" class="form-control" placeholder="Você conseguiu!" rows="5" ><?= base64_decode($ind->msg); ?></textarea>
                           <small>Informe aqui, oque seu cliente deve fazer após atingir a quantidade indicada</small>
                       </div>
                     </div>
                  </div>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $idioma->fechar; ?></button>
                  <button type="button" onclick="save_ind();" id="btn_ind" class="btn btn-primary" ><?= $idioma->salvar; ?></button>
                </div>
              </div>
            </div>
           </div>


           <!--  Modal add aviso -->
           <div class="modal fade" id="modal_add_aviso" tabindex="-1" role="dialog" aria-labelledby="titulo_modal_add_aviso" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="titulo_modal_add_aviso"><?= $idioma->adicionar_aviso; ?></h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body" id="body_modal_add_aviso">

                  <div class="row">
                    <div class="col-md-12" style="margin-bottom:5px;">
                      <p class="text-center" id="msg_response_aviso_add" ></p>
                    </div>
                     <div class="col-md-12">
                       <div class="form-group">
                         <input type="text" class="form-control" id="titulo_aviso_add" placeholder="<?= $idioma->titulo_aviso; ?>" name="titulo_aviso_add" value="">
                       </div>
                     </div>
                     <div class="col-md-12">
                       <div class="form-group">
                         <textarea class="form-control" name="texto_aviso_add" id="texto_aviso_add" rows="5" placeholder="<?= $idioma->texto_aviso; ?>" cols="80"></textarea>
                       </div>
                     </div>
                     <div class="col-md-6">
                       <div class="form-group">
                         <input type="date" class="form-control" name="auto_delete_aviso_add" id="auto_delete_aviso_add" value="" min="<?=  date('Y-m-d', strtotime('+1 days', strtotime(date('Y-m-d')))); ?>" >
                         <small><?= $idioma->quando_aviso_some; ?></small>
                       </div>
                     </div>
                     <div class="col-md-6">
                       <div class="form-group">
                          <select class="form-control" id="color_aviso_add" name="color_aviso_add">
                            <option value="danger">Danger</option>
                            <option value="warning">Warning</option>
                            <option value="info">Info</option>
                            <option value="success">Success</option>
                            <option value="secondary">Secondary</option>
                          </select>
                          <small>
                            <span class="badge badge-danger" >Danger</span> &nbsp;
                            <span class="badge badge-warning" >Warning</span> &nbsp;
                            <span class="badge badge-info" >Info</span> &nbsp;
                            <span class="badge badge-success" >Success</span> &nbsp;
                            <span class="badge badge-secondary" >Secondary</span>
                          </small>
                       </div>
                     </div>
                  </div>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $idioma->fechar; ?></button>
                  <button type="button" onclick="add_aviso();" id="btn_add_aviso" class="btn btn-primary" ><?= $idioma->adicionar; ?></button>
                </div>
              </div>
            </div>
           </div>

           <?php } ?>






              <div class="col-md-12 card" style="padding:20px;">
                <?php if($area_cli_conf){ ?>

                  <div class="row">

                <form class="row" enctype="multipart/form-data" action="../control/control.edite_painel_cliente.php" method="post">

                  <input type="hidden" name="logo_atual" id="logo_atual" value="<?= $area_cli_conf->logo_area; ?>"  >
                  <input type="hidden" name="slug_atual" id="slug_atual" value="<?= $area_cli_conf->slug_area; ?>"  >
                  <input type="hidden" name="id_painel" id="id_painel" value="<?= $area_cli_conf->id; ?>"  >


                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="text" class="form-control" name="nome_area" id="nome_area" value="<?= $area_cli_conf->nome_area; ?>" placeholder="<?= $idioma->nome_area_cliente; ?>" >
                      </div>
                    </div>

                    <div class="col-md-6">
                      <small id="response_slug" ></small>
                      <div class="form-group">
                        <div class="input-group mb-2">
                          <div class="input-group-prepend">
                            <div class="input-group-text">cliente.gestorlite.com/</div>
                          </div>
                          <input type="text" class="form-control" name="slug_area" id="slug_area" value="<?= $area_cli_conf->slug_area; ?>" placeholder="<?= $idioma->caminho_aera_cli; ?>" >
                        </div>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <select class="form-control" name="situ_area" id="situ_area" >
                          <option <?php if($area_cli_conf->situ_area == 1){ echo "selected"; } ?> value="1"><?= $idioma->ativado; ?></option>
                          <option <?php if($area_cli_conf->situ_area == 0){ echo "selected"; } ?> value="0"><?= $idioma->desativado; ?></option>
                        </select>
                      </div>
                    </div>

                    <div class="col-md-2">
                      <div class="form-group">
                         <label for="logo_area" class="btn btn-outline-primary" ><?= $idioma->caregar_logo; ?> <i class="fa fa-upload" ></i> </label>
                         <input onchange="load_img_area_cli(event);" type="file" style="display:none;" id="logo_area" name="logo_area" value="" >
                         <small>300 x 150 <b>.png</b></small>
                      </div>
                    </div>

                    <div class="col-md-4 text-center">
                      <div style="border:1px solid #b301ef;border-radius:10px;" class="form-group">
                        <img id="img_area_cli" width="150" src="../cliente/logo/<?= $area_cli_conf->logo_area; ?>" alt="">
                      </div>
                    </div>

                    <div class="col-md-12">
                      <div class="form-group">
                        <textarea name="text_suporte" id="text_suporte" rows="5" cols="80" class="form-control form-control-sm" ><?= $area_cli_conf->text_suporte; ?></textarea>
                      </div>
                    </div>

                    <div class="col-md-12 text-left">
                      <div class="form-group">
                        <button type="submit" class="btn btn-outline-success" name="button"><?= $idioma->salvar; ?></button>
                      </div>
                    </div>

                  </form>

                  <script type="text/javascript">

                    function load_img_area_cli(event) {
                       var url = URL.createObjectURL(event.target.files[0]);
                       $('#img_area_cli').attr('src',url);
                     }

                  </script>

                <?php }else{ ?>
                  <center>
                    <p><?= $idioma->nao_gerou_area_cli; ?></p>
                    <button type="button" class="btn btn-outline-primary" id="btn_gera_a" name="button" onclick="gera_area_cli(<?= $_SESSION['SESSION_USER']['id']?>);" ><i class="fa fa-refresh" ></i> <?= $idioma->gerar_area_cli; ?></button>
                  </center>
                <?php } ?>
              </div>
          </div>

           </div>
           </div>
        </main>
    
    <script>
        function save_ind(){
            
            $("#btn_ind").prop('disabled', true);
            $("#btn_ind").html('<i class="fa fa-spin fa-spinner" ></i> Aguarde');
            
           
            var dados    = new Object();
            dados.status = $("#status").val();
            dados.qtd    = $("#qtd").val();
            dados.meses  = $("#meses").val();
            dados.msg    = $("#msg").val();
            
            dados = JSON.stringify(dados);
            
            $.post('../control/control.ind_cliente.php',{dados:dados},function(data){
               var obj = JSON.parse(data);
               
               if(obj.erro){
                   $("#msg_response_ind").removeClass("text-success");
                   $("#msg_response_ind").addClass("text-danger");
               }else{
                   $("#msg_response_ind").removeClass("text-danger");
                   $("#msg_response_ind").addClass("text-success");
               }
               
               $("#msg_response_ind").html(obj.msg);
               
               setTimeout(function(){
                   $("#msg_response_ind").html('');
               },3000);
               
               $("#btn_ind").prop('disabled', false);
                $("#btn_ind").html('Salvar');
               
            });
        }
            
     function save_planos_amostra(){
            
            $("#btn_amostra").prop('disabled', true);
            $("#btn_amostra").html('<i class="fa fa-spin fa-spinner" ></i> Aguarde');
            
            var amostra_planos = $("#amostra_planos").val();

            $.post('../control/control.ind_cliente.php',{amostra_plans:true,amostra_planos:amostra_planos},function(data){
                
                 $("#btn_amostra").prop('disabled', false);
                 $("#btn_amostra").html('Salvar');
            
               var obj = JSON.parse(data);
               
               if(obj.erro){
                   $("#msg_response_amostra").removeClass("text-success");
                   $("#msg_response_amostra").addClass("text-danger");
               }else{
                   $("#msg_response_amostra").removeClass("text-danger");
                   $("#msg_response_amostra").addClass("text-success");
               }
               
               $("#msg_response_amostra").html(obj.msg);
               
               setTimeout(function(){
                   $("#msg_response_amostra").html('');
               },3000);
               
               $("#btn_ind").prop('disabled', false);
                $("#btn_ind").html('Salvar');
               
            });
        }
        
    </script>

 <!-- footer -->
 <?php include_once 'inc/footer.php'; ?>
