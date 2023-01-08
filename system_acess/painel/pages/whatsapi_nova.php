
 <?php


  $gestor_class = new Gestor();
  
  
   if(!isset($whatsapi_class)){
        $whatsapi_class = new Whatsapi();
    }

   // listar clientes

   $wsapi = $whatsapi_class->list_msgs($_SESSION['SESSION_USER']['id']);
    
   $v_device_rapiwha   = $whatsapi_class->verific_device($_SESSION['SESSION_USER']['id']);
   $v_device_chatpro   = $whatsapi_class->verific_device($_SESSION['SESSION_USER']['id'],'chatpro');
   $v_device_gestorbot = $whatsapi_class->verific_device($_SESSION['SESSION_USER']['id'],'gestorbot');
   $v_device_patrao    = $whatsapi_class->verific_device($_SESSION['SESSION_USER']['id'],'patrao');
   $v_device_zapi      = $whatsapi_class->verific_device($_SESSION['SESSION_USER']['id'],'ZAPI');
   
   $grupo_beta = $gestor_class->get_user_grupo_beta($_SESSION['SESSION_USER']['email']);

 ?>



<!-- Head and Nav -->
<?php include_once 'inc/head-nav.php'; ?>

    <!-- NavBar -->
    <?php include_once 'inc/nav-bar.php'; ?>
    

    <main class="page-content">
      
        <div class="">
            
            <div style="padding: 10px;-webkit-box-shadow: 0px 0px 16px -2px rgb(0 0 0 / 84%);box-shadow: 0px 0px 16px -2px rgb(0 0 0 / 84%);width: 99%;" class="card row" >
                
            
           <div class="col-md-6">
                    <h1 class="h2">WhatsAPI <i class="fa fa-whatsapp" ></i></h1>
                    <span style="font-size:10px;" ><?= $idioma->mostrados_ultimos_50_whats_api; ?></span>
                    <br />
              </div>
            <div class="col-md-6">
                <div class="btn-toolbar ">
                  <div class="btn-group mr-3">
                    <button onclick="location.href='fila_zap';" class="btn btn-outline-secondary" >Acompanhar fila <span class="badge badge-info">new</span></button>
                    <button onclick="$('#modal_pareamento_zapi').modal('show');" class="btn btn-outline-secondary" ><i class="fa fa-whatsapp" ></i> Api Própria</button>
                    <button onclick="location.href='../control/control.export_ws_msg.php';" type="button" class="btn btn-sm btn-outline-secondary"><i class="fa fa-download" ></i> Download</button>
                  </div>
                 </div>
            </div>
            
            <!-- end btns -->
            
            <!-- table -->
            <div class="col-md-12">
                
              <div class="table-responsive">
                <table class="table table-striped table-sm">
                  <thead>
                    <tr>
                      <th>Whatsapp <i class="fa fa-whatsapp" ></i></th>
                      <th><?= $idioma->data; ?> <i class="fa fa-calendar" ></i></th>
                      <th><?= $idioma->mensagem; ?> <i class="fa fa-comments" ></i></th>
                    </tr>
                  </thead>
                  <tbody id="tbody_clientes" class="" >
                    <?php
        
                       if($wsapi){
        
                         while($msg = $wsapi->fetch(PDO::FETCH_OBJ)){
        
                    ?>
        
        
                    <tr >
                      <td><i class="fa fa-whatsapp" ></i> <?= $msg->whatsapp; ?></td>
                      <td><?= $msg->data.' - '.$msg->hora; ?></td>
                      <td style="width:70%;" ><i class="fa fa-arrow-right" ></i> <?= $msg->msg; ?></td>
        
                    </tr>
        
                  <?php } }else{ ?>
        
                    <tr>
                      <td class="text-center" colspan="6" ><?= $idioma->nenhuma_mensagem; ?></td>
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



<!--  Modal  gestorBot -->
<div class="modal fade"  data-backdrop="static" id="modal_gestorBot" tabindex="-1" role="dialog" aria-labelledby="Titutlo_modal_gestorBot" aria-hidden="true">
 <div class="modal-dialog modal-lg" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="titutlo_modal_gestorBot">API GESTOR-BOT</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <input type="hidden" id="cont_scan" value="0" />
     <div class="modal-body " id="body_modal_gestorBot" >
         

        <div class="row" >
            
            <div class="col-md-12" >

                    <fieldset style="padding-top:10px!important;border: 1px solid #CCC;margin:5px;padding:5px;border-radius:10px;" class="row col-md-12" >
     
                         <div class="col-md-6 form-group" >
                             <div class="custom-control custom-checkbox mr-lg">
                                <input <?php if($v_device_gestorbot){ if($v_device_gestorbot->situ == 1){ echo 'checked'; } }?> type="checkbox" class="custom-control-input" id="situ_api_gestorbot">
                                <label class="custom-control-label" for="situ_api_gestorbot">Situação</label>
                              </div>
                         </div>
  
                        <div class="col-md-6 form-group" >
                          <span style="font-size:12px;" >Preço Médio P. Msg/ R$ 0,00</span>
                        </div>
                         
                        <div class="col-md-12 form-group" >
                            <input style="cursor:no-drop;" type="text" value="<?= base64_encode($user->email); ?>" disabled placeholder="API KEY"  class="form-control" />
                            <input type="text" value="<?= base64_encode($user->email); ?>" style="display:none;" placeholder="API KEY" id="api_key_gestorbot" class="form-control" />
                        </div>

                            <div class="col-md-12 form-group" >
                                <button id="btn_save_key_gestorbot" style="width:100%;" class="btn btn-primary btn-lg" onclick="save_key('gestorbot');" >Salvar</button>
                            </div>

                        
                        <div class="col-md-12" >
                            <div class="">
                                <ul>
                                    <h4>Como funciona ?</h4>
                                    <li>
                                        <p>
                                            A api <b>Gestor-bot</b> é uma instância gratuita fornecida pela Gestor Lite. As mensagens são enviadas automáticamente se ativada.
                                        </p>
                                        <p>
                                           <i class="fa fa-hand-o-right"></i> Nós temos um número próprio para o envio das mensagens. <b>+1 (510) 370-1932</b>. É importante se você usar está api, pedir que seus clientes adicione este número em suas agendas.
                                        </p>
                                        <p>
                                           <i class="fa fa-hand-o-right"></i> Nós não respondemos nenhum cliente por este whatsapp, se algum cliente seu enviar uma mensagem irá receber a seguinte mensagem:
                                            <div class="alert alert-secondary">
                                                Olá. Que pena, infelizmente não posso te ajudar. 
                                                
                                                 🤖 Sou um robô criado apenas para enviar notificações. Tente entrar em contato com seu provedor de serviços por outro lugar. 
                                                
                                                
                                                 Posso te pedir um favor ?
                                                Adicione meu número, se precisar te ajudo a lembrar das suas faturas 😊
                                            </div>
                                        </p>
                                        <p>
                                         <i class="fa fa-hand-o-right"></i>   Portanto coloque todas as informações necessárias na mensagem que será enviada.
                                        </p>
                                         <p>
                                          <i class="fa fa-hand-o-right"></i>  Adicione você também este número, será por ele, que serão enviadas seus lembretes do painel.
                                        </p>
                                        <p>
                                          <i class="fa fa-warning text-warning"></i> Contrate o plano patrão e envie mensagens pelo seu próprio whatsapp
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    
                    </fieldset>

            </div>
            
        </div>

      </div>

     <div class="modal-footer">
       <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $idioma->fechar; ?></button>
     </div>
    </div>

   </div>
 </div>

<!--  Modal Scan whatsapp -->
<div class="modal fade"  data-backdrop="static" id="modal_pareamento_zapi" tabindex="-1" role="dialog" aria-labelledby="Titutlo_modal_pareamento" aria-hidden="true">
 <div class="modal-dialog modal-lg" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="Titutlo_modal_fat_cli">Utilizar API </h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <input type="hidden" id="cont_scan" value="0" />
     <div class="modal-body " id="body_modal_pareamento_zapi" >
         
        <input id="status_load_qr" type="hidden" value="1" />
        <input type="hidden" value="<?php if($v_device_zapi){ echo $v_device_zapi->device_id; }else{ echo 'none'; } ?> " id="keydevice_zapi" />

        <div class="row" >
            <?php if($v_device_zapi){ ?>
            <div class="col-md-12 text-center">
                <button onclick="remove_api_zapi();" id="remove_api_zapi" class="btn btn-primary btn-sm" >Desativar API</button>
            </div>
            <?php } ?>
            
            <div class="col-md-6" >
                <center><img src="img/easy_zapi.png" style="width:70%;" /></center>
                <br />
                <ol class="_1p68X"><li class="eGEEX">Abra o WhatsApp no seu celular</li><li class="eGEEX"><span dir="ltr" class="_3Whw5 selectable-text invisible-space copyable-text">Toque em <strong><span dir="ltr" class="_3Whw5 selectable-text invisible-space copyable-text">Mais opções <span class="_3cZ5X"><svg height="24px" viewBox="0 0 24 24" width="24px"><rect fill="#f2f2f2" height="24" rx="3" width="24"></rect><path d="m12 15.5c.825 0 1.5.675 1.5 1.5s-.675 1.5-1.5 1.5-1.5-.675-1.5-1.5.675-1.5 1.5-1.5zm0-2c-.825 0-1.5-.675-1.5-1.5s.675-1.5 1.5-1.5 1.5.675 1.5 1.5-.675 1.5-1.5 1.5zm0-5c-.825 0-1.5-.675-1.5-1.5s.675-1.5 1.5-1.5 1.5.675 1.5 1.5-.675 1.5-1.5 1.5z" fill="#818b90"></path></svg></span></span></strong> ou <strong><span dir="ltr" class="_3Whw5 selectable-text invisible-space copyable-text">Ajustes <span class="_3cZ5X"><svg width="24" height="24" viewBox="0 0 24 24"><rect fill="#F2F2F2" width="24" height="24" rx="3"></rect><path d="M12 18.69c-1.08 0-2.1-.25-2.99-.71L11.43 14c.24.06.4.08.56.08.92 0 1.67-.59 1.99-1.59h4.62c-.26 3.49-3.05 6.2-6.6 6.2zm-1.04-6.67c0-.57.48-1.02 1.03-1.02.57 0 1.05.45 1.05 1.02 0 .57-.47 1.03-1.05 1.03-.54.01-1.03-.46-1.03-1.03zM5.4 12c0-2.29 1.08-4.28 2.78-5.49l2.39 4.08c-.42.42-.64.91-.64 1.44 0 .52.21 1 .65 1.44l-2.44 4C6.47 16.26 5.4 14.27 5.4 12zm8.57-.49c-.33-.97-1.08-1.54-1.99-1.54-.16 0-.32.02-.57.08L9.04 5.99c.89-.44 1.89-.69 2.96-.69 3.56 0 6.36 2.72 6.59 6.21h-4.62zM12 19.8c.22 0 .42-.02.65-.04l.44.84c.08.18.25.27.47.24.21-.03.33-.17.36-.38l.14-.93c.41-.11.82-.27 1.21-.44l.69.61c.15.15.33.17.54.07.17-.1.24-.27.2-.48l-.2-.92c.35-.24.69-.52.99-.82l.86.36c.2.08.37.05.53-.14.14-.15.15-.34.03-.52l-.5-.8c.25-.35.45-.73.63-1.12l.95.05c.21.01.37-.09.44-.29.07-.2.01-.38-.16-.51l-.73-.58c.1-.4.19-.83.22-1.27l.89-.28c.2-.07.31-.22.31-.43s-.11-.35-.31-.42l-.89-.28c-.03-.44-.12-.86-.22-1.27l.73-.59c.16-.12.22-.29.16-.5-.07-.2-.23-.31-.44-.29l-.95.04c-.18-.4-.39-.77-.63-1.12l.5-.8c.12-.17.1-.36-.03-.51-.16-.18-.33-.22-.53-.14l-.86.35c-.31-.3-.65-.58-.99-.82l.2-.91c.03-.22-.03-.4-.2-.49-.18-.1-.34-.09-.48.01l-.74.66c-.39-.18-.8-.32-1.21-.43l-.14-.93a.426.426 0 00-.36-.39c-.22-.03-.39.05-.47.22l-.44.84-.43-.02h-.22c-.22 0-.42.01-.65.03l-.44-.84c-.08-.17-.25-.25-.48-.22-.2.03-.33.17-.36.39l-.13.88c-.42.12-.83.26-1.22.44l-.69-.61c-.15-.15-.33-.17-.53-.06-.18.09-.24.26-.2.49l.2.91c-.36.24-.7.52-1 .82l-.86-.35c-.19-.09-.37-.05-.52.13-.14.15-.16.34-.04.51l.5.8c-.25.35-.45.72-.64 1.12l-.94-.04c-.21-.01-.37.1-.44.3-.07.2-.02.38.16.5l.73.59c-.1.41-.19.83-.22 1.27l-.89.29c-.21.07-.31.21-.31.42 0 .22.1.36.31.43l.89.28c.03.44.1.87.22 1.27l-.73.58c-.17.12-.22.31-.16.51.07.2.23.31.44.29l.94-.05c.18.39.39.77.63 1.12l-.5.8c-.12.18-.1.37.04.52.16.18.33.22.52.14l.86-.36c.3.31.64.58.99.82l-.2.92c-.04.22.03.39.2.49.2.1.38.08.54-.07l.69-.61c.39.17.8.33 1.21.44l.13.93c.03.21.16.35.37.39.22.03.39-.06.47-.24l.44-.84c.23.02.44.04.66.04z" fill="#818b90"></path></svg></span></span></strong> e selecione <strong>WhatsApp Web</strong></span></li><li class="eGEEX">Aponte seu celular para essa tela para capturar o código</li></ol>    
                <hr>
                <ul>
                    <li>
                        Após fazer o pareamente, atualize a página.
                    </li>
                </ul>
            </div>
            <div class="col-md-6" >
                 <center><span id="load_qr_icon" style="display:none;" >Aguarde <i class="fa fa-spinner fa-spin"></i></span><br /><br />
                 <img onclick="init_qr();" src="img/qrcode-inative.png" class="img-thumbnail" id="qr-inative" />
                 <!--<h5>Estamos atualizando</h5>-->
                 <!--<p>Aguarde e volte mais tarde</p>-->
                 <br /><br />
                 <span class="text-danger" id="returnErro"></span></center>
            </div>
        </div>
     
      </div>

     <div class="modal-footer">
       <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $idioma->fechar; ?></button>
     </div>
    </div>

   </div>
 </div>
 


<!--  Modal Scan whatsapp -->
<div class="modal fade"  data-backdrop="static" id="modal_pareamento" tabindex="-1" role="dialog" aria-labelledby="Titutlo_modal_pareamento" aria-hidden="true">
 <div class="modal-dialog modal-lg" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="Titutlo_modal_fat_cli">Adicionar Minha credencial Whats API</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <input type="hidden" id="cont_scan" value="0" />
     <div class="modal-body " id="body_modal_pareamento" >
         

        <div class="row" >
            
            <div class="col-md-12" >

                    <fieldset style="padding-top:10px!important;border: 1px solid #CCC;margin:5px;padding:5px;border-radius:10px;" class="row col-md-12" >
                      
                         
                        <div class="col-md-3 form-group" >
                            <img src="<?php if($dark == 1){ echo "https://panel.rapiwha.com/landing/images/logo_rapiwha-light.svg"; }else{ echo 'https://panel.rapiwha.com/landing/images/logo_rapiwha-dark.svg'; }?>" width="150" />
                        </div>
                        
                         <div class="col-md-2 form-group" >
                             <div class="custom-control custom-checkbox mr-sm-2">
                                <input <?php if($v_device_rapiwha){ if($v_device_rapiwha->situ == 1){ echo 'checked'; } }?> type="checkbox" class="custom-control-input" id="situ_api_rapiwha">
                                <label class="custom-control-label" for="situ_api_rapiwha">Situação</label>
                              </div>
                         </div>
                         
                          <div class="col-md-3 form-group" >
                            <a target="_blank" href="https://rapiwha.com" >Visitar <i class="fa fa-globe" ></i></a> |
                            <a target="_blank" href="https://youtu.be/w8QaksteIcw" >Tutorial <i class="fa fa-external-link" ></i></a>
                          </div>
                         <div class="col-md-4 form-group" >
                          <span style="font-size:12px;" >Preço Médio P. Msg/ R$ 0,25</span>
                        </div>
                         
                        <div class="col-md-12 form-group" >
                            <input type="text" value="<?php if($v_device_rapiwha){ echo $v_device_rapiwha->device_id;} ?>" placeholder="API KEY" id="api_key_rapiwha" class="form-control" />
                            <small>API KEY</small>
                        </div>
                        <div class="col-md-12 form-group" >
                            <button id="btn_save_key_rapiwha" style="width:100%;" class="btn btn-primary btn-lg" onclick="save_key('rapiwha');" >Salvar</button>
                        </div>
                    
                    </fieldset>
                    
                    <fieldset style="padding-top:10px!important;border: 1px solid #CCC;margin:5px;padding:5px;border-radius:10px;" class="row col-md-12" >
                       
                         
                        <div class="col-md-3 form-group" >
                            <img src="<?php if($dark == 1){ echo "<?=SET_URL_PRODUCTION?>/painel/img/logo-gestor-lite_dark_on.png"; }else{ echo '<?=SET_URL_PRODUCTION?>/painel/img/logo-gestor-lite.png'; }?>" width="150" />
                        </div>
                        
                         <div class="col-md-2 form-group" >
                             <div class="custom-control custom-checkbox mr-sm-2">
                                <input <?php if($v_device_patrao){ if($v_device_patrao->situ == 1){ echo 'checked'; } }?> type="checkbox" class="custom-control-input" id="situ_api_patrao">
                                <label class="custom-control-label" for="situ_api_patrao">Situação</label>
                              </div>
                         </div>
                         
                         <div class="col-md-3 form-group" >
                          <a target="_blank" href="<?=SET_URL_PRODUCTION?>/painel/cart" >Visitar <i class="fa fa-globe" ></i></a> |
                          <a href="#" >Tutorial <i class="fa fa-external-link" ></i></a>
                        </div>
                         <div class="col-md-4 form-group" >
                          <span style="font-size:12px;" >Preço Médio P. Msg/ R$ 0,00</span>
                        </div>
                        
                        <div class="col-md-12 form-group" >
                            <input type="text" value="<?php if($v_device_patrao){  echo $v_device_patrao->device_id; } ?>" placeholder="Endpoint (Plano Patrão)" id="api_key_patrao" class="form-control" />
                            <small> <i class="fa fa-warning text-warning" ></i> VERSÃO DESCONTINUADA ! USE A NOVA API</small>
                        </div>

                        <div class="col-md-12 form-group" >
                            <button id="btn_save_key_patrao" style="width:100%;" class="btn btn-primary btn-lg" onclick="save_key('patrao');" >Salvar</button>
                        </div>
                     
                    </fieldset>
                    

                
            </div>
            
        </div>
     
      </div>

     <div class="modal-footer">
       <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $idioma->fechar; ?></button>
     </div>
    </div>

   </div>
 </div>
 
   
       <script>
       
       
       function remove_api_zapi(){
           
           $("#status_load_qr").val('0');
           
           $("#remove_api_zapi").prop('disabled', true);
           $("#remove_api_zapi").html('Aguarde <i class="fa fa-spinner fa-spin" ></i>');
           
           var keydevice_zapi = $("#keydevice_zapi").val();
            $.post('../control/api-zapi/control.load_qr.php',{remove:true,keydevice_zapi:keydevice_zapi},function(data){
               location.href="";
            });
       }
       
           function init_qr(){
               $("#returnErro").html('');
               load_qr();
           }
       
       
         function load_qr(){
             $("#load_qr_icon").show();
             var status_load_qr = $("#status_load_qr").val();
             var keydevice_zapi = $("#keydevice_zapi").val();
             
             $("#status_load_qr").val('0');
             
            if(status_load_qr == 1){
             
             $.post('../control/api-zapi/control.load_qr.php',{load:true,keydevice_zapi:keydevice_zapi},function(data){
                 
                 $("#load_qr_icon").hide()
                
                try{
                   var obj = JSON.parse(data);
                
                    if(obj.erro){
                        $("#returnErro").html(obj.msg);
                    }else{
                        
                        $("#qr-inative").attr("src", 'data:image/png;base64,'+obj.qrcode);
                        $("#keydevice_zapi").val(obj.key);
                         setTimeout(function(){
                               $("#status_load_qr").val('1');
                               $("#qr-inative").attr("src", 'img/qrcode-inative.png');
                           },60000);
                    }
                }catch(e){
                  $("#returnErro").html('Desculpe, volte mais tarde, ou entre em contato com o suporte');
                }
    
             });
             
            }else{
                $("#load_qr_icon").hide()
                $("#returnErro").html('Aguarde até tentar novamente');
            }
         }
 
        
            
          function value_checkbox(id){
              if(typeof $(id).val() != "undefined"){
                
                if( $(id).is(":checked") == true ){
                    var situ = 1;
                }else{
                    var situ = 0;
                }
                   
               }else{
                   var situ = 0;
               }
            
             return situ;
          }
       
       
           function save_key(api){
               
               $("#btn_save_key_"+api).prop('disabled', true);
               $("#btn_save_key_"+api).html('Salvar <i class="fa fa-spin fa-refresh" ></i>');
               
               
               if(api == "chatpro"){
                   var api_key = $("#api_key_"+api).val()+"@@@@"+$("#endpoint_chatpro").val();
               }else{
                   var api_key =  $("#api_key_"+api).val();
               }
               
               
               
               
               var situ = value_checkbox("#situ_api_"+api);
               
              

             $.post('../control/control.add_key_api.php',{api_key:api_key,api:api,situ:situ},function(data){
                 var obj = JSON.parse(data);
                 alert(obj.msg);
                
                $("#btn_save_key_"+api).prop('disabled', false);
                $("#btn_save_key_"+api).html('Salvar');
                
                if(obj.erro){
                    if(obj.msg == "Você já possui outra API ativa, desative-a para ativar está."){
                        $("#situ_api_"+api).prop("checked", false);
                    }
                }
                 
             });
           }
       </script>


 <!-- footer -->
 
 <?php include_once 'inc/footer.php'; ?>
