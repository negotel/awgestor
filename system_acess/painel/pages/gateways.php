 <?php
 
  if($plano_usergestor->financeiro_avan == 0){
       header('Location: cart?upgrade');
      exit;
    }
    
    if($plano_usergestor->mini_area_cliente == 0){
       header('Location: cart?upgrade');
      exit;
    }


  $gateways_class = new Gateways();

  $picpay_gate = $gateways_class->dados_picpay_user($_SESSION['SESSION_USER']['id']);
  $bank_gate = $gateways_class->dados_bank_user($_SESSION['SESSION_USER']['id']);
  $mp_gate = $gateways_class->dados_mp_user($_SESSION['SESSION_USER']['id']);
  $ph_gate = $gateways_class->dados_ph_user($_SESSION['SESSION_USER']['id']);

 ?>


<!-- Head and Nav -->
<?php include_once 'inc/head-nav.php'; ?>

<script src="https://cdn.tiny.cloud/1/a8et6dziwmrkdy9wmaowzufw8054zc0wnys52y4kfwuc8de1/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

    <!-- NavBar -->
    <?php include_once 'inc/nav-bar.php'; ?>

     <main class="page-content">
<div class="">
            
            <div style="padding: 10px;-webkit-box-shadow: 0px 0px 16px -2px rgb(0 0 0 / 84%);box-shadow: 0px 0px 16px -2px rgb(0 0 0 / 84%);width: 99%;" class="card row" >
                
              <div class="col-md-12">
                <h1 class="h2">Gateways de pagamentos <i class="fa fa-dollar" ></i> </h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                </div>
              </div>
        
              <div class="col-md-12">
                  <div class="col-md-3"></div>
                  <div class="col-md-6">
                      <div class="btn-group">
                          <button class="btn btn-info btn-sm" onclick="load_card_gateways('mercadopago');" >Mercado Pago <i class="fa fa-handshake-o"></i></button>
                          <button class="btn btn-success btn-sm" onclick="load_card_gateways('picpay');" >PicPay <i class="fa fa-qrcode"></i></button>
                          <button class="btn btn-primary btn-sm" onclick="load_card_gateways('paghiper');" >Pag Hiper <i class="fa fa-barcode"></i></button>
                          <button class="btn btn-secondary btn-sm" onclick="load_card_gateways('banco');" >Banco <i class="fa fa-bank"></i> / PIX 
                            <svg width="17" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                              <defs/>
                              <g fill="#FFF" fill-rule="evenodd">
                                <path d="M393.072 391.897c-20.082 0-38.969-7.81-53.176-22.02l-77.069-77.067c-5.375-5.375-14.773-5.395-20.17 0l-76.784 76.786c-14.209 14.207-33.095 22.019-53.179 22.019h-9.247l97.521 97.52c30.375 30.375 79.614 30.375 109.988 0l97.239-97.238h-15.123zm-105.049 74.327c-8.55 8.53-19.93 13.25-32.05 13.25h-.02c-12.12 0-23.522-4.721-32.05-13.25l-56.855-56.855c7.875-4.613 15.165-10.248 21.758-16.84l63.948-63.948 64.23 64.23c7.637 7.66 16.188 14.013 25.478 18.952l-54.439 54.46zM310.958 22.78c-30.374-30.374-79.613-30.374-109.988 0l-97.52 97.52h9.247c20.082 0 38.97 7.834 53.178 22.02l76.784 76.785c5.57 5.592 14.622 5.57 20.17 0l77.069-77.068c14.207-14.187 33.094-22.02 53.176-22.02h15.123l-97.239-97.237zm6.028 96.346l-64.23 64.23-63.97-63.97c-6.593-6.592-13.86-12.206-21.736-16.818l56.853-56.877c17.69-17.645 46.476-17.668 64.121 0l54.44 54.461c-9.292 4.961-17.842 11.315-25.479 18.974h.001z"/>
                                <path d="M489.149 200.97l-58.379-58.377h-37.706c-13.838 0-27.394 5.635-37.185 15.426l-77.068 77.069c-7.202 7.18-16.623 10.77-26.067 10.77-9.443 0-18.885-3.59-26.066-10.77l-76.785-76.785c-9.792-9.814-23.346-15.427-37.207-15.427h-31.81L22.78 200.97c-30.374 30.375-30.374 79.614 0 109.988l58.095 58.074 31.81.021c13.86 0 27.416-5.635 37.208-15.426l76.784-76.764c13.925-13.947 38.208-13.924 52.133-.02l77.068 77.066c9.791 9.792 23.346 15.405 37.185 15.405h37.706l58.379-58.356c30.374-30.374 30.374-79.613 0-109.988zm-362.19 129.724c-3.763 3.786-8.942 5.917-14.273 5.917H94.302l-48.59-48.564c-17.689-17.69-17.689-46.476 0-64.143L94.3 175.296h18.385c5.331 0 10.51 2.154 14.295 5.918l74.74 74.74-74.761 74.74zm339.257-42.647l-48.848 48.87h-24.305c-5.309 0-10.508-2.155-14.251-5.92l-75.023-75.043 75.023-75.023c3.743-3.764 8.942-5.918 14.252-5.918h24.304l48.847 48.891c8.573 8.551 13.273 19.93 13.273 32.05 0 12.141-4.7 23.52-13.273 32.093z"/>
                              </g>
                            </svg>
                          </button>
                      </div>
                      <p id="response-gate">
                          
                      </p>
                  </div>
                  <div class="col-md-3"></div>
                  
                  <div style="margin-top:5px;" id="card-mercadopago" class="col-md-12">
                      <div style="padding:10px;" class="card">
                          <div class="card-head">
                              <h4>Integrar ao Mercado Pago </h4>
                              <a target="_blank" href="https://www.mercadopago.com.br/developers/panel/credentials/" >Pegar minhas credenciais <i class="fa fa-external-link"></i></a>
                          </div>
                          <div class="card-body">
                              <div class="form-group">
                                  <input type="text" class="form-control" placeholder="client_id" value="<?php if($mp_gate){ echo $mp_gate->client_id; } ?>" id="mp_client_id" />
                              </div>
                               <div class="form-group">
                                  <input type="text" class="form-control" placeholder="client_secret" value="<?php if($mp_gate){ echo $mp_gate->client_secret; } ?>" id="mp_client_secret" />
                              </div>
                          </div>
                          <div class="text-center card-footer">
                               <small>Deixe os campos em branco para deletar</small>
                              <button class="btn btn-info" id="btn_gate_mercadopago" onclick="save_gate('mercadopago');" style="width:100%;" id="btn_gate_mercadopago" >Salvar</button>
                          </div>
                          

                      </div>
                  </div>
                  
                     <div style="margin-top:5px;display:none;" id="card-paghiper" class="col-md-12">
                      <div style="padding:10px;" class="card">
                          <div class="card-head">
                              <h4>Integrar ao Pag Hiper <span class="badge badge-danger">BETA</span> </h4>
                                
                                <div class="custom-control custom-checkbox mr-lg">
                                <input <?php if($ph_gate){ if($ph_gate->situ == 1){ echo 'checked'; } } ?> type="checkbox" class="custom-control-input" id="situ_gate_paghiper">
                                <label class="custom-control-label" for="situ_gate_paghiper">Ativo</label>
                                </div>
                              <a href="https://www.paghiper.com/painel/credenciais/" target="_blank" >Pegar minhas credenciais <i class="fa fa-external-link"></i></a>
                          </div>
                          <div class="card-body">
                              <div class="form-group">
                                  <input type="text" class="form-control" placeholder="API KEY" value="<?php if($ph_gate){ echo $ph_gate->apikey; } ?>" id="ph_apikey" />
                              </div>
                               <div class="form-group">
                                  <input type="text" class="form-control" placeholder="TOKEN" value="<?php if($ph_gate){ echo $ph_gate->token; } ?>" id="ph_token" />
                              </div>
                          </div>
                          <div class="text-center card-footer">
                               <small>Deixe os campos em branco para deletar</small>
                              <button class="btn btn-info" id="btn_gate_paghiper" onclick="save_gate('paghiper');" style="width:100%;" id="btn_gate_paghiper" >Salvar</button>
                          </div>
        
                      </div>
                  </div>
                  
                  <div style="margin-top:5px;display:none;" id="card-picpay" class="col-md-12">
                      <div style="padding:10px;" class="card">
                          <div class="card-head">
                              <h4>PicPay</h4>
                              <div class="custom-control custom-checkbox mr-lg">
                                <input <?php if($picpay_gate){ if($picpay_gate->situ == 1){ echo 'checked'; } } ?> type="checkbox" class="custom-control-input" id="situ_gate_picpay">
                                <label class="custom-control-label" for="situ_gate_picpay">Ativo</label>
                              </div>
                              <button onclick="save_gate('picpay');" class="btn btn-success" style="width:100%;" id="btn_gate_picpay" >Salvar</button>
                               <a onclick="load_modelo_gateway('picpay');" class="link text-info" style="cursor:pointer;" >Clique aqui para carregar modelo pronto</a>
        
                          </div>
                          <div class="card-body">
                             
                              <script>
                                  tinymce.init({ 
                                    selector:'textarea#picpay_dados',
                                    language_url : 'js/lang_editor_txt/pt_BR.js',
                                    height: 400,
                                    plugins: [
                                        'lists code emoticons',
                                        'advlist autolink lists link image charmap print preview anchor',
                                        'searchreplace visualblocks code fullscreen',
                                        'insertdatetime media table paste code wordcount'
                                      ],
                                      toolbar: 'undo redo | styleselect | bold italic | ' +
                                                'alignleft aligncenter alignright alignjustify | ' +
                                                'outdent indent | numlist bullist | link image | code | emoticons',
                                  });
                              </script>
                            
                              <textarea id="picpay_dados" placeholder="Coloque aqui seu Qr Code e seu usuário do picpay" ><?php if($picpay_gate){ if($picpay_gate->content != ""){ echo $picpay_gate->content; } } ?></textarea>
        
                          </div>
                          <div class="card-footer">
                          </div>
                      </div>
                  </div>
                  
                  <div style="margin-top:5px;display:none;" id="card-banco" class="col-md-12">
                      <div style="padding:10px;" class="card">
                          <div class="card-head">
                              <h4>Banco & PIX</h4>
                              <div class="custom-control custom-checkbox mr-lg">
                                <input <?php if($bank_gate){ if($bank_gate->situ == 1){ echo 'checked'; } } ?> type="checkbox" class="custom-control-input" id="situ_gate_banco">
                                <label class="custom-control-label" for="situ_gate_banco">Ativo</label>
                              </div>
                              <button class="btn btn-secondary" style="width:100%;" onclick="save_gate('banco');" id="btn_gate_banco"  >Salvar</button>
                              <a onclick="load_modelo_gateway('banco');" class="link text-info" style="cursor:pointer;" >Clique aqui para carregar modelo pronto</a>
                          </div>
                          <div class="card-body">
        
                             
                              <script>
                                  tinymce.init({ 
                                    selector:'textarea#banco_dados',
                                    language_url : 'js/lang_editor_txt/pt_BR.js',
                                    height: 400,
                                    plugins: [
                                        'lists code emoticons',
                                        'advlist autolink lists link image charmap print preview anchor',
                                        'searchreplace visualblocks code fullscreen',
                                        'insertdatetime media table paste code wordcount'
                                      ],
                                      toolbar: 'undo redo | styleselect | bold italic | ' +
                                                'alignleft aligncenter alignright alignjustify | ' +
                                                'outdent indent | numlist bullist | link image | code | emoticons',
                                  });
                              </script>
                            
                              <textarea id="banco_dados" placeholder="Coloque aqui as informações do seu banco" ><?php if($bank_gate){ if($bank_gate->content != ""){ echo $bank_gate->content; } } ?></textarea>
        
                          </div>
                          <div class="card-footer">
                              
                          </div>
                      </div>
                  </div>
                  
                  
              </div>
        <input type="hidden" value="mercadopago" id="active_tab" />
        </div>
        </div>
    </main>
  </div>
