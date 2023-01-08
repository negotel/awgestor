<?php


/**
 *
 */
class Gestor extends Conn
{


    function __construct()
    {
        $this->conn = new Conn;
        $this->pdo = $this->conn->pdo();
    }


    public function list_planos()
    {

        $query = $this->pdo->query("SELECT * FROM `plano_user_gestor`");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if (count($fetch) > 0) {

            $query = $this->pdo->query("SELECT * FROM `plano_user_gestor` ORDER BY id ASC ");
            return $query;

        } else {
            return false;
        }

    }

    public function remove_att($id)
    {
        if ($this->pdo->query("DELETE FROM `atualizacoes` WHERE id='$id' ")) {
            return true;
        } else {
            return false;
        }
    }

    public function insert_update($nome, $texto)
    {

        $query = $this->pdo->prepare("INSERT INTO `atualizacoes` (nome,texto,data) VALUES (:nome,:texto,:data) ");
        $query->bindValue(':nome', $nome);
        $query->bindValue(':texto', $texto);
        $query->bindValue(':data', date('m/d/Y H:i:s'));

        if ($query->execute()) {
            return true;
        } else {
            return false;
        }

    }

    public static function tempo_corrido($time)
    {

        $now = strtotime(date('m/d/Y H:i:s'));
        $time = strtotime($time);
        $diff = $now - $time;

        $seconds = $diff;
        $minutes = round($diff / 60);
        $hours = round($diff / 3600);
        $days = round($diff / 86400);
        $weeks = round($diff / 604800);
        $months = round($diff / 2419200);
        $years = round($diff / 29030400);


        if ($seconds <= 10) return "agora mesmo";
        else if ($seconds <= 50) return "há alguns segundos ";
        else if ($seconds <= 60) return "há 1 min ";
        else if ($minutes <= 60) return $minutes == 1 ? 'há 1 minuto ' : 'há ' . $minutes . ' minutos ';
        else if ($hours <= 24) return $hours == 1 ? 'há 1 hora ' : 'há ' . $hours . ' horas ';
        else if ($days <= 7) return $days == 1 ? 'há 1 dia' : 'há ' . $days . ' dias ';
        else if ($weeks <= 4) return $weeks == 1 ? 'há 1 semana ' : 'há ' . $weeks . ' semanas ';
        else if ($months <= 12) return $months == 1 ? 'há 1 mês ' : 'há ' . $months . ' meses ';
        else return $years == 1 ? 'há um ano ' : 'há ' . $years . ' anos ';

    }


    public function get_updates()
    {

        $query = $this->pdo->query("SELECT * FROM `atualizacoes`");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if (count($fetch) > 0) {

            $query = $this->pdo->query("SELECT * FROM `atualizacoes` ORDER BY id DESC ");
            return $query;

        } else {
            return false;
        }

    }

    public function list_contatos()
    {

        $query = $this->pdo->query("SELECT * FROM `contato_gestorlite`");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if (count($fetch) > 0) {

            $query = $this->pdo->query("SELECT * FROM `contato_gestorlite` ORDER BY id ASC ");
            return $query;

        } else {
            return false;
        }

    }

    public function soma_mes_atual_gestor()
    {
        $date_explode_at = explode('/', date('d/m/Y'));
        $valor_m_atual_p = 0.00;

        $query = $this->pdo->query("SELECT * FROM `faturas_user` WHERE forma !='Teste Grátis' AND status='Aprovado'");

        while ($mov = $query->fetch(PDO::FETCH_OBJ)) {
           $explode_mov = explode('/', $mov->data);
            if ($explode_mov[2] == $date_explode_at[2] && $explode_mov[1] == $date_explode_at[1]) {
                $valor_m_atual_p = $valor_m_atual_p + self::convertMoney(1, $mov->valor);
            }
        }

        return self::convertMoney(2, $valor_m_atual_p);
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


    public function list__faturas_user()
    {

        $query = $this->pdo->query("SELECT * FROM `faturas_user`");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);

        if (count($fetch) > 0) {

            $query = $this->pdo->query("SELECT * FROM `faturas_user` ORDER BY id DESC");
            return $query;

        } else {
            return false;
        }

    }

    public function list__faturas_user_pay()
    {

        $query = $this->pdo->query("SELECT * FROM `faturas_user` WHERE forma !='Teste Grátis' AND status='Aprovado'");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);

