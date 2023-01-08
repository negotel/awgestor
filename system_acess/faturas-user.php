<?php

 if(!isset($_SESSION['ADMIN_LOGADO'])){
     echo '<script>location.href="index.php?page=login";</script>';
     die;
 }
 
 $whatsapi_class = new Whatsapi();
 $comprovantes_class = new Comprovantes();
 $gestor_class = new Gestor();
 $faturas_class = new Faturas();
 
 $traffic_class = new Traffic();
$num_traffic   = $traffic_class->count_traffic_prossing();

$flyers_class = new Flyer();
$num_flyers   = $flyers_class->count_flyer_prossing();

 $num_fila_zap  = $whatsapi_class->count_fila();
 $num_comprovantes = $comprovantes_class->count_comp();
 
  if(isset($_POST['edite_fat'])){
     $dados = json_decode($_POST['dados']);

     if($faturas_class->update_fat_admin($dados->id,$dados->valor,$dados->data,$dados->status)){
         echo json_encode(array('success' => true));
         die;
     }else{
          echo json_encode(array('success' => false));
         die;
     }
 }
 
 
 if(!isset($_GET['user'])){
     echo '<script>location.href="<?=SET_URL_PRODUCTION?>/system/index.php?page=home";</script>';
     die;
 }
 
 $list_faturas  = $faturas_class->list($_GET['user']);
 $list_faturas2 = $faturas_class->list($_GET['user']);

 $list_contatos3 = $gestor_class->list_contatos();
 if($list_contatos3){
 $num_contatos   = count($list_contatos3->fetchAll(PDO::FETCH_OBJ));
 }else{
     $num_contatos = 0;
 }

 
 if($list_faturas2){
     $num_faturas   = count($list_faturas2->fetchAll(PDO::FETCH_OBJ));
 }else{
     $num_faturas = 0;
 }
 
 if(isset($_GET['delete_fatura'])){
     if($faturas_class->delete_fatura($_GET['delete_fatura'])){
         
         if(is_file('../qrcodes/imgs/'.$_GET['delete_fatura'].'.png')){
             unlink('../qrcodes/imgs/'.$_GET['delete_fatura'].'.png');
         }
         
         
         $msg_hide = "Fatura deletada";
         $color = "success";
     }else{
         $msg_hide = "Erro ao deletar fatura";
         $color = "danger";
     }
     
     echo '<script>location.href="?page=faturas-user&user='.$_GET['user'].'&color_msg_hide='.$color.'&msg_hide='.$msg_hide.'";</script>';
 }
 
 

 if(isset($_GET['dados_fatura'])){
     $fatura = $faturas_class->dados($_GET['dados_fatura']);
     echo json_encode($fatura);
     die;
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
        <div class="card-head" >
            <h4>Faturas do cliente</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="table_users2" class="">
              <thead>
                <tr>
                  <th style="display:none;" >1</th>
                  <th>Id</th>
                  <th>Valor</th>
                  <th>Status</th>
                  <th>Data</th>
                  <th>Forma</th>
                  <th>Comprovante</th>
                  <th>Opção</th>
                </tr>
              </thead>
              <tbody>
                  
            <?php if($num_faturas >0) {
        
                while($fatura = $list_faturas->fetch(PDO::FETCH_OBJ)){
    
                switch ($fatura->status) {
                   case 'Pendente': $status = "<span class='badge badge-secondary' >Pendente</span>"; break;
                   case 'Aprovado': $status = "<span class='badge badge-success' >Aprovado</span>"; break;
                   case 'Devolvido': $status = "<span class='badge badge-danger' >Devolvido</span>"; break;
                   case 'Rejeitado': $status = "<span class='badge badge-danger' >Rejeitado</span>"; break;
                   case 'Análise': $status = "<span class='badge badge-warning' >Análise</span>"; break;
                   case 'Cancelado': $status = "<span class='badge badge-danger' >Cancelado</span>"; break;
                   case 'Mediação': $status = "<span class='badge badge-danger' >Mediação</span>"; break;
                   default: $status = "<span class='badge badge-info' >{$fatura->status}</span>"; break;
                 }
                 
                 switch ($fatura->forma) {
    
                   case 'Boleto': $icon_f = "<i class='fa fa-barcode' ></i>"; break;
                   case 'Cartão de crédito': $icon_f = "<i class='fa fa-credit-card' ></i>"; break;
                   case 'Saldo MP': $icon_f = "<i class='fa fa-handshake-o' ></i>"; break;
                   case 'Meu Saldo': $icon_f = "<i class='fa fa-money' ></i>"; break;
    
                   default: $icon_f = ""; break;
                 }


                    $url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
                    $url .= "://" . $_SERVER['HTTP_HOST'];
                    $url .= "/".explode("/", substr(str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER["SCRIPT_NAME"]), 0, -1))[1];
            ?>
            
            
                <tr>
                  <td><?= $fatura->id; ?></td>
                  <td>R$ <?= $fatura->valor; ?></td>
                  <td><?= $status; ?></td>
                  <td><?= $fatura->data; ?> - <?= $fatura->hora; ?></td>
                  <td><?= $icon_f.' '.$fatura->forma; ?>  </td>
                  <td><?php if($fatura->comprovante != '0'){ echo '<a target="_blank" href="'.$url.'/comprovantes/'.$fatura->comprovante.'" >Ver Comp <i class="fa fa-file" ></i></a>'; } ?></td>
                  <td>
                      
                      <button onclick="view_fatura(<?= $fatura->id; ?>,<?= $fatura->id_user; ?>);" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#ver_fatura" title="Ver">
                          <i class="fa fa-pencil" ></i>
                      </button>
                      <button onclick="modal_confirm('index.php?page=faturas-user&user=<?= $_GET['user'];?>&delete_fatura=<?= $fatura->id; ?>','Deseja Deletar a fatura ?','bg-danger');" class="btn btn-sm btn-danger" title="Remover">
                          <i class="fa fa-trash" ></i>
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
<div class="modal fade" id="ver_fatura" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Fatura</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          
           <input type="hidden" placeholder="Id" value="" name="id" id="id" />
           <div class="form-group" >
             <label>ID</label>
             <input disabled type="text" class="form-control" placeholder="Id" value="" name="id_fat" id="id_fat" />
         </div>
         
         <div class="form-group" >
             <label>Forma</label>
             <input disabled type="text" class="form-control" placeholder="Forma" value="" name="forma" id="forma" />
         </div>

         <div class="form-group" >
             <label>Valor</label>
             <input type="text" class="form-control" placeholder="Valor" value="" name="valor" id="valor" />
         </div>
         <div class="form-group" >
             <label>Data</label>
              <input type="text" class="form-control" placeholder="Data" value="" name="data" id="data" />
         </div>

          <div class="form-group" >
             <label>Status</label>
             <input type="text" class="form-control" placeholder="Status" value="" name="status" id="status" />
                 Pendente, Aprovado, Devolvido, Rejeitado, Análise, Cancelado, Mediação
         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-info" id="btn_save_fat" onclick="save_fat();" >Salvar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal confirm -->
<div class="modal fade" id="modal_confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div id="header_color" class="modal-header">
        <h5 class="modal-title" id="title_confirm"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="text-center modal-body">
        <center><h3 id="msg_confirm" ></h3></center>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <a type="button" class="btn btn-primary text-white" id="button_confirm" >Continuar</a>
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
        
        function modal_confirm(url,msg,bg){
            $("#header_color").removeClass();
            $("#header_color").addClass('modal-header '+bg);
            $("#title_confirm").html(' <i class="fa fa-warning" ></i> '+msg);
            $("#button_confirm").attr('href',url);
            $("#msg_confirm").html(msg);
            if(bg == "bg-danger"){
                $("#title_confirm").addClass('text-white');
            }else{
                $("#title_confirm").removeClass('text-white');
            }
            
            
            $("#modal_confirm").modal('show');
            
        }
        
        function save_fat(){
            
            $("#btn_save_fat").prop('disabled', true);
            
           var dados_fat_save = new Object();
           
            dados_fat_save.id = $("#id").val();
            dados_fat_save.valor = $("#valor").val();
            dados_fat_save.data = $("#data").val();
            dados_fat_save.status = $("#status").val();

            var json_dados = JSON.stringify(dados_fat_save);
            
            $.post('index.php?page=faturas-user',{edite_fat:true,dados:json_dados},function(data){
                var resposta = JSON.parse(data);
                if(resposta.success){
                    alert('Fatura atualizado');
                    location.reload();
                }else{
                    alert('Erro ao atualizar fatura');
                    location.reload();
                }
            });
        }
        
        function view_fatura(fat,user){
            $.get('index.php?page=faturas-user&user='+user+'&dados_fatura='+fat,function(data){
                var fatura_res = JSON.parse(data);
                $("#id").val(fatura_res.id);
                $("#forma").val(fatura_res.forma);
                $("#id_fat").val(fatura_res.id);
                $("#valor").val(fatura_res.valor);
                $("#status").val(fatura_res.status);
                $("#data").val(fatura_res.data);
            });
        }

        
        
    </script>


 </body>
</html>
