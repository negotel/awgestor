<?php

 if(!isset($_SESSION['ADMIN_LOGADO'])){
     echo '<script>location.href="index.php?page=login";</script>';
     die;
 }
 
 $whatsapi_class = new Whatsapi();
 $comprovantes_class = new Comprovantes();
 $gestor_class = new Gestor();
 $faturas_class = new Faturas();
 
 $num_fila_zap  = $whatsapi_class->count_fila();
 $list_contatos  = $gestor_class->list_contatos();
 $list_contatos3 = $gestor_class->list_contatos();

 $num_comprovantes = $comprovantes_class->count_comp();
 
 $traffic_class = new Traffic();
 $num_traffic   = $traffic_class->count_traffic_prossing();
 
 $flyers_class = new Flyer();
$num_flyers   = $flyers_class->count_flyer_prossing();
 
 if($list_contatos3){
     $num_contatos   = count($list_contatos3->fetchAll(PDO::FETCH_OBJ));
 }else{
     $num_contatos = 0;
 }
 
 if(isset($_GET['delete_contato'])){
     if($gestor_class->delete_contato($_GET['delete_contato'])){
         $msg_hide = "Contato deletado";
         $color = "success";
     }else{
         $msg_hide = "Erro ao deletar contato";
         $color = "danger";
     }
     
     echo '<script>location.href="?page=contato&color_msg_hide='.$color.'&msg_hide='.$msg_hide.'";</script>';
 }
 
 

 if(isset($_GET['dados_contato'])){
     $contato = $gestor_class->dados_contato($_GET['dados_contato']);
     echo json_encode($contato);
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
<!--      <link href="--><?//=SET_URL_PRODUCTION?><!--/painel/css/dashboard.css" rel="stylesheet">-->
  </head>
  <body>
<?php require_once 'inc/nav.php'; ?>
<div class="container-fluid">
  <div class="row">
    <?php require_once 'inc/menu.php'; ?>
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"> <i class="fa fa-phone"></i> Contatos <?= $num_contatos; ?> </h1>
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
                <h4>Pessoas que entraram em contato</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table_users2" class="">
                      <thead>
                        <tr>
                          <th style="display:none;" >1</th>
                          <th>Id</th>
                          <th>Nome</th>
                          <th>Email</th>
                          <th>Telefone</th>
                          <th>Data</th>
                          <th>Msg</th>
                          <th>Cliente</th>
                          <th>Opção</th>
                        </tr>
                      </thead>
                      <tbody>
                          
                    <?php if($num_contatos >0) {
                
                        while($contato = $list_contatos->fetch(PDO::FETCH_OBJ)){
            
                              
                        $explo_data = explode('/',$contato->data);
                        $order_data = $explo_data[2].$explo_data[1].$explo_data[0];
                    
                    ?>
                    
                     <?php
                      if($contato->data != 0 && $contato->data != ""){
            
                        $explodeData  = explode('/',$contato->data);
                        $explodeData2 = explode('/',date('d/m/Y'));
                        $dataVen      = $explodeData[2].$explodeData[1].$explodeData[0];
                        $dataHoje     = $explodeData2[2].$explodeData2[1].$explodeData2[0];
            
                        $Pvencimento = str_replace('/','-',$contato->data);
                        $timestamp   = strtotime("-3 days",strtotime($Pvencimento));
                        $venX        = date('d/m/Y', $timestamp);
            
                        $timestamp   = strtotime("-2 days",strtotime($Pvencimento));
                        $venY        = date('d/m/Y', $timestamp);
            
                        $timestamp   = strtotime("-1 days",strtotime($Pvencimento));
                        $venZ        = date('d/m/Y', $timestamp);
            
                        if($dataVen == $dataHoje){
                            $ven = "<b class='text-success'>{$contato->data}</b>";
                        }
                       if($dataHoje > $dataVen){
                            $ven = "<b class='text-danger'>{$contato->data}</b>";
                        }
                        if($dataHoje < $dataVen && $venX != date('d/m/Y') && $venY != date('d/m/Y') && $venZ != date('d/m/Y')){
                            $ven = "<b class='text-success'>{$contato->data}</b>";
                        }
                       if($venX == date('d/m/Y') || $venY == date('d/m/Y') || $venZ == date('d/m/Y')){
                          $ven = "<b class='text-success'>{$contato->data}</b>";
                        }
                      }else{
                            $ven = "<span class='text-info'>Aguardando </span>";
                      }
            
                      ?>
                    
                        <tr>
                          <td style="display:none;" ><?= $order_data; ?></td>
                          <td><?= $contato->id; ?></td>
                          <td><?= $contato->nome; ?></td>
                          <td><?= substr($contato->email,0,10).'...'; ?></td>
                          <td><?= $contato->whatsapp; ?></td>
                          <td><?= $ven; ?></td>
                          <td><?= substr($contato->msg,0,20).'...'; ?></td>
                          <td><?= $contato->cliente; ?></td>
                          <td>
                              
                              <button onclick="view_contato(<?= $contato->id; ?>);" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#ver_contato" title="Ver">
                                  <i class="fa fa-eye" ></i>
                              </button>
                              <button onclick="modal_confirm('index.php?page=contato&delete_contato=<?= $contato->id; ?>','Deseja Deletar o contato ?','bg-danger');" class="btn btn-sm btn-danger" title="Remover">
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
<div class="modal fade" id="ver_contato" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <div class="form-group" >
             <label>Nome</label>
             <input type="text" disabled class="form-control" placeholder="Nome" value="" name="nome" id="nome" />
         </div>
         <div class="form-group" >
             <label>Email</label>
             <input type="email" disabled class="form-control" placeholder="Email" value="" name="email" id="email" />
         </div>
         <div class="form-group" >
             <label>Whatsapp</label>
             <input type="text" disabled class="form-control" placeholder="Telefone" value="" name="telefone" id="telefone" />
         </div>
         <div class="form-group" >
             <label>Data</label>
             <input type="text" disabled class="form-control" placeholder="Data" value="" name="data" id="data" />
         </div>
         <div class="form-group" >
             <label>Assunto</label>
             <input type="text" disabled class="form-control" placeholder="Assunto" value="" name="assunto" id="assunto" />
         </div>
         <div class="form-group" >
             <label>Mensagem</label>
             <textarea rows="8" disabled class="form-control" id="msg" name="msg" ></textarea>
         </div>
         <div class="form-group" >
             <label>Cliente ?</label>
             <input type="text" disabled class="form-control" placeholder="Cliente" value="" name="cliente" id="cliente" />
         </div>
          <div class="form-group" >
             <label>IP</label>
             <input type="text" disabled class="form-control" placeholder="Ip" value="" name="ip" id="ip" />
         </div>
          <div class="form-group" >
             <label>Cidade</label>
             <input type="text" disabled class="form-control" placeholder="Cidade" value="" name="cidade" id="cidade" />
         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
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
        
        function view_contato(contato){
            $.get('index.php?page=contato&dados_contato='+contato,function(data){
                var contato_res = JSON.parse(data);
                $("#nome").val(contato_res.nome);
                $("#email").val(contato_res.email);
                $("#telefone").val(contato_res.whatsapp);
                $("#assunto").val(contato_res.assunto);
                $("#msg").text(contato_res.msg);
                $("#cliente").val(contato_res.cliente);
                $("#data").val(contato_res.data);
                $("#ip").val(contato_res.ip);
                $("#cidade").val(contato_res.cidade);
            });
        }

        
        
    </script>


 </body>
</html>
