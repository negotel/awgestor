<style>
    body {
        background-color: #191b1d;
    }

    li.nav-item {
        background-color: #9c39ff;
        color: #fff !important;
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
    }

    li a {
        color: #fff !important;
    }

    li a i {
        background: #fff;
        color: #9c39ff;
        padding: 5px;
        border-radius: 13px;
    }

    .card {
        box-shadow: 0px 0px 20px -4px rgb(95 88 103) !important;
        padding: 10px !important;
        border-radius: 28px !important;
        background-color: #191b1d;
    }

    .card-footer {
        border-top: 0px !important;
        border-radius: 39px !important;
    }

    .link_active {
        background-color: #fff;
        color: #9c39ff !important;
        border-radius: 21px;
    }

    main {
        background-color: #191b1d !important;
        color: #FFF !important;
    }

    table {
        color: #FFF !important;
    }

    .dataTable td {
        color: #fff !important;
    }

    table.dataTable tbody tr {
        background-color: #191b1d;

    }
</style>

<nav style="position:fixed;background-color: #9c39ff !important;min-height: 900px;" id="sidebarMenu"
     class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="sidebar-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?php if (isset($_GET['page'])) {
                    if ($_GET['page'] == "home") {
                        echo 'link_active';
                    }
                } ?> " href="?page=home">
                    <i class="fa fa-tachometer"></i>
                    Dashboard <span class="sr-only">(current)</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if (isset($_GET['page'])) {
                    if ($_GET['page'] == "contato") {
                        echo 'link_active';
                    }
                } ?>" href="?page=contato">
                    <i class="fa fa-phone"></i>
                    Contato <?php if ($num_contatos > 0) {
                        echo '<span class="badge badge-danger" >' . $num_contatos . '</span>';
                    } ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if (isset($_GET['page'])) {
                    if ($_GET['page'] == "comprovantes") {
                        echo 'link_active';
                    }
                } ?>" href="?page=comprovantes">
                    <i class="fa fa-upload"></i>
                    Comprovantes <?php if ($num_comprovantes > 0) {
                        echo '<span class="badge badge-danger" >' . $num_comprovantes . '</span>';
                    } ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if (isset($_GET['page'])) {
                    if ($_GET['page'] == "solicitacoes_traffic") {
                        echo 'link_active';
                    }
                } ?>" href="?page=solicitacoes_traffic">
                    <i class="fa fa-plane"></i>
                    Solic. de Tráfego <?php if ($num_traffic) {
                        echo '<span class="badge badge-danger" >' . $num_traffic . '</span>';
                    } ?>
                </a>
            </li>


            <li class="nav-item">
                <a class="nav-link <?php if (isset($_GET['page'])) {
                    if ($_GET['page'] == "flyers") {
                        echo 'link_active';
                    }
                } ?>" href="?page=flyers">
                    <i class="fa fa-crop"></i>
                    Criação banners <?php if ($num_flyers > 0) {
                        echo '<span class="badge badge-danger" >' . $num_flyers . '</span>';
                    } ?>
                </a>
            </li>


            <li class="nav-item">
                <a class="nav-link <?php if (isset($_GET['page'])) {
                    if ($_GET['page'] == "fila_zap") {
                        echo 'link_active';
                    }
                } ?>" href="?page=fila_zap">
                    <i class="fa fa-whatsapp"></i>
                    Fila Zap Send <?php if ($num_fila_zap > 0) {
                        echo '<span class="badge badge-info" >' . $num_fila_zap . '</span>';
                    } ?>
                </a>
            </li>


            <li class="nav-item">
                <a class="nav-link <?php if (isset($_GET['page'])) {
                    if ($_GET['page'] == "faturas") {
                        echo 'link_active';
                    }
                } ?>" href="?page=faturas">
                    <i class="fa fa-file"></i>
                    Faturas
                </a>
            </li>

            <?php if (!isset($_SESSION['SUB_ACCESS'])) { ?>

                <li class="nav-item">
                    <a class="nav-link <?php if (isset($_GET['page'])) {
                        if ($_GET['page'] == "financas") {
                            echo 'link_active';
                        }
                    } ?>" href="?page=financas">
                        <i class="fa fa-dollar"></i>
                        Ganhos
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php if (isset($_GET['page'])) {
                        if ($_GET['page'] == "atualizacoes") {
                            echo 'link_active';
                        }
                    } ?>" href="?page=atualizacoes">
                        <i class="fa fa-leaf"></i>
                        Atualizações
                    </a>
                </li>

            <?php } ?>

            <li class="nav-item">
                <a class="nav-link <?php if (isset($_GET['page'])) {
                    if ($_GET['page'] == "cupons") {
                        echo 'link_active';
                    }
                } ?>" href="?page=cupons">
                    <i class="fa fa-ticket"></i>
                    Cupons
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?php if (isset($_GET['page'])) {
                    if ($_GET['page'] == "checkzap") {
                        echo 'link_active';
                    }
                } ?>" href="?page=checkzap">
                    <i class="fa fa-check"></i>
                    Check Whatsapp
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" target="_blank" href="http://wsapi.in/w/qrcode.php?token=2f8cbc1b5b92ce32b422">
                    <i class="fa fa-plug"></i>
                    Connect Whatsapp
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if (isset($_GET['page'])) {
                    if ($_GET['page'] == "parceiros") {
                        echo 'link_active';
                    }
                } ?>" href="?page=parceiros">
                    <i class="fa fa-handshake-o"></i>
                    Criar parceiro
                </a>
            </li>


        </ul>


    </div>
</nav>