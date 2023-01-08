<?php 

  $traffic_class = new Traffic();
  $list_traffic = $traffic_class->list_traffic($user->id);

?>
<!-- Head and Nav -->
<?php include_once 'inc/head-nav.php'; ?>


    <!-- NavBar -->
    <?php include_once 'inc/nav-bar.php'; ?>

    <main class="page-content">
<div class="">
            
            <div style="padding: 10px;-webkit-box-shadow: 0px 0px 16px -2px rgb(0 0 0 / 84%);box-shadow: 0px 0px 16px -2px rgb(0 0 0 / 84%);width: 99%;" class="card row" >
            
              <div class="col-md-12">
                <h2 class="h2">Tráfego em Links <i class="fa fa-rocket"></i> </h2>
                <span>Solicite Tráfego para seu website, vídeo ou qualquer tipo de link</span>
             </div>
    
    
     <div class="col-md-12">
      <div class="row">
       <div class="col-md-12 text-center">
        <button class="btn btn-success btn-sm" onclick="$('#modal_solicita_traffic').modal('show');" >Solicitar Novo Tráfego</button>     
       </div>
       <div class="col-md-12">
             <h3>Meus últimos pedidos</h3>
         <div class="table-responsive">
            <table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th>Data</th>
                  <th>Acessos</th>
                  <th>Link</th>
                  <th>Tipo</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                  
                  <?php if($list_traffic){ ?>
    
    
                    <?php while($traffic = $list_traffic->fetch(PDO::FETCH_OBJ)){ 
                    
                    
                    $status['Processando'] = '<span class="badge badge-warning" >Processando</span>';
                    $status['Entregue'] = '<span class="badge badge-success" >Entregue</span>';
                    
                    
                    
                    ?>
                    
                    <tr>
                      <td><?= $traffic->data; ?></td>
                      <td><?= $traffic->qtd_acesso; ?></td>
                      <td><a target="_blank" href="<?= $traffic->link; ?>" ><?= substr($traffic->link,0,25); if(strlen($traffic->link)>25){ echo '...'; } ?></a></td>
                      <td><?= $traffic->tipo_link; ?></td>
                      <td><?= $status[$traffic->status]; ?></td>
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


<!--  Modal Scan whatsapp -->
<div class="modal fade"  data-backdrop="static" id="modal_solicita_traffic" tabindex="-1" role="dialog" aria-labelledby="Titutlo_modal_pareamento" aria-hidden="true">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="Titutlo_modal_fat_cli">Solicitar tráfego em links</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body " id="body_modal_solicita_traffic" >
         

        <div class="row" >
            
            
             <form class="row" id="form_solicita_traffic" name="form_solicita_traffic" action="" >
                
                <div class="col-md-12" >
                          <?php
                            date_default_timezone_set('America/Sao_Paulo');
                    
                            $hora = date("H:m");
                            $abre = "07:00";
                            $fecha = "18:00";
                            if($hora > $abre && $hora < $fecha) {
                           }else {
                              echo '<div class="col-md-12 alert alert-info">Você está solicitando fora de <b>horário comercial</b>, os acessos serão entregues durante horário comercial</div>';
                            }
                        ?>
                    
                     <div class="col-md-12"> 
                         <div class="form-group">
                             <input type="url" class="form-control" placeholder="http://seusite.com" id="url_traffic" name="url_traffic" />
                         </div>
                   </div>
                 <div class="col-md-12">
                     <div class="form-group">
                         <small>Seu link é:</small>
                         <select class="form-control" id="type_link" name="type_link">
                            <option value="Website" >Website</option>
                            <option value="FanPage Facebook" >FanPage Facebook</option>
                         </select>
                     </div>
                 </div>
                 <div class="col-md-12">
                     <div class="form-group">
                         <small>Qual País:</small>
                         <select class="form-control" id="pais" name="pais">
                            <option value="Todos" >Todos</option>
                            
                            <?php 
                            
                                $json = (array)json_decode(file_get_contents('https://gist.githubusercontent.com/jonasruth/61bde1fcf0893bd35eea/raw/10ce80ddeec6b893b514c3537985072bbe9bb265/paises-gentilicos-google-maps.json'));
                                
                                foreach($json as $key => $value){
                                    echo '<option value="'.$value->nome_pais.'" >'.$value->nome_pais.'</option>';
                                }
                                
                            
                            
                            ?>
                          
                          
                         </select>
                     </div>
                 </div>
                  <div class="col-md-12">
                     <div class="form-group">
                         <small>Quantos acessos:</small>
                         <select class="form-control" id="qtd_acessos" name="qtd_acessos">
                            <option value="1" >500</option>
                            <option value="2" >1000</option>
                         </select>
                     </div>
                  </div>
                  
                   <div class="col-md-12">
                     <div class="form-group">
                         <small>Deseja tráfego por keyWord?</small>
                         <select class="form-control" id="deseja_key_words" name="deseja_key_words">
                            <option onclick="$('#div_keywords').hide();" value="nao" >Não</option>
                            <option onclick="$('#div_keywords').show();" value="sim" >Sim</option>
                         </select>
                     </div>
                   </div>
                   
                    <div id="div_keywords" style="display:none;" class="col-md-12">
                      <div class="form-group">
                         <small>Defina as KeyWords (Max: 5)</small>
                         <textarea class="form-control" id="key_words" name="key_words" placeholder="Ex: roupas baratas, sapatos masculino, moda verão" ></textarea>
                      </div>
                    </div>
                    
                     <div class="col-md-12">
                      <div class="form-group">
                         <small>Deseja tráfego de origem?</small>
                         <select class="form-control" id="deseja_origem" name="deseja_origem">
                            <option onclick="$('#origem_link_div').hide();" value="nao" >Não</option>
                            <option onclick="$('#origem_link_div').show();" value="sim" >Sim</option>
                         </select>
                      </div>
                    </div>
                    
                      <div id="origem_link_div" style="display:none;" class="col-md-12">
                          <div class="form-group">
                             <small>Defina a origem: </small>
                             <select class="form-control" id="origem_link" name="origem_link">
                                <option value="Google" >Google</option>
                                <option value="Bing" >Bing</option>
                                <option value="Baidu" >Baidu</option>
                             </select>
                          </div>
                      </div>
                    
                    <div class="col-md-12">
                        <div class="form-group">
                         <small>Defina porcentagem por plataforma <i class="fa fa-percent"></i></small>
                          <div class="row">
                              <div class="col-md-6" >
                                  <div class="form-group">
                                      <small>Para Desktop</small>
                                     <input onkeyup="sumporcent('desk');" onchange="sumporcent('desk');" min="0" max="100" type="number" class="form-control" placeholder="Ex: 50" value="50" id="porcent_plataform_desktop" name="porcent_plataform_desktop" />
                                 </div>
                              </div>
                              <div class="col-md-6" >
                                     <small>Para Mobile</small>
                                    <input onkeyup="sumporcent('mobi');" onchange="sumporcent('mobi');" min="0" max="100" type="number" class="form-control" placeholder="Ex: 50%" value="50" id="porcent_plataform_mobile" name="porcent_plataform_mobile" />
                              </div>
                          </div>
                      </div>
                    </div>
                    
                    <div class="" id="msg_return" ></div>
                    
                </div>        
                
             </form>
         
        </div>
     
      </div>
      
      

     <div class="modal-footer">
       <button type="button" onclick="solicita_traffic();" id="btn_solicita_traffic" class="btn btn-success" >Solicitar</button>
       <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $idioma->fechar; ?></button>
     </div>
    </div>

   </div>
 </div>
 <script>
    
    function sumporcent(type){
        var desk = parseInt($("#porcent_plataform_desktop").val());
        var mobi = parseInt($("#porcent_plataform_mobile").val());
        
        if(type == 'desk'){
            var newMobi = (100-desk);
            $("#porcent_plataform_desktop").attr('max',desk);
            $("#porcent_plataform_mobile").val(newMobi);
            $("#porcent_plataform_mobile").attr('max',newMobi);
        }else{
            var newDesk = (100-mobi);
            $("#porcent_plataform_mobile").attr('max',mobi);
            $("#porcent_plataform_desktop").val(newDesk);
            $("#porcent_plataform_desktop").attr('max',newDesk);
        }
    }
 
 
 
     function solicita_traffic(){
         $("#btn_solicita_traffic").prop('disabled', true);
         $("#btn_solicita_traffic").html('Aguarde <i class="fa fa-spinner fa-spin" ></i>');
         
         
         var dados = $("#form_solicita_traffic").serialize();
         $.post("../control/control.traffic.php",{solicita:true,dados:dados},function(data){
            try {
              var obj = JSON.parse(data);
              if(obj.erro){
                  $("#msg_return").removeClass('alert alert-danger alert alert-success');
                  $("#msg_return").addClass('alert alert-danger');
                  $("#msg_return").html(obj.msg);
              }else{
                  $("#msg_return").removeClass('alert alert-danger alert alert-success');
                  $("#msg_return").addClass('alert alert-success');
                  $("#msg_return").html(obj.msg);
                  setTimeout(function(data){
                     location.href="";
                  });
              }
            }
            catch (e) {
                  $("#msg_return").removeClass('alert alert-danger alert alert-success');
                  $("#msg_return").addClass('alert alert-danger');
                  $("#msg_return").html('Desculpe, não consegui trabalhar direito. Entre em contato com suporte técnico.');
            }
            
            $("#btn_solicita_traffic").prop('disabled', false);
            $("#btn_solicita_traffic").html('Solicitar');
            
            
         });
         
         
     }
 </script>
 <!-- footer -->
 <?php include_once 'inc/footer.php'; ?>
