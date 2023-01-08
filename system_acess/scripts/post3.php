<?php
include_once "../../config/settings.php";
/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simple to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

// DB table to use
$table = 'faturas_user';

// Table's primary key
$primaryKey = 'id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case object
// parameter names


$columns = array(
    array('db' => 'id', 'dt' => 'id'),
    array('db' => 'valor', 'dt' => 'valor', 'formatter' => function ($d, $row) {

        return "R$ " . $row['valor'];

    }),
    array('db' => 'status', 'dt' => 'status', 'formatter' => function ($d, $row) {

        switch ($row['status']) {
            case 'Pendente':
                $status = "<span class='badge badge-secondary' >Pendente</span>";
                break;
            case 'Aprovado':
                $status = "<span class='badge badge-success' >Aprovado</span>";
                break;
            case 'Devolvido':
                $status = "<span class='badge badge-danger' >Devolvido</span>";
                break;
            case 'Rejeitado':
                $status = "<span class='badge badge-danger' >Rejeitado</span>";
                break;
            case 'Análise':
                $status = "<span class='badge badge-warning' >Análise</span>";
                break;
            case 'Cancelado':
                $status = "<span class='badge badge-danger' >Cancelado</span>";
                break;
            case 'Mediação':
                $status = "<span class='badge badge-danger' >Mediação</span>";
                break;
            default:
                $status = "<span class='badge badge-info' >" . $row['status'] . "</span>";
                break;
        }

        return $status;

    }),

    array('db' => 'forma', 'dt' => 'forma', 'formatter' => function ($d, $row) {

        switch ($row['forma']) {
            case 'Boleto':
                $icon_f = "<i class='fa fa-barcode' ></i> ";
                break;
            case 'Cartão de Crédito':
                $icon_f = "<i class='fa fa-credit-card' ></i> ";
                break;
            case 'Cartão de Débito':
                $icon_f = "<i class='fa fa-credit-card' ></i> ";
                break;
            case 'Saldo MP':
                $icon_f = "<i class='fa fa-handshake-o' ></i> ";
                break;
            case 'TED':
                $icon_f = "<i class='fa fa-bank' ></i> ";
                break;
            case 'Mercado Pago':
                $icon_f = "<i class='fa fa-handshake-o' ></i> ";
                break;
            case 'Teste Grátis':
                $icon_f = "<i class='fa fa-heart' ></i> ";
                break;
            case 'Pendente':
                $icon_f = "<i class='fa fa-question' ></i> ";
                break;
            case 'Meu Saldo':
                $icon_f = "<i class='fa fa-money' ></i> ";
                break;
            default:
                $icon_f = "";
                break;
        }

        return $icon_f;

    }),


    array('db' => 'data', 'dt' => 'data'),

    array('db' => 'ref', 'dt' => 'ref', 'formatter' => function ($d, $row) {

        $html = substr($row['ref'], 0, 20) . '...';
        return $html;

    }),


    array('db' => 'id_user', 'dt' => 'id_user', 'formatter' => function ($d, $row) {

        $var_html = '<a href="index.php?page=cliente&id=' . $row['id_user'] . '" >' . $row['id_user'] . '</a>';
        return $var_html;
    }),

    array('db' => 'id', 'dt' => 'opc', 'formatter' => function ($d, $row) {

        $var_html = '<button onclick="modal_confirm(\'index.php?page=faturas&delete_fat=' . $row['id'] . '\',\'Deseja Deletar a fatura ?\',\'bg-danger\');" class="btn btn-sm btn-danger" title="Remover">
                          <i class="fa fa-trash" ></i>
                      </button>';
        return $var_html;
    }),


);

// SQL server connection information
$sql_details = array(
    'user' => SET_DB_USERNAME,
    'pass' => SET_DB_PASSWORD,
    'db' => SET_DB_NAME,
    'host' => SET_DB_HOSTNAME
);

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

require('../inc/ssp.class.php');

// echo json_encode(

// );

$whereAll = NULL;
if (isset($_GET['pagos'])) {
    $whereAll .= " status='Aprovado'";
} else if (isset($_GET['inativos'])) {
    $whereAll .= NULL;
}

$return = SSP::complex($_POST, $sql_details, $table, $primaryKey, $columns, $whereResult = null, $whereAll);


echo json_encode($return);




