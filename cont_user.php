<?php
date_default_timezone_set('America/Sao_Paulo');
set_time_limit(12000);//coloque no inicio do arquivo
ini_set('max_execution_time', 12000);

// Autoload
class Autoload
{

    public function __construct()
    {

        spl_autoload_extensions('.class.php');
        spl_autoload_register(array($this, 'load'));

    }

    private function load($className)
    {

        $extension = spl_autoload_extensions();
        require_once('class/' . $className . $extension);
    }
}

$autoload = new Autoload();


$conn = new Conn();
$pdo = $conn->pdo();


if (isset($_GET['mov_b2b'])) {

    function convertMoney($type, $valor)
    {
        if ($type == 1) {
            $a = str_replace(',', '.', str_replace('.', '', $valor));
            return $a;
        } else if ($type == 2) {
            return number_format($valor, 2, ",", ".");
        }

    }


    $valor = 0;

    $query_select_mov = $pdo->query("SELECT * FROM `financeiro`");
    while ($mov = $query_select_mov->fetch(PDO::FETCH_OBJ)) {
        $valor += convertMoney(1, $mov->valor);
    }

    echo convertMoney(2, $valor);

    die;
}

if (isset($_GET['mov_system'])) {

    function convertMoney($type, $valor)
    {
        if ($type == 1) {
            $a = str_replace(',', '.', str_replace('.', '', $valor));
            return $a;
        } else if ($type == 2) {
            return number_format($valor, 2, ",", ".");
        }

    }


    $valor = 0;

    $query_select_mov = $pdo->query("SELECT * FROM `financeiro_gestor`");
    while ($mov = $query_select_mov->fetch(PDO::FETCH_OBJ)) {
        $valor = ($valor + convertMoney(1, $mov->valor));
    }

    echo convertMoney(2, $valor);

    die;
}

$plano['p'][7]['qtd'] = 0;
$plano['p'][6]['qtd'] = 0;
$plano['p'][5]['qtd'] = 0;
$plano['p'][1]['qtd'] = 0;

$all = 0;


$query_select_vencidos = $pdo->query("SELECT * FROM `user` WHERE vencimento != '00/00/0000'");

while ($user = $query_select_vencidos->fetch(PDO::FETCH_OBJ)) {


    if (isset($plano['p'][$user->id_plano])) {

        $explodeData = explode('/', $user->vencimento);
        $explodeData2 = explode('/', date('d/m/Y'));
        $dataVen = $explodeData[2] . $explodeData[1] . $explodeData[0];
        $dataHoje = $explodeData2[2] . $explodeData2[1] . $explodeData2[0];

        if (!isset($_GET['vencidos'])) {

            if ($dataVen == $dataHoje) {
                $plano['p'][$user->id_plano]['qtd'] = ($plano['p'][$user->id_plano]['qtd'] + 1);
            } else if ($dataHoje < $dataVen) {
                $plano['p'][$user->id_plano]['qtd'] = ($plano['p'][$user->id_plano]['qtd'] + 1);
            }
        } else {
            if ($dataHoje > $dataVen) {
                $plano['p'][$user->id_plano]['qtd'] = ($plano['p'][$user->id_plano]['qtd'] + 1);
            }
        }

    } else {
        $plano['p'][1]['qtd']++;
    }

    $all++;
}

$plano['p'][7]['plano'] = 'Patrão';
$plano['p'][6]['plano'] = 'Profissional';
$plano['p'][5]['plano'] = 'Amador';
$plano['p'][1]['plano'] = 'Outros';

$plano['total'] = ($plano['p'][7]['qtd'] + $plano['p'][6]['qtd'] + $plano['p'][5]['qtd'] + $plano['p'][1]['qtd']);
$plano['porcentagem'] = substr(($plano['total'] / $all) * 100, 0, 4);


echo json_encode($plano);