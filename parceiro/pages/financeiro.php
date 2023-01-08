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

   
   $af  = new Afiliado();
   $fin = new Financeiro();

  // nome mes atual
   $mes_atual = ucfirst(gmstrftime('%B'));

   // receita mes a mes
   $meses = explode('&=&',$fin->mes_a_mes($_SESSION['AFILIADO']['id']));
   
   // receita ano a ano
   $anos = explode('|',$fin->dados_decada_af($_SESSION['AFILIADO']['id']));

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

             <div class="col-md-6">
                 <div class="card">
                     <canvas id="chart1" width="100%" ></canvas>
                 </div>
             </div>
             
               <div class="col-md-6">
                 <div class="card">
                     <canvas id="chart2" width="100%" ></canvas>
                 </div>
             </div>

            </div>

           
          </div>
        </div>
      </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.1.1/dist/chart.min.js" ></script>

    <script>
        var ctx = document.getElementById('chart1').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?= $meses[1]; ?>,
                datasets: [{
                    label: 'Receita Mês R$ ',
                    data: <?= $meses[0]; ?>,
                    fill: false,
                    borderWidth: 3,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.5
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        
        
        
        var ctx2 = document.getElementById('chart2').getContext('2d');
        var myChart2 = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: [<?= $anos[0]; ?>],
                datasets: [{
                    label: 'Receita Anual R$ ',
                    data: [<?= $anos[1]; ?>],
                    fill: false,
                    borderWidth: 3,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.5
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        
        
        </script>
    
    <?php include_once 'inc/footer.php'; ?>
