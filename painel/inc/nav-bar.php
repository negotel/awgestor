
 <?php

    $atendente[1] = "+553196352452";
    $atendente[2] = "+553196352452";
    
    if(!isset($whatsapi_class)){
        $whatsapi_class = new Whatsapi();
    }
    
    $wsapiStatus = $whatsapi_class->verific_device_situ($_SESSION['SESSION_USER']['id']);

?>
    
  <div class="page-wrapper chiller-theme toggled">
  <a id="show-sidebar" style="z-index: 99999999;height: 42px;font-size: 21px!important;" class="btn btn-sm btn-dark" href="#">
    <i class="fa fa-bars"></i>
  </a>
  <nav id="sidebar" class="sidebar-wrapper">
    <div style='-webkit-box-shadow: 0px 0px 16px -2px rgb(0 0 0 / 84%);box-shadow: 0px 0px 16px -2px rgb(0 0 0 / 84%);' class="sidebar-content">
      <div class="sidebar-brand">
        <a href="<?=SET_URL_PRODUCTION?>/painel" >Gestor Lite</a>
        <div id="close-sidebar">
          <i class="fa fa-times"></i>
        </div>
      </div>
      <div class="sidebar-header">
        <div class="user-pic">
          <img class="img-responsive img-rounded" src="https://www.gravatar.com/avatar/<?= md5($user->email); ?>?v=<?= date('dmyihs'); ?>" alt="User picture">
        </div>
        <div class="user-info">
          <span class="ussher-name"><?= explode(' ',$user->nome)[0]; ?>
            <strong><?= @end(explode(' ',$user->nome)); ?></strong>
          </span>
          <span class="user-role"><?= @$user->vencimento;?></span>
          <span class="user-status">
            <?php if(isset($ven_user)){ ?>h
            <i class="fa fa-circle text-danger"></i>
            <span>Inativo</span>
            <?php }else{ ?>
             <i class="fa fa-circle"></i>
             <span>Ativo</span>
            <?php } ?>
          </span>
        </div>
      </div>
      <!-- sidebar-header  -->
      
      <div class="sidebar-menu">
       <!--<div class="row">-->
       <!--     <div class="col-md-12">-->
       <!--         <a target="_blank" href="https://t.me/joinchat/U_FagQKJgrUEDt2V" ><img src="https://uploaddeimagens.com.br/images/003/325/796/full/321.png?1625700731" width="100%" /></a>-->
                <!--<a target="_blank" href="<?=SET_URL_PRODUCTION?>/vitalicio/" ><img src="https://uploaddeimagens.com.br/images/003/327/007/full/VITALICIO-SOCIO.png?1625769066" width="100%" /></a>-->
       <!--     </div>-->
       <!-- </div>-->
    
        <ul>
          <li class="header-menu">
            <span>General</span>
          </li>
         <li id="home" >
            <a href="home">
              <i class="fa fa-users"></i>
              <span>Clientes</span>
             
            </a>
          </li>
          
          <li id="whatsapi" >
            <a href="whatsapi">
              <i class="fa fa-whatsapp"></i>
              <span>WhatsAPI</span>
              <span class="badge badge-pill badge-success">new</span>
               
            </a>
          </li>
         
           <li id="chatbot" >
            <a href="chatbot">
              <i class="fa fa-rocket"></i>
              <span>Chat Bot</span>
            </a>
          </li>
          
          <li id="financeiro" >
            <a href="financeiro">
              <i class="fa fa-balance-scale"></i>
              <span> Financeiro</span>
            </a>
          </li>
          
          <li id="planos" >
            <a href="planos">
              <i class="fa fa-diamond"></i>
              <span> Planos </span>
            </a>
          </li>
          
           <li id="delivery-aut" >
            <a href="delivery-aut">
              <i class="fa fa-archive"></i>
              <span> Produtos Digitais </span>
            </a>
          </li>
          
           <li id="notify_gestor" >
            <a href="notify_gestor">
              <i class="fa fa-bell"></i>
              <span> Notify Gestor</span>
            </a>
          </li>
          
          <li id="gateways" >
            <a href="gateways">
              <i class="fa fa-dollar"></i>
              <span> Gateways Pay</span>
            </a>
          </li>
          
          
          <li class="header-menu">
            <span>Extras</span>
          </li>
          
           <li id="painel_cliente_conf" >
            <a href="painel_cliente_conf" >
              <i class="fa fa-user"></i>
              <span>Área do cliente </span>
            </a>
          </li>
        
          
           <li id="cart" >
            <a href="cart"  >
              <i class="fa fa-credit-card"></i>
              <span>Assinatura</span>
            </a>
          </li>
          
          <li id="pagamentos" >
            <a href="pagamentos"  >
              <i class="fa fa-coffee"></i>
              <span>Pagamentos</span>
            </a>
          </li>


          <li class="header-menu">
            <span>Suporte</span>
          </li>
          <li>
            <a href="https://ajuda.gestorlite.com/" target="_blank" >
              <i class="fa fa-book"></i>
              <span>Base de conhecimento</span>
            </a>
          </li>
          <li>
            <a href="<?=SET_URL_PRODUCTION?>/contato" target="_blank" >
              <i class="fa fa-phone"></i>
              <span>Contato</span>
            </a>
          </li>
          <!--<li>-->
          <!--  <a href="https://wa.me/<?= $atendente[rand(1,2)]?>" target="_blank">-->
          <!--    <i class="fa fa-whatsapp"></i>-->
          <!--    <span>Suporte Whatsapp</span>-->
          <!--  </a>-->
          <!--</li>-->
        </ul>
      </div>
      <!-- sidebar-menu  -->
    </div>
    <!-- sidebar-content  -->
    <div class="sidebar-footer">
      <a href="atualizacoes">
        <i class="fa fa-leaf"></i>
        <span class="badge badge-pill badge-warning notification">1</span>
      </a>
     


      <a href="configuracoes">
        <i class="fa fa-cog"></i>
        <!--<span class="badge-sonar"></span>-->
      </a>
      <a href="sair">
        <i class="fa fa-power-off"></i>
      </a>
    </div>
  </nav>
