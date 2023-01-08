<div class="main-menu menu-fixed menu-light menu-accordion    menu-shadow " data-scroll-to-active="true" data-img="theme-assets/images/backgrounds/02.jpg">
  <div class="navbar-header">
    <ul class="nav navbar-nav">
      <li class="nav-item text-center" style="text-align:center;" >
            <img width="100" class="" alt="<?= $_SESSION['PAINEL']['nome'];?>" src="<?= $link_gestor; ?>/logo/<?= $_SESSION['PAINEL']['logo'];?>"/>
       </li>
      <li class="nav-item d-md-none"><a class="nav-link close-navbar"><i class="ft-x"></i></a></li>
    </ul>
  </div>
  <div class="main-menu-content">
    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
      <li class=" nav-item"><a href="<?= $link_gestor; ?>/<?= $_SESSION['PAINEL']['slug'];?>"><i class="ft-home"></i><span class="menu-title" data-i18n="">Inicio</span></a>
      </li>
      <li class=" nav-item"><a href="<?= $link_gestor; ?>/<?= $_SESSION['PAINEL']['slug'].'/planos';?>"><i class="fa fa-diamond"></i><span class="menu-title" data-i18n="">Planos</span></a>
      </li>
      <li class=" nav-item"><a href="<?= $link_gestor; ?>/<?= $_SESSION['PAINEL']['slug'].'/suporte';?>"><i class="la la-phone-square"></i><span class="menu-title" data-i18n="">Suporte</span></a>
      </li>
      <li class=" nav-item"><a href="<?= $link_gestor; ?>/<?= $_SESSION['PAINEL']['slug'].'/dados';?>"><i class="fa fa-play"></i><span class="menu-title" data-i18n="">Dados</span></a>
      </li>
      <li class=" nav-item"><a href="<?= $link_gestor; ?>/<?= $_SESSION['PAINEL']['slug'].'/avisos';?>"><i class="la la-bell-o"></i><span class="menu-title" data-i18n="">Avisos
        <?php
         if($cont_aviso>0){
           echo "<span style='border-radius:50px;' class='badge badge-danger' >{$cont_aviso}</span>";
         }
        ?>
      </span></a>
      </li>
      <?php 
        
        if(json_decode($_SESSION['PAINEL']['indicacao'])->status == 1){
        
      ?>
      <li class=" nav-item"><a href="<?= $link_gestor; ?>/<?= $_SESSION['PAINEL']['slug'].'/indicacao';?>"><i class="fa fa-heart"></i><span class="menu-title" data-i18n="">Indicar</span></a>
      </li>
      <?php } ?>
       <li class="divider"></li>
     
    </ul>
  </div>
  <div class="navigation-background"></div>
</div>
