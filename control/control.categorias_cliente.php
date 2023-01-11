<?php

@session_start();
require_once "../config/settings.php";
if (isset($_SESSION['SESSION_USER'])) {


    if (isset($_POST['type'])) {

        $type = $_POST['type'];

        require_once '../class/Conn.class.php';
        require_once '../class/User.class.php';
        require_once '../class/Clientes.class.php';
        require_once '../class/Logs.class.php';
        require_once '../class/Gestor.class.php';
        
        $user_c = new User();
        $user = $user_c->dados($_SESSION['SESSION_USER']['id']);
        $logs = new Logs();
        $gestor = new Gestor();
        $clientes_c = new Clientes();


        $num_categorias_possui = $clientes_c->count_categorias_clientes($_SESSION['SESSION_USER']['id']);
        $plano_user_gestor = $gestor->plano($user->id_plano);


        if ($type == "add") {

            if ($num_categorias_possui >= $plano_user_gestor->categorias_cliente) {
                echo '{"erro":true,"msg":"Atingiu o limite máximo de categorias para seu plano atual."}';
                die;
            } else {

                $cores[0] = "danger";
                $cores[1] = "primary";
                $cores[2] = "secondary";
                $cores[3] = "info";
                $cores[4] = "warning";
                $cores[5] = "marrom";
                $cores[6] = "green";
                $cores[7] = "roxo";
                $cores[8] = "verde2";


                if (isset($cores[$getCategoria->cor])) {
                    $back = $cores[$getCategoria->cor];
                } else {
                    $back = $getCategoria->cor;
                }

                $cor = $cores[rand(0, 8)];
                $nome = "Categoria " . ($num_categorias_possui + 1);
                $id_user = $_SESSION['SESSION_USER']['id'];

                $add = $clientes_c->add_categoria($id_user, $nome, $cor);

                if ($add) {
                    echo '{"erro":false,"msg":"Categoria adicionada"}';
                    die;
                } else {
                    echo '{"erro":true,"msg":"Desculpe, não foi possível criar a categoria no momento."}';
                    die;
                }

            }

        } else if ($type == "list") {

            $categorias = $clientes_c->list_categorias_clientes($_SESSION['SESSION_USER']['id']);

            if ($categorias) {

                $html = "";

                while ($cate = $categorias->fetch(PDO::FETCH_OBJ)) {

                    $clientes_num = $clientes_c->count_clientes_by_categoria($cate->id, $_SESSION['SESSION_USER']['id']);

                    $color_text['danger'] = "white";
                    $color_text['primary'] = "white";
                    $color_text['secondary'] = "white";
                    $color_text['info'] = "white";
                    $color_text['warning'] = "black";
                    $color_text["marrom"] = "white";
                    $color_text["green"] = "white";
                    $color_text["roxo"] = "white";
                    $color_text["verde2"] = "white";

                    $cores['danger'] = "#ec3541";
                    $cores['primary'] = "#0048ff";
                    $cores['secondary'] = "#dddddd";
                    $cores['info'] = "#2d87ce";
                    $cores['warning'] = "#fb9100";
                    $cores['marrom'] = "#6d2b19";
                    $cores['green'] = "#2bad18";
                    $cores['roxo'] = "#7922ff";
                    $cores['verde2'] = "#04fbb1";

                    if (isset($cores[$cate->cor])) {
                        $back = $cores[$cate->cor];
                    } else {
                        $back = $cate->cor;
                    }

                    $html .= '<div class="col-md-4">
                        <div id="card_cate_' . $cate->id . '" style="background-color:' . $back . '!important;" class="card text-white">
                            <div class="card-header">
                              <h5 onclick="rename_categoria(' . $cate->id . ')" id="title_categoria_' . $cate->id . '" class="text-white" >' . $cate->nome . ' <i class="fa fa-edit" ></i> </h5>
                              <input maxlength="20" type="text" id="input_categoria_' . $cate->id . '" onfocusout="save_name_categoria(' . $cate->id . ');" style="display:none;width: 100%;height: 33px;font-size: 20px;border: 0px;border-radius: 6px;text-align: center;" placeholder="Nome categoria" value="' . $cate->nome . '">
                            </div>
                            <div class="card-body">
                                 <span>' . $clientes_num . ' clientes</span>
                                 <span class="text-right"><i onclick="remove_categoria(' . $cate->id . ');" style="cursor:pointer;float: right;" class="fa fa-trash"></i></span>
                              <div class="card-footer" >
                                <input onchange="checkFilled(' . $cate->id . ');save_color_categoria(' . $cate->id . ');" type="color" style="width: 100%;height: 21px;" name="color_cate_' . $cate->id . '" value="' . $back . '" id="color_cate_' . $cate->id . '" />
                              </div>
                            </div>
                            </div>
                      </div>
                      
                      <script>
                        const inputEle_' . $cate->id . ' = document.getElementById("input_categoria_' . $cate->id . '");
                        inputEle_' . $cate->id . '.addEventListener("keyup", function(e){
                              var key = e.which || e.keyCode;
                              if (key == 13) { 
                                save_name_categoria(' . $cate->id . ');
                              }
                            });
                      </script>
                      
                      ';

                }

                echo $html;

            } else {
                echo '{"erro":true,"msg":"Desculpe, não foi possível listar suas categorias no momento."}';
                die;
            }

        } else if ($type == "remove") {

            if (isset($_POST['categoria'])) {

                $id = $_POST['categoria'];

                $remove = $clientes_c->remove_categoria($id, $_SESSION['SESSION_USER']['id']);

                if ($remove) {
                    echo '{"erro":false,"msg":"categoria removida"}';
                    die;
                } else {
                    echo '{"erro":true,"msg":"Desculpe, não foi possível remove a categoria no momento."}';
                    die;
                }
            }
        } else if ($type == "save") {

            if (isset($_POST['nome']) && isset($_POST['id'])) {

                $id = $_POST['id'];
                $nome = $_POST['nome'];

                $save = $clientes_c->update_categoria($id, $nome, $_SESSION['SESSION_USER']['id']);

                if ($save) {
                    echo '{"erro":false,"msg":"categoria atualizada"}';
                    die;
                } else {
                    echo '{"erro":true,"msg":"Desculpe, não foi possível atualizar a categoria no momento."}';
                    die;
                }
            }
        } else if ($type == "save_color") {

            if (isset($_POST['cor']) && isset($_POST['id'])) {

                $id = $_POST['id'];
                $cor = $_POST['cor'];

                $save = $clientes_c->update_categoria_cor($id, $cor, $_SESSION['SESSION_USER']['id']);

                if ($save) {
                    echo '{"erro":false,"msg":"categoria atualizada"}';
                    die;
                } else {
                    echo '{"erro":true,"msg":"Desculpe, não foi possível atualizar a categoria no momento."}';
                    die;
                }
            }
        }


    }

}

?>
