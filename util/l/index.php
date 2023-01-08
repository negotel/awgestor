<?php 

 header("Access-Control-Allow-Origin: *");

 require_once 'autoload.php';


   $clientes_class = new Clientes();

 if(isset($_POST['id'])){
     
     $zap    = $_POST['zap'];
     $email  = $_POST['mail'];
     $id     = $_POST['id'];
     
     if($clientes_class->verifica_lista_negra($id)){
         
         if($clientes_class->add_lista_negra($id,$email,$zap)){
             echo '1';
         }else{
             echo '0';
         }
         
     }else{
         if($clientes_class->update_lista_negra($id,$email,$zap)){
               echo '1';
         }else{
               echo '0';
         }
     }
     
     
     die;
     
 }


 $explo_url = explode('/',$_GET['url']);

 
 if(isset($explo_url[0])){
      $auth = true;
      
      $id_cli = $explo_url[0];
      
      if(isset($explo_url[1])){
          $zap = $explo_url[1];
      }else{
          $zap = 'n';
      }
      
      if(isset($explo_url[2])){
          $mail = $explo_url[2];
      }else{
          $mail = 'n';
      }
      
      $lista_n = $clientes_class->dados_lista_negra($id_cli);
      
      if($lista_n){
          
          if($lista_n->whatsapp == 'n'){
              $zap =  $zap;
          }else{
              $zap =  $lista_n->whatsapp;
          }
          
           if($lista_n->email == 'n'){
              $mail =  $mail;
          }else{
              $mail =  $lista_n->email;
          }

      }
      
      
      
 }else{
     $auth = false;
 }




?>
<!DOCTYPE html>
<html lang="pt-br">
   <head>
       
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
      <meta charset="UTF-8">
      <?php if($auth){ ?>
        <title>Cancelar inscrição</title>
      <?php }else{ ?>
      <title>Link quebrado</title>
      <?php } ?>
      <link href="<?=SET_URL_PRODUCTION?>/img/favicon.ico" rel="shortcut icon" />
      <link href="css/style.scss" rel="stylesheet">
	  <link href="<?=SET_URL_PRODUCTION?>/painel/css/bootstrap.min.css" rel="stylesheet">
	  <link href="css/icons/css/font-awesome.min.css" rel="stylesheet">
     

   </head>
   <body translate="no">
      <div class="container">
          
          <?php if($auth){ ?>
          
             <div style="margin-top:100px!important;" class="row text-center">
                 
                 <div class="col-md-2"></div>
                
                <div id="body_center" class="col-md-8">
                        
                    <h3>
                        Despedidas são sempre difíceis, mas as vezes necessária!
                    </h3>
                    
                    <p>
                        Se deseja não receber mais mensagens, clique no botão abaixo.
                    </p>
                    
                    <button id="btn_cancel" class="btn btn-primary" onclick="cancel_inscricao(<?= $id_cli; ?>);" >
                        Cancelar inscrição
                    </button>
                    
                </div>
                
                <div class="col-md-2"></div>
             </div>
             
    	<?php }else{ ?>
    	    
    	    <section>
    	        <center>
    	            <img style="width:200px;" src="img/404.png" />
    	            <h3 class="text-white" >Link quebrado</h3>
    	            <p>
    	                Que pena, este link parece não estar mais disponível.
    	            </p>
    	        </center>
    	    </section>
    	
		 <?php } ?>
      </div>
	  	<script>
		  function mudaDDI(ddi,country){

			  $("#ddi").val(ddi);
			  $("#dropDownDDI").html('<img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/'+country+'.png" /> +'+ddi);
		  }
		</script>
      
      
	  <script src="<?=SET_URL_PRODUCTION?>/painel/js/jquery.js"></script>
	  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" ></script>

	  <script>
	   function cancel_inscricao(idcli){
	       
	       $("#btn_cancel").prop('disabled', true);
	       $("#btn_cancel").html('Aguarde <i class="fa fa-frown-o fa-spin" ></i>');
	       
	       var mail = '<?= $mail; ?>';
	       var zap  = '<?= $zap; ?>';
	       
	       $.post('https://glite.me/l/',{id:idcli,mail:mail,zap:zap},function(data){
	           if(data == '1'){
	               $("#body_center").html('<img src="<?=SET_URL_PRODUCTION?>/template_mail/template_1/img/check-icone-scaled.png" width="200" /><br /><p>Pronto! Agora você não vai mais receber mensagens.</p>');
	           }else{
	                $("#body_center").html('<img src="<?=SET_URL_PRODUCTION?>/template_mail/template_1/img/close.png" width="200" /><br /><p>Desculpe minha incompetência, mas não consegui fazer isso agora. Tente mais tarde.</p>');
  
	           }
	       });
	   }
	  </script>
	  
   </body>
</html>
