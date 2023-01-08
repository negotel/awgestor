<?php 
 
 $gestor_class = new Gestor();
 
 
 $atualizacoes = $gestor_class->get_updates();
 
?>
<!-- Head and Nav -->
<?php include_once 'inc/head-nav.php'; ?>


    <!-- NavBar -->
    <?php include_once 'inc/nav-bar.php'; ?>

    <main class="page-content">
      
        <div class="container">
            
            <div class="row">
        
      <div class="col-md-12">
        <h1 class="h2">Acompanhe nossos updates <i class="fa fa-leaf" ></i> </h1>
      </div>
     
        <div class="col-md-12">
            <div class="main-timeline">

                <?php 
                
                    if($atualizacoes){
                        while($atualizacao = $atualizacoes->fetch(PDO::FETCH_OBJ)){ ?>
                        
                        <!-- start experience section-->
                        <div class="timeline">
                            <div class="icon"></div>
                            <div class="date-content">
                                <div class="date-outer">
                                    <span class="date">
                                    <span class="month"><?= $gestor_class->tempo_corrido($atualizacao->data); ?></span>
                                    <span class="year"><?= date('d/m/Y', strtotime($atualizacao->data)); ?></span>
                                    </span>
                                </div>
                            </div>
                            <div class="timeline-content">
                                <h5 class="title"><?= $atualizacao->nome; ?></h5>
                                <p class="description">
                                    <?= $atualizacao->texto; ?>
                                </p>
                            </div>
                        </div>
                        <!-- end experience section-->

                    <?php } } ?>
                    

                    </div>
             </div>

    </main>
  </div>
</div>

 <!-- footer -->
 <?php include_once 'inc/footer.php'; ?>
