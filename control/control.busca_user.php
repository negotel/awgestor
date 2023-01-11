<?php

  @session_start();
require_once "../config/settings.php";
  if(isset($_SESSION['SESSION_USER'])){

    if($_SESSION['SESSION_USER']['id'] != ""){

      if(isset($_POST['busca'])){

        $busca = trim($_POST['busca']);

        require_once '../class/Conn.class.php';
        require_once '../class/Clientes.class.php';
        require_once '../class/Planos.class.php';
        require_once '../class/Gestor.class.php';
        require_once '../class/User.class.php';

        $clientes = new Clientes();
        $planos   = new Planos();
        $gestor   = new Gestor();
        $user     = new User();
        
        $dados_user = $user->dados($_SESSION['SESSION_USER']['id']);
        $plano_usergestor = $gestor->plano($dados_user->id_plano);
        

        $buscar = $clientes->busca($busca,$_SESSION['SESSION_USER']['id']);

        if($buscar){

          echo '<form class="" id="form_checkbox" action="../control/control.delete_clientes.php" method="POST">';

          while ($cli = $buscar->fetch(PDO::FETCH_OBJ)) {

            // buscar dados do plano
            $plano = $planos->plano($cli->id_plano);


              if($cli->vencimento != '0'){

                 // verificar data do vencimento
                 $explodeData  = explode('/',$cli->vencimento);
                 $explodeData2 = explode('/',date('d/m/Y'));
                 $dataVen      = $explodeData[2].$explodeData[1].$explodeData[0];
                 $dataHoje     = $explodeData2[2].$explodeData2[1].$explodeData2[0];

                 if($dataVen == $dataHoje){
                     $ven = "<b class='badge badge-warning'>{$cli->vencimento}</b>";
                 }else if($dataHoje > $dataVen){
                     $ven = "<b class='badge badge-danger'>{$cli->vencimento}</b>";
                 }
                 else if($dataHoje < $dataVen){
                     $ven = "<b class='badge badge-success'>{$cli->vencimento}</b>";
                 }
             }else{
               $ven = "<b class='badge badge-secondary'>Não definido</b>";
             }
             
                 $getCategoria = $clientes->get_categoria($cli->categoria);
                  if($getCategoria){
                      $colorCate = $getCategoria->cor;
                  }else{
                      $colorCate = "secondary";
                  }

             ?>

             <tr id="tr_<?= $cli->id; ?>" class="trs " >
                 
               <td>
                   <span class="bg-<?= $colorCate; ?>">&nbsp;</span>
                   <?= $cli->nome; ?>
               <?php if($cli->identificador_externo != NULL && $cli->identificador_externo != ""){?>
                    <br /><span style="font-size: 13px; margin: 0px;top: 0px!important;position: relative;color: gray;font-style: italic;">#<?= $cli->identificador_externo; ?></span>
                <?php } ?>
                </td>
               <td><?php if($cli->email == "vazio"){ echo $cli->email." <i style='font-size:10px;cursor:pointer;' title='ADICIONE UM EMAIL' class='text-danger fa fa-warning' ></i>";}else{ echo $cli->email; } ?></td>
               <td><?php if(@$cli->telefone == "vazio"){ echo @$cli->telefone." <i style='font-size:10px;cursor:pointer;' title='".@$idioma->adicione_um_telefone."' class='text-danger fa fa-warning' ></i>";}else{ echo '<a target="_blank" href="http://wa.me/'.@$cli->telefone.'" > <i class="fa fa-whatsapp"></i> '.@$cli->telefone.'</a>'; } ?></td>
               <td><?= $ven; ?></td>
               <td><?php if($plano){ echo $plano->nome; }else{ echo "<i style='cursor:pointer;' title='ADICIONE UM PLANO' class='text-danger fa fa-warning' ></i> "; }  ?></td>
               <td>
                 <button onclick="modal_send_zap(<?= $cli->id; ?>,'<?= $cli->nome; ?>','<?= $cli->telefone; ?>',<?php if($plano){ echo $plano->id; }else{ echo 'no'; } ?>);" title="COBRANÇA" type="button" class="btn-outline-primary btn btn-sm"  id="" > <i class="fa fa-paper-plane" ></i> </button>
                 <button <?php if($plano == false){ echo 'disabled'; } ?> onclick="renew_cli(<?= $cli->id; ?>,<?= $cli->id_plano; ?>);" title="RENOVAR" type="button" class="btn-outline-primary btn btn-sm  "  id="btn_renew_<?= $cli->id; ?>" > <i id="_btn_renew_<?= $cli->id; ?>" class="fa fa-refresh" ></i> </button>
                 <button onclick="edite_cliente(<?= $cli->id; ?>);" title="EDITAR" type="button" class="btn-outline-primary btn btn-sm btn-outline-primary"> <i class="fa fa-pencil" ></i> </button>
                 <button onclick="modal_del_cli(<?= $cli->id; ?>);" title="EXCLUIR" type="button" class="btn-outline-primary btn btn-sm  "> <i class="fa fa-trash" ></i> </button>
                 <button <?php if(@$plano_usergestor->faturas_cliente == 1){ ?> onclick="modal_faturas_cli(<?= $cli->id; ?>,'<?= $cli->nome; ?>','<?= $cli->email; ?>');" <?php }else{ echo 'onclick="alert(\'Faça Upgrade\');location.href=\'cart?upgrade\';"'; } ?> title="<?= @$idioma->registr_de_fats; ?>" type="button" class="btn-outline-primary btn btn-sm  "> <i class="fa fa-file" ></i> </button>

               </td>
             </tr>

             <?php
          }
        }else{
          echo '<tr><td class="text-center" colspan="7" >Nenhum cliente encontrado com "'.$busca.'" </td></tr></form>';
        }

      }else{
        echo '{"erro":true,"msg":"Request is required"}';
      }


    }else{
      echo '{"erro":true,"msg":"User not found"}';
    }

  }else{
    echo '{"erro":true,"msg":"403"}';
  }

?>
