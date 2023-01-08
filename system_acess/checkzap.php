<?php

 if(!isset($_SESSION['ADMIN_LOGADO'])){
     echo '<script>location.href="index.php?page=login";</script>';
     die;
 }
 
 $whatsapi_class = new Whatsapi();
 $comprovantes_class = new Comprovantes();
 $gestor_class = new Gestor();

 $traffic_class = new Traffic();
 $num_traffic   = $traffic_class->count_traffic_prossing();
 
 $flyers_class = new Flyer();
 $num_flyers   = $flyers_class->count_flyer_prossing();
 
 
 $num_fila_zap  = $whatsapi_class->count_fila();
 $num_comprovantes = $comprovantes_class->count_comp();

 $atualizacoes = $gestor_class->get_updates();

 $list_contatos3 = $gestor_class->list_contatos();
 if($list_contatos3){
 $num_contatos   = count($list_contatos3->fetchAll(PDO::FETCH_OBJ));
 }else{
     $num_contatos = 0;
 }
 

?>
<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Administrativo</title>
<link href="<?=SET_URL_PRODUCTION?>/img/favicon.ico" rel="shortcut icon" />

    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/dashboard/">

    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/docs/4.5/dist/css/bootstrap.min.css" rel="stylesheet" >

    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">

      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"
            integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"/>
    	
    <meta name="theme-color" content="#563d7c">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">
  </head>
  <body>
      <?php require_once 'inc/nav.php'; ?>


<div class="container-fluid">
  <div class="row">
    <?php require_once 'inc/menu.php'; ?>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"> <i class="fa fa-check" ></i> Checar conexão de um usuario</h1>
      </div>
      <?php if(isset($_GET['msg_hide'])){ ?>
      <div id="msg_hide" class="alert alert-<?= $_GET['color_msg_hide']?>" >
          <?= $_GET['msg_hide']; ?>
      </div>
      <script>
          setTimeout(function(){
              $("#msg_hide").hide(100);
          },5000);
      </script>
      <?php } ?>
      
       <div class="card">
        <div class="card-head">
            <h4>Check Whatsapp</h4>
        </div>
        <div class="card-body" >
            
          <div class="row">
              <div class="col-md-12 text-right" id="btn_recheck" style="display:none;" >
                  <button onclick="recheck();" class="btn btn-sm btn-info"> <i class="fa fa-check" ></i> Rechecar</button>
              </div>
              <div class="col-md-2" ></div>
              <div id="return-check" style="display:none;" class="col-md-8 text-center" ></div>
              <div id="form-check" class="col-md-8" >
                    <p>
                        Para maior precisão digite o ID
                    </p>
                    <div class="form-group" >
                        <input type="text" class="form-control" placeholder="Informe o ID ou Email do cliente" id="info_user" />
                    </div>
                    <div class="form-group" >
                        <button id="btnCheck" onclick="checkZap();" class="btn btn-lg btn-success" style="width:100%;" >Checar</button>
                    </div>
              </div>
              <div class="col-md-2" ></div>
          </div>
            
        </div>
      </div>
    </main>
  </div>
</div>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    
    <script>

     function recheck(){
         $("#btn_recheck").hide(100);
         $("#return-check").hide();
         $("#form-check").show();
     }
        

       function checkZap(){
           
            $("#btnCheck").prop('disabled', true);
            $("#btnCheck").html('Um momento jovem...');

           var infoCli = $("#info_user").val();
           $.post("control/checkzap.php",{check:infoCli},function(data){
               
               $("#btnCheck").prop('disabled', false);
               $("#btnCheck").html('Checar');
               $("#btn_recheck").show();
               
               var obj = JSON.parse(data);
               
               if(obj.erro){
                   
                   $("#form-check").hide(100);
                   $("#return-check").show();
                   
                   if(typeof obj.type != 'undefined'){
                       $("#return-check").html('<h5 class="text-danger" >'+obj.msg+'</h5><p><i class="fa fa-calendar" ></i> '+obj.date+'</p>');
                   }else{
                       $("#return-check").html('<h5 class="text-danger" >'+obj.msg+'</h5><img src="img/not-connected.png" width="50%;" /><p><i class="fa fa-calendar" ></i> '+obj.date+'</p>');
                   }
                   
                   
               }else{
                   
                   $("#form-check").hide(100);
                   $("#return-check").show();
                   $("#return-check").html('<h5 class="text-success" >'+obj.msg+'</h5><img src="img/connected.png" width="50%;" /><p><i class="fa fa-calendar" ></i> '+obj.date+'</p>');
                   
               }
               
           });
       }


        
        
    </script>


 </body>
</html>
