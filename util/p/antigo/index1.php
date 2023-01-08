<?php 

 require_once 'autoload.php';
 require_once 'system.php';

 $_SESSION['captcha'] = md5(rand(10000,9999999));	
 
?>

<!DOCTYPE html>
<html lang="pt-br">
   <head>
       
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
      <meta charset="UTF-8">
      <?php if($auth){ ?>
        <title>R$ <?= $planoDados->valor; ?> | <?= $planoDados->nome; ?></title>
      <?php }else{ ?>
      <title>Link quebrado</title>
      <?php } ?>
      <link href="<?=SET_URL_PRODUCTION?>/img/favicon.ico" rel="shortcut icon" />
      <link href="css/style.scss" rel="stylesheet">
	  <link href="https://glite.me/assets/css/bootstrap.min.css" rel="stylesheet">
	  <link href="https://glite.me/assets/css/icons/css/font-awesome.min.css" rel="stylesheet">
      <style>
	  body {
		  background: -webkit-gradient(linear, left top, right top, from(<?= $color1; ?>), to(<?= $color2; ?> ));
		  background: linear-gradient(to right, <?= $color1; ?>  0%, <?= $color2; ?>  100%);
		  font-family: 'Trebuchet MS', Helvetica, sans-serif;
		  letter-spacing: 0.03em;
		  text-rendering: optimizeLegibility;
		  -webkit-font-smoothing: antialiased;
		  overflow-x: hidden;
		}
		
		.ticket {
			backface-visibility: hidden;
			transform-origin: 50% 50%;
			top: 50%;
			left: 55%;
			margin-left: -144px;
			position: absolute;
			display: inline-block;
			padding: 15px 25px;
			background-image:
			radial-gradient( ellipse closest-side at 50%  50%, hsla(0, 0%, 100%, 0.10), transparent 90%),
			radial-gradient( circle at 0    100%, transparent 14px, <?= $color_ticket; ?> 15px),
			radial-gradient( circle at 100% 100%, transparent 14px, <?= $color_ticket; ?> 15px),
			radial-gradient( circle at 100% 0, transparent 14px, <?= $color_ticket; ?> 15px),
			radial-gradient( circle at 0    0, transparent 14px, <?= $color_ticket; ?> 15px);
		    background-position: center center, bottom left, bottom right, top right, top left;
			background-size: cover, 51% 51%, 51% 51%, 51% 51%, 51% 51%;
			background-repeat: no-repeat;
			border-width: 0 4px;
			border-color: transparent;
			border-style: solid;
			border-image: radial-gradient(cover circle, <?= $color_ticket; ?> 0%, <?= $color_ticket; ?> 50%, transparent 51%) 0 39% / 15px 4px repeat;
			-webkit-filter: drop-shadow(hsla(0, 0%, 0%, 0.55) 1px 1px 2px);
		 }
		
		.ticket > div {
			width: 200px;
			height: 100px;
			box-sizing: border-box;
			position:relative;
			border-color: <?= $border_ticket; ?>;
			border-style: solid;
			border-width: 2px;
			border-radius:5px;
			text-align:center;
			font: 2em/1 Impact;
			text-transform:uppercase;
			padding:15px;
			font-stretch: extra-expanded;   
		}

		.ticket > div:before,
		.ticket > div:after {   
		border-color:  <?= $border_ticket; ?>;
		}
		
		.card-details__submit{
			background: radial-gradient(ellipse at center, <?= $color_button; ?> 0%, <?= $color_button; ?> 100%);
			background-position: center;
			background-repeat: no-repeat;
		}
		
		@media screen and (max-width: 766px) {
		   .ticket{
			display:none;
		  }

		}
				
      </style>

   </head>
   <body translate="no">
      <div class="container">
          
          <?php if($auth){ ?>
          
             <section class="product">
                <div class="product__details">
                   <h1 class="product__details-heading">R$ <?= $planoDados->valor; ?> </h1>
                   <span class="product__details-sub-heading"><?= $planoDados->nome; ?></span>
                   <div class="product__details-basket">
                      <div class="ticket">
                         <div data-number="<?= $planoDados->valor; ?>"><?= $planoDados->dias; ?><br/>dias</div>
                      </div>
                      <div class="ticket">
                         <div data-number="<?= $planoDados->valor; ?>"><?= $planoDados->dias; ?><br/>dias</div>
                      </div>
                   </div>
                </div>
                <div class="card-details" >
                    
                    
                    
                   <fieldset class="card-details__fieldset">
                      <span class="card-details__heading">Nós aceitamos:</span>
                      <div class="card-details__cards" data-card-types>
                          <?php if($mpUser){ ?>
                             <div class="card-details__cards-item">
                                <img class="card-details__cards-image" src="img/mercado-pago.png" alt="Mercado Pago" title="Mercado Pago" aria-hidden="true">
                             </div>
                          <?php } ?>
                          <?php if($ppUser){ ?>
                             <div class="card-details__cards-item">
                                <img class="card-details__cards-image" title="Pic Pay" src="img/ppay-icon.png" alt="Pic Pay" aria-hidden="true">
                             </div>
                          <?php } ?>
                           <?php if($phUser){ ?>
                             <div class="card-details__cards-item">
                                <img class="card-details__cards-image" title="Pag Hiper" src="img/paghiper.png" alt="Pag Hiper" aria-hidden="true">
                             </div>
                          <?php } ?>
                      </div>
                   </fieldset>
                   
                   
    			   
                   <fieldset class="card-details__fieldset">
                      <span class="card-details__heading" aria-hidden="true">Seu Nome</span>
                      <div class="card-details__holder">
                         <label class="card-details__holder-label" for="cardHolderName">Seu Nome</label>
                         <input class="card-details__holder-input" type="text" id="nome" placeholder="Digite aqui seu nome" data-input>
                      </div>
                   </fieldset>
    			   
    			   
    			   <fieldset class="card-details__fieldset">
                      <span class="card-details__heading" aria-hidden="true">Seu Email</span>
                      <div class="card-details__holder">
                         <label class="card-details__holder-label" for="cardHolderName">Seu Email</label>
                         <input class="card-details__holder-input" type="text" id="email" placeholder="exemplo@mail.com" data-input>
                      </div>
                   </fieldset>
    			   
    			     <fieldset class="card-details__fieldset">
    				  <div class="card-details__expiration">
                         <span class="card-details__heading" aria-hidden="true">DDI</span>
                         <div class="card-details__expiration-date">
                          <input type="hidden" id="plano_id" value="<?= $planoId; ?>" />
                          <input type="hidden" id="captcha" value="<?= $_SESSION['captcha']; ?>" />
    					  <input type="hidden" id="ddi" value="55" />
    						<div class="btn-group">
    						<button style="font-size: 0.8rem;" id="dropDownDDI" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    							<img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/br.png" /> +55
    						</button>
    						<div class="dropdown-menu">
    							<a style="cursor:pointer;" onclick="mudaDDI('55','br')" class="dropdown-item"><img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/br.png" /> +55</a>
    							<a style="cursor:pointer;" onclick="mudaDDI('351','pt');" class="dropdown-item" ><img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/pt.png" /> +351</a>
    							<a style="cursor:pointer;" onclick="mudaDDI('1','usa');" class="dropdown-item" ><img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/usa.png" /> +1</a>
    							<a style="cursor:pointer;" onclick="mudaDDI('49','ger');" class="dropdown-item"><img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/ger.png" /> +49</a>
    							<a style="cursor:pointer;" onclick="mudaDDI('54','arg');" class="dropdown-item" ><img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/arg.png" /> +54</a>
    							<a style="cursor:pointer;" onclick="mudaDDI('598','uru');" class="dropdown-item"><img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/uru.png" /> +598</a>
    							<a style="cursor:pointer;" onclick="mudaDDI('44','gbr');" class="dropdown-item"><img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/gbr.png" /> +44</a>
    							<a style="cursor:pointer;" onclick="mudaDDI('34','esp');" class="dropdown-item"><img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/esp.png" /> +34</a>
    							<a style="cursor:pointer;" onclick="mudaDDI('1','can');" class="dropdown-item" ><img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/can.png" /> +1</a>
    							<a style="cursor:pointer;" onclick="mudaDDI('57','col');" class="dropdown-item" ><img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/col.png" /> +57</a>
    						</div>
    					</div>
                         </div>
                      </div>
                      <div class="card-details__expiration">
                         <span class="card-details__heading" aria-hidden="true">Número Whatsapp</span>
                         <div class="card-details__expiration-date">
                            <label class="card-details__expiration-date-label" for="whatsapp">Número Whatsapp</label>
                            <input placeholder="(11) 9 9999-9999" class="card-details__expiration-date-input" type="text" id="whatsapp" data-input>
                         </div>
                      </div>
                   </fieldset>
    
                   <button class="card-details__submit" onclick="continuar_gliteme();" id="button_next" type="button" data-submit-button><?= $text_button; ?></button>
                </div>
             </section>
             
             <p>
    			Página Segura <img src="img/61457.png" style="width:15px;float:left;margin:5px;" />
    		 </p>
    		 
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
      
      
	  <script src="https://glite.me/assets/js/jquery.js"></script>
	  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" ></script>
	  <script src="https://glite.me/assets/js/popper.js"></script>
	  <script src="https://glite.me/assets/js/bootstrap.min.js"></script>
	  <script src="https://glite.me/assets/js/jquery.mask.js"></script>
	  <script src="https://glite.me/p/js/main.js"></script>
	  
   </body>
</html>

