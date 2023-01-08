<?php

  $whatsapi_class = new Whatsapi();
  $list_fila_msgs = $whatsapi_class->list_msgs_fila_user($user->id);
  $list_msg_send  = $whatsapi_class->list_msgs($user->id);

  $clientes_class = new Clientes();

?>

<body class="crm_body_bg">

<?php include_once 'inc/head-nav.php'; ?>
<?php include_once 'inc/sidebar.php'; ?>


<section class="main_content dashboard_part">
<?php include_once 'inc/nav.php'; ?>
   <div class="main_content_iner ">
       <div class="container-fluid plr_30 body_white_bg pt_30">
           <div style="margin-bottom:20px;" class="row justify-content-center">
               <div class="col-12">
                   <div class="QA_section">
                       <div style="margin-bottom:10px;" class="white_box_tittle list_header">
                           <h4>Whats API Registros

                             <svg style="width: 20px!important;top: -3px;position: relative;margin-left: 10px;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>

                           </h4>
                           <small>Cortesia de <i class="fa fa-heart"></i> <a target="_blank" href="https://api-whats.com/">api-whats.com</a> </small>
                       </div>
                   </div>
               </div>
               <div class="col-12">
                 <div style="margin-bottom:10px;" class="btn-toolbar ">
                   <div class="btn-group mr-3">
                     <button onclick="location.href='whatsapi';" class="btn btn-outline-primary" > <i class="fa fa-arrow-left"></i> Voltar</button>
                   </div>
                  </div>
               </div>
           </div>
         </div>

         <div class="container-fluid plr_30 body_white_bg pt_30">
           <div class="row justify-content-center">

               <div class="col-12">
                   <div class="QA_section">
                           <div class="row">
                             <div class="col-lg-12">
                               <div class="row">
                                 <div class="col-md-12">
                                   <h2 class="h2">Fila de mensagens <i class="fa fa-whatsapp"></i> </h2>
                                   <span>Acompanhe as mesagens que estão na fila para serem enviadas</span>
                                </div>

                                <div class="col-md-12">
                                  <div class="QA_table ">
                                      <!-- table-responsive -->
                                      <table class="table lms_table_active">
                                          <thead>
                                              <tr>
                                                  <th scope="col">Cliente</th>
                                                  <th scope="col">Previsão para envio</th>
                                                  <th scope="col">Mensagem</th>
                                                  <th scope="col">Remover</th>
                                              </tr>
                                          </thead>
                                          <tbody>

                                              <?php if($list_fila_msgs){ ?>


                                                <?php while($fila = $list_fila_msgs->fetch(PDO::FETCH_OBJ)){


                                                    $nome_cliente = "--------";
                                                    $zap_cliente = "--------";
                                                    $cliente_dados = $clientes_class->dados($fila->id_cliente);

                                                    if($cliente_dados){
                                                      $nome_cliente  = $cliente_dados->nome;
                                                      $zap_cliente   = $cliente_dados->telefone;
                                                    }

                                                $previsao = $whatsapi_class->calc_previsao_disparo($fila->id);


                                                ?>

                                                <tr>
                                                  <td><?= $nome_cliente. '<br /> <a class="text-primary" style="font-size:10px;" target="_blank" href="http://wa.me/'.$zap_cliente.'?text='.urlencode($fila->msg).'" >'.$zap_cliente.'</a>'; ?></td>
                                                  <td><?= date('d/m/Y H:i', $previsao);?></td>
                                                  <td>
                                                      <?= $fila->msg; ?>
                                                  </td>
                                                  <td>
                                                      <button type="button" onclick="removeFilaMsg(<?= $fila->id; ?>);" class="btn btn-sm btn-outline-danger" name="button">
                                                        <i class="fa fa-trash"></i>
                                                      </button>
                                                  </td>
                                                </tr>

                                                <?php } ?>

                                            <?php }  ?>

                                          </tbody>
                                      </table>
                                  </div>
                                </div>

                               </div>
                             </div>

                           </div>

                   </div>
               </div>
             </div>
         </div>
      </div>

       <div class="main_content_iner ">
           <div class="container-fluid plr_30 body_white_bg pt_30">
             <div class="row justify-content-center">
               <div class="col-12">
                   <div class="QA_section">
                           <div class="row">
                             <div class="col-lg-12">
                               <div class="row">
                                 <div class="col-md-12">
                                   <h2 class="h2">Logs de mensagens <i class="fa fa-whatsapp"></i> </h2>
                                   <span>Veja as ultimas 20 mensagens que a API enviou</span>
                                   <button style="margin-left:10px;" onclick="location.href='../control/control.export_ws_msg.php';" type="button" class="btn btn-sm btn-outline-primary"><i class="fa fa-download" ></i> Download</button>
                                </div>

                                <div class="col-md-12">
                                  <div class="QA_table ">
                                      <!-- table-responsive -->
                                      <table class="table lms_table_active">
                                          <thead>
                                              <tr>
                                                  <th scope="col">Destino</th>
                                                  <th scope="col">Data</th>
                                                  <th scope="col">Mensagem</th>
                                              </tr>
                                          </thead>
                                          <tbody>

                                              <?php if($list_msg_send){ ?>


                                                <?php while($msg = $list_msg_send->fetch(PDO::FETCH_OBJ)){


                                                ?>

                                                <tr>
                                                  <td><br /> <span class="text-primary" ><?= $msg->whatsapp; ?></span></td>
                                                  <td><?= $msg->data; ?> <?= $msg->hora; ?></td>
                                                  <td>
                                                      <?= $msg->msg; ?>
                                                  </td>
                                                </tr>

                                                <?php } ?>

                                            <?php }  ?>

                                          </tbody>
                                      </table>
                                  </div>
                                </div>

                               </div>
                             </div>

                           </div>

                   </div>
               </div>


           </div>
       </div>
   </div>
</div>




<?php include_once 'inc/footer.php'; ?>
