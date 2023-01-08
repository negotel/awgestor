 <?php


 if(!isset($_GET['id'])){
     
     echo '<script>location.href="integracoes"</script>';
     exit;
 }



  $apiPainel = new ApiPainel();

  $v_api_painel = $apiPainel->info_credenciais($_GET['id'],$_SESSION['SESSION_USER']['id']);
  
  if($v_api_painel == false){
      echo '<script>location.href="integracoes";</script>';
      die;
  }

 ?>


<!-- Head and Nav -->
<?php include_once 'inc/head-nav.php'; ?>

    <style>
        #mceu_43{
            display:none !important;
        }
         #mceu_87{
         display:none !important;
        }
    </style>

<script src="https://cdn.tiny.cloud/1/a8et6dziwmrkdy9wmaowzufw8054zc0wnys52y4kfwuc8de1/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>


    <!-- NavBar -->
    <?php include_once 'inc/nav-bar.php'; ?>

     <main class="page-content">
    
<div class="">
            
            <div style="padding: 10px;-webkit-box-shadow: 0px 0px 16px -2px rgb(0 0 0 / 84%);box-shadow: 0px 0px 16px -2px rgb(0 0 0 / 84%);width: 99%;" class="card row" >
           
      <div class="col-md-12">
        <h1 class="h2">Templates </h1>
        <div class="btn-toolbar mb-2 mb-md-0">
        </div>
      </div>
      
    <div class="col-md-12">
      <div class="row">
          <div class="col-md-3"></div>
          <div class="col-md-6">
              <div class="btn-group">
                  <button class="btn btn-success btn-lg" onclick="load_card_modelo('whatsapp');" >Whatsapp <i class="fa fa-whatsapp"></i></button>
                  <button class="btn btn-secondary btn-lg" onclick="load_card_modelo('mail');" >Email <i class="fa fa-envelope"></i></button>
                  <button class="btn btn-danger btn-lg" onclick="load_card_modelo('tutorial');" >Tutorial <i class="fa fa-youtube"></i></a>
              </div>
              <p id="response-modelo">
                  
              </p>
          </div>
          <div class="col-md-3"></div>
          
          <div style="margin-top:5px;display:none;" id="card-tutorial" class="col-md-12">
              <div style="padding:10px;" class="card">
                  <div class="card-head">
                      <h4>Tutorial</h4>
                  </div>
                  <div class="card-body">
    
                        <div class="embed-responsive embed-responsive-16by9">
                          <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/Lrtt1CJmJi8?start=212" allowfullscreen></iframe>
                        </div>
                    
                  </div>
                  <div class="card-footer">
                  </div>
              </div>
          </div>

          <div style="margin-top:5px;" id="card-whatsapp" class="col-md-12">
              <div style="padding:10px;" class="card">
                  <div class="card-head">
                      <h4>Template Whatsapp</h4>

                      <button onclick="save_modelo('whatsapp');" class="btn btn-success" style="width:100%;" id="btn_modelo_whatsapp" >Salvar</button>
                      <a onclick="load_modelo_teste('whatsapp');" class="link text-info" style="cursor:pointer;" >Clique aqui para carregar modelo pronto</a>

                  </div>
                  <div class="card-body">
                      <textarea class="form-control" id="whatsapp_dados" placeholder="" rows="15" ><?php if($v_api_painel){ if($v_api_painel->template_zap != ""){ echo $v_api_painel->template_zap; } } ?></textarea>

                  </div>
                  <div class="card-footer">
                  </div>
              </div>
          </div>
          
          <div style="margin-top:5px;display:none;" id="card-mail" class="col-md-12">
              <div style="padding:10px;" class="card">
                  <div class="card-head">
                      <h4>Template Email</h4>
                      <button class="btn btn-secondary" style="width:100%;"  onclick="save_modelo('mail');" id="btn_modelo_mail"  >Salvar</button>
                      <a onclick="load_modelo_teste('mail');" class="link text-info" style="cursor:pointer;" >Clique aqui para carregar modelo pronto</a>
                  </div>
                  <div class="card-body">

                     
                      <script>
                          tinymce.init({ 
                            selector:'textarea#mail_dados',
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
                    
                      <textarea id="mail_dados" placeholder="Template email" ><?php if($v_api_painel){ if($v_api_painel->template_mail != ""){ echo $v_api_painel->template_mail; } } ?></textarea>

                  </div>
                  <div class="card-footer">
                      
                  </div>
              </div>
          </div>
          
          
      </div>
         <input type="hidden" value="whatsapp" id="active_tab" />
         <input type="hidden" value="<?= $_GET['id']; ?>" id="id_painel" />
         </div>
         </div>
         </div>
    </main>
  </div>
</div>
<script>

    function save_modelo(modelo){
        
        $("#btn_modelo_"+modelo).prop('disabled', true);
        $("#btn_modelo_"+modelo).html('Aguarde <i class="fa fa-refresh fa-spin" ></i>');
        
        if(modelo == "whatsapp" ){
          var content = $('#'+modelo+'_dados').val();
        }else{
          var content = tinymce.get(modelo+'_dados').getContent();
        }
        
        var id = $("#id_painel").val();
        var modelo = modelo;
        
        $.post('../control/control.update_modelo_teste.php',{modelo:modelo,content:content,id:id},function(data){
            
            var respostaJ = JSON.parse(data);
            
            if(respostaJ.erro){
                $('#response-modelo').removeClass();
                $('#response-modelo').addClass('text-danger');
                $('#response-modelo').html(respostaJ.msg);
            }else{
                $('#response-modelo').removeClass();
                $('#response-modelo').addClass('text-success');
                $('#response-modelo').html(respostaJ.msg);
            }
            
            $("#btn_modelo_"+modelo).prop('disabled', false);
            $("#btn_modelo_"+modelo).html('Salvar');
            
            setTimeout(function(){
              $('#response-modelo').html('');  
            },5000);
            
        }); 
    } 

    function load_modelo_teste(teste){
        $.get('<?=SET_URL_PRODUCTION?>/painel/preview/modelo-teste-'+ teste +'.txt',function(data){
            
            if(teste == "whatsapp" ){
                $('#'+teste+'_dados').val(data);
            }else{
              tinymce.get(teste+'_dados').setContent(data);
            }
                
        });
    }
    
    function load_card_modelo(card){
        var active_tab = $("#active_tab").val();
        $("#card-"+active_tab).hide(100);
        $("#card-"+card).show(100);
        $("#active_tab").val(card);
    }
    
</script>

 <!-- footer -->
 <?php include_once 'inc/footer.php'; ?>
