<?php

  setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
  date_default_timezone_set('America/Sao_Paulo');
   
  include_once 'inc/head.php';
  include_once 'inc/acess.php';
  
  require_once '../class/Conn.class.php';
  require_once '../class/Afiliado.class.php';
  require_once '../class/Gestor.class.php';

   
  $af  = new Afiliado();
  $ges = new Gestor();

  //get produto afiliado
  $planos_af = $af->getPlanosAf($_SESSION['AFILIADO']['id']);

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
                <li class="breadcrumb-item active" aria-current="page">Minhas comissões</li>
              </ol>
            </nav>

            <div class="pb-3">
              <h1>Oi <?= explode(' ',$_SESSION['AFILIADO']['nome'])[0]; ?>!</h1>
            </div>

            <div class="row">


            </div>

            <div class="row">

              <div class="col-lg-12">
                <div class="card">
                  <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-header-title">Minhas comissões</div>

                  </div>
                  <div class="card-body collapse show" id="card1">
                    <div class="table-responsive-md">
                      <table class="table table-actions table-striped table-hover mb-0">
                        <thead>
                          <tr>
                            <th scope="col">Plano</th>
                            <th scope="col">Valor</th>
                            <th scope="col">Comissão</th>
                          </tr>
                        </thead>
                        <tbody>
                            
                            
                            
                          <?php if($planos_af){
                             while($comissao_plano = $planos_af->fetch(PDO::FETCH_OBJ)){
                                 
                                 $plano = $ges->plano($comissao_plano->plano);
                                 
                          ?>
                          
                          <tr>
                            <td><?= $plano->nome; ?></td>
                            <td>R$ <?= $plano->valor; ?></td>
                            <td>R$ <?= $comissao_plano->valor; ?></td>
                          </tr>
                        <?php } }else{ ?>
                        
                         <tr>
                            <td class="text-center" colspan="3"><h4>Você ainda não tem nenhum plano comissionado. Entre em contato conosco para negociar sua comissão.<br /><br /> <i class="fa fa-phone"></i> 0800 000 0270 <br /> <i class="fa fa-whatsapp"></i> 31 9635-2452</h4></td>
                          </tr>
                        
                        <?php } ?>
                        
                        </tbody>
                      </table>
                    </div>
                </div>
              </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include_once 'inc/footer.php'; ?>
