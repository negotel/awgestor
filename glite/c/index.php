<?php 

 require_once '../p/autoload.php';
 
 $faturas_class = new Faturas();
 $user_class = new User();
 $comprovantes_class = new Comprovantes();
 $whatsapi_class = new Whatsapi();
 
 if(isset($_GET['url'])){
     
    $explode_url = explode('/',$_GET['url']);

    $fat = $faturas_class->dados($explode_url[0]);

    if($fat){
        
        $user = $user_class->dados($fat->id_user);
        
         
          if(isset($_FILES) && isset($_POST['meio_pay_idFat'])){
              $files = $_FILES;
              $post  = $_POST;
              $comp = $comprovantes_class->uploadComp($files,$post,'../../comprovantes/',$user,$whatsapi_class);
        
              if($comp){
                  $msg = $comp;
              }else{
                  $msg = "Desculpe, ocorreu um erro. Entre em contato com o suporte.";
              }
          }

        
        $erro = false;
        
    }else{
        $erro = true;
    }

 }else{
    $erro = true;
    
 }

?>
<!doctype html>
<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://glite.me/c/css/bootstrap.min.css">
    <link href="<?=SET_URL_PRODUCTION?>/img/favicon.ico" rel="shortcut icon" />

    <title>Enviar comprovante</title>
  </head>
  <body>
     
     <div class="container">
         <div class="row" style="margin-top:100px;">
             <div class="col-md-2" ></div>
             <div class="col-md-8" >
                 
                 <?php if($erro == false){ ?>
                 
                 <h3>
                     Olá, você esta prestes a enviar um comprovante da fatura Nº <b><?= $fat->id; ?></b>, de <b>R$ <?= $fat->valor;?></b> 
                     
                 </h3>
                 <div class="row">
                   
                     <div class="text-center col-md-12">
                           <?php if(isset($msg)){ ?>
                             <center> 
                                 <div class="alert alert-success" >
                                      <?= $msg; ?> <br />
                                      Em caso de erro, renomeie o arquivo para <b>comprovante</b>
                                  </div>
                              </center>
                             <?php } ?>
                             
                            <?php if($fat->comprovante == '0'){ ?>
                             
                             <form id="form_comp" action="" method="POST" enctype="multipart/form-data" >
                                 <div class="form-group">
                                     <label class="btn btn-lg btn-primary" for="comprovante" >Selecionar comprovante</label>
                                     <input onchange="selecionado();" type="file" style="display:none;" name="comprovante" id="comprovante" />
                                     <input type="hidden" value="<?= $fat->id; ?>" name="meio_pay_idFat" id="meio_pay_idFat" />
                                     <br /><span id="text_msg" ></span>
                                 </div>
                                 
                                  <div class="form-group">
                                     <button class="btn btn-sm btn-info" id="btn_send" disabled >Enviar</button>
                                 </div>
                             </form>
                         <?php }else{ ?>
                                <div class="alert alert-info" >
                                    Um comprovante para está fatura ja fora enviado. Se considera isso um engano, entre em contato com o suporte. <br />
                                    <a target="_blank" href="<?=SET_URL_PRODUCTION?>/faq?contato">Suporte</a>
                                </div>
                         <?php } ?>
                         
                     </div>
                     
                     <?php if(is_file('../../qrcodes/imgs/'.$fat->id.'.png')){ ?>
                           
                           <div class="col-md-12 text-center">
                               <p class="">
                                   Precisa enviar comprovante pelo celular ? <br />
                                   Escaneie o Qr Code abaixo.
                               </p>
                               <img src="<?= '<?=SET_URL_PRODUCTION?>/qrcodes/imgs/'.$fat->id.'.png'; ?> " />
                           </div>
                           
                           
                     <?php } ?>
                     
                 </div>
                 <?php }else{ ?>
                 
                   <div class="row text-center">
                   
                     <div class="text-center col-md-12">
                         <div class="alert alert-info" >
                            Lamentamos, mas está fatura não está mais disponível para comprovação de pagamento<br />
                            <a  target="_blank" href="<?=SET_URL_PRODUCTION?>/faq?contato">Suporte</a>
                        </div>
                         
                    </div>
                 </div>
                 
                 <?php } ?>
                 
                 
                 
             </div>
             <div class="col-md-2" ></div>
         </div>
     </div>
     
    <script src="https://glite.me/c/js/jquery.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    
    <script>
        function selecionado(){
            $("#text_msg").addClass('text-success');
            $("#text_msg").html('Arquivo selecionado');
            $("#btn_send").prop('disabled', false);
        }
    </script>
    
    
  </body>
</html>