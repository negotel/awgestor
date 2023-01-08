<?php


/**
 *
 */
class Faturas extends Conn
{


    function __construct()
    {
        $this->conn = new Conn;
        $this->pdo = $this->conn->pdo();
    }


    public function list($user)
    {

        $query = $this->pdo->query("SELECT * FROM `faturas_user` WHERE id_user='$user' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);


        if (count($fetch) > 0) {

            $query = $this->pdo->query("SELECT * FROM `faturas_user` WHERE id_user='$user' ORDER BY id DESC ");
            return $query;

        } else {
            return false;
        }

    }

    public function getmoeda($nome)
    {

        $query = $this->pdo->query("SELECT * FROM `moeda` WHERE nome='$nome' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);

        if ($fetch) {
            $query = $this->pdo->query("SELECT * FROM `moeda` WHERE nome='$nome' LIMIT 1 ");
            $fetch = $query->fetch(PDO::FETCH_OBJ);
            return $fetch;
        } else {
            return false;
        }

    }

    public function getmoedaId($id)
    {

        $query = $this->pdo->query("SELECT * FROM `moeda` WHERE id='$id' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if (count($fetch) > 0) {

            $query = $this->pdo->query("SELECT * FROM `moeda` WHERE id='$id' LIMIT 1 ");
            $fetch = $query->fetch(PDO::FETCH_OBJ);
            return $fetch;

        } else {
            return false;
        }

    }

    public function num_fats($user)
    {

        $query = $this->pdo->query("SELECT * FROM `faturas_user` WHERE id_user='$user' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        return count($fetch);

    }

    public function verify_cod_user($user, $codigo)
    {

        $query = $this->pdo->query("SELECT * FROM `used_cod` WHERE id_user='$user' AND codigo='$codigo' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if (count($fetch) > 0) {
            return false;
        } else {
            return true;
        }

    }


    public function get_cod($codigo, $fat)
    {

        $query = $this->pdo->query("SELECT * FROM `cod_promo` WHERE codigo='$codigo' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if (count($fetch) > 0) {


            $query = $this->pdo->query("SELECT * FROM `cod_promo` WHERE codigo='$codigo' ");
            $fetch = $query->fetch(PDO::FETCH_OBJ);


            $explodeData = explode('/', $fetch->validade);
            $explodeData2 = explode('/', date('d/m/Y'));
            $dataVen = $explodeData[2] . $explodeData[1] . $explodeData[0];
            $dataHoje = $explodeData2[2] . $explodeData2[1] . $explodeData2[0];

            if ($dataHoje > $dataVen) {
                return false;
            } else {


                // aplicar desconto

                $queryF = $this->pdo->query("SELECT * FROM `faturas_user` WHERE id='$fat' ");
                $fetchF = $queryF->fetch(PDO::FETCH_OBJ);

                $valor_fat = str_replace(',', '.', str_replace('.', '', $fetchF->valor));
                $valor_desconto = str_replace(',', '.', str_replace('.', '', $fetch->desconto));

                $new_v = number_format(($valor_fat - $valor_desconto), 2, ",", ".");
                $user = $fetchF->id_user;

                if ($this->pdo->query("UPDATE `faturas_user` SET valor='$new_v' WHERE id='$fat' ")) {


                    $this->pdo->query("INSERT INTO `used_cod` (`id_user`,`codigo`) VALUES ('$user','$codigo')");
                    return true;

                } else {
                    return false;
                }

            }


        } else {
            return false;
        }

    }


    public function update_fat_admin($id, $valor, $data, $status)
    {

        if ($this->pdo->query("UPDATE `faturas_user` SET valor='$valor', data='$data', status='$status' WHERE id='$id' ")) {
            return true;
        } else {
            return false;
        }
    }

    public function delete_fatura($id)
    {

        if ($this->pdo->query("DELETE FROM `faturas_user` WHERE id='$id' ")) {
            return true;
        } else {
            return false;
        }
    }

    public function create($plano, $user, $moeda, $status = "Pendente", $forma = "Pendente", $tipo = 'plano')
    {

        $ref = substr(base64_encode(md5(rand()) . date('dmYHis') . md5($user->id + rand()) . rand()), 0, 200) . $user->id;

        $query = $this->pdo->prepare("INSERT INTO `faturas_user`(`ref`, `valor`, `data`, `hora`, `id_user`, `id_plano`, `forma`, `status`, `token`, `comprovante`,`tipo`,`moeda`) VALUES (:ref,:valor,:data,:hora,:id_user,:id_plano,:forma,:status,:token,:comprovante,:tipo,:moeda)");
        $query->bindValue(':ref', $ref);
        $query->bindValue(':valor', $plano->valor);
        $query->bindValue(':data', date('d/m/Y'));
        $query->bindValue(':hora', date('H:i'));
        $query->bindValue(':id_user', $user->id);
        $query->bindValue(':id_plano', $plano->id);
        $query->bindValue(':forma', $forma);
        $query->bindValue(':status', $status);
        $query->bindValue(':token', sha1(date('His') . rand()));
        $query->bindValue(':comprovante', '0');
        $query->bindValue(':tipo', $tipo);
        $query->bindValue(':moeda', $moeda);

        if ($query->execute()) {
            return $ref;
        } else {
            return false;
        }

    }


    public function dados($id)
    {

        $query = $this->pdo->query("SELECT * FROM `faturas_user` WHERE id='$id' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if (count($fetch) > 0) {

            $query = $this->pdo->query("SELECT * FROM `faturas_user` WHERE id='$id' ");
            $fetch = $query->fetch(PDO::FETCH_OBJ);
            return $fetch;

        } else {
            return false;
        }


    }

}


?>
