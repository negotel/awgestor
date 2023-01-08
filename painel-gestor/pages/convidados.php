<?php

  if(isset($_GET['limit'])){
    $limit = $_GET['limit'] == "all" ? false : $_GET['limit'];
  }else{
    $limit = 50;
  }


   // listar $convidados
   
   $user_class_p = new User();

   $convidados = $user_class_p->list_convidados($_SESSION['SESSION_USER']['id']);

 ?>



<!-- Head and Nav -->
<?php include_once 'inc/head-nav.php'; ?>


    <!-- NavBar -->
    <?php include_once 'inc/nav-bar.php'; ?>
    
    <?php if(isset($_SESSION['SESSION_CVD'])){ ?>
      
      <div class="row text-center">
        <div class="col-md-12">
          <h2>Você não permissão para acessar está pagina</h2>
        </div>
      </div>
      
      
      <?php }else{ ?>

      <main class="page-content">
    
    <div class="container">
        
       <div class="row">
           
      <div class="col-md-12">
        <h2 class="h2">Membros da equipe</h2><br />
        <small>Membros da equipe podem acessar sua conta</small>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group mr-2">
            <button onclick="$('#modal_add_cvd').modal('show');" type="button" class="btn btn-sm btn-outline-secondary"><i class="fa fa-plus" ></i> <?= $idioma->adicionar_novo; ?></button>
          </div>
        </div>
      </div>
      <?php
       if(isset($_SESSION['INFO'])){
         echo '<div id="msg_hide" class="alert alert-secondary">'.$_SESSION['INFO'].'</div>';
         unset($_SESSION['INFO']);
       }
       

       ?>
       
   <div class="col-md-12">
          
      <div class="table-responsive">

        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th><?= $idioma->nome; ?></th>
              <th><?= $idioma->email; ?></th>
              <th><?= $idioma->senha; ?></th>
              <th></th>
            </tr>
          </thead>
          <tbody id="tbody_clientes" class="" >
            <form class="" id="form_checkbox" action="../control/control.delete_clientes.php" method="POST">
            <?php

               if($convidados){

                 while($cvd = $convidados->fetch(PDO::FETCH_OBJ)){

            ?>


            <tr class="trs " >
              <td><?= $cvd->nome; ?></td>
              <td><?= $cvd->email; ?></td>
              <td><a class="text-info" onclick="alert('<?= $cvd->senha; ?>');" style="cursor:pointer;" >****</a></td>
              <td>
                <button onclick="modal_del_cvd(<?= $cvd->id; ?>);" title="EXCLUIR" type="button" class="btn-outline-danger btn btn-sm  "> <i class="fa fa-trash" ></i> </button>
              </td>
            </tr>

          <?php } }else{ ?>

            <tr>
              <td class="text-center" colspan="6" >Não há nenhum membro da equipe</td>
            </tr>


          <?php } ?>

            </form>
          </tbody>
        </table>


      </div>
      </div>
      </div>
      </div>
    </main>
  </div>
</div>



<!--  Modal add clientes -->
<div class="modal fade" id="modal_add_cvd" tabindex="-1" role="dialog" aria-labelledby="TituloModalLongoExemplo" aria-hidden="true">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="Titutlo_modal_add_cliente">Novo Membro</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body" id="body_modal_add_cvd" >


          <div class="row">

            <div class="col-md-12">
              <span id="res_add" ></span>
           </div>

           <div class="col-md-12">
             <input type="text" class="form-control margin" id="nome_cvd" placeholder="<?= $idioma->nome; ?>">
           </div>
           
            <div class="col-md-12">
             <input type="text" class="form-control margin" id="email_cvd" placeholder="Email">
             <small id="response_email_add" ></small>
           </div>

           <div class="col-md-12">
             <input type="text" class="form-control margin" id="senha_cvd" placeholder="<?= $idioma->senha; ?>">
           </div>

          

     </div>

     <div class="modal-footer">
       <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $idioma->fechar; ?></button>
       <button type="button" onclick="add_cvd();" id="btn_add_cvd" class="btn btn-primary"><?= $idioma->adicionar; ?></button>
     </div>


   </div>
 </div>
</div>
</div>


<!--  Modal del clientes -->
<div class="modal fade" id="modal_del_cvd" tabindex="-1" role="dialog" aria-labelledby="Titutlo_modal_del_cvde" aria-hidden="true">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header bg-danger">
       <h5 class="modal-title text-white" id="Titutlo_modal_del_cvd">Deletar Membro</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body" id="body_modal_del_cvd" >

       <input type="hidden" name="id_del_cvd" id="id_del_cvd">

          <div class="row">

           <div class="col-md-12 text-center margin">

             <h4>
                 Deseja deletar o membro ?
             </h4>

           </div>

     </div>
     <div class="modal-footer">

       <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $idioma->cancelar; ?></button>
       <button type="button" onclick="del_cvd();" id="btn_del_cvd" class="btn btn-primary"><?= $idioma->deletar; ?></button>

     </div>


   </div>
 </div>
</div>
</div>

<script>

    function modal_del_cvd(id){
        $("#id_del_cvd").val(id);
        $("#modal_del_cvd").modal('show');
    }
    
    function del_cvd(){
        
        $("#btn_del_cvd").prop('disabled', true);
        $("#btn_del_cvd").html('Aguarde <i class="fa fa-refresh fa-spin" ></i>');
     
       var id_cvd =  $("#id_del_cvd").val();
            
        $.post('../control/control.convidado.php',{delete_cvd:"true",id_cvd:id_cvd},function(data){
                location.reload();
        });
    }


    function add_cvd(){
        
        $("#btn_add_cvd").prop('disabled', true);
        $("#btn_add_cvd").html('Aguarde <i class="fa fa-refresh fa-spin" ></i>');
        
        var add_cvd_ar = new Object();
        add_cvd_ar.nome = $("#nome_cvd").val();
        add_cvd_ar.email = $("#email_cvd").val();
        add_cvd_ar.senha = $("#senha_cvd").val();
        
        dados = JSON.stringify(add_cvd_ar);
        
        $.post('../control/control.convidado.php',{add_cvd:"true",dados:dados},function(data){
            
            var obj = JSON.parse(data);
            
            if(obj.erro == true){
                $("#res_add").addClass("text-danger");
                $("#res_add").html(obj.msg);
                setTimeout(function(){
                    $("#res_add").html('');
                },3000);
            }else{
                location.reload();
            }
            
            $("#btn_add_cvd").prop('disabled', false);
            $("#btn_add_cvd").html('Adicionar');
        
        });
        
    }
</script>

<?php } ?>

 <!-- footer -->
 <?php include_once 'inc/footer.php'; ?>
