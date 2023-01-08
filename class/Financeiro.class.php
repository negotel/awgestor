<?php


/**
 *
 */
class Financeiro extends Conn
{


    function __construct()
    {
        $this->conn = new Conn;
        $this->pdo = $this->conn->pdo();
    }


    public function export_dados($data1, $data2, $user)
    {

        $query = $this->pdo->query("SELECT * FROM `financeiro` WHERE data BETWEEN '$data1' AND '$data2' AND id_user='$user'");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if (count($fetch) > 0) {

            $query = $this->pdo->query("SELECT id,tipo,data,hora,valor,nota FROM `financeiro` WHERE data BETWEEN '$data1' AND '$data2' AND id_user='$user' ORDER BY id DESC ");
            $fetch = $query->fetchAll(PDO::FETCH_OBJ);

            return (array)$fetch;

        } else {
            return false;
        }

    }

    public function getmoeda($id)
    {

        $query = $this->pdo->query("SELECT * FROM `clientes` WHERE id='$id' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);

        if (count($fetch) > 0) {

            $query = $this->pdo->query("SELECT * FROM `clientes` WHERE id='$id' LIMIT 1");
            $fetch = $query->fetch(PDO::FETCH_OBJ);

            $query = $this->pdo->query("SELECT * FROM `moeda` WHERE id='{$fetch->moeda}' LIMIT 1");
            $fetch = $query->fetch(PDO::FETCH_OBJ);
            return $fetch;


        } else {
            return false;
        }


    }

    public function list_admin($limit = false)
    {


        $lim = $limit ? $limit : 20;

        $query = $this->pdo->query("SELECT * FROM `financeiro_gestor`  ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if (count($fetch) > 0) {

            $query = $this->pdo->query("SELECT * FROM `financeiro_gestor` ORDER BY id DESC LIMIT $lim");
            return $query;

        } else {
            return false;
        }

    }


    public function vendas_day_admin($data)
    {

        $query = $this->pdo->query("SELECT * FROM `financeiro_gestor` WHERE data='$data' AND tipo='1'");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if (count($fetch) > 0) {

            $query = $this->pdo->query("SELECT * FROM `financeiro_gestor` WHERE data='$data' AND tipo='1' ORDER BY id DESC");
            $fetch = $query->fetchAll(PDO::FETCH_OBJ);
            if (count($fetch) > 0) {
                return $fetch;
            }
            return false;
        } else {
            return false;
        }

    }


    public function insert_admin($dados)
    {

        $query = $this->pdo->prepare("INSERT INTO `financeiro_gestor` (tipo,valor,data,nota ) VALUES (:tipo,:valor,:data,:nota) ");
        $query->bindValue(':tipo', $dados->tipo);
        $query->bindValue(':valor', str_replace(" ", "", str_replace("R$", "", str_replace("€", "", $dados->valor))));
        $query->bindValue(':data', $dados->data);
        $query->bindValue(':nota', $dados->nota);


        if ($query->execute()) {
            return true;
        } else {
            return false;
        }

    }


    public function insert($dados)
    {

        $query = $this->pdo->prepare("INSERT INTO `financeiro` (id_user,tipo,data,hora,valor,nota) VALUES (:id_user,:tipo,:data,:hora,:valor,:nota) ");
        $query->bindValue(':id_user', $dados->id_user);
        $query->bindValue(':tipo', $dados->tipo);
        $query->bindValue(':data', $dados->data);
        $query->bindValue(':hora', $dados->hora);
        $query->bindValue(':valor', str_replace(" ", "", str_replace("R$", '', str_replace("€", '', $dados->valor))));
        $query->bindValue(':nota', $dados->nota);


        if ($query->execute()) {
            return true;
        } else {
            return false;
        }

    }

    public function update($dados)
    {

        $query = $this->pdo->prepare("UPDATE `financeiro` SET tipo= :tipo, data= :data, hora= :hora, valor= :valor, nota= :nota WHERE id= :id");
        $query->bindValue(':tipo', $dados->tipo);
        $query->bindValue(':data', $dados->data);
        $query->bindValue(':hora', $dados->hora);
        $query->bindValue(':valor', str_replace(" ", "", str_replace("R$", "", str_replace("€", "", $dados->valor))));
        $query->bindValue(':nota', $dados->nota);
        $query->bindValue(':id', $dados->id);

        if ($query->execute()) {
            return true;
        } else {
            return false;
        }


    }

    public function remove_mov_admin($id)
    {
        $query = $this->pdo->query("DELETE FROM `financeiro_gestor` WHERE id='$id' ");
        if ($query) {
            return true;
        } else {
            return false;
        }
    }


    public function delete($id)
    {

        $query = $this->pdo->query("DELETE FROM `financeiro` WHERE id='$id' ");
        if ($query) {
            return true;
        } else {
            return false;
        }

    }


    public function detalhe($id)
    {
        $query = $this->pdo->query("SELECT * FROM `financeiro` WHERE id='$id' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if (count($fetch) > 0) {

            $query = $this->pdo->query("SELECT * FROM `financeiro` WHERE id='$id' LIMIT 1");
            $fetch = $query->fetch(PDO::FETCH_OBJ);
            return $fetch;

        } else {
            return false;
        }
    }

    public function list_vendas($user, $limit = false)
    {


        $lim = $limit ? $limit : 20;

        $query = $this->pdo->query("SELECT * FROM `vendas_parceiro` WHERE parceiro='$user' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if (count($fetch) > 0) {

            $query = $this->pdo->query("SELECT * FROM `vendas_parceiro` WHERE parceiro='$user' ORDER BY id DESC LIMIT $lim");
            return $query;

        } else {
            return false;
        }

    }

    public function list($user, $limit = false)
    {


        $lim = $limit ? $limit : 20;

        $query = $this->pdo->query("SELECT * FROM `financeiro` WHERE id_user='$user' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if (count($fetch) > 0) {

            $query = $this->pdo->query("SELECT * FROM `financeiro` WHERE id_user='$user' ORDER BY id DESC LIMIT $lim");
            return $query;

        } else {
            return false;
        }

    }

    public function list2($user)
    {


        $query = $this->pdo->query("SELECT * FROM `financeiro` WHERE id_user='$user' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if (count($fetch) > 0) {

            $query = $this->pdo->query("SELECT * FROM `financeiro` WHERE id_user='$user' AND tipo='1' ORDER BY id DESC ");
            return $query;

        } else {
            return false;
        }

    }

    public function charts($user)
    {

        $query = $this->pdo->query("SELECT * FROM `financeiro` WHERE id_user='$user' AND tipo='1' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if (count($fetch) > 0) {

            $query = $this->pdo->query("SELECT * FROM `financeiro` WHERE id_user='$user' AND tipo='1' ORDER BY id DESC ");
            return $query;

        } else {
            return false;
        }

    }


    public function update_graph_u($user, $orderm)
    {

        $order_existe = self::graph_order_existe($user);

        if ($order_existe) {
            // update
            $query = $this->pdo->query("UPDATE `order_graph_user` SET order_g='$orderm' WHERE id_user='$user' ");
            if ($query) {
                return true;
            } else {
                return false;
            }

        } else {
            // insert
            $query = $this->pdo->query("INSERT INTO `order_graph_user` (id_user,order_g) VALUES ('$user','$orderm') ");
            if ($query) {
                return true;
            } else {
                return false;
            }

        }


    }


    public function graph_order_existe($user)
    {

        $query = $this->pdo->query("SELECT * FROM `order_graph_user` WHERE id_user='$user' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);

        if (count($fetch) > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function graph_order($user)
    {

        $array_ordem = false;

        $query = $this->pdo->query("SELECT * FROM `order_graph_user` WHERE id_user='$user' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);

        if (count($fetch) > 0) {
            // possui ordem
            $query = $this->pdo->query("SELECT * FROM `order_graph_user` WHERE id_user='$user' ");
            $fetch = $query->fetch(PDO::FETCH_OBJ);

            if (explode(',', $fetch->order_g)) {
                $array_ordem = explode(',', $fetch->order_g);
            } else {
                $this->pdo->query("DELETE * FROM `order_graph_user` WHERE id_user='$user' ");
                $array_ordem = [
                    0 => '1',
                    1 => '2',
                    2 => '3',
                    3 => '4'
                ];
            }

        } else {
            // cria ordem padrão
            $array_ordem = [
                0 => '1',
                1 => '2',
                2 => '3',
                3 => '4'
            ];

        }

        return $array_ordem;

    }


    public function charts_g($user)
    {

        $query = $this->pdo->query("SELECT * FROM `financeiro` WHERE id_user='$user' AND tipo='2' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if (count($fetch) > 0) {

            $query = $this->pdo->query("SELECT * FROM `financeiro` WHERE id_user='$user' AND tipo='2' ORDER BY id DESC ");
            return $query;

        } else {
            return false;
        }

    }

    public function seven_mov($user)
    {

        $data2 = date('d/m/Y', strtotime('-6 days', strtotime(date('d-m-Y'))));
        $data1 = date('d/m/Y');

        $query = $this->pdo->query("SELECT * FROM `financeiro` WHERE data BETWEEN '$data2' AND '$data1' AND id_user='$user' AND tipo='1'");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if (count($fetch) > 0) {

            $query = $this->pdo->query("SELECT * FROM `financeiro` WHERE data BETWEEN '$data2' AND '$data1' AND id_user='$user' AND tipo='1'");
            return $query;

        } else {
            return false;
        }

    }

    public function mes_a_mes($user)
    {

        $ano_atual = date('Y');
        $mes_atual = date('m');

        $meses = array(
            '01' => 0,
            '02' => 0,
            '03' => 0,
            '04' => 0,
            '05' => 0,
            '06' => 0,
            '07' => 0,
            '08' => 0,
            '09' => 0,
            '10' => 0,
            '11' => 0,
            '12' => 0
        );

        $query = self::list_vendas($user);

        if ($query) {

            while ($mov = $query->fetch(PDO::FETCH_OBJ)) {

                $ano_mov = explode('/', $mov->data)[2];
                $mes_mov = explode('/', $mov->data)[1];

                if ($ano_mov == $ano_atual) {

                    if (!isset($meses[$mes_mov])) {
                        $meses[$mes_mov] = self::convertMoney(1, $mov->valor);
                    } else {
                        $meses[$mes_mov] += self::convertMoney(1, $mov->valor);
                    }


                }

            }

            return json_encode(array_values($meses)) . "&=&" . json_encode(array_keys($meses));
        } else {
            return false;
        }


    }


    public function projecao($user)
    {

        $mes_avante = date('m', strtotime('+1 months', strtotime(date('Y-m-d'))));

        $mes_anterior1 = date('m', strtotime('-1 months', strtotime(date('Y-m-d'))));
        $ano_do_mes1 = date('Y', strtotime('-1 months', strtotime(date('Y-m-d'))));

        $valor_mes_ant1 = 0;

        $mes_anterior2 = date('m', strtotime('-2 months', strtotime(date('Y-m-d'))));
        $ano_do_mes2 = date('Y', strtotime('-2 months', strtotime(date('Y-m-d'))));

        $valor_mes_ant2 = 0;

        $mes_atual = date('m');
        $ano_do_mes_atual = date('Y');

        $valor_mes_atual = 0;


        $query1 = self::list2($user);

        if ($query1) {

            while ($mes_ant1 = $query1->fetch(PDO::FETCH_OBJ)) {
                $data_explo = explode('/', $mes_ant1->data);
                if ($data_explo[2] == $ano_do_mes1) {
                    if ($data_explo[1] == $mes_anterior1) {
                        $valor_mes_ant1 = ($valor_mes_ant1 + self::convertMoney(1, $mes_ant1->valor));
                    }
                }
            }

            $query3 = self::list2($user);

            while ($mes_ant2 = $query3->fetch(PDO::FETCH_OBJ)) {
                $data_explo = explode('/', $mes_ant2->data);
                if ($data_explo[2] == $ano_do_mes2) {
                    if ($data_explo[1] == $mes_anterior2) {
                        $valor_mes_ant2 = ($valor_mes_ant2 + self::convertMoney(1, $mes_ant2->valor));
                    }
                }
            }

            $query2 = self::list2($user);

            while ($mes_atu = $query2->fetch(PDO::FETCH_OBJ)) {
                $data_explo = explode('/', $mes_atu->data);
                if ($data_explo[2] == date('Y')) {
                    if ($data_explo[1] == date('m')) {
                        $valor_mes_atual = ($valor_mes_atual + self::convertMoney(1, $mes_atu->valor));
                    }
                }
            }


            if ($valor_mes_ant2 != 0 && $valor_mes_ant1 != 0 && $valor_mes_ant1 != 0) {
                $con = true;
            } else {
                $con = false;
            }

            if ($con) {

                $percentual_m = 80.0 / 100.0;

                $v1 = ($valor_mes_atual + $valor_mes_ant2 + $valor_mes_ant1) / 3;

                $pro = self::convertMoney(2, $v1 + ($v1 - ($percentual_m * $v1)));
                $pro_mes = self::text_mes($mes_avante, true);
                $json = json_encode(["erro" => false, "projecao" => "{$pro}", "mes" => $pro_mes]);

            } else {
                $json = json_encode(["erro" => false, "projecao" => false, "msg" => "Você não tem dados suficientes para uma futura projeção"]);
            }


            return $json;

        } else {
            return json_encode(["erro" => true, "projecao" => "0,00", "msg" => "Desculpe ocorreu um erro"]);
        }
    }


    public function percentual($user)
    {

        $mes_anterior = date('m', strtotime('-1 months', strtotime(date('Y-m-d'))));
        $ano_do_mes = date('Y', strtotime('-1 months', strtotime(date('Y-m-d'))));

        $valor_mes_ant = 0;
        $valor_mes_atu = 0;

        $query1 = self::list($user);

        if ($query1) {

            while ($mes_ant = $query1->fetch(PDO::FETCH_OBJ)) {
                $data_explo = explode('/', $mes_ant->data);
                if ($data_explo[2] == $ano_do_mes) {
                    if ($data_explo[1] == $mes_anterior) {
                        $valor_mes_ant = ($valor_mes_ant + self::convertMoney(1, $mes_ant->valor));
                    }
                }
            }

            $query2 = self::list($user);

            while ($mes_atu = $query2->fetch(PDO::FETCH_OBJ)) {
                $data_explo = explode('/', $mes_atu->data);
                if ($data_explo[2] == date('Y')) {
                    if ($data_explo[1] == date('m')) {
                        $valor_mes_atu = ($valor_mes_atu + self::convertMoney(1, $mes_atu->valor));
                    }
                }
            }


            $diferenca = $valor_mes_atu - $valor_mes_ant;

            if ($valor_mes_ant == 0) {
                $porcentagem = 100;
            } else {
                $porcentagem = ($diferenca / $valor_mes_atu) * 100;
            }


            if ($porcentagem < 0) {
                $icon = "<i class='text-danger fa fa-caret-down ' ></i>";
            } else if ($porcentagem == 0) {
                $icon = "<i class='text-secondary fa fa-circle ' ></i>";
            } else {
                $icon = "<i class='text-success fa fa-caret-up ' ></i>";
            }

            if ($porcentagem >= 100) {
                $porcentagem = 100;
            } else {
                $porcentagem = substr($porcentagem, 0, 2);
            }

            return $porcentagem . '|' . $icon . '|' . self::text_mes($mes_anterior, true);

        } else {
            return '0|<i class=\'text-secondary fa fa-circle \' ></i>|' . self::text_mes($mes_anterior, true);
        }
    }

    public function movimentado_ano($user)
    {

        $valor = 0;

        $query = self::list($user);

        if ($query) {

            while ($mov = $query->fetch(PDO::FETCH_OBJ)) {

                $ano_mov = explode('/', $mov->data)[2];

                if ($ano_mov == date('Y')) {
                    $valor = $valor + self::convertMoney(1, $mov->valor);
                }

            }

            return self::convertMoney(2, $valor);

        } else {
            return '0,00';
        }

    }


    public function movimentado_mes($user)
    {

        $valor = 0;

        $query = self::list($user);

        if ($query) {

            while ($mov = $query->fetch(PDO::FETCH_OBJ)) {

                $ano_mov = explode('/', $mov->data)[2];
                $mes_mov = explode('/', $mov->data)[1];

                if ($ano_mov == date('Y') && $mes_mov == date('m')) {
                    $valor = $valor + self::convertMoney(1, $mov->valor);
                }

            }

            return self::convertMoney(2, $valor);
        } else {
            return '0,00';
        }


    }


    public function dados_decada_af($user)
    {

        $ano_atual = date('Y');
        $array_anos = array();

        for ($i = 0; $i < 11; $i++) {

            $array_anos[$i][($ano_atual - $i)] = 0;

            $query = self::list_vendas($user);

            if ($query) {

                while ($mov = $query->fetch(PDO::FETCH_OBJ)) {

                    $explo_date = explode('/', $mov->data);

                    if (isset($array_anos[$i][$explo_date[2]])) {
                        $array_anos[$i][$explo_date[2]] = ($array_anos[$i][$explo_date[2]] + self::convertMoney(1, $mov->valor));
                    }

                }


            } else {
                return false;
                break;
            }


        }

        $dec = $array_anos;
        $anos = "";
        $vl = "";

        foreach ($dec as $key => $value) {
            foreach ($value as $k => $val) {
                $anos .= $k . ",";
                $vl .= $val . ",";
            }
        }

        return rtrim($anos, ',') . '|' . rtrim($vl, ',');

    }

    public function dados_decada($user)
    {

        $ano_atual = date('Y');
        $array_anos = array();

        for ($i = 0; $i < 11; $i++) {

            $array_anos[$i][($ano_atual - $i)] = 0;

            $query = self::list($user);

            if ($query) {

                while ($mov = $query->fetch(PDO::FETCH_OBJ)) {

                    $explo_date = explode('/', $mov->data);

                    if (isset($array_anos[$i][$explo_date[2]])) {
                        $array_anos[$i][$explo_date[2]] = ($array_anos[$i][$explo_date[2]] + self::convertMoney(1, $mov->valor));
                    }

                }


            } else {
                return false;
                break;
            }


        }

        $dec = $array_anos;
        $anos = "";
        $vl = "";

        foreach ($dec as $key => $value) {
            foreach ($value as $k => $val) {
                $anos .= $k . ",";
                $vl .= $val . ",";
            }
        }

        return rtrim($anos, ',') . '|' . rtrim($vl, ',');

    }

    public function text_mes($mes, $simples = false)
    {

        $array_meses_text = [
            '01' => 'Janeiro',
            '02' => 'Fevereiro',
            '03' => 'Março',
            '04' => 'Abril',
            '05' => 'Maio',
            '06' => 'Junho',
            '07' => 'Julho',
            '08' => 'Agosto',
            '09' => 'Setembro',
            '10' => 'Outubro',
            '11' => 'Novembro',
            '12' => 'Dezembro'
        ];

        $array_meses_text_s = [
            '01' => 'Jan',
            '02' => 'Fev',
            '03' => 'Mar',
            '04' => 'Abr',
            '05' => 'Mai',
            '06' => 'Jun',
            '07' => 'Jul',
            '08' => 'Ago',
            '09' => 'Set',
            '10' => 'Out',
            '11' => 'Nov',
            '12' => 'Dez',
        ];


        if ($simples == true) {
            return $array_meses_text[$mes];
        } else {
            return $array_meses_text_s[$mes];
        }


    }


    public function array_seven_days()
    {

        $array_return = [
            date('d', strtotime('-7 days', strtotime(date('d-m-Y')))) => 0,
            date('d', strtotime('-6 days', strtotime(date('d-m-Y')))) => 0,
            date('d', strtotime('-5 days', strtotime(date('d-m-Y')))) => 0,
            date('d', strtotime('-4 days', strtotime(date('d-m-Y')))) => 0,
            date('d', strtotime('-3 days', strtotime(date('d-m-Y')))) => 0,
            date('d', strtotime('-2 days', strtotime(date('d-m-Y')))) => 0,
            date('d', strtotime('-1 days', strtotime(date('d-m-Y')))) => 0,
            date('d', strtotime('-0 days', strtotime(date('d-m-Y')))) => 0
        ];

        return $array_return;

    }

    public function array_seven_days_sem()
    {

        $diasemana = array('Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab');

        $array_return = [
            date('d', strtotime('-7 days', strtotime(date('d-m-Y')))) => $diasemana[date('w', strtotime('-7 days', strtotime(date('d-m-Y'))))],
            date('d', strtotime('-6 days', strtotime(date('d-m-Y')))) => $diasemana[date('w', strtotime('-6 days', strtotime(date('d-m-Y'))))],
            date('d', strtotime('-5 days', strtotime(date('d-m-Y')))) => $diasemana[date('w', strtotime('-5 days', strtotime(date('d-m-Y'))))],
            date('d', strtotime('-4 days', strtotime(date('d-m-Y')))) => $diasemana[date('w', strtotime('-4 days', strtotime(date('d-m-Y'))))],
            date('d', strtotime('-3 days', strtotime(date('d-m-Y')))) => $diasemana[date('w', strtotime('-3 days', strtotime(date('d-m-Y'))))],
            date('d', strtotime('-2 days', strtotime(date('d-m-Y')))) => $diasemana[date('w', strtotime('-2 days', strtotime(date('d-m-Y'))))],
            date('d', strtotime('-1 days', strtotime(date('d-m-Y')))) => $diasemana[date('w', strtotime('-1 days', strtotime(date('d-m-Y'))))],
            date('d', strtotime('-0 days', strtotime(date('d-m-Y')))) => $diasemana[date('w', strtotime('-0 days', strtotime(date('d-m-Y'))))]
        ];

        return $array_return;

    }


    public function convertMoney($type, $valor)
    {
        if ($type == 1) {
            $a = str_replace(',', '.', str_replace('.', '', $valor));
            return $a;
        } else if ($type == 2) {
            return number_format($valor, 2, ",", ".");
        }

    }


    public function soma_mes_atual_admin()
    {

        $date_explode_at = explode('/', date('d/m/Y'));
        $valor_m_atual_p = 0;
        $valor_m_atual_n = 0;

        $query = $this->pdo->query("SELECT * FROM `financeiro_gestor`");

        if ($query) {

            while ($mov = $query->fetch(PDO::FETCH_OBJ)) {

                $explode_mov = explode('/', $mov->data);

                if ($explode_mov[2] == $date_explode_at[2] && $explode_mov[1] == $date_explode_at[1]) {
                    // mes e ano atuais

                    /*Somar entrada*/
                    if ($mov->tipo == 1) {
                        $valor_m_atual_p = $valor_m_atual_p + self::convertMoney(1, $mov->valor);
                    } else if ($mov->tipo == 2) {
                        /*Somar saida*/
                        $valor_m_atual_n = $valor_m_atual_n + self::convertMoney(1, $mov->valor);
                    }

                }

            }

            return self::convertMoney(2, $valor_m_atual_p) . '|' . self::convertMoney(2, $valor_m_atual_n);
        } else {
            return '0,00|0,00';
        }
    }

    public function soma_mes_anterior($user)
    {

        $date_explode_ant = explode('/', date('d/m/Y', strtotime('-1 months', strtotime(date('Y-m-d')))));
        $valor_m_ante_p = 0;
        $valor_m_ante_n = 0;


        $query = $this->pdo->query("SELECT * FROM `financeiro` WHERE id_user='$user'");

        if ($query) {

            while ($mov = $query->fetch(PDO::FETCH_OBJ)) {

                $explode_mov = explode('/', $mov->data);


                if ($explode_mov[2] == $date_explode_ant[2] && $explode_mov[1] == $date_explode_ant[1]) {

                    // mes e ano atuais

                    /*Somar entrada*/
                    if ($mov->tipo == 1) {
                        $valor_m_ante_p = $valor_m_ante_p + self::convertMoney(1, $mov->valor);
                    } else if ($mov->tipo == 2) {
                        /*Somar saida*/
                        $valor_m_ante_n = $valor_m_ante_n + self::convertMoney(1, $mov->valor);
                    }

                }

            }

            return self::convertMoney(2, $valor_m_ante_p) . '|' . self::convertMoney(2, $valor_m_ante_n);
        } else {
            return '0,00|0,00';
        }
    }


    public function soma_mes_atual($user)
    {

        $date_explode_at = explode('/', date('d/m/Y'));
        $valor_m_atual_p = 0;
        $valor_m_atual_n = 0;

        $query = $this->pdo->query("SELECT * FROM `financeiro` WHERE id_user='$user'");

        if ($query) {

            while ($mov = $query->fetch(PDO::FETCH_OBJ)) {

                $explode_mov = explode('/', $mov->data);

                if ($explode_mov[2] == $date_explode_at[2] && $explode_mov[1] == $date_explode_at[1]) {
                    // mes e ano atuais

                    /*Somar entrada*/
                    if ($mov->tipo == 1) {
                        $valor_m_atual_p = $valor_m_atual_p + self::convertMoney(1, $mov->valor);
                    } else if ($mov->tipo == 2) {
                        /*Somar saida*/
                        $valor_m_atual_n = $valor_m_atual_n + self::convertMoney(1, $mov->valor);
                    }

                }

            }

            return self::convertMoney(2, $valor_m_atual_p) . '|' . self::convertMoney(2, $valor_m_atual_n);
        } else {
            return '0,00|0,00';
        }
    }


    public function soma_mes_atual_parceiro($user)
    {

        $date_explode_at = explode('/', date('d/m/Y'));
        $valor_m_atual_p = 0;

        $query = $this->pdo->query("SELECT * FROM `vendas_parceiro` WHERE parceiro='$user'");

        if ($query) {

            while ($mov = $query->fetch(PDO::FETCH_OBJ)) {

                $explode_mov = explode('/', $mov->data);

                if ($explode_mov[2] == $date_explode_at[2] && $explode_mov[1] == $date_explode_at[1]) {
                    // mes e ano atuais

                    $valor_m_atual_p = $valor_m_atual_p + self::convertMoney(1, $mov->valor);

                }

            }

            return self::convertMoney(1, $valor_m_atual_p);
        } else {
            return '0';
        }
    }

}


?>
