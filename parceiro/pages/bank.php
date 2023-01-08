<?php

 include_once 'inc/head.php';
 $banks_l = json_decode(file_get_contents('src/json/banco_codigo.json'));

?>

  <body>
    <div class="adminx-container">
      <?php include_once 'inc/nav.php'; ?>
      <?php include_once 'inc/sidebar.php'; ?>

      <!-- Main Content -->
      <div class="adminx-content">
        <div class="adminx-main-content">
          <div class="container-fluid">
            <!-- BreadCrumb -->
            <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb adminx-page-breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Configurações</a></li>
                <li class="breadcrumb-item active"  aria-current="page">Conta bancária</li>
              </ol>
            </nav>

            <div class="pb-3">
              <h1>Configurar dados Conta bancária</h1>
            </div>

            <div class="row">
              <div class="col-lg-12">


                <div class="card mb-grid">
                  <div class="card-header">
                    <div class="card-header-title">Informe seus dados bancários</div>
                  </div>
                  <div class="card-body" style="padding:10px;">
                    <div class="form-group">
                      <label class="form-label">Selecione o banco</label>
                      <select name="select" class="form-control js-choice">
                        <?php
                            foreach ($banks_l as $bank) {
                             $selected = "";
                             if($bank->value == "260"){
                               $selected = "selected";
                             }
                             echo '<option '.$selected.' value="'.base64_encode($bank->value).'_'.base64_encode($bank->label).'" >'.$bank->value.' | '.$bank->label.'</option>';
                            }
                         ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label class="form-label">Agência</label>
                      <input type="text" class="form-control" name="agencia" id="agencia" placeholder="xxxxxx ou xxxxx-x" value="">
                      <small>Informe o digito se possuir</small>
                    </div>
                    <div class="form-group">
                      <label class="form-label">Conta</label>
                      <input type="text" class="form-control" name="conta" id="conta" placeholder="xxxxxx ou xxxxx-x" value="">
                      <small>Informe o digito se possuir</small>
                    </div>
                    <div class="form-group">
                      <label class="form-label">CPF ou CNPJ</label>
                      <input type="text" class="form-control" name="cpf_cnpj" id="cpf_cnpj" placeholder="000.000.000-00 ou 00.000.000/0000-00" value="">
                    </div>
                  </div>
                  <div class="card-footer">
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
      <!-- // Main Content -->
    </div>
    <!-- If you prefer vanilla JS these are the only required scripts -->
    <!-- script src="../dist/js/vendor.js"></script>
    <script src="../dist/js/adminx.vanilla.js"></script-->

   <?php include_once 'inc/footer.php'; ?>
