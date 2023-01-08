<!DOCTYPE html>
<html lang="pt-br">
   <head>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
      <meta charset="UTF-8">
      <title>Redirecionando</title>
      <link href="<?=SET_URL_PRODUCTION?>/img/favicon.ico" rel="shortcut icon" />
	  <link href="<?=SET_URL_PRODUCTION?>/painel/css/bootstrap.min.css" rel="stylesheet">


   </head>
   <body translate="no">
      <div class="container">
          
          
             <div style="margin-top:100px!important;" class="row text-center">
                 
                <div class="col-md-4"></div>
                
                <div id="body_center" class="col-md-4">
                        
                    <img src="https://upload.wikimedia.org/wikipedia/commons/c/c7/Loading_2.gif" width="200px;" /> 
                    <br />
                    <h3>Aguarde...</h3>
                    
                </div>
                
                <div class="col-md-4"></div>
             </div>

      </div>

	  <script>

	    
	     <?php
	    
    	    if(isset($_GET['ref']) || isset($_GET['af'])){
    	        
    	        if(isset($_GET['af'])){
    	           echo 'setTimeout(function(){ location.href="<?=SET_URL_PRODUCTION?>?af='.$_GET['af'].'"; },4000);';
    	        }else{
    	           echo 'setTimeout(function(){ location.href="<?=SET_URL_PRODUCTION?>?ref='.$_GET['ref'].'"; },4000);';
    	        }
    	        
    	    }else{
    	        echo 'setTimeout(function(){ location.href="<?=SET_URL_PRODUCTION?>"; },4000);';

    	    } ?>
	  


	  </script>
	  
   </body>
</html>
