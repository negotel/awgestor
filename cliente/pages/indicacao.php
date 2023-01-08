
  <?php

   include_once 'inc/head.php';
   include_once 'inc/nav-top.php';
   include_once 'inc/nav-sidebar.php';
   
   $clientes_class = new Clientes();

   $conf_indicacao = json_decode($_SESSION['PAINEL']['indicacao']);
   $qtd_indicacoes = $clientes_class->get_indicacoes($_SESSION['SESSION_CLIENTE']['id']);
   
   if(json_decode($_SESSION['PAINEL']['indicacao'])->status == 0){
       echo '<script>location.href="../";</script>';
       exit();
   }

  ?>
    

    <canvas id="canvas" style="z-index: 999;"></canvas>
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-wrapper-before"></div>
        <div class="content-header row">
          <div class="content-header-left col-md-4 col-12 mb-2">
            <h5 class="content-header-title">Olá, <?= explode(' ',$_SESSION['SESSION_CLIENTE']['nome'])[0];?> !</h5>
            <p style="color:#fff;">
            <?php

            $name = explode(' ',$_SESSION['SESSION_CLIENTE']['nome'])[0];

            $msg_madruga = array(
              0 => "Ainda acordado?",
              1 => "Essas horas acordado!",
              2 => "Quem precisa dormir não é mesmo?",
              3 => "Dizem que Einstein dormia apenas 3 horas por dia.",
              4 => "Vai dormi jovem!",
              5 => "Falta de sono pode causar varios danos a saúde.",
              6 => "Vai lá, vai dormi, deixa que eu cuido das coisas pra você.",
              7 => "Sem sono? Pois é eu também...",
              8 => "Bom, agora deve ser meio dia em algum lugar não é mesmo.",
              9 => "Pois é {$name}, as vezes eu também não durmo de madrugada.",
              10 => "Você tem café ai? porquê eu quero um"
            );

            $sp = $_SESSION['PAINEL']['slug'];

            $msg_boa_tarde = array(
              0 => "Oiii.. Como vc ta?",
              1 => "Agora é ".date('H:i').'',
              2 => "Precisa de alguma coisa ? <a href='{$link_gestor}/{$sp}/suporte' >Clica aqui</a>",
              3 => "Boa tarde!"
            );


            $hr = date(" H ");
            if($hr >= 12 && $hr<18) {
            $resp = $msg_boa_tarde[rand(0,3)];}
            else if ($hr >= 0 && $hr <4 ){
            $resp = $msg_madruga[rand(0,10)];}
            else if($hr >= 4 && $hr <12){
            $resp = "Bom dia!";}
            else{
            $resp = "Boa noite";}

            echo "$resp";
            ?>
            </p>
          </div>
          <div class="content-header-right col-md-8 col-12">
            <div class="breadcrumbs-top float-md-right">
              <div class="breadcrumb-wrapper mr-1">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item text-white"> Vencimento: <i class="fa fa-calendar" ></i> <?= $_SESSION['SESSION_CLIENTE']['vencimento']; ?></li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <div class="content-body"><!-- Basic Tables start -->


          <div class="row">
          	<div class="col-12">
          		<div class="<?php if($qtd_indicacoes->qtd >= $conf_indicacao->qtd){ ?>indicacao_show<? } ?> card">
          			<div class="card-header">
          				<h4 class="card-title"><b><?= $name; ?></b>, Agora você pode ganhar <b><?= $conf_indicacao->meses; ?> <?php if($conf_indicacao->meses>1){ echo "meses"; }else{ echo "mês";} ?> grátis</b> nos indicando!</h4>
          			</div>
          			<div class="card-content collapse show">
          				
          				<div style="padding:30px;" class="row">
          				    <div class="col-md-6">
          				        <p>Você indicou:</p>
          				        
          				        <h2><?= $qtd_indicacoes->qtd; ?>/<?= $conf_indicacao->qtd; ?></h2>
          				        
          				    </div>
          				    <div class="col-md-6">
          				        <p>Seu link de indicação: <span id="info_copy" class="text-success"></span></p>
          				        <?php if($qtd_indicacoes->qtd >= $conf_indicacao->qtd){ ?>
          				         <del class="text-info link_ind"  style="cursor:pointer;" >https://glite.me/ind/<?= str_replace("=","",base64_encode($_SESSION['SESSION_CLIENTE']['id'])); ?></del>
          				        <?php }else{ ?>
          				         <span onclick="copy_link();" class="text-info link_ind"  style="cursor:pointer;" >https://glite.me/ind/<?= str_replace("=","",base64_encode($_SESSION['SESSION_CLIENTE']['id'])); ?></span>
          				        <?php } ?>
          				    </div>
          				</div>
          				<?php 
          				
          				    if($qtd_indicacoes->qtd >= $conf_indicacao->qtd){ 
          				        
          				 ?>
          				 
          				    
          				  <div style="padding:30px;" class="row">
          				      <div class="col-md-12">
          				          <p style="font-size:12px;" class="text-secondary">
          				            <i class="fa fa-warning"></i>  Tire uma captura de tela, e nos envie por qualquer meio de contato.
          				          </p>
          				      </div>
          				      <div class="col-md-12" >
          				          <div class="row">
          				              <div class="col-md-4">
          				                  <p>Identificador:</p>
          				                  <h4>#<?= $qtd_indicacoes->id; ?></h4>
          				              </div>
          				          </div>
          				      </div>
          				      <div class="col-md-12" >
          				          <p>
                  				      <?= str_replace("\n","<br />",base64_decode($conf_indicacao->msg)); ?>
                  				  </p>
          				      </div>
          				  </div>
          				 
          				 
          				 <?php
          				    }else{
          				
          				?>
          				<ul>
          				    <h4>Como participar?</h4>
          				    <li>Compartilhe o link acima com seus amigos e conhecidos</li>
          				    <li>Ao atingir a indicação de <?= $conf_indicacao->qtd; ?> amigos, você receberá instruções para para receber seu prêmio</li>
          				    <br />
          				    <h4>Mas se liga na regrinha:</h4>
          				    <li>Seu indicado deve adquirir ao menos um plano</li>
          				</ul>
          				<?php } ?>
          			</div>
          		</div>
          	</div>
          </div>
          <!-- Basic Tables end -->

        </div>
      </div>
    </div>
    <input type="text" id="input_link" value="https://glite.me/ind/<?= str_replace("=","",base64_encode($_SESSION['SESSION_CLIENTE']['id'])); ?>" style="left: -40008px!important;z-index: -540;float: left;position: absolute;" />
    <script>
        function copy_link(){
            
              $('#input_link').select();
                
             if(document.execCommand('copy')){
                $("#info_copy").html("<i class='fa fa-check' ></i> Copiado!");
                setTimeout(function(){
                    $("#info_copy").html("");
                },3000);
              }
           
        }
        
        <?php if($qtd_indicacoes->qtd >= $conf_indicacao->qtd){ ?>
        hide_canva();
        function hide_canva(){
            setTimeout(function(){
                $("#canvas").hide();
            },8000);
        }
        
        //-----------Var Inits--------------
        canvas = document.getElementById("canvas");
        ctx = canvas.getContext("2d");
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
        cx = ctx.canvas.width/2;
        cy = ctx.canvas.height/2;
        
        let confetti = [];
        const confettiCount = 200;
        const gravity = 0.5;
        const terminalVelocity = 6;
        const drag = 0.075;
        const colors = [
          { front : 'red', back: 'darkred'},
          { front : 'green', back: 'darkgreen'},
          { front : 'blue', back: 'darkblue'},
          { front : 'yellow', back: 'darkyellow'},
          { front : 'orange', back: 'darkorange'},
          { front : 'pink', back: 'darkpink'},
          { front : 'purple', back: 'darkpurple'},
          { front : 'turquoise', back: 'darkturquoise'},
        ];
        
        //-----------Functions--------------
        resizeCanvas = () => {
        	canvas.width = window.innerWidth;
        	canvas.height = window.innerHeight;
        	cx = ctx.canvas.width/2;
        	cy = ctx.canvas.height/2;
        }
        
        randomRange = (min, max) => Math.random() * (max - min) + min
        
        initConfetti = () => {
          for (let i = 0; i < confettiCount; i++) {
            confetti.push({
              color      : colors[Math.floor(randomRange(0, colors.length))],
              dimensions : {
                x: randomRange(10, 20),
                y: randomRange(10, 30),
              },
              position   : {
                x: randomRange(0, canvas.width),
                y: canvas.height - 1,
              },
              rotation   : randomRange(0, 2 * Math.PI),
              scale      : {
                x: 1,
                y: 1,
              },
              velocity   : {
                x: randomRange(-25, 25),
                y: randomRange(0, -50),
              },
            });
          }
        }
        
        //---------Render-----------
        render = () => {  
          ctx.clearRect(0, 0, canvas.width, canvas.height);
          
          confetti.forEach((confetto, index) => {
            let width = (confetto.dimensions.x * confetto.scale.x);
            let height = (confetto.dimensions.y * confetto.scale.y);
            
            // Move canvas to position and rotate
            ctx.translate(confetto.position.x, confetto.position.y);
            ctx.rotate(confetto.rotation);
            
            // Apply forces to velocity
            confetto.velocity.x -= confetto.velocity.x * drag;
            confetto.velocity.y = Math.min(confetto.velocity.y + gravity, terminalVelocity);
            confetto.velocity.x += Math.random() > 0.5 ? Math.random() : -Math.random();
            
            // Set position
            confetto.position.x += confetto.velocity.x;
            confetto.position.y += confetto.velocity.y;
            
            // Delete confetti when out of frame
            if (confetto.position.y >= canvas.height) confetti.splice(index, 1);
        
            // Loop confetto x position
            if (confetto.position.x > canvas.width) confetto.position.x = 0;
            if (confetto.position.x < 0) confetto.position.x = canvas.width;
        
            // Spin confetto by scaling y
            confetto.scale.y = Math.cos(confetto.position.y * 0.1);
            ctx.fillStyle = confetto.scale.y > 0 ? confetto.color.front : confetto.color.back;
             
            // Draw confetto
            ctx.fillRect(-width / 2, -height / 2, width, height);
            
            // Reset transform matrix
            ctx.setTransform(1, 0, 0, 1, 0, 0);
          });
        
          // Fire off another round of confetti
          if (confetti.length <= 10) initConfetti();
        
          window.requestAnimationFrame(render);
        }
        
        //---------Execution--------
        initConfetti();
        render();
        
        //----------Resize----------
        window.addEventListener('resize', function () {
          resizeCanvas();
        });
        
        //------------Click------------
        window.addEventListener('click', function() {
          initConfetti();
        });

    <?php } ?>
    </script>
    <!-- ////////////////////////////////////////////////////////////////////////////-->

    <?php include_once 'inc/footer.php';?>
