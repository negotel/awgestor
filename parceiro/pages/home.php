<?php

   setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
   date_default_timezone_set('America/Sao_Paulo');
   
  include_once 'inc/head.php';
  include_once 'inc/acess.php';
  
   function valorPorExtenso ( $number = '0', $decimals = 2, $int_only = false ) {
              	$number = (string)$number;
              	$simbol = null;
              	if ( $number > '99999999999999999999999' ) {
              		$number = bcdiv( $number, '1000000000000000000000000', $decimals);
              		$simbol = 'Y';
              	}
              	elseif ( $number > '999999999999999999999' ) {
              		$number = bcdiv( $number, '1000000000000000000000', $decimals);
              		$simbol = 'Z';
              	}
              	elseif ( $number > '999999999999999999' ) {
              		$number = bcdiv( $number, '1000000000000000000', $decimals);
              		$simbol = 'E';
              	}
              	elseif ( $number > '999999999999999' ) {
              		$number = bcdiv( $number, '1000000000000000', $decimals);
              		$simbol = 'P';
              	}
              	elseif ( $number > '999999999999' ) {
              		$number = bcdiv( $number, '1000000000000', $decimals);
              		$simbol = 'T';
              	}
              	elseif ( $number > '999999999' ) {
              		$number = bcdiv( $number, '1000000000', $decimals);
              		$simbol = 'G';
              	}
              	elseif ( $number > '999999' ) {
              		$number = bcdiv( $number, '1000000', $decimals);
              		$simbol = 'M';
              	}
              	elseif ( $number > '999' ) {
              		$number = bcdiv( $number, '1000', $decimals);
              		$simbol = 'k';
              	}
              	if ( $int_only ) return (int)$number . $simbol;
              	return (int)$number . $simbol;
    }
   
   require_once '../class/Conn.class.php';
   require_once '../class/Afiliado.class.php';
   require_once '../class/Financeiro.class.php';
   require_once '../class/User.class.php';
   require_once '../class/Gestor.class.php';

   
   $af  = new Afiliado();
   $fin = new Financeiro();
   $usr = new User();
   $ges = new Gestor();

   // count indicados
   $indicados_total = $af->countIndicados($_SESSION['AFILIADO']['id']);
   
   // valor financeiro mes atual
   $valor_mes = $fin->soma_mes_atual_parceiro($_SESSION['AFILIADO']['id']);
   
   // nome mes atual
   $mes_atual = ucfirst(gmstrftime('%B'));
   
   // ultimas vendas
   $ultimas_vendas =  $fin->list_vendas($_SESSION['AFILIADO']['id'],10);

   
   
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
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
              </ol>
            </nav>

            <div class="pb-3">
              <h1>Oi <?= explode(' ',$_SESSION['AFILIADO']['nome'])[0]; ?>!</h1>
            </div>

            <div class="row">
                
            <div class="col-md-12 col-lg-6 d-flex">
                <img style="margin-bottom:10px;" src="img/img-dash.png" width="100%" />
            </div>


              <div class="col-md-12 col-lg-3 d-flex">
                <div class="card border-0 bg-primary text-white text-center mb-grid w-100">
                  <div class="d-flex flex-row align-items-center h-100">
                    <div class="card-icon d-flex align-items-center h-100 justify-content-center">
                      <i style="font-size:30px;" class="fa fa-users" ></i>
                    </div>
                    <div class="card-body">
                      <div class="card-info-title">Indicados Total</div>
                      <h3 class="card-title mb-0">
                        <?= valorPorExtenso($indicados_total);?>
                      </h3>
    
                    </div>

                  </div>
                </div>
              </div>

              <div class="col-md-12 col-lg-3 d-flex">
                <div class="card border-0 bg-primary text-white text-center mb-grid w-100">
                  <div class="d-flex flex-row align-items-center h-100">
                    <div class="card-icon d-flex align-items-center h-100 justify-content-center">
                        <i style="font-size:30px;" class="fa fa-money" ></i>
                    </div>
                    <div class="card-body">
                      <div class="card-info-title">Receita este mês</div>
                      <h3 class="card-title mb-0">
                      R$ <?= valorPorExtenso($valor_mes);?>
                      </h3>
                      <div class="card-footer">
                        <?= $mes_atual; ?>
                      </div>
                    </div>

                  </div>
                </div>
              </div>


            </div>

            <div class="row">

              <div style="margin-bottom:20px;" class="col-lg-4">
                <div class="input-group">
                 <input type="text" id="link_parceiro" class="form-control" placeholder="Link de Afiliado" value="https://glite.me/r/?ref=<?= $_SESSION['AFILIADO']['id']; ?>" >
                 <div class="input-group-append">
                   <button class="btn btn-outline-secondary" onclick="link_parceiro();" type="button">Copiar</button>
                 </div>
               </div>
               <small>Compartilhe seu link de parceiro <span class="text-success" id="copy_info"></span> </small>
               <script type="text/javascript">
                 function link_parceiro() {
                   var copyText = document.getElementById("link_parceiro");
                    copyText.select();
                    copyText.setSelectionRange(0, 99999);
                    document.execCommand("copy");
                    $("#copy_info").html('| Copiado !');
                    setTimeout(function(){
                      $("#copy_info").html('');
                    },3000);
                 }
               </script>
              </div>
              <div style="margin-bottom:20px;" class="col-lg-12">
              </div>

              <div class="col-lg-12">
                <div class="card">
                  <div class="card-header">
                    Últimas vendas
                  </div>
                  <div class="card-body">
                    <div class="table-responsive-md">
                      <table class="table table-actions table-striped table-hover mb-0">
                        <thead>
                          <tr>
                            <th scope="col">
                              <label class="custom-control custom-checkbox m-0 p-0">
                                <input type="checkbox" class="custom-control-input table-select-all">
                                <span class="custom-control-indicator"></span>
                              </label>
                            </th>
                            <th scope="col">Nome</th>
                            <th scope="col">Whatsapp</th>
                            <th scope="col">Email</th>
                            <th scope="col">Plano</th>
                            <th scope="col">Data</th>
                            <th scope="col">Comissão</th>
                          </tr>
                        </thead>
                        <tbody>
                            
                         <?php if($ultimas_vendas){ 
                         
                            function obfuscateEmail($email){
                                $em   = explode("@", $email);
                            
                                $name = implode(array_slice($em, 0, count($em)-1), '@');
                            
                                if(strlen($name)==1){
                                    return   '*'.'@'.end($em);
                                }
                            
                                $len  = floor(strlen($name)/2);
                            
                                return substr($name,0, $len) . str_repeat('*', $len) . "@" . end($em);
                            }
                         
                            while($vendas = $ultimas_vendas->fetch(PDO::FETCH_OBJ)){
                          
                             $cliente  = $usr->dados($vendas->user_id);
                             $plano    = $ges->plano($vendas->plano);
                         ?>
                            
                          <tr>
                            <th scope="row">
                              <label class="custom-control custom-checkbox m-0 p-0">
                                <input type="checkbox" class="custom-control-input table-select-row">
                                <span class="custom-control-indicator"></span>
                              </label>
                            </th>
                            <td><?= $cliente->ddi; ?>  <?= $cliente->telefone; ?></td>
                            <td><?= explode(' ',$cliente->nome)[0]; ?></td>
                            <td><?= $cliente->email;?></td>
                            <td><?= $plano->nome; ?></td>
                            <td><?= $vendas->data; ?></td>
                            <td><span class="badge badge-pill badge-success"> <i class="fa fa-plus" ></i> R$ <?= $vendas->valor; ?></span></td>
                          </tr>
            

                        <?php } }else{ ?>
                        
                          <tr class="text-center">
                            <th colspan="7" class="text-center">Nenhuma venda recente</th>
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
