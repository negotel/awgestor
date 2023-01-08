<?php

 if(!isset($_SESSION['ADMIN_LOGADO'])){
     echo '<script>location.href="index.php?page=login";</script>';
     die;
 }
 
 
 $conn = new Conn();
 $pdo = $conn->pdo();
 
 $cupons = $pdo->query("SELECT * FROM `cod_promo` ");
 
 $cupons_n1 = $pdo->query("SELECT * FROM `cod_promo` ");
 $cupons_n = count($cupons_n1->fetchAll(PDO::FETCH_OBJ));

 $whatsapi_class = new Whatsapi();
 $comprovantes_class = new Comprovantes();
 $gestor_class = new Gestor();
 $financeiro_class = new Financeiro();
 
 $traffic_class = new Traffic();
 $num_traffic   = $traffic_class->count_traffic_prossing();

$flyers_class = new Flyer();
$num_flyers   = $flyers_class->count_flyer_prossing();
 
 if(isset($_GET['delete_cp'])){
     $id_cp = $_GET['delete_cp'];
     if($pdo->query("DELETE FROM `cod_promo` WHERE id='$id_cp' ")){
         echo '<script>location.href="?page=cupons&color_msg_hide=success&msg_hide=Removido com sucesso";</script>';
         die;
     }else{
         echo '<script>location.href="?page=cupons&color_msg_hide=danger&msg_hide=Erro ao remover";</script>';
         die;
     }
 }
 
 if(isset($_POST['add_cp'])){
     $valor = $_POST['valor'];
     $cupom = $_POST['cupom'];
     $validade = $_POST['validade'];
     
     if($pdo->query("INSERT INTO `cod_promo`(`codigo`, `validade`, `desconto`) VALUES ('$cupom','$validade','$valor')")){
         echo '?page=cupons&color_msg_hide=success&msg_hide=Adicionado com sucesso';
         die;
     }else{
         echo '?page=cupons&color_msg_hide=danger&msg_hide=Erro ao adicionar';
         die;
     }
     
 }
 
 $list_contatos  = $gestor_class->list_contatos();
 $list_contatos3 = $gestor_class->list_contatos();
 
 $list_faturas  = $gestor_class->list__faturas_user_pay();
 $list_faturas2  = $gestor_class->list__faturas_user_pay();
 
 $num_fila_zap  = $whatsapi_class->count_fila(); 
 $num_comprovantes = $comprovantes_class->count_comp();
 
 $valor_mes = $gestor_class->soma_mes_atual_gestor();
 
 if($list_contatos3){
     $num_contatos   = count($list_contatos3->fetchAll(PDO::FETCH_OBJ));
 }else{
     $num_contatos = 0;
 }
 
 if($list_faturas2){
     $num_faturas  = count($list_faturas2->fetchAll(PDO::FETCH_OBJ));
 }else{
     $num_faturas = 0;
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
        <div class="btn-gorup">
            <button onclick="add_novimentacao();" class="btn btn-info btn-sm" > <i class="fa fa-plus" ></i> Adicionar Cupom</button>
        </div>
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

    <div class="row" >
        <div class="col-md-12" >
           
            <div class="card">
                <div class="card-head">
                   <h4>Cupons</h4>   
                </div>
            <div class="card-body" >
                
           <div style="margin-bottom:50px;" class="table-responsive">
                <table id="table_mov" class="">
                  <thead>
                    <tr>
                      <th>Valor Desconto</th>
                      <th>Validade</th>
                      <th>Cupom</th>
                      <th>Opção</th>
                    </tr>
                  </thead>
                  <tbody>
                      
                <?php if($cupons_n>0) {
            
                    while($cp = $cupons->fetch(PDO::FETCH_OBJ)){
                        

                ?>

                    <tr>
                        
                      <td>R$ <?= $cp->desconto; ?></td>
                      <td><?= $cp->validade; ?></td>
                      <td><?= $cp->codigo; ?></td>
                      <td>
                          <button onclick="modal_confirm('index.php?page=cupons&delete_cp=<?= $cp->id; ?>','Deseja Deletar o cupom ?','bg-danger');" class="btn btn-sm btn-danger" title="Remover">
                              <i class="fa fa-trash" ></i>
                          </button>
                      </td>
                    </tr>
                   
                 <?php } }else{ ?> 
                 
                  <tr class="text-center">
                        
                          <td colspan="4" class="text-center">Nenhum cupom</td>
          
                    </tr>
                 
                 
                 <?php } ?>
                 
                  </tbody>
                </table>
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

<!-- Modal modal_nota_view -->
<div class="modal fade" id="modal_nota_view" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div id="header_color" class="modal-header">
        <h5 class="modal-title" id="title_confirm">Nota da movimentação</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="p_nota"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal movimentacao -->
<div class="modal fade" id="modal_add_mov" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div id="header_color" class="modal-header">
        <h5 class="modal-title" id="title_confirm">Adicionar um cupom</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <input type="number" placeholder="Valor" id="valor" class="form-control" />
            <small>somente numeros</small>
        </div>
        <div class="form-group">
           <input type="text" placeholder="dd/mm/aaaa" id="validade" class="form-control" />
        </div>
        <div class="form-group">
           <input type="text" placeholder="DIGITE AQUI" style="text-transform:uppercase;" id="cupom" class="form-control" />
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="button" onclick="add_mov_fun();" class="btn btn-primary text-white" id="btn_add_mov" >Adicionar</button>
      </div>
    </div>
  </div>
</div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="<?=SET_URL_PRODUCTION?>/painel/js/jquery.maskMoney.js" ></script>
    <script>
       $(document).ready(function() {
           

             $('#table_users2').DataTable( {
                
            } );
            
             $('#table_mov').DataTable( {
                 
            } );
            
            
            $("#valor").maskMoney({prefix:'R$ ', thousands:'.', decimal:',', affixesStay: true});
            
        } );
        

        
        function add_mov_fun(){
            
             $("#btn_add_mov").prop('disabled', true);
             $("#btn_add_mov").html('Aguarde <i class="fa fa-refresh fa-spin" ></i>');
            
            var valor = $("#valor").val();
            var validade = $("#validade").val();
            var cupom = $("#cupom").val();
            
            $.post('',{add_cp:true,valor:valor,validade:validade,cupom:cupom},function(data){
                   location.href=data;
                
            });
        }
        
        function add_novimentacao(){
            $("#modal_add_mov").modal('show');
        }
        
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
        
        
    </script>


 </body>
</html>
