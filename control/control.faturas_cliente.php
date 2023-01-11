<?php

  @session_start();
require_once "../config/settings.php";
  $json = new stdClass();

  if(isset($_SESSION['SESSION_USER'])){


    if(isset($_POST['type']) && isset($_POST['id'])){

      $id   = trim($_POST['id']);
      $type = $_POST['type'];

      require_once '../class/Conn.class.php';
      require_once '../class/Clientes.class.php';
      require_once '../class/Gestor.class.php';
      require_once '../class/Planos.class.php';
      require_once '../class/User.class.php';
      require_once '../class/Logs.class.php';
      require_once '../class/Financeiro.class.php';

      $clientes   = new Clientes();
      $gestor     = new Gestor();
      $planos     = new Planos();
      $user       = new User();
      $financeiro = new Financeiro();
      $logs       = new Logs();
      $dados_user = $user->dados($_SESSION['SESSION_USER']['id']);
      $dados_cli  = $clientes->dados($id);

      if($dados_cli->id_user == $_SESSION['SESSION_USER']['id']){

            if($type == "list"){

              $list = $clientes->list_fat($id);

              if($list){


                while ($fat = $list->fetch(PDO::FETCH_OBJ)) {

                  $plano_fat = $planos->plano($fat->id_plano);

                  ?>

                  <tr>
                    <th scope="row"><?= $fat->id;?></th>
                    <td>
                        R$ <?= $fat->valor;?>
                        <input type="hidden" id="valor_fat_tale_<?= $fat->id;?>" value="<?= $fat->valor;?>" />
                    </td>
                    <td><?= $fat->data;?></td>
                    <td><?= $plano_fat->nome; ?></td>
                    <td>
                      <div class="form-group">
                        <select id="status_fat_<?= $fat->id;?>" onchange="update_status_fat(<?= $fat->id;?>,<?= $id;?>);" class="form-control form-control-sm" name="">
                          <option <?php if($fat->status == "Pendente" ){ echo "selected"; } ?> value="Pendente">Pendente</option>
                          <option <?php if($fat->status == "Pago" ){ echo "selected"; } ?> value="Pago">Pago</option>
                          <option <?php if($fat->status == "Rejeitado" ){ echo "selected"; } ?> value="Rejeitado">Rejeitado</option>
                          <option <?php if($fat->status == "Devolvido" ){ echo "selected"; } ?> value="Devolvido">Devolvido</option>
                        </select>
                      </div>
                    </td>
                    <td> <button id="btn_delete_fat<?= $fat->id;?>" title="REMOVER FATURA" type="button" class="btn btn-sm btn-outline-danger" name="button" onclick="delete_fat(<?= $fat->id;?>,<?= $id;?>);" ><i class="fa fa-trash" ></i></button> </td>
                  </tr>


              <?php }


              }else{

                echo '<tr><td colspan="6" class="text-center" >Nenhuma fatura</td></tr>';

              }

            }else if($type == "busca_plano"){
                
                
                $plano = $_POST['plano'];
                $dados_p = $planos->plano($plano);
                
                if($dados_p){
                    echo $dados_p->valor;
                }else{
                    echo '0,00';
                }
                
                
            }else if($type == "delete"){

              $idFat = $_POST['idfat'];

              $list = $clientes->delete_fat($idFat);
              if($list){
                $logs->log($_SESSION['SESSION_USER']['id'],"Deletou a fatura #{$idFat}");
                return true;
              }else{
                return false;
              }
            }else if($type == "create"){

              $dados = json_decode(trim($_POST['dados']));
              $ref   = sha1(uniqid().$dados->id_cli.date('d/m/Y H:i:s'));

              if($dados->id_cli != "" && $dados->id_plano != "" && $dados->valor != "" && $dados->data != "" && $dados->status != ""){
                  
                $dados->ref   = $ref;
                $dados->data  = date('d/m/Y', strtotime($dados->data));
                $dados->valor = str_replace('R$','',str_replace(' ','',$dados->valor));

                $create = $clientes->create_fat($dados);

                if($create){
                    
                    
                    if($dados->move == 1 && $dados->status == "Pago"){
                        
                        // adicionar movimentacao no financeiro
                        $finan = new stdClass();
                        $finan->id_user = $_SESSION['SESSION_USER']['id'];
                        $finan->tipo = 1;
                        $finan->data = date('d/m/Y');
                        $finan->hora = date('H:i');
                        $finan->valor = $dados->valor;
                        $finan->nota = "Adicionado referente a uma fatura";
                        
                        $financeiro->insert($finan);

                    }
                    
                    
                    
                    
                    
                    
                  $logs->log($_SESSION['SESSION_USER']['id'],"Criou uma nova fatura para {$dados_cli->nome}");
                  $json->erro = false;
                  $json->msg  = "Fatura criada com sucesso.";
                  echo json_encode($json);

                }else{

                  $json->erro = true;
                  $json->msg  = "Erro ao criar fatura, tente mais tarde.";
                  echo json_encode($json);

                }

              }else{
                $json->erro = true;
                $json->msg  = "Preencha todos os campos";
                echo json_encode($json);
              }

            }else if($type == "update_status"){

              $idFat = $_POST['idfat'];
              $status = $_POST['status'];
              $valor = $_POST['valor'];
              $finan = $_POST['finan'];
              
              if($finan == 1 && $status == "Pago"){
                        
                // adicionar movimentacao no financeiro
                $finan = new stdClass();
                $finan->id_user = $_SESSION['SESSION_USER']['id'];
                $finan->tipo = 1;
                $finan->data = date('d/m/Y');
                $finan->hora = date('H:i');
                $finan->valor = $valor;
                $finan->nota = "Adicionado referente a uma fatura";
                
                $financeiro->insert($finan);
    
            }
              

              $list = $clientes->update_fat_status($idFat,$status);
              if($list){

                $logs->log($_SESSION['SESSION_USER']['id'],"Alterou o status da fatura #{$idFat} para {$status}");

                $json->erro = false;
                $json->msg  = "Status Alterado";
                echo json_encode($json);
              }else{
                $json->erro = true;
                $json->msg  = "Erro ao alterar status";
                echo json_encode($json);
              }
            }

      }else{

        $json->erro = true;
        $json->msg  = "Not authorized";
        echo json_encode($json);

      }

    }else{
      $json->erro = true;
      $json->msg  = "Request is required";
      echo json_encode($json);
    }

  }else{
    $json->erro = true;
    $json->msg  = "403";
    echo json_encode($json);
  }

?>
