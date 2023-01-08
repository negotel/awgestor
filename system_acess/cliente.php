<?php

 if(!isset($_SESSION['ADMIN_LOGADO'])){
     echo '<script>location.href="index.php?page=login";</script>';
     die;
 }


 $whatsapi_class = new Whatsapi();
 $comprovantes_class = new Comprovantes();
 $user_class = new User();
 $gestor_class = new Gestor();
 
 $traffic_class = new Traffic();
$num_traffic   = $traffic_class->count_traffic_prossing();

$flyers_class = new Flyer();
$num_flyers   = $flyers_class->count_flyer_prossing();


 $num_fila_zap  = $whatsapi_class->count_fila();
 $num_comprovantes = $comprovantes_class->count_comp();
 
 
 if(!isset($_GET['id'])){
     echo '<script>location.href="<?=SET_URL_PRODUCTION?>/system/index.php?page=faturas";</script>';
     die;
 }else{
     $cliente = $user_class->dados($_GET['id']);

     if(!$cliente) return false;

     $plano_cliente = $gestor_class->plano($cliente->id_plano);
     
     
     
     
     if($cliente->vencimento != 0 && $cliente->vencimento != ""){
    
        $explodeData  = explode('/',$cliente->vencimento);
        $explodeData2 = explode('/',date('d/m/Y'));
        $dataVen      = $explodeData[2].$explodeData[1].$explodeData[0];
        $dataHoje     = $explodeData2[2].$explodeData2[1].$explodeData2[0];
    
        $Pvencimento = str_replace('/','-',$cliente->vencimento);
        $timestamp   = strtotime("-3 days",strtotime($Pvencimento));
        $venX        = date('d/m/Y', $timestamp);
    
        $timestamp   = strtotime("-2 days",strtotime($Pvencimento));
        $venY        = date('d/m/Y', $timestamp);
    
        $timestamp   = strtotime("-1 days",strtotime($Pvencimento));
        $venZ        = date('d/m/Y', $timestamp);
    
        if($dataVen == $dataHoje){
            $ven = "<b class='text-info'>{$cliente->vencimento}</b>";
        }
       if($dataHoje > $dataVen){
            $ven = "<b class='text-danger'>{$cliente->vencimento}</b>";
        }
        if($dataHoje < $dataVen && $venX != date('d/m/Y') && $venY != date('d/m/Y') && $venZ != date('d/m/Y')){
            $ven = "<b class='text-success'>{$cliente->vencimento}</b>";
        }
       if($venX == date('d/m/Y') || $venY == date('d/m/Y') || $venZ == date('d/m/Y')){
          $ven = "<b class='text-warning'>{$cliente->vencimento}</b>";
        }
      }else{
            $ven = "<span class='text-info'>Aguardando </span>";
      }
     
     
     
     
     
     
     
     
 }
 
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
        <h1 class="h2">Cliente [ <?= $cliente->nome; ?> ]</h1>
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
      
      <div class="row">
          
          <div style="margin-bottom:10px;" class="col-md-12">
              
              
              <div class="btn-goup">
                  <button onclick="location.href='index.php?page=faturas-user&user=<?= $cliente->id; ?>';" class="btn btn-info" ><i class="fa fa-file"></i> Ver faturas</button>
                  <button onclick="modal_confirm('index.php?page=home&delete_user=<?= $cliente->id; ?>','Deseja Deletar o cliente ?','bg-danger');" class="btn btn-danger" style="cursor:pointer;" ><i class="fa fa-trash" ></i> Remover  </button>
              </div>
              
          </div>
          
          <div style="margin-bottom:10px;" class="col-md-6">
              <div style="padding:10px;" class="card">
                  <div class="card-head">
                      <h3><?= $plano_cliente->nome;?></h3>
                  </div>
                  <div class="card-body">
                      <h3 class="text-success" >R$ <?= $plano_cliente->valor;?></h3>
                  </div>
              </div>
          </div>
          <div style="margin-bottom:10px;" class="col-md-6">
              <div style="padding:10px;" class="card">
                  <div class="card-head">
                      <h3>Vencimento</h3>
                  </div>
                  <div class="card-body">
                      <h3><?= $ven;?></h3>
                  </div>
                  
              </div>
          </div>
          
     <div class="col-md-12">
        <div class="card">
            <div class="card-body" >
              <div class="form-group" >
                  <input type="text" name="nome" id="nome" value="<?= $cliente->nome; ?>" placeholder="Nome" class="form-control" />
              </div>
              <div class="form-group" >
                  <input type="email" name="email" id="email" value="<?= $cliente->email; ?>" placeholder="Email" class="form-control" />
              </div>
              <div class="form-group" >
                  <input type="text" name="telefone" id="telefone" value="<?= $cliente->telefone; ?>" placeholder="Telefone" class="form-control" />
              </div>
              <div class="form-group" >
                  <input type="text" name="senha" id="senha" value="<?= $cliente->senha; ?>" placeholder="Senha" class="form-control" />
              </div>
              <div class="form-group" >
                  <input type="text" name="vencimento" id="vencimento" value="<?= $cliente->vencimento; ?>" placeholder="Vencimento" class="form-control" />
              </div>
              <div class="form-group" >
                   <button id="btn_save_cli" onclick="save_cliente();" class="btn btn-success btn-lg" style="width:100%!important;" >Salvar</button>
              </div>
          </div>
         </div>
     </div>
         
    </div>


    </main>
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
        
       function save_cliente(){
           
           $('#btn_save_cli').prop('disabled', true);
           $('#btn_save_cli').html('Aguarde <i class="fa fa-refresh fa-spin" ></i>');
            
            var dados_user_save = new Object();
           
            dados_user_save.nome = $("#nome").val();
            dados_user_save.email = $("#email").val();
            dados_user_save.telefone = $("#telefone").val();
            dados_user_save.senha = $("#senha").val();
            dados_user_save.vencimento = $("#vencimento").val();
            dados_user_save.id = <?= $cliente->id; ?>;
            dados_user_save.id_plano = <?= $cliente->id_plano; ?>;
            
            var json_dados = JSON.stringify(dados_user_save);
            
            $.post('index.php?page=home',{edite_user:true,dados:json_dados},function(data){
                var resposta = JSON.parse(data);
                if(resposta.success){
                    alert('Usuario atualizado');
                }else{
                    alert('Erro ao atualizar usuario');
                }
                
                $('#btn_save_cli').prop('disabled', false);
                $('#btn_save_cli').html('Salvar');
                location.reload();
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
