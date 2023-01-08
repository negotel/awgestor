 <?php
 
 $logs_class = new Logs();

  // buscar registros
  $registros = $logs_class->list_logs($_SESSION['SESSION_USER']['id']);

 ?>


<!-- Head and Nav -->
<?php include_once 'inc/head-nav.php'; ?>



    <!-- NavBar -->
    <?php include_once 'inc/nav-bar.php'; ?>

    <main class="page-content">
    
    <div class="container">
        
       <div class="row">
           
      <div class="col-md-12">
        <h1 class="h2"><?= $idioma->registros_de_atividade; ?> <i class="fa fa-bug" ></i> </h1>
        <span><?= $idioma->mostrados_ultimos_20; ?></span>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group mr-2">
            <button onclick="location.href='../control/download_logs.php';" type="button" class="btn btn-sm btn-outline-secondary"><i class="fa fa-download" ></i> Download</button>
          </div>
        </div>
      </div>
      <div class="col-md-12">
          <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th>Browser</th>
              <th><?= $idioma->data; ?></th>
              <th><?= $idioma->hora; ?></th>
              <th>User</th>
              <th><?= $idioma->atividade; ?></th>
            </tr>
          </thead>
          <tbody>

            <?php

                if($registros){

                while($log = $registros->fetch(PDO::FETCH_OBJ)){

                  if($log->browser == "desconhecido"){
                    $icon_b = "question";
                  }else if($log->browser == "Pagamento"){
                    $icon_b = "credit-card-alt";
                  }else{
                   $icon_b = $log->browser;
                  }



                ?>
                <tr>
                  <td> <i  title="<?= ucfirst($log->browser); ?>" class="fa fa-<?= $icon_b; ?>" ></i> <?= ucfirst($log->browser); ?></td>
                  <td><?= $log->data; ?></td>
                  <td><?= $log->hora; ?></td>
                  <td><?= $_SESSION['SESSION_USER']['nome']; ?></td>
                  <td><?= $log->atividade; ?></td>
                </tr>
              <?php } }else{ ?>
                <tr>
                  <td class="text-center" colspan="5" ><?= $idioma->nenhum_registro; ?></td>
                </tr>
              <?php } ?>

          </tbody>
        </table>
      </div>
      </div>
      </div>
      </div>
    </main>
  </div>
</div>

 <!-- footer -->
 <?php include_once 'inc/footer.php'; ?>
