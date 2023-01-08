
 <?php

    $atendente[1] = "+553196352452";
    $atendente[2] = "+553196352452";

    if(!isset($whatsapi_class)){
        $whatsapi_class = new Whatsapi();
    }

    $wsapiStatus = $whatsapi_class->verific_device_situ($_SESSION['SESSION_USER']['id']);

?>
            <!-- menu  -->
    <div class="container-fluid no-gutters">
        <div class="row">
            <div class="col-lg-12 p-0">
                <div class="header_iner d-flex justify-content-between align-items-center">
                    <div class="sidebar_icon d-lg-none">
                        <i class="ti-menu"></i>
                    </div>
                    <div class="serach_field-area">

                        </div>
                    <div class="header_right d-flex justify-content-between align-items-center">
                        <div class="header_notification_warp d-flex align-items-center">
                            <li>
                                <a href="<?=SET_URL_PRODUCTION?>/painel/atualizacoes"> <img src="img/icon/bell.svg" alt=""> </a>
                            </li>
                            <li>
                                <a href="#"> <img src="img/icon/msg.svg" alt=""> </a>
                            </li>
                        </div>
                        <div class="profile_info">
                            <img src="https://www.gravatar.com/avatar/<?= md5($user->email); ?>?v=<?= date('dmyihs'); ?>" alt="#">
                            <div class="profile_info_iner">
                                <p>Bem vindo</p>
                                <h5><?= end(explode(' ',$user->nome)); ?>, <?= explode(' ',$user->nome)[0]; ?></h5>
                                <div class="profile_info_details">
                                    <a href="<?=SET_URL_PRODUCTION?>/painel/configuracoes">Configurações <i class="ti-settings"></i></a>
                                    <a href="sair">Sair <i class="ti-shift-left"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <a style="z-index:9999;margin-left:39px;" class="btn btn-sm btn-primary" href="<?=SET_URL_PRODUCTION?>/painel/delivery-aut" >Usar versão anterior</a>

            </div>
        </div>
    </div>
    <!--/ menu  -->
