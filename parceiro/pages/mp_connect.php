<?php

  setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
  date_default_timezone_set('America/Sao_Paulo');
   
  include_once 'inc/head.php';
  include_once 'inc/acess.php';

  require_once '../class/Conn.class.php';
  require_once '../class/Afiliado.class.php';
        

  $class_af = new Afiliado();
  
  // get af by id
  $afiliado = $class_af->getAfiliadoById($_SESSION['AFILIADO']['id']);
  
  // get access mp
  $access_mp_af = $class_af->verifyCredencial($_SESSION['AFILIADO']['id']);
  
  
  if(!$afiliado){
      echo '<script>location.href="sair";</script>';
  }

  ?>
  <body>
    <div class="adminx-container">
      <?php include_once 'inc/nav.php'; ?>

      <!-- expand-hover push -->
      <!-- Sidebar -->
      <?php include_once 'inc/sidebar.php'; ?>


      <!-- adminx-content-aside -->
      <div class="adminx-content">
        <!-- <div class="adminx-aside">

        </div> -->

        <div class="adminx-main-content">
          <div class="container-fluid">
            <!-- BreadCrumb -->
            <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb adminx-page-breadcrumb">
                <li class="breadcrumb-item"><a href="home">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Financeiro</li>
              </ol>
            </nav>

            <div class="pb-3">
              <h1>Oi <?= explode(' ',$_SESSION['AFILIADO']['nome'])[0]; ?>!</h1>
            </div>

            <div class="row">

             <div class="col-md-12">
                 <div style="padding:20px;" class="card">
                      <div class="row">
                          <div class="col-md-3">
                              
                              <img src="img/digital_payments_banner_illustration.png" width="100%" />
                              
                          </div>
                          <div class="col-md-6">
                              <?php if(isset($_GET['successful'])){ ?>
                              <p class="alert alert-success">
                                Operação realizada com sucesso.
                              </p>
                              <?php } ?>
                              <?php if(isset($_GET['error'])){ ?>
                              <p class="alert alert-danger">
                               Erro ao executaroperação. Fale com suporte.
                              </p>
                              <?php } ?>
                              <p>
                                  Para receber seus pagamentos como Parceiro, você precisa conectar seu Mercado Pago. <br />
                                  Nós trabalhamos com Split de pagamentos. Assim quando sair uma venda pelo seu link de afiliado, você recebe sua comissão na hora, dentro do seu mercado pago.
                              </p>
                              <br />
                                <?php if($access_mp_af <1){ ?>
                                 <a href="https://auth.mercadopago.com.br/authorization?client_id=2155770650472302&response_type=code&state=<?= $_SESSION['AFILIADO']['id']; ?>&platform_id=mp&redirect_uri=<?=SET_URL_PRODUCTION?>/parceiro/mp_nt" class="btn btn-info btn-lg" >Conectar</a>
                                <?php }else{ ?>
                                   <a href="<?=SET_URL_PRODUCTION?>/parceiro/renew_mp" class="btn btn-info btn-lg" >Renovar credencial</a>
                                <?php } ?>
                          </div>
                          <div class="col-md-3"></div>
                      </div>
                 </div>
             </div>


            </div>

           
          </div>
        </div>
      </div>
    </div>
    

    
    <?php include_once 'inc/footer.php'; ?>
