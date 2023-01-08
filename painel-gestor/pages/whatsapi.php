<?php

   $dados_notify = $user->notify_page;


   if($dados_notify == NULL && $dados_notify == ""){
       $notify = 0;
       $teste  = false;
       $bussines = "";
   }else{
       $jsonNotify = json_decode($dados_notify);
       $notify     = $jsonNotify->notify;
       $teste      = $jsonNotify->teste;
       $bussines   = $jsonNotify->bussines;
   }


?>


<?php include_once 'inc/head-nav.php'; ?>
<?php include_once 'inc/sidebar.php'; ?>


<section class="main_content dashboard_part">
<?php include_once 'inc/nav.php'; ?>
   <div class="main_content_iner ">
       <div class="container-fluid plr_30 body_white_bg pt_30">
           <div style="margin-bottom:20px;" class="row justify-content-center">
               <div class="col-12">
                   <div class="QA_section">
                       <div style="margin-bottom:10px;" class="white_box_tittle list_header">
                           <h4>Whats API

                             <svg style="width: 20px!important;top: -3px;position: relative;margin-left: 10px;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>

                           </h4>
                           <small>Cortesia de <i class="fa fa-heart"></i> <a target="_blank" href="https://api-whats.com/">api-whats.com</a> </small>
                       </div>
                   </div>
               </div>
               <div class="col-12">
                 <div style="margin-bottom:10px;" class="btn-toolbar ">
                   <div class="btn-group mr-3">
                     <button onclick="location.href='fila_zap';" class="btn btn-outline-primary" > Ver mensagens na fila</button>
                   </div>
                  </div>
               </div>
           </div>
         </div>

         <div class="container-fluid plr_30 body_white_bg pt_30">
           <div class="row justify-content-center">
               <div class="col-12">
                   <div class="QA_section">
                           <div class="row">


                             <div class="col-lg-12">
                               <div class="row">
                                 <div class="col-md-12">
                                   <input id="status_load_qr" type="hidden" value="1" />
                                   <input type="hidden" value="<?php if($v_device_zapi){ echo $v_device_zapi->device_id; }else{ echo 'none'; } ?> " id="keydevice_zapi" />

                                   <div class="row" >
                                       <?php if($v_device_zapi){ ?>
                                       <div class="col-md-12 text-center">
                                           <button onclick="remove_api_zapi();" id="remove_api_zapi" class="btn btn-primary btn-sm" >Desativar API</button>
                                       </div>
                                       <?php } ?>

                                       <div class="col-md-6 text-center" >
                                           <center><img src="img/image-whatsapi.png" style="width:70%;" /></center>
                                           <br />
                                           <ol class="_1p68X"><li class="eGEEX">Abra o WhatsApp no seu celular</li><li class="eGEEX"><span dir="ltr" class="_3Whw5 selectable-text invisible-space copyable-text">Toque em <strong><span dir="ltr" class="_3Whw5 selectable-text invisible-space copyable-text">Mais opções <span class="_3cZ5X"><svg height="24px" viewBox="0 0 24 24" width="24px"><rect fill="#f2f2f2" height="24" rx="3" width="24"></rect><path d="m12 15.5c.825 0 1.5.675 1.5 1.5s-.675 1.5-1.5 1.5-1.5-.675-1.5-1.5.675-1.5 1.5-1.5zm0-2c-.825 0-1.5-.675-1.5-1.5s.675-1.5 1.5-1.5 1.5.675 1.5 1.5-.675 1.5-1.5 1.5zm0-5c-.825 0-1.5-.675-1.5-1.5s.675-1.5 1.5-1.5 1.5.675 1.5 1.5-.675 1.5-1.5 1.5z" fill="#818b90"></path></svg></span></span></strong> ou <strong><span dir="ltr" class="_3Whw5 selectable-text invisible-space copyable-text">Ajustes <span class="_3cZ5X"><svg width="24" height="24" viewBox="0 0 24 24"><rect fill="#F2F2F2" width="24" height="24" rx="3"></rect><path d="M12 18.69c-1.08 0-2.1-.25-2.99-.71L11.43 14c.24.06.4.08.56.08.92 0 1.67-.59 1.99-1.59h4.62c-.26 3.49-3.05 6.2-6.6 6.2zm-1.04-6.67c0-.57.48-1.02 1.03-1.02.57 0 1.05.45 1.05 1.02 0 .57-.47 1.03-1.05 1.03-.54.01-1.03-.46-1.03-1.03zM5.4 12c0-2.29 1.08-4.28 2.78-5.49l2.39 4.08c-.42.42-.64.91-.64 1.44 0 .52.21 1 .65 1.44l-2.44 4C6.47 16.26 5.4 14.27 5.4 12zm8.57-.49c-.33-.97-1.08-1.54-1.99-1.54-.16 0-.32.02-.57.08L9.04 5.99c.89-.44 1.89-.69 2.96-.69 3.56 0 6.36 2.72 6.59 6.21h-4.62zM12 19.8c.22 0 .42-.02.65-.04l.44.84c.08.18.25.27.47.24.21-.03.33-.17.36-.38l.14-.93c.41-.11.82-.27 1.21-.44l.69.61c.15.15.33.17.54.07.17-.1.24-.27.2-.48l-.2-.92c.35-.24.69-.52.99-.82l.86.36c.2.08.37.05.53-.14.14-.15.15-.34.03-.52l-.5-.8c.25-.35.45-.73.63-1.12l.95.05c.21.01.37-.09.44-.29.07-.2.01-.38-.16-.51l-.73-.58c.1-.4.19-.83.22-1.27l.89-.28c.2-.07.31-.22.31-.43s-.11-.35-.31-.42l-.89-.28c-.03-.44-.12-.86-.22-1.27l.73-.59c.16-.12.22-.29.16-.5-.07-.2-.23-.31-.44-.29l-.95.04c-.18-.4-.39-.77-.63-1.12l.5-.8c.12-.17.1-.36-.03-.51-.16-.18-.33-.22-.53-.14l-.86.35c-.31-.3-.65-.58-.99-.82l.2-.91c.03-.22-.03-.4-.2-.49-.18-.1-.34-.09-.48.01l-.74.66c-.39-.18-.8-.32-1.21-.43l-.14-.93a.426.426 0 00-.36-.39c-.22-.03-.39.05-.47.22l-.44.84-.43-.02h-.22c-.22 0-.42.01-.65.03l-.44-.84c-.08-.17-.25-.25-.48-.22-.2.03-.33.17-.36.39l-.13.88c-.42.12-.83.26-1.22.44l-.69-.61c-.15-.15-.33-.17-.53-.06-.18.09-.24.26-.2.49l.2.91c-.36.24-.7.52-1 .82l-.86-.35c-.19-.09-.37-.05-.52.13-.14.15-.16.34-.04.51l.5.8c-.25.35-.45.72-.64 1.12l-.94-.04c-.21-.01-.37.1-.44.3-.07.2-.02.38.16.5l.73.59c-.1.41-.19.83-.22 1.27l-.89.29c-.21.07-.31.21-.31.42 0 .22.1.36.31.43l.89.28c.03.44.1.87.22 1.27l-.73.58c-.17.12-.22.31-.16.51.07.2.23.31.44.29l.94-.05c.18.39.39.77.63 1.12l-.5.8c-.12.18-.1.37.04.52.16.18.33.22.52.14l.86-.36c.3.31.64.58.99.82l-.2.92c-.04.22.03.39.2.49.2.1.38.08.54-.07l.69-.61c.39.17.8.33 1.21.44l.13.93c.03.21.16.35.37.39.22.03.39-.06.47-.24l.44-.84c.23.02.44.04.66.04z" fill="#818b90"></path></svg></span></span></strong> e selecione <strong>WhatsApp Web</strong></span></li><li class="eGEEX">Aponte seu celular para essa tela para capturar o código</li></ol>
                                           <hr>
                                           <ul>
                                               <li>
                                                   Após fazer o pareamente, atualize a página.
                                               </li>
                                           </ul>
                                       </div>
                                       <div class="col-md-6 text-center" >
                                            <center><span id="load_qr_icon" style="display:none;" >Aguarde <i class="fa fa-spinner fa-spin"></i></span><br /><br />
                                            <img onclick="init_qr();" src="img/qrcode-inative.png" class="img-thumbnail" id="qr-inative" /></a>
                                            <br /><br />
                                            <span class="text-danger" id="returnErro"></span>


                                          </center>
                                       </div>
                                   </div>

                                 </div>
                               </div>
                             </div>

                           </div>

                   </div>
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
<?php include_once 'inc/footer.php'; ?>
