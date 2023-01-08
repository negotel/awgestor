<?php

  $ApiPainel = new ApiPainel();



  $maximo = 20;
  $pagina = isset($_GET['page']) ? ($_GET['page']) : '1';
  $inicio = $pagina - 1;
  $inicio = $maximo * $inicio;

  $list_testes  = $ApiPainel->list_teste_history($_SESSION['SESSION_USER']['id'],$inicio,$maximo);

  $gerados      = $ApiPainel->cont_teste_mes($_SESSION['SESSION_USER']['id']);
  $total        = $gerados;
  $financeiro   = new Financeiro();
  $paineis = $ApiPainel->credenciais($_SESSION['SESSION_USER']['id'],false);

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
                           <h2>Integrações <i class="fa fa-code" ></i></h2>
                        </div>
                   </div>
               </div>
               <div class="col-12">
                 <div style="margin-bottom:10px;" class="btn-toolbar ">
                   <div class="btn-group mr-3">
                     <button onclick="$('#modal_credencial').modal('show');" class="btn btn-outline-primary" > Nova Integração</button>
                   </div>
                  </div>
               </div>
               <div style="margin-bottom:20px;" class="text-right col-md-12" >
                  <span style="font-size:20px;" >
                    <i class="fa fa-calendar" ></i> <?= $financeiro->text_mes(date('m'),TRUE); ?>  | Testes gerados <?= $gerados; ?> / <?php if($plano_usergestor->limit_teste > 100000000){ echo "&infin;"; }else{ echo $plano_usergestor->limit_teste; } ?>
                  </span>
               </div>
           </div>
         </div>

         <div class="container-fluid plr_30 body_white_bg pt_30">
           <div class="row justify-content-center">
               <div class="col-12">

                   <div class="QA_section">
                           <div class="row">

                             <div class="col-md-12">
                               <div class="QA_table ">
                                   <!-- table-responsive -->
                                   <table class="table lms_table_active">
                                       <thead>
                                           <tr>
                                             <th>Painel</th>
                                             <th>CMS</th>
                                             <th>Testes</th>
                                             <th>Link de teste</th>
                                             <th>Opções</th>
                                           </tr>
                                       </thead>
                                       <tbody>
                                         <?php


                                            if($paineis){

                                              while($painel = $paineis->fetch(PDO::FETCH_OBJ)){

                                                  $teste = "<span class='badge badge-success' > Ativo</span>";

                                                  if($painel->situ_teste == 0){
                                                      $teste = "<span class='badge badge-danger' > Inativo</span>";
                                                  }

                                         ?>


                                         <tr >
                                           <td><?= $painel->nome; ?></td>
                                           <td><a href="<?= $painel->cms; ?>" target="_blank" ><?php echo substr($painel->cms,0,20); ?>...</a></td>
                                           <td><?= $teste; ?></td>
                                           <td><a href="https://glite.me/t/<?= $painel->chave; ?>" target="_blank" >https://glite.me/t/<?php echo substr($painel->chave,0,6); ?>...</td>
                                           <td>
                                               <button class="btn btn-sm btn-outline-primary" onclick="remove_painel_modal(<?= $painel->id; ?>);" > <i class="fa fa-trash"></i> </button>
                                               <button class="btn btn-sm btn-outline-primary" onclick="edit_modal_painel(<?= $painel->id; ?>);" > <i class="fa fa-edit"></i> </button>
                                               <button onclick="location.href='template-message-teste?id=<?= $painel->id; ?>';" type="button" class="btn-whatsapp-svg btn btn-sm btn-outline-primary">
                                                 <svg style="width: 20px!important;" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" fill="#7922ff"></path></svg>
                                               </button>
                                               <button onclick="modal_iframe(<?= $painel->id; ?>);" type="button" class="btn btn-sm btn-outline-primary"><i class="fa fa-code" ></i></button>

                                           </td>
                                         </tr>

                                         <textarea style="display:none;" id="ifram_cod_<?= $painel->id; ?>" ><iframe src="https://glite.me/t/<?= $painel->chave; ?>" style="height:100%;width:100%;border:none;" name="Gerador de testes" ></iframe></textarea>

                                       <?php } } ?>

                                       </tbody>
                                   </table>
                               </div>
                             </div>

                           </div>

                   </div>
               </div>
           </div>
       </div>


       <div class="container-fluid plr_30 body_white_bg pt_30">
         <div class="row justify-content-center">
             <div class="col-12">
               <hr>
                 <div class="QA_section">
                         <div class="row">
                           <div class="col-md-12">
                            <h3>Testes gerados</h3>
                            <small>Todos os testes são excluidos após 1 mês</small>
                           </div>
                           <div class="col-md-12">
                             <div class="QA_table ">
                                 <!-- table-responsive -->
                                 <table class="table lms_table_active">
                                     <thead>
                                         <tr>
                                           <th>Nome</th>
                                           <th>Email</th>
                                           <th>Whatsapp</th>
                                           <th>Data</th>
                                           <th>Hora</th>
                                           <th>User</th>
                                           <th>Senha</th>
                                           <th>Painel</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                       <?php


                                          if($list_testes){

                                            while($teste = $list_testes->fetch(PDO::FETCH_OBJ)){

                                       ?>


                                       <tr >
                                         <td><?= $teste->nome; ?></td>
                                         <td><?= $teste->email; ?></td>
                                         <td><?= $teste->whatsapp; ?></td>
                                         <td><?= $teste->data; ?></td>
                                         <td><?= $teste->hora; ?></td>
                                         <td><?= $teste->username; ?></td>
                                         <td><?= $teste->password; ?></td>
                                         <td><?= $teste->api_name; ?></td>
                                       </tr>

                                     <?php }  } ?>

                                     </tbody>
                                 </table>
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
