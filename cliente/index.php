<?php
  
  require_once 'autoload.php';
  $link_gestor = "https://cliente.gestorlite.com/";

  if(isset($_GET['token'])){
      $_SESSION['token'] = trim($_GET['token']);
  }
  
  if(isset($_GET['plano'])){
      $_SESSION['plano'] = $_GET['plano'];
  }

 if(isset($_GET['login'])){
     $_SESSION['email_login'] = $_GET['login'];
 }
 
 if(isset($_COOKIE['panel_user'])){
     if(isset($_GET['url'])){
        $explo_url  = explode('/',$_GET['url']);
        if(isset($_SESSION['PAINEL'])){
          $panel_user = $_COOKIE['panel_user'];
          setcookie('panel_user', $panel_user, (time() + (30000 * 24 * 3600)));
        }else{
          $panel_user = $explo_url[0];
          setcookie('panel_user', $panel_user, (time() + (30000 * 24 * 3600)));
        }
      }else{
        if(isset($_SESSION['PAINEL'])){
          $panel_user = $_COOKIE['panel_user'];
          setcookie('panel_user', $panel_user, (time() + (30000 * 24 * 3600)));
        }else{
          include_once 'pages/404.php';
          exit;
        }
      }
     
 }else{

      if(isset($_GET['url'])){
        $explo_url  = explode('/',$_GET['url']);
        if(isset($_SESSION['PAINEL'])){
          $panel_user = $_SESSION['PAINEL']['slug'];
          setcookie('panel_user', $panel_user, (time() + (30000 * 24 * 3600)));
        }else{
          $panel_user = $explo_url[0];
          setcookie('panel_user', $panel_user, (time() + (30000 * 24 * 3600)));
        }
      }else{
        if(isset($_SESSION['PAINEL'])){
          $panel_user = $_SESSION['PAINEL']['slug'];
          setcookie('panel_user', $panel_user, (time() + (30000 * 24 * 3600)));
        }else{
          include_once 'pages/404.php';
          exit;
        }
      }
 }

    $clientes_class = new Clientes();
    $user_class = new User();
    $gestor_class = new Gestor();
    $gateways_class = new Gateways();

    // buscar painel
    $painel = $clientes_class->area_cli_dados($panel_user);


    if($painel != false){

      $user_dono  = $user_class->dados($painel->id_user);
      $plano_dono = $gestor_class->plano($user_dono->id_plano);

      // gate credentials Mercado Pago
       if($plano_dono->gateways){
             $plano_gate = 1;
             $mp_credenciais = $gateways_class->dados_mp_user($user_dono->id);
         }else{
             $mp_credenciais = new stdClass();
             $mp_credenciais->client_id = '';
             $mp_credenciais->client_secret = '';
             $plano_gate = 0;
         }

      $explodeData_user  = explode('/',$user_dono->vencimento);
      $explodeData2_user = explode('/',date('d/m/Y'));
      $dataVen_user      = $explodeData_user[2].$explodeData_user[1].$explodeData_user[0];
      $dataHoje_user     = $explodeData2_user[2].$explodeData2_user[1].$explodeData2_user[0];

      if($dataVen_user == $dataHoje_user || $dataHoje_user < $dataVen_user){
          $ven_user = false;
      }else if($dataHoje_user > $dataVen_user){
          $ven_user = true;
      }


      if($painel->situ_area == 1 && $plano_dono->mini_area_cliente == 1 && $ven_user == false){

      // criar sessao com os dados do painel
      $_SESSION['PAINEL']['nome']      = $painel->nome_area;
      $_SESSION['PAINEL']['logo']      = $painel->logo_area;
      $_SESSION['PAINEL']['slug']      = $painel->slug_area;
      $_SESSION['PAINEL']['situ']      = $painel->situ_area;
      $_SESSION['PAINEL']['suporte']   = $painel->text_suporte;
      $_SESSION['PAINEL']['id_user']   = $painel->id_user;
      $_SESSION['PAINEL']['indicacao'] = $painel->indicacao;
      $_SESSION['PAINEL']['planos_amostra']   = $painel->planos_amostra;
      
      function isJson($string) {
         json_decode($string);
         return (json_last_error() == JSON_ERROR_NONE);
        }
        
        
    if(isJson($painel->indicacao)){
        $_SESSION['PAINEL']['indicacao'] = $painel->indicacao;
    }else{
        $_SESSION['PAINEL']['indicacao'] = '{"status":"0","meses":"0"}';
    }

      if(!isset($_SESSION['LOGADO'])){
          
          if(isset($_GET['plano'])){
              header('LOCATION: login/?plano='.$_GET['plano']);
          }else if(isset($_GET['create'])){
              
              if(isset($_GET['ind'])){
                header('LOCATION: login/create?ind='.$_GET['ind']);
              }else{
                  header('LOCATION: login/create');
              }
                  
          }else{
            header('LOCATION: ../login');
          }

        

      }else{
          
         
          if(isset($_GET['plano'])){
                
                 require_once '../class/Conn.class.php';
                 require_once '../class/Clientes.class.php';
                 require_once '../class/Planos.class.php';
                     
                 $clientes = new Clientes();
                 $planos = new Planos();

                $plano = $planos->plano($_GET['plano']);
                
      
                if($plano){
            
                    $fatura = new stdClass();
                    $fatura->id_plano   = $plano->id;
                    $fatura->valor      = str_replace('R$','',str_replace(' ','',$plano->valor));
                    $fatura->data       = date('d/m/Y');
                    $fatura->status     = 'Pendente';
                    $fatura->id_cli     = $_SESSION['SESSION_CLIENTE']['id'];
                    $fatura->ref        = sha1(date('d/m/Y H:i:s'));
                    
                    $create = $clientes->create_fat($fatura);
                    
                    if($create){
                         echo '<script>location.href="?fat='.$fatura->ref.'"</script>';
                    }
                    
                }
                
            
          }
          

          
        if(isset($explo_url[1])){

            if($explo_url[0] == $_SESSION['PAINEL']['slug']){

              if($explo_url[1] != ""){

                if(is_file('pages/'.$explo_url[1].'.php')){
                  include_once 'pages/'.$explo_url[1].'.php';
                }else{
                  include_once 'pages/404.php';
                }

              }else{
                include_once 'pages/home.php';
              }




            }else{
              // Erro not found panel
              setcookie('panel_user');
            }

        }else{
          include_once 'pages/home.php';
        }

      }


    }else{
      // Erro not found panel
      include_once 'pages/404.php';
      setcookie('panel_user');
    }

    }else{
      // Erro not found panel
      if(isset($_SESSION['PAINEL'])){
        unset($_SESSION['PAINEL']);
      }
      include_once 'pages/404.php';
      setcookie('panel_user');
    }



?>
