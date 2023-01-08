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
$table = 'financeiro_gestor';
 
// Table's primary key
$primaryKey = 'id';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case object
// parameter names



$columns = array(
    array( 'db' => 'id', 'dt' => 'id'),
    array( 'db' => 'valor', 'dt' => 'valor', 'formatter' => function ($d, $row){
        
        return "R$ ".$row['valor'];
        
    }),
    array( 'db' => 'tipo', 'dt' => 'tipo' , 'formatter' => function ($d, $row) {
            
        switch ($row['tipo']) {

           case '1': return "<span class='badge badge-success'> <i class='fa fa-arrow-up' ></i> Entrada</span>"; break;
           case '2': return "<span class='badge badge-danger'><i class='fa fa-arrow-down ' ></i> Saída</span>"; break;
           
         }
          
        }),
        

    array( 'db' => 'data', 'dt' => 'data'),
    
    array( 'db' => 'nota', 'dt' => 'nota', 'formatter' => function ($d, $row) {
        

        
             $html = '<textarea id="nota_'.$row['id'].'" style="display:none;">'.$row['nota'].'</textarea>
                     <a class="text-info" style="cursor:pointer;" onclick="modal_view_nota('.$row['id'].');" >'.substr($row['nota'],0,20).'...'.'</a>';
                     
            return $html;
        
        }),
        
        
    array( 'db' => 'id', 'dt' => 'opc' , 'formatter' => function ($d, $row) {
            
             $var_html = '<button onclick="modal_confirm(\'index.php?page=financas&delete_mov='.$row['id'].'\',\'Deseja Deletar a movimentação ?\',\'bg-danger\');" class="btn btn-sm btn-danger" title="Remover">
                              <i class="fa fa-trash" ></i>
                          </button>';
                
             return $var_html;   
    
             
        }),
    
    
    );
 
// SQL server connection information
$sql_details = array(
    'user' => SET_DB_USERNAME,
    'pass' => SET_DB_PASSWORD,
    'db'   => SET_DB_NAME,
    'host' => SET_DB_HOSTNAME
);
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
 
require( '../inc/ssp.class.php' );
 
// echo json_encode(
    
// );

$return = SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns );

echo json_encode($return);




