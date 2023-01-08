<?php 


 $color1 = isset($colorsLink->color1) ? $colorsLink->color1 : "#8019c5";
 $color2 = isset($colorsLink->color2) ? $colorsLink->color2 : "#8019c5";

 $color_ticket  = isset($colorsLink->color_ticket) ? $colorsLink->color_ticket : "#770ac1";
 $border_ticket = isset($colorsLink->border_ticket) ? $colorsLink->border_ticket : "#b13fff";

 $color_button = isset($colorsLink->color_button) ? $colorsLink->color_button : "#8019c5";
 $text_button = isset($colorsLink->text_button) ? $colorsLink->text_button : "Continuar";





?>

<!DOCTYPE html>
<html lang="pt-br">
   <head>
      <meta charset="UTF-8">
      <title>Link quebrado</title>
      <link href="<?=SET_URL_PRODUCTION?>/img/favicon.ico" rel="shortcut icon" />
      <link href="css/style.scss" rel="stylesheet">
	  <link href="<?=SET_URL_PRODUCTION?>/painel/css/bootstrap.min.css" rel="stylesheet">
	  <link href="<?=SET_URL_PRODUCTION?>/painel/css/icons/css/font-awesome.min.css" rel="stylesheet">
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
         
    	    
    	    <section>
    	        <center>
    	            <img style="width:200px;" src="../p/img/404.png" />
    	            <h3 class="text-white" >Link quebrado</h3>
    	            <p style="color:#fff;">
    	                Que pena, este link parece não estar mais disponível.
    	            </p>
    	        </center>
    	    </section>
    
      </div>

      
      
	  <script src="<?=SET_URL_PRODUCTION?>/painel/js/jquery.js"></script>
	  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" ></script>
	  <script src="<?=SET_URL_PRODUCTION?>/painel/js/popper.js"></script>
	  <script src="<?=SET_URL_PRODUCTION?>/painel/js/bootstrap.min.js"></script>
	  <script src="<?=SET_URL_PRODUCTION?>/login/js/jquery.mask.js"></script>

   </body>
</html>

