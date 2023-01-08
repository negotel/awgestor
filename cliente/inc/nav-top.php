
   <!-- fixed-top-->
   <nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-light">
     <div class="navbar-wrapper">
       <div class="navbar-container content">
           
         <div class="collapse navbar-collapse show menu-mobi-personal" style="display:none!important;float:left!important;" id="navbar-mobile">


           <ul class="nav navbar-nav float-right">

             <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">             
             <span class="avatar"><i class="fa fa-bars" ></i>       <?php
                         if($cont_aviso>0){
                           echo "<span style='border-radius:50px;' class='badge badge-danger' >{$cont_aviso}</span>";
                         }
                        ?>
     
             </span></a>
               <div class="dropdown-menu dropdown-menu-right">
                 <div class="arrow_box_right"><a class="dropdown-item" href="#"></span></a>
                   <div class="dropdown-divider"></div><a class="dropdown-item" href="<?= $link_gestor; ?>/<?= $_SESSION['PAINEL']['slug'];?>"><i class="ft-home"></i> Inicio</a>
                   <div class="dropdown-divider"></div><a class="dropdown-item" href="<?= $link_gestor; ?>/<?= $_SESSION['PAINEL']['slug'].'/planos';?>"><i class="fa fa-diamond"></i> Planos</a>
                   <div class="dropdown-divider"></div><a class="dropdown-item" href="<?= $link_gestor; ?>/<?= $_SESSION['PAINEL']['slug'].'/suporte';?>"><i class="la la-phone-square"></i> Suporte</a>
                   <div class="dropdown-divider"></div><a class="dropdown-item" href="<?= $link_gestor; ?>/<?= $_SESSION['PAINEL']['slug'].'/dados';?>"><i class="fa fa-play"></i> Dados</a>
                   <div class="dropdown-divider"></div><a class="dropdown-item" href="<?= $link_gestor; ?>/<?= $_SESSION['PAINEL']['slug'].'/avisos';?>"><i class="la la-bell-o"></i> Avisos
                    <?php
                         if($cont_aviso>0){
                           echo "<span style='border-radius:50px;' class='badge badge-danger' >{$cont_aviso}</span>";
                         }
                        ?>
                   </a>
                   <?php if(json_decode($_SESSION['PAINEL']['indicacao'])->status == 1){?>
                    <div class="dropdown-divider"></div><a class="dropdown-item" href="<?= $link_gestor; ?>/<?= $_SESSION['PAINEL']['slug'].'/indicacao';?>"><i class="fa fa-heart"></i> Indicar</a>
                   <?php } ?>
                 </div>
               </div>
             </li>
           </ul>
         </div>
         
         
         <div class="collapse navbar-collapse show" id="navbar-mobile">
           <ul class="nav navbar-nav mr-auto float-left">
             <li class="nav-item d-none d-md-block"><a class="nav-link nav-link-expand" href="#"><i class="ficon ft-maximize"></i></a></li>
           </ul>

           <ul class="nav navbar-nav float-right">

             <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">             <span class="avatar avatar-online"><img src="<?= $link_gestor; ?>/theme-assets/images/portrait/small/avatar-s-19.png" alt="avatar"><i></i></span></a>
               <div class="dropdown-menu dropdown-menu-right">
                 <div class="arrow_box_right"><a class="dropdown-item" href="#"><span class="avatar avatar-online"><img src="<?= $link_gestor; ?>/theme-assets/images/portrait/small/avatar-s-19.png" alt="avatar"><span class="user-name text-bold-700 ml-1"><?= explode(' ',$_SESSION['SESSION_CLIENTE']['nome'])[0]; ?></span></span></a>
                   <div class="dropdown-divider"></div><a class="dropdown-item" href="<?= $link_gestor; ?>/<?= $_SESSION['PAINEL']['slug'].'/profile';?>"><i class="ft-user"></i> Editar perfil</a>
                   <div class="dropdown-divider"></div><a class="dropdown-item" href="<?= $link_gestor; ?>/<?= $_SESSION['PAINEL']['slug'].'/sair';?>"><i class="ft-power"></i> Sair</a>
                 </div>
               </div>
             </li>
           </ul>
         </div>
       </div>
     </div>
   </nav>

   <!-- ////////////////////////////////////////////////////////////////////////////-->