</div>
<script>

    function save_gate(gate){
        
        $("#btn_gate_"+gate).prop('disabled', true);
        $("#btn_gate_"+gate).html('Aguarde <i class="fa fa-refresh fa-spin" ></i>');
        
        
        var content = "";
        
        if(gate == "mercadopago"){
           content = $('#mp_client_id').val()+'@@@'+$('#mp_client_secret').val();
        }else if(gate == "paghiper"){
            content = $('#ph_apikey').val()+'@@@'+$('#ph_token').val();
        }else{
            content = tinymce.get(gate+'_dados').getContent();
        }
        
        
        
        var situ = 0;
        
        if($("#situ_gate_"+gate).is(":checked")){
            situ = 1;
        }else{
            situ = 0;
        }
    
        
        var gate    = gate;
        
        $.post('../control/control.save_gate.php',{gateway:gate,situ:situ,content:content},function(data){
            
            var respostaJ = JSON.parse(data);
            
            if(respostaJ.erro){
                $('#response-gate').removeClass();
                $('#response-gate').addClass('text-danger');
                $('#response-gate').html(respostaJ.msg);
            }else{
                $('#response-gate').removeClass();
                $('#response-gate').addClass('text-success');
                $('#response-gate').html(respostaJ.msg);
            }
            
            $("#btn_gate_"+gate).prop('disabled', false);
            $("#btn_gate_"+gate).html('Salvar');
            
            setTimeout(function(){
              $('#response-gate').html('');  
            },5000);
            
        }); 
    } 

    function load_modelo_gateway(gate){
        $.get('<?=SET_URL_PRODUCTION?>/painel/preview/modelo-gateway-'+ gate +'.txt',function(data){
            tinymce.get(gate+'_dados').setContent(data);
        });
    }
    
    function load_card_gateways(card){
        var active_tab = $("#active_tab").val();
        $("#card-"+active_tab).hide(100);
        $("#card-"+card).show(100);
        $("#active_tab").val(card);
    }
    
</script>

 <!-- footer -->
 <?php include_once 'inc/footer.php'; ?>
