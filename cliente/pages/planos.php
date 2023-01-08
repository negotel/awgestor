<?php

   include_once 'inc/head.php';
   include_once 'inc/nav-top.php';
   include_once 'inc/nav-sidebar.php';
   
   $planos_class = new Planos();
 

   $planos = $planos_class->list($_SESSION['PAINEL']['id_user']);

  ?>



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
              3 => "Boa tarde!",
              4 => "Deixa eu te conta. Sabia que a NASA vai voltar pra lua em 2024?",
              5 => "Quer conversar? <a href='{$link_gestor}/{$sp}/suporte' >Me chama aqui</a>",
              6 => "{$name} você gosta de kiwi?",
              7 => "Hey {$name}, ta tudo bem com vc?"
            );


            $hr = date(" H ");
            if($hr >= 12 && $hr<18) {
            $resp = $msg_boa_tarde[rand(0,7)];}
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
          		<div class="card">
          			<div class="card-header">
          				<h4 class="card-title">
          				    <?php if($_SESSION['PAINEL']['planos_amostra'] == 0){ ?>
          				      Seu plano atual.
          				    <?php }else{ ?>
          				      Nossos Planos- 
          				    <?php } ?>
          				    </h4>
          				<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
          				<div class="heading-elements">
          					<ul class="list-inline mb-0">
          						<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
          						<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
          					</ul>
          				</div>
          			</div>
          			<div class="card-content collapse show">
          				<div class="card-body">
                         <div class="row" >
                          <?php
                          
                          
                            if($_SESSION['PAINEL']['planos_amostra'] == 0){
                            
                             $plano_cli = $planos_class->plano($_SESSION['SESSION_CLIENTE']['id_plano']);
                                       
                           ?>
                                       
                                    <div class="col-md-4 card text-center" style="padding:10px;border:1px solid gray;">
                                      <div class="card-head">
                                          <h3><?= $plano_cli->nome; ?></h3>
                                      </div>
                                      <div class="card-body">
                                          <h2>
                                              R$ <?= $plano_cli->valor; ?>
                                          </h2>
                                      </div>
                                      <div class="card-footer">
                                          <a class="btn btn-success"  href="./?plano=<?= $plano_cli->id; ?>">RENOVAR</a>
                                          <br />
                                          <small>
                                              <?= $plano_cli->dias; ?> dias
                                          </small>
                                      </div>
                                  </div>
                              
                                               
                            <?php  }else{
                          
                          
    
                            if($planos){
    
                              while ($plano = $planos->fetch(PDO::FETCH_OBJ)) {
                          
                           ?>
    
                              <div class="col-md-4">
                                  <div class="card text-center" style="padding:10px;border:1px solid gray;">
                                      <div class="card-head">
                                          <h3><?= $plano->nome; ?></h3>
                                      </div>
                                      <div class="card-body">
                                          <h2>
                                              R$ <?= $plano->valor; ?>
                                          </h2>
                                      </div>
                                      <div class="card-footer">
                                          <a class="btn btn-success"  href="./?plano=<?= $plano->id; ?>">ASSINAR</a>
                                          <br />
                                          <small>
                                              <?= $plano->dias; ?> dias
                                          </small>
                                      </div>
                                  </div>
                              </div>
                                <?php  } }else{ ?>
            
                                      Não há Planos
                                      
            
                                <?php } } ?>
                           </div>
          				</div>
          			</div>
          		</div>
          	</div>
          </div>
          <!-- Basic Tables end -->

        </div>
      </div>
    </div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->

    <?php include_once 'inc/footer.php';?>
