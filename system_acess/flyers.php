<?php

if(!isset($_SESSION['ADMIN_LOGADO'])){
     echo '<script>location.href="index.php?page=login";</script>';
     die;
 }


 $whatsapi_class = new Whatsapi();
 $comprovantes_class = new Comprovantes();
 $gestor_class = new Gestor();
 $traffic_class = new Traffic();
 
 $flyers_class = new Flyer();
 $num_flyers       = $flyers_class->count_flyer_prossing();

 $list_contatos  = $gestor_class->list_contatos();
 $list_contatos3 = $gestor_class->list_contatos();

 $list_flyers  = $flyers_class->list_flyer_all();

 $num_comprovantes = $comprovantes_class->count_comp();
 $num_traffic      = $traffic_class->count_traffic_prossing();
 

 if($list_contatos3){
     $num_contatos   = count($list_contatos3->fetchAll(PDO::FETCH_OBJ));
 }else{
     $num_contatos = 0;
 } 


 $num_fila_zap  = $whatsapi_class->count_fila();
 $list_fila_zap = $whatsapi_class->list_msgs_fila_2();


 if(isset($_GET['dados_flyer'])){
     $fila = $flyers_class->dados_flyer($_GET['dados_flyer']);
     echo json_encode($fila);
     die;
 }
 
 if(isset($_GET['entregue'])){
     
     $update = $flyers_class->entregueF($_GET['entregue'],$_GET['link']);
     if($update){
         echo '1';
     }else{
         echo '0';
     }
 }
  if(isset($_GET['aceita'])){
     $update = $flyers_class->updateStatus($_GET['aceita'],'Processando');
     if($update){
         echo '1';
     }else{
         echo '0';
     }
 }
 
 if(isset($_GET['recusar'])){
     $update = $flyers_class->recusarF($_GET['recusar'],$_GET['msg']);
     if($update){
         echo '1';
     }else{
         echo '0';
     }
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

    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/dashboard/">

    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/docs/4.5/dist/css/bootstrap.min.css" rel="stylesheet" >

    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">

      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"
            integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"/>
    	
    <meta name="theme-color" content="#563d7c">

<link href="<?=SET_URL_PRODUCTION?>/img/favicon.ico" rel="shortcut icon" />

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
      
      .active_sol{
          background:#9c39ff!important;
          color:#fff!important;
      }
      
      .active_sol a{
          color:#fff!important;
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
        <h1 class="h2">Solicitações para criação de banners</h1>
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
            <h4>Solicitações Flyers</h4>
        </div>
    <div class="card-body" >
      <div class="table-responsive">
            <table id="table_users2" class="">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Cliente</th>
                  <th>Data</th>
                  <th>Tipo</th>
                  <th>Status</th>
                  <th>Opção</th>
                </tr>
              </thead>
              <tbody>
                  
              <?php if($list_flyers){ ?>
        
        
                <?php while($flyer = $list_flyers->fetch(PDO::FETCH_OBJ)){ 
                
                
                $status['Pendente'] = '<span class="badge badge-secindary" >Pendente</span>'; 
                $status['Processando'] = '<span class="badge badge-warning" >Processando</span>';
                $status['Entregue'] = '<span class="badge badge-success" >Entregue</span>';
                $status['Recusado'] = '<span class="badge badge-danger" >Recusado</span>';
                
                
                
                ?>
            
                <tr <?php if($flyer->status == "Prossesando" || $flyer->status == "Pendente"){ echo 'class="active_sol" '; } ?> >
                  <td><?= $flyer->id; ?></td>
                  <td><a target="_blank" href="index.php?page=cliente&id=<?= $flyer->id_user; ?>" ><?= $flyer->id_user; ?></a></td>
                  <td><?= $flyer->data; ?></td>
                  <td><?= $flyer->type; ?></td>
                  <td><?= $status[$flyer->status]; ?></td>
                  <td>
                      
                      <button onclick="view_solicitacao(<?= $flyer->id; ?>);" class="btn btn-sm btn-info" data-toggle="modal" data-target="#ver_solicitacao" title="Ver">
                          <i class="fa fa-eye" ></i>
                      </button>
                      
                      
                      <?php if($flyer->link_download != NULL){ ?>
                      <a href="<?= $flyer->link_download; ?>" target="_blank" class="btn btn-sm btn-success" >
                          <i class="fa fa-link" ></i>
                      </a>
                      <?php }else{ ?>
                        <button onclick="$('#info_recusa_<?= $flyer->id; ?>').modal();" class="btn btn-sm btn-primary" >
                          <i class="fa fa-question" ></i>
                        </button>
                      <?php } ?>
                     
                  </td>
                </tr>
               
               
    
    
            <div class="modal fade" id="info_recusa_<?= $flyer->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Visualizar Solicitação</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                      <p>
                          <?= $flyer->info_adm; ?>
                      </p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                  </div>
                </div>
              </div>
            </div>
            
            
    
    
             <?php } } ?>
         
            </tbody>
           </table>
         </div>
        </div>
      </div>
    </main>
  </div>
</div>


<div class="modal fade" id="ver_solicitacao" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Visualizar Solicitação</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="form-group" >
              <input type="hidden" id="id_solicitacao" name="id_solicitacao" />
              <button style="display:none;" id="btn_entregue" onclick="mark_entregue();" class="btn btn-success" >Marcar como Entregue</button>
              <button style="display:none;" id="btn_aceita" onclick="aceita_flyer();" class="btn btn-info" >Aceitar Flyer</button>
              <button style="display:none;" id="btn_recusa" onclick="recusar_flyer();" class="btn btn-danger" >Recusar Flyer</button>
         </div>
         <div class="form-group" >
             <label><b>ID Cliente</b></label>
             <input type="text" disabled class="form-control" placeholder="id_user" value="" name="id_user" id="id_user" />
         </div>
          <div class="form-group" >
             <label><b>Cores</b></label>
             <input type="text" disabled class="form-control" placeholder="cores" value="" name="cores" id="cores" />
         </div>
         <div class="form-group" >
             <label><b>Prazo</b></label>
             <input type="text" disabled class="form-control" placeholder="prazo" value="" name="prazo" id="prazo" />
         </div>
          <div class="form-group" >
             <label><b>Modelo Exemplo</b></label>
             <input type="text" disabled class="form-control" placeholder="logo" value="" name="exemplo_modelo" id="exemplo_modelo" />
         </div>
         <div class="form-group" >
             <label><b>Logo</b></label>
             <input type="text" disabled class="form-control" placeholder="logo" value="" name="logo" id="logo" />
         </div>
         <div class="form-group" >
             <label><b>Imagens</b></label>
             <p style="background-color: #8409ffcf;padding: 13px;color: #fff;" id="imagens"></p>
         </div>
         <div class="form-group" >
             <label><b>Informações</b></label>
             <p style="background-color: #8409ffcf;padding: 13px;color: #fff;" id="informacoes"></p>
         </div>

         <div class="form-group" >
             <label><b>Data</b></label>
             <input type="text" disabled class="form-control" placeholder="data" value="" name="data" id="data" />
         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    
    <script>
       $(document).ready(function() {
           

             $('#table_users2').DataTable( {
                "order": [[ 0, "desc" ]]
            } );
            
        } );
        
        function recusar_flyer(){
            $(".btn").prop('disabled', true);
            
            var id = $('#id_solicitacao').val();

            var msg = prompt("Por favor, informe o motivo da recusa");
              if (msg != null) {
                  $.get('index.php?page=flyers&recusar='+id+'&msg='+msg,function(data){
                     if(data == 0){
                         alert('Erro ao recusar');
                         $(".btn").prop('disabled', false);
                     }else{
                         location.href="";
                     }
                     
                 });
             }

        }
        
        
        function aceita_flyer(){
            $(".btn").prop('disabled', true);
               var id = $('#id_solicitacao').val();
            
              $.get('index.php?page=flyers&aceita='+id,function(data){
                 if(data == 0){
                     alert('Erro ao aceita');
                     $(".btn").prop('disabled', false);
                 }else{
                     location.href="";
                 }
                 
             });
             

        }
        
        
        
        function mark_entregue(){
            $(".btn").prop('disabled', true);
            var id = $('#id_solicitacao').val();
            
            var link_d = prompt("Informe o link para download da arte");
             if (link_d != null) {
                 $.get('index.php?page=flyers&entregue='+id+'&link='+link_d,function(data){
                     if(data == 0){
                         alert('Erro ao marcar como entregue');
                         $(".btn").prop('disabled', false);
                     }
                    location.href=""; 
                 });
             }
        }

        
        function view_solicitacao(id){
            $(".btn").prop('disabled', true);
            $("#btn_aceita").hide();
            $("#btn_recusa").hide();
            $("#btn_entregue").hide();
                    
            $("#id_solicitacao").val(id);
            
            $.get('index.php?page=flyers&dados_flyer='+id,function(data){
                $(".btn").prop('disabled', false);
                
                var fila_res = JSON.parse(data);
                
                if(fila_res.status == "Pendente"){
                    $("#btn_aceita").show();
                    $("#btn_recusa").show();
                }
                
                if(fila_res.status == "Processando"){
                    $("#btn_entregue").show();
                }
                
                
                $("#id_user").val(fila_res.id_user);
                $("#cores").val(fila_res.cores_principal);
                $("#prazo").val(fila_res.prazo);
                $("#logo").val(fila_res.logo);
                $("#imagens").html(fila_res.imagens);
                $("#informacoes").html(fila_res.informacoes);
                $("#data").val(fila_res.data);
                $("#exemplo_modelo").val(fila_res.modelo_exemplo);
                
                $("#ver_solicitacao").modal('show');
                
            });
        }

        
        
    </script>


 </body>
</html>
