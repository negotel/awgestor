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
$num_flyers   = $flyers_class->count_flyer_prossing();

 $list_contatos  = $gestor_class->list_contatos();
 $list_contatos3 = $gestor_class->list_contatos();

 $list_traffic  = $traffic_class->list_traffic_all();

 $num_comprovantes = $comprovantes_class->count_comp();
 $num_traffic      = $traffic_class->count_traffic_prossing();

 if($list_contatos3){
     $num_contatos   = count($list_contatos3->fetchAll(PDO::FETCH_OBJ));
 }else{
     $num_contatos = 0;
 } 


 $num_fila_zap  = $whatsapi_class->count_fila();
 $list_fila_zap = $whatsapi_class->list_msgs_fila_2();


 if(isset($_GET['dados_traffic'])){
     $fila = $traffic_class->dados_traffic($_GET['dados_traffic']);
     echo json_encode($fila);
     die;
 }
 
 if(isset($_GET['entregue'])){
     $update = $traffic_class->updateStatus($_GET['entregue'],'Entregue');
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
        <h1 class="h2">Solicitações para gerar Trafégo</h1>
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
        <h4>Solicitações de Tráfego</h4>
    </div>
    <div class="card-body" >
      <div class="table-responsive">
            <table id="table_users2" class="">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Cliente</th>
                  <th>Data</th>
                  <th>Acessos</th>
                  <th>Link</th>
                  <th>Tipo</th>
                  <th>Status</th>
                  <th>Opção</th>
                </tr>
              </thead>
              <tbody>
                  
              <?php if($list_traffic){ ?>
        
        
                <?php while($traffic = $list_traffic->fetch(PDO::FETCH_OBJ)){ 
                
                
                $status['Processando'] = '<span class="badge badge-warning" >Processando</span>';
                $status['Entregue'] = '<span class="badge badge-success" >Entregue</span>';
                
                
                
                ?>
            
                <tr <?php if($traffic->status == "Processando"){ echo 'class="active_sol" '; } ?> >
                  <td><?= $traffic->id; ?></td>
                  <td><a target="_blank" href="index.php?page=cliente&id=<?= $traffic->id_user; ?>" ><?= $traffic->id_user; ?></a></td>
                  <td><?= $traffic->data; ?></td>
                  <td><?= $traffic->qtd_acesso; ?></td>
                  <td><a target="_blank" href="<?= $traffic->link; ?>" ><?= substr($traffic->link,0,25); if(strlen($traffic->link)>25){ echo '...'; } ?></a></td>
                  <td><?= $traffic->tipo_link; ?></td>
                  <td><?= $status[$traffic->status]; ?></td>
                  <td>
                      
                      <button onclick="view_solicitacao(<?= $traffic->id; ?>);" class="btn btn-sm btn-info" data-toggle="modal" data-target="#ver_solicitacao" title="Ver">
                          <i class="fa fa-eye" ></i>
                      </button>
                     
                  </td>
                </tr>
               
             <?php } } ?>
             
              </tbody>
            </table>
         </div>
        </div>
      </div>
    </main>
  </div>
</div>

<!-- Modal ver contato -->
<div class="modal fade" id="ver_solicitacao" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
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
             <button id="btn_entregue" onclick="mark_entregue();" class="btn btn-success" >Marcar como Entregue</button>
         </div>
         <div class="form-group" >
             <label>ID Cliente</label>
             <input type="text" disabled class="form-control" placeholder="id_user" value="" name="id_user" id="id_user" />
         </div>
         <div class="form-group" >
             <label>URL</label>
             <input type="text" disabled class="form-control" placeholder="link" value="" name="link" id="link" />
         </div>
         <div class="form-group" >
             <label>Tipo Link</label>
             <input type="text" disabled class="form-control" placeholder="tipo_link" value="" name="tipo_link" id="tipo_link" />
         </div>
         <div class="form-group" >
             <label>Origem</label>
             <input type="text" disabled class="form-control" placeholder="origem" value="" name="origem" id="origem" />
         </div>
         <div class="form-group" >
             <label>Pís</label>
             <input type="text" disabled class="form-control" placeholder="pais" value="" name="pais" id="pais" />
         </div>
         <div class="form-group" >
             <label>Keywords</label>
             <input type="text" disabled class="form-control" placeholder="keywords" value="" name="keywords" id="keywords" />
         </div>
         <div class="form-group" >
             <label>Qtd. Acesso</label>
             <input type="text" disabled class="form-control" placeholder="qtd_acesso" value="" name="qtd_acesso" id="qtd_acesso" />
         </div>
         <div class="form-group" >
             <label>Porcentagem DeskTop</label>
             <input type="text" disabled class="form-control" placeholder="percent_desktop" value="" name="percent_desktop" id="percent_desktop" />
         </div>
         <div class="form-group" >
             <label>Porcentagem Mobile</label>
             <input type="text" disabled class="form-control" placeholder="percent_mobile" value="" name="percent_mobile" id="percent_mobile" />
         </div>
         <div class="form-group" >
             <label>Data</label>
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
        
        
        function mark_entregue(){
            var id = $('#id_solicitacao').val();
             $.get('index.php?page=solicitacoes_traffic&entregue='+id,function(data){
                 if(data == 0){
                     alert('Erro ao marcar como entregue');
                 }
                location.href=""; 
             });
        }

        
        function view_solicitacao(id){
            $("#id_solicitacao").val(id);
            
            $.get('index.php?page=solicitacoes_traffic&dados_traffic='+id,function(data){
                var fila_res = JSON.parse(data);
                $("#id_user").val(fila_res.id_user);
                $("#link").val(fila_res.link);
                $("#tipo_link").val(fila_res.tipo_link);
                $("#origem").val(fila_res.origem);
                $("#keywords").text(fila_res.keywords);
                $("#status").val(fila_res.status);
                $("#qtd_acesso").val(fila_res.qtd_acesso);
                $("#percent_desktop").val(fila_res.percent_desktop+'%');
                $("#percent_mobile").val(fila_res.percent_mobile+'%');
                $("#data").val(fila_res.data);
                $("#pais").val(fila_res.pais);
                
            });
        }

        
        
    </script>


 </body>
</html>
