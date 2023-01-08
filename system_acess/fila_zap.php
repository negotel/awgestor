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

 $list_contatos  = $gestor_class->list_contatos();
 $list_contatos3 = $gestor_class->list_contatos();

$num_comprovantes = $comprovantes_class->count_comp();

 if($list_contatos3){
     $num_contatos   = count($list_contatos3->fetchAll(PDO::FETCH_OBJ));
 }else{
     $num_contatos = 0;
 } 


 $num_fila_zap  = $whatsapi_class->count_fila();
 $list_fila_zap = $whatsapi_class->list_msgs_fila_2();


 if(isset($_GET['dados_fila'])){
     $fila = $whatsapi_class->dados_fila($_GET['dados_fila']);
     echo json_encode($fila);
     die;
 }

?>
<!doctype html>
<html lang="en">
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
        <h1 class="h2"> <i class="fa fa-whatsapp" ></i> Fila Send Zap <?= $num_fila_zap; ?> </h1>
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
            <h4>Fila de mensagens para enviar Whatsapp</h4>
        </div>
    <div class="card-body" >
      
      <div class="table-responsive">
        <table id="table_users2" class="">
          <thead>
            <tr>
              <th>Id</th>
              <th>User</th>
              <th>Destino</th>
              <th>Msg</th>
              <th>API</th>
              <th>Tipo</th>
              <th>Opção</th>
            </tr>
          </thead>
          <tbody>
              
        <?php if($num_fila_zap >0) {
    
            while($fila = $list_fila_zap->fetch(PDO::FETCH_OBJ)){

          ?>
        
            <tr <?php if($fila->importante == 1){ echo 'class="text-white bg-danger"';}?>>
              <td><?= $fila->id; ?></td>
              <td><a href="index.php?page=cliente&id=<?= $fila->id_user; ?>" ><?= $fila->id_user; ?></a></td>
              <td><?= $fila->destino; ?></td>
              <td><?= substr($fila->msg,0,20).'...'; ?></td>
              <td><?= $fila->api; ?></td>
              <td><?= $fila->tipo; ?></td>
              <td>
                  
                  <button onclick="view_fila(<?= $fila->id; ?>);" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#ver_fila" title="Ver">
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
<div class="modal fade" id="ver_fila" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Visualizar Msg Fila</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <div class="form-group" >
             <label>device_id</label>
             <input type="text" disabled class="form-control" placeholder="device_id" value="" name="device_id" id="device_id" />
         </div>
         <div class="form-group" >
             <label>id_user</label>
             <input type="text" disabled class="form-control" placeholder="id_user" value="" name="id_user" id="id_user" />
         </div>
         <div class="form-group" >
             <label>Destino</label>
             <input type="text" disabled class="form-control" placeholder="destino" value="" name="destino" id="destino" />
         </div>
         <div class="form-group" >
             <label>Api</label>
             <input type="text" disabled class="form-control" placeholder="api" value="" name="api_input" id="api_input" />
         </div>
         <div class="form-group" >
             <label>codigo</label>
             <input type="text" disabled class="form-control" placeholder="codigo" value="" name="codigo" id="codigo" />
         </div>
         <div class="form-group" >
             <label>Mensagem</label>
             <textarea rows="8" disabled class="form-control" id="msg" name="msg" ></textarea>
         </div>
         <div class="form-group" >
             <label>Cliente Id</label>
             <input type="text" disabled class="form-control" placeholder="id_cliente" value="" name="id_cliente" id="id_cliente" />
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
                "order": [[ 0, "asc" ]]
            } );
            
        } );

        
        function view_fila(id_fila){
            $.get('index.php?page=fila_zap&dados_fila='+id_fila,function(data){
                var fila_res = JSON.parse(data);
                $("#device_id").val(fila_res.device_id);
                $("#id_user").val(fila_res.id_user);
                $("#destino").val(fila_res.destino);
                $("#msg").val(fila_res.msg);
                $("#api_input").text(fila_res.api);
                $("#codigo").val(fila_res.codigo);
                $("#id_cliente").val(fila_res.id_cliente);
                $("#tipo").val(fila_res.tipo);
            });
        }

        
        
    </script>


 </body>
</html>
