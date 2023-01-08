
  <?php

   include_once 'inc/head.php';
   include_once 'inc/nav-top.php';
   include_once 'inc/nav-sidebar.php';



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
          		<div class="card">
          			<div class="card-header">
          				<h4 class="card-title">Meus dados</h4>
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
          					<p class="card-text">Alterar meus dados</p>

                    <div class="row">
                       <div class="col-md-12">
                          <p id="response_msg_profile" ></p>
                       </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <input class="form-control" type="text" id="nome_cli" placeholder="Seu nome" name="nome" value="<?= $_SESSION['SESSION_CLIENTE']['nome']; ?>">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <input class="form-control" type="email" id="email_cli" placeholder="Seu email" name="email" value="<?= $_SESSION['SESSION_CLIENTE']['email']; ?>">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <input disabled style="cursor: not-allowed!important;" class="form-control" type="text" id="telefone_disabled" placeholder="Seu telefone" name="telefone_disabled" value="<?= $_SESSION['SESSION_CLIENTE']['telefone']; ?>">
                            <small>Para alterar seu telefone, entre em contato com suporte</small>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <input class="form-control" type="password" id="senha_cli" placeholder="Uma nova senha" name="senha_cli" value="">
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            <button id="bnt_form_profile" type="button" onclick="save_my_profile();" class="btn btn-primary" name="button"> <i class="fa fa-floppy-o" ></i> Salvar</button>
                          </div>
                        </div>


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
