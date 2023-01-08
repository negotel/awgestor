<?php

   // listar clientes

   $clientes_class = new Clientes();
   $planos_class = new Planos();
   $financeiro_class = new Financeiro();

   $num_cli = 0;
   $num_cliInad = 0;

   $count_cli = $clientes_class->count_clientes($_SESSION['SESSION_USER']['id']);
    if($count_cli){
        $num_cli = $count_cli;
    }

   $count_cliIn = $clientes_class->count_clientes_inadimplentes($_SESSION['SESSION_USER']['id']);
    if($count_cliIn){
        $num_cliInad = $count_cliIn;
    }

   $val = $financeiro_class->soma_mes_atual($_SESSION['SESSION_USER']['id']);
   $valores_mov  = explode('|',$val);

   // soma caixa atual
   $cx_at = ( $financeiro_class->convertMoney(1,$valores_mov[0]) - $financeiro_class->convertMoney(1,$valores_mov[1]) );


   $val_2 = $financeiro_class->soma_mes_anterior($_SESSION['SESSION_USER']['id']);
   $valores_mov_ant  = explode('|',$val_2);


   // soma caixa mes passado
   $cx_ant = ( $financeiro_class->convertMoney(1,$valores_mov_ant[0]) - $financeiro_class->convertMoney(1,$valores_mov_ant[1]) );


 ?>


 
<?php include_once 'inc/head-nav.php'; ?>
<?php include_once 'inc/sidebar.php'; ?>


<section class="main_content dashboard_part">
<?php include_once 'inc/nav.php'; ?>
    <div class="main_content_iner ">
        <div class="container-fluid plr_30 body_white_bg pt_30">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="single_element">
                        <div class="quick_activity">
                            <div class="row">
                                <div class="col-12">
                                    <div class="quick_activity_wrap">
                                        <div class="single_quick_activity">
                                            <h4>Total de clientes</h4>
                                            <h3><span class="counter"><?= $num_cli; ?></span> </h3>
                                            <p><b><?= explode(' ',$user->nome)[0];?></b>, seu total de clientes é este</p>
                                        </div>
                                        <div class="single_quick_activity">
                                            <h4>Clientes Inadimplentes</h4>
                                            <h3><span class="counter"><?= $num_cliInad; ?></span> </h3>
                                            <p>Clientes vencidos</p>
                                        </div>
                                        <div class="single_quick_activity">
                                            <h4>Caixa atual</h4>
                                            <h3><?= $moeda->simbolo; ?> <span class="counter"><?= $cx_at; ?></span> </h3>
                                            <p>Seu caixa hoje <b><?= explode(' ',$user->nome)[0];?></b></p>
                                        </div>
                                        <div class="single_quick_activity">
                                            <h4>Fechamento caixa, mês anterior</h4>
                                            <h3><?= $moeda->simbolo; ?> <span class="counter"><?= $cx_ant; ?></span> </h3>
                                            <p>Você fechou o mês anterior</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-xl-12">
                    <div class="white_box mb_30 min_430">
                        <div class="box_header  box_header_block ">
                            <div class="main-title">
                                <h3 class="mb-0" >Gastos e Ganhos</h3>
                                <span><?= date('Y'); ?></span>
                            </div>

                        </div>
                        <input id="data_bar_active" type="hidden" />
                        <input id="data_bar_active2" type="hidden" />
                        <div id="bar_active"></div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-12 col-xl-3 ">
                    <div class="white_box mb_30 min_430">
                        <div class="box_header  box_header_block">
                            <div class="main-title">
                                <h3 class="mb-0" >Clientes ativos</h3>
                            </div>
                        </div>
                        <div id="radial_2"></div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <input type="hidden" id="data_chart_porcentagem" />
                    <div class="white_box min_430">
                        <div class="box_header  box_header_block">
                            <div class="main-title">
                                <h3 class="mb-0" >Clientes inadimplentes</h3>
                            </div>
                        </div>
                        <div id="radial_1"></div>

                    </div>
                </div>
                <div class="col-lg-12 col-xl-6">
                    <div class="white_box mb_30 min_430">
                        <div class="box_header  box_header_block">
                            <div class="main-title">
                                <h3 class="mb-0" >Seus ganhos nos últimos 7 dias</h3>
                            </div>
                        </div>
                        <input type="hidden" value="" id="value_chart_seven" />
                        <canvas height="200" id="visit-sale-chart"></canvas>
                    </div>
                </div>


            </div>
        </div>
    </div>
<?php include_once 'inc/footer.php'; ?>
