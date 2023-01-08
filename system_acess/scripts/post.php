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
$table = 'user';
 
// Table's primary key
$primaryKey = 'id';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case object
// parameter names

// { "data": "id" },
// { "data": "nome" },
// { "data": "email" },
// { "data": "telefone" },
// { "data": "plano" },
// { "data": "vencimento" },
// { "data": "action" }



$columns = array(
    array( 'db' => 'id', 'dt' => 'id'),
    array( 'db' => 'nome', 'dt' => 'nome' , 'formatter' => function ($d, $row) {
            
          $var_html = "<a href=\"index.php?page=cliente&id=".$row['id']."\" >".$row['nome']."</a><br />";
          
          
         require_once '../../class/Conn.class.php';
         $conn = new Conn();
         $pdo  = $conn->pdo();
         
         $query = $pdo->query("SELECT * FROM `user` WHERE id='".$row['id']."' ");
         $fetch = $query->fetch(PDO::FETCH_OBJ);

         if($fetch->parceiro == 1 ){
             $var_html .= '<span style="font-size:12px;" class="badge badge-info" >Parceiro</span>';
          }

         if($fetch->id_rev != 0 && $fetch->id_rev != NULL){
             $var_html .= '<span style="font-size:12px;" class="text-danger" ><a class="text-danger" target="_blank" href="index.php?page=cliente&id='.$fetch->id_rev.'" >Cliente de revenda</a></span>';
          }
          
         return $var_html;
        }),
        
    array( 'db' => 'email', 'dt' => 'email'),
    array( 'db' => 'id', 'dt' => 'telefone', 'formatter' => function ($d, $row){
        
         require_once '../../class/Conn.class.php';
         $conn = new Conn();
         $pdo  = $conn->pdo();
         
         $query = $pdo->query("SELECT * FROM `user` WHERE id='".$row['id']."' LIMIT 1");
         $fetch = $query->fetch(PDO::FETCH_ASSOC);
        
        $paises_ddi = json_decode(file_get_contents('https://raw.githubusercontent.com/luannsr12/ddi-json-flag/main/data2.json'),true);
        $num = str_replace(')','',str_replace(' ','',str_replace('-','',str_replace('(','',$fetch['telefone']))));
        return '<a href="https://wa.me/'.$fetch['ddi'].$num.'" target="_blank" ><img width="20" src="'.$paises_ddi[$fetch['ddi']]['img'].'" /> '.$num;
        
    }),
    array( 'db' => 'id_plano', 'dt' => 'id_plano' , 'formatter' => function ($d, $row) {
        
          $plano_info[1] = "Amador";
          $plano_info[2] = "Profissional";
          $plano_info[3] = "Patrão";

          return $plano_info[$row['id_plano']];
          
          
    }),
    array( 'db' => 'vencimento', 'dt' => 'vencimento', 'formatter' => function ($d, $row) { 
        
        if($row['vencimento'] != 0 && $row['vencimento'] != ""){

            $explodeData  = explode('/',$row['vencimento']);
            $explodeData2 = explode('/',date('d/m/Y'));
            $dataVen      = $explodeData[2].$explodeData[1].$explodeData[0];
            $dataHoje     = $explodeData2[2].$explodeData2[1].$explodeData2[0];

            $Pvencimento = str_replace('/','-',$row['vencimento']);
            $timestamp   = strtotime("-3 days",strtotime($Pvencimento));
            $venX        = date('d/m/Y', $timestamp);

            $timestamp   = strtotime("-2 days",strtotime($Pvencimento));
            $venY        = date('d/m/Y', $timestamp);

            $timestamp   = strtotime("-1 days",strtotime($Pvencimento));
            $venZ        = date('d/m/Y', $timestamp);

            if($dataVen == $dataHoje){
                $ven = "<b class='text-info'>{$row['vencimento']}</b>";
            }
           if($dataHoje > $dataVen){
                $ven = "<b class='text-danger'>{$row['vencimento']}</b>";
            }
            if($dataHoje < $dataVen && $venX != date('d/m/Y') && $venY != date('d/m/Y') && $venZ != date('d/m/Y')){
                $ven = "<b class='text-success'>{$row['vencimento']}</b>";
            }
           if($venX == date('d/m/Y') || $venY == date('d/m/Y') || $venZ == date('d/m/Y')){
              $ven = "<b class='text-warning'>{$row['vencimento']}</b>";
            }
          }else{
                $ven = "<span class='text-info'>Aguardando </span>";
          }
         
         return $ven;
        
        
        }),
        
        array( 'db' => 'nome', 'dt' => 'clientes' , 'formatter' => function ($d, $row) {
            
             require_once '../../class/Conn.class.php';
             $conn = new Conn();
             $pdo  = $conn->pdo();
             
             $query = $pdo->query("SELECT * FROM `clientes` WHERE id_user='".$row['id']."' ");
             $fetch = $query->fetchAll(PDO::FETCH_OBJ);
             return count($fetch);
    
             
        }),
        
        array( 'db' => 'nome', 'dt' => 'opc' , 'formatter' => function ($d, $row) {
            
             $var_html = "<div class=\"dropdown\">
                    <button class=\"btn btn-secondary dropdown-toggle\" type=\"button\" id=\"dropdownMenuButton\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
                    Ver
                  </button>
                  <div class=\"dropdown-menu\" aria-labelledby=\"dropdownMenuButton\">
                    <a onclick=\"dados_edite_user(".$row['id'].");\" class=\"dropdown-item\" style=\"cursor:pointer;\" >Editar <i class=\"fa fa-pencil\" ></i></a>
                    <a onclick=\"modal_confirm('index.php?page=home&delete_user=".$row['id']."','Deseja Deletar o usuário ?','bg-danger');\" class=\"dropdown-item\" style=\"cursor:pointer;\" >Remover <i class=\"fa fa-trash\" ></i> </a>
                    <a onclick=\"location.href='index.php?page=faturas-user&user=".$row['id']."';\" class=\"dropdown-item\" style=\"cursor:pointer;\" >Ver faturas <i class=\"fa fa-file\" ></i></a>
                  </div>
                </div>";
                
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