        if (count($fetch) > 0) {

            $query = $this->pdo->query("SELECT * FROM `faturas_user`  WHERE forma !='Teste Grátis' AND status='Aprovado' ORDER BY id DESC");
            return $query;

        } else {
            return false;
        }

    }

    public function delete_fat_user($id)
    {
        if ($this->pdo->query("DELETE FROM `faturas_user` WHERE id='$id' ")) {
            return true;
        } else {
            return false;
        }
    }

    public function list__pre_cadastro()
    {

        $query = $this->pdo->query("SELECT * FROM `user`");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);

        if (count($fetch) > 0) {

            $query = $this->pdo->query("SELECT * FROM `user` ORDER BY id ASC WHERE id > 74");
            return $query;

        } else {
            return false;
        }

    }

    function delete_contato($id)
    {
        if ($query = $this->pdo->query("DELETE FROM `contato_gestorlite` WHERE id= {$id}")) {
            return true;
        } else {
            return false;
        }
    }

    function dados_contato($id)
    {

        $query = $this->pdo->query("SELECT * FROM `contato_gestorlite` WHERE id='$id' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if (count($fetch) > 0) {

            $query = $this->pdo->query("SELECT * FROM `contato_gestorlite` WHERE id='$id' LIMIT 1 ");
            $fetch = $query->fetch(PDO::FETCH_OBJ);
            return $fetch;

        } else {
            return false;
        }
    }

    function get_user_grupo_beta($email)
    {

        $query = $this->pdo->query("SELECT * FROM `grupo_beta` WHERE email='$email' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if (count($fetch) > 0) {

            return true;

        } else {
            return false;
        }
    }

    public function plano($id)
    {

        $query = $this->pdo->query("SELECT * FROM `plano_user_gestor` WHERE id='$id' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if (count($fetch) > 0) {

            $query = $this->pdo->query("SELECT * FROM `plano_user_gestor` WHERE id='$id' LIMIT 1 ");
            $fetch = $query->fetch(PDO::FETCH_OBJ);
            return $fetch;

        } else {
            return false;
        }

    }

    public function num_cobrancas()
    {

        $query = $this->pdo->query("SELECT * FROM `num_cobrancas` WHERE id='1' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if (count($fetch) > 0) {

            $query = $this->pdo->query("SELECT * FROM `num_cobrancas` WHERE id='1' LIMIT 1 ");
            $fetch = $query->fetch(PDO::FETCH_OBJ);
            return $fetch;

        } else {
            return false;
        }

    }


    public function num_clientes()
    {

        $query = $this->pdo->query("SELECT * FROM `user`");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);

        return count($fetch);

    }

    public function text_pre_cadastro($id)
    {

        $query = $this->pdo->query("SELECT * FROM `text_pre_cadastro` WHERE id='$id' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if (count($fetch) > 0) {

            $query = $this->pdo->query("SELECT * FROM `text_pre_cadastro` WHERE id='$id' LIMIT 1 ");
            $fetch = $query->fetch(PDO::FETCH_OBJ);
            return $fetch;

        } else {
            return false;
        }

    }

    public function text_recover_pass($id)
    {

        $query = $this->pdo->query("SELECT * FROM `text_recover_pass` WHERE id='$id' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if (count($fetch) > 0) {

            $query = $this->pdo->query("SELECT * FROM `text_recover_pass` WHERE id='$id' LIMIT 1 ");
            $fetch = $query->fetch(PDO::FETCH_OBJ);
            return $fetch;

        } else {
            return false;
        }

    }


    public function insert_beta($dados)
    {

        $query = $this->pdo->prepare("INSERT INTO `grupo_beta` (nome,email,whatsapp) VALUES (:nome,:email,:whatsapp) ");
        $query->bindValue(':nome', $dados->nome);
        $query->bindValue(':email', $dados->email);
        $query->bindValue(':whatsapp', $dados->whatsapp);

        if ($query->execute()) {
            return true;
        } else {
            return false;
        }

    }

    public function beta_add($email)
    {

        $query = $this->pdo->query("SELECT * FROM `grupo_beta` WHERE email='$email' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if (count($fetch) > 0) {

            return false;

        } else {

            return true;

        }

    }


}


?>
