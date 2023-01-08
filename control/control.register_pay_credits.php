<?php

  @session_start();

  if(isset($_SESSION['SESSION_USER']) && isset($_POST)){

    require_once '../class/Conn.class.php';
    require_once '../class/User.class.php';
    require_once '../libs/MercadoPago/lib/mercadopago.php';
    require_once '../class/MercadoPago.class.php';
    require_once '../class/Gestor.class.php';
    require_once '../class/Revenda.class.php';
    require_once '../class/Faturas.class.php';
    require_once '../class/Logs.class.php';
    require_once '../class/Financeiro.class.php';

    $user    = new User();
    $mp      = new MercadoPago();
    $gestor  = new Gestor();
    $revenda = new Revenda();
    $faturas = new Faturas();
    $logs    = new Logs();
    $financeiro    = new Financeiro();

    $id_user            = $_SESSION['SESSION_USER']['id'];
    $dados_user         = $user->dados($id_user);
    $moeda              = $user->getmoeda($dados_user->moeda);
    $plano_user         = $gestor->plano($dados_user->id_plano);
    $tipo_pay           = $_POST['tipo_pay'] ? trim($_POST['tipo_pay']) : "mp";
    $valor_cred         = 10;
    $creditos           = trim($_POST['cred']);
    $plano_user->id     = $creditos;
    $plano_user->valor  = $revenda->convertMoney(2,$creditos*$valor_cred);
    $minimo = 6;


    $moeda = $faturas->getmoedaId($dados_user->moeda);
    

    if($creditos<$minimo){
      echo '{"erro":true,"msg":"Permitido comprar acima de 5 créditos","redirect":false}';
      die;
    }

    if($tipo_pay == "mp"){

      $ref = $faturas->create($plano_user,$dados_user,$moeda->nome,"Pendente","Pendente","creditos");
      if($ref){

        $link = $mp->payment($ref,"Compra de {$creditos} creditos - Gestor Lite",(float)$revenda->convertMoney(1,$plano_user->valor));

        if($link){
          echo '{"erro":false,"msg":"'.$link.'"}';
          die;
        }else{
          echo '{"erro":true,"msg":"Recomece o pagamento, clique em \'Pagamentos\' no menu"}';
          die;
        }

      }else{
        echo '{"erro":true,"msg":"Não foi possivel gerar esta fatura no momento."}';
        die;
      }

  }else{

    $ref = $faturas->create($plano_user,$dados_user,"Pendente","Saldo em conta",1);
    if($ref){

        $saldo_user = $revenda->saldo_user($id_user,true);
        if($saldo_user>$revenda->convertMoney(1,$plano_user->valor) || $saldo_user==$revenda->convertMoney(1,$plano_user->valor)){

          if($revenda->change_saldo($id_user,$revenda->convertMoney(1,$plano_user->valor),false)){
            // add creditos
            if($revenda->creditos_rev_change($id_user,$plano_user->id,true)){
              // update fatura
                if($faturas->change_fat_status('Aprovado',$ref)){
                  echo '{"erro":false,"msg":"Você comprou '.$plano_user->id.' créditos"}';
                  $logs->log($id_user,"Comprou $plano_user->id créditos");
                  die;
                }else{
                  echo '{"erro":true,"msg":"Estamos passando por instabilidade, notifique este erro ao Suporte. ERRO:64-REGISTERPAYCREDITS"}';
                  die;
                }
            }else{
              echo '{"erro":true,"msg":"Estamos passando por instabilidade, notifique este erro ao Suporte. ERRO:62-REGISTERPAYCREDITS"}';
              die;
            }
          }else{
            echo '{"erro":true,"msg":"Estamos passando por instabilidade, notifique este erro ao Suporte. ERRO:60-REGISTERPAYCREDITS"}';
            die;
          }

        }else{
          $restante = $revenda->convertMoney(2,(str_replace('-','',$revenda->convertMoney(1,$plano_user->valor)-$saldo_user)));
          echo '{"erro":true,"msg":"Saldo insuficiente, junte mais '.$moeda->simbolo.' '.$restante.'"}';
          die;
        }
    }

  }


  }


?>
