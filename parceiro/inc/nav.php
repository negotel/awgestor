<?php 

   require_once '../class/Conn.class.php';
   require_once '../class/Afiliado.class.php';
   $af  = new Afiliado();
   
   $num_n = $af->countNotify($_SESSION['AFILIADO']['id']);
   
   $notifys = $af->getNotifys($_SESSION['AFILIADO']['id']);

?>
<nav class="navbar navbar-expand justify-content-between fixed-top">
  <a class="navbar-brand mb-0 h1 d-none d-md-block" href="index.html">
    Parceiro Gestor Lite
  </a>


  <div class="d-flex flex-1 d-block d-md-none">
    <a href="#" class="sidebar-toggle ml-3">
      <i data-feather="menu"></i>
    </a>
  </div>

  <ul class="navbar-nav d-flex justify-content-end mr-2">
    <!-- Notificatoins -->
    <li onclick="reset_notify();" class="nav-item dropdown d-flex align-items-center mr-2">
      <a class="nav-link nav-link-notifications" id="dropdownNotifications" data-toggle="dropdown" href="#">
        <i class="oi oi-bell display-inline-block align-middle"></i>
        <?php if ($num_n != 0){ ?>
        <span class="nav-link-notification-number"><?= $num_n; ?></span>
        <?php } ?>
      </a>
      <div class="dropdown-menu dropdown-menu-right dropdown-menu-notifications" aria-labelledby="dropdownNotifications">
        <div class="notifications-header d-flex justify-content-between align-items-center">
          <span class="notifications-header-title">
            Notificações
          </span>
        </div>

        <div class="list-group">
            
            <?php if($num_n>0){ while($not = $notifys->fetch(PDO::FETCH_OBJ)){ ?>
         
              <a href="" class="list-group-item list-group-item-action">
                <p class="mb-1">
                    <?= $not->texto; ?>
                </p>
                <small><?= $not->data; ?></small>
              </a>
              
            <?php } }else{ ?>
             <a href="" class="list-group-item list-group-item-action">
               <p class="text-center">
                    Nenhuma notificação
                </p>
              </a>
            <?php } ?>
  
        </div>

        <div class="notifications-footer text-center">
         
        </div>
      </div>
    </li>
    
    <script>
        function reset_notify(){
            $.post('control/reset_not.php');
        }
    </script>
    
    <!-- Notifications -->
    <li class="nav-item dropdown">
      <a class="nav-link avatar-with-name" id="navbarDropdownMenuLink" data-toggle="dropdown" href="#">
        <img src="https://raw.githubusercontent.com/azouaoui-med/pro-sidebar-template/gh-pages/src/img/user.jpg" class="d-inline-block align-top" alt="">
      </a>
      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
        <a class="dropdown-item" href="<?=SET_URL_PRODUCTION?>/painel/configuracoes" target="_blank" >Meu Perfil</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item text-danger" href="sair">Sair</a>
      </div>
    </li>
  </ul>
</nav>
