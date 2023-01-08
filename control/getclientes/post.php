<?php
 
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
$table = 'clientes';
 
// Table's primary key
$primaryKey = 'id';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case object
// parameter names


$columns = array(
    array( 'db' => 'id', 'dt' => 'nome', 'formatter' => function ($d, $row){
        
        
         require_once '../../class/Conn.class.php';
         $conn = new Conn();
         $pdo  = $conn->pdo();
         
         
         $query1 = $pdo->query("SELECT * FROM `clientes` WHERE id='".$row['id']."' LIMIT 1");
         $user   = $query1->fetch(PDO::FETCH_ASSOC);
         
         $query = $pdo->query("SELECT * FROM `categorias_cliente` WHERE id='".$user['categoria']."' ");
         $fetch = $query->fetchAll(PDO::FETCH_OBJ);
         if( count($fetch)>0 ){
             $query = $pdo->query("SELECT * FROM `categorias_cliente` WHERE id='".$user['categoria']."' ");
             $cate = $query->fetch(PDO::FETCH_OBJ);
         }else{
             $cate = false;
         }
         
        $cores['danger'] = "#ec3541";
        $cores['primary'] = "#0048ff";
        $cores['secondary'] = "#dddddd";
        $cores['info'] = "#2d87ce";
        $cores['warning'] = "#fb9100";
        $cores['marrom'] = "#6d2b19";
        $cores['green'] = "#2bad18";
        $cores['roxo'] = "#7922ff";
        $cores['verde2'] = "#04fbb1";
    
       if(isset($cores[$cate->cor])){
             $back = $cores[$cate->cor];
         }else{
             $back = $cate->cor;
         }
     
        
        $span = " <span class='etiqueta_cate_".$cate->id."' style=\"color: ".$back."!important;min-height: 12px;width: 14%!important;text-align: center;font-size: 12px;color: #fff;float: left;margin-right: 5px;margin-top: 5px;\"><i class='fa fa-circle' ></i></span>";
        return $span."<span style='float:left;position: absolute;' >".$user['nome']."</span>";
        
        
    }),
    
            
    
    array( 'db' => 'id', 'dt' => 'opc' , 'formatter' => function ($d, $row) {
        
        
             require_once '../../class/Conn.class.php';
             $conn = new Conn();
             $pdo  = $conn->pdo();
             
             $query1 = $pdo->query("SELECT * FROM `clientes` WHERE id='".$row['id']."' LIMIT 1");
             $user   = $query1->fetch(PDO::FETCH_ASSOC);
         
             
             $query = $pdo->query("SELECT * FROM `planos` WHERE id='".$row['id_plano']."' ");
             $fetch = $query->fetchAll(PDO::FETCH_OBJ);
             if( count($fetch)>0 ){
                 $query = $pdo->query("SELECT * FROM `planos` WHERE id='".$row['id_plano']."' ");
                 $plano = $query->fetch(PDO::FETCH_OBJ);
             }else{
                 $plano = false;
             }
        
            
            $var_html = "   <button onclick=\"modal_send_zap(".$user['id'].",'".$user['nome']."','".$user['telefone']."',";
            
            if($plano){  
                $var_html .= "$plano->id"; 
            }else{ 
                $var_html .=" 'no'";
            } 
            
            $var_html .=");\" title=\"COBRANÇA\" type=\"button\" class=\"btn-outline-primary btn btn-sm\"  id=\"\" > <i class=\"fa fa-paper-plane\" ></i> </button>&nbsp;";
            $var_html .="<button ";
            if($plano == false){  
                $var_html .= "disabled style=\"cursor:no-drop;\"";
            }
            
            $var_html .= " onclick=\"renew_cli(".$user['id'].",".$user['id_plano'].");\" title=\"RENOVAR\" type=\"button\" class=\"btn-outline-primary btn btn-sm  \"  id=\"btn_renew_".$user['id']."\" > <i id=\"_btn_renew_".$user['id']."\" class=\"fa fa-redo\" ></i> </button>&nbsp;";
            $var_html .= "<button onclick=\"edite_cliente(".$user['id'].");\" title=\"EDITAR\" type=\"button\" class=\"btn-outline-primary btn btn-sm btn-outline-primary\"> <i class=\"fa fa-pencil-alt\" ></i> </button>&nbsp;";
            $var_html .= "<button onclick=\"modal_del_cli(".$user['id'].");\" title=\"EXCLUIR\" type=\"button\" class=\"btn-outline-primary btn btn-sm  \"> <i class=\"fa fa-trash\" ></i> </button>&nbsp;";
            $var_html .="<button";
            

           if($plano){ 
           
             $var_html .= " onclick=\"modal_faturas_cli(".$user['id'].",'".$user['nome']."','".$user['email']."');\"";
           
           }else{ 
               
             $var_html .= " onclick=\"alert('".$idioma->faca_upgrade_alert."'); location.href='cart?upgrade'\";"; 
             
           } 
           
           $var_html .= " title=\"Registro de faturas\" type=\"button\" class=\"btn-outline-primary btn btn-sm  \"> <i class=\"fa fa-file\" ></i> </button>&nbsp;";

        
           return $var_html;   

         
    }),
    
    array( 'db' => 'email', 'dt' => 'email', 'formatter' => function ($d, $row) {
        if($row['email'] == "" || $row['email'] == NULL){
            return '[Sem email]';
        }else{
            return $row['email'];
        }
    }),
    array( 'db' => 'telefone', 'dt' => 'whatsapp', 'formatter' => function ($d, $row) {
        
        return "<a href=\"http://wa.me/".$row['telefone']."\" target=\"_blank\" > <i class='fas fas-whatsapp' ></i> ".$row['telefone']."</a>";
        
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
        
     array( 'db' => 'id_plano', 'dt' => 'plano' , 'formatter' => function ($d, $row) {
        
          require_once '../../class/Conn.class.php';
          $conn = new Conn();
          $pdo  = $conn->pdo();
         
          $query = $pdo->query("SELECT * FROM `planos` WHERE id='".$row['id_plano']."' ");
          $fetch = $query->fetchAll(PDO::FETCH_OBJ);
          if( count($fetch)>0 ){
             $query = $pdo->query("SELECT * FROM `planos` WHERE id='".$row['id_plano']."' ");
             $plano = $query->fetch(PDO::FETCH_OBJ);
          }else{
             $plano = false;
          }
          
          if($plano){
            return $plano->nome;
          } else{
              return "Não possui";
          }
    }),

    
    array( 'db' => 'totime', 'dt' => 'totime'),

    
    );
    
    
    @session_start();
    
    if(isset($_SESSION['SESSION_USER'])){
 
        // SQL server connection information
        $sql_details = array(
            'user' => 'siteiptv_gestor',
            'pass' => '9=zoXxX?.Eym',
            'db'   => 'siteiptv_gestorlite',
            'host' => 'localhost'
        );
         
         
        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
         * If you just want to use the basic configuration for DataTables with PHP
         * server-side, there is no need to edit below this line.
         */
         
        require( '../../class/ssp.class.php' );
         
        // echo json_encode(
            
        // );
        
        $whereAll = "";
        
          if(!isset($_REQUEST['search'])){
            $whereAll .= " id_user='".$_SESSION['SESSION_USER']['id']."'";
          }
               
          if(isset($_REQUEST['search'])){
                $value = $_REQUEST['search']['value'];
                if($value == ""){
                    $whereAll .= " id_user='".$_SESSION['SESSION_USER']['id']."'";
                }else{
                    $whereAll .= " id_user='".$_SESSION['SESSION_USER']['id']."' AND (CONVERT(`id` USING utf8) LIKE '%{$value}%' OR CONVERT(`nome` USING utf8) LIKE '%{$value}%' OR CONVERT(`email` USING utf8) LIKE '%{$value}%' OR CONVERT(`telefone` USING utf8) LIKE '%{$value}%' OR CONVERT(`vencimento` USING utf8) LIKE '%{$value}%' OR CONVERT(`identificador_externo` USING utf8) LIKE '%{$value}%')";
                }
            }
        
        
        if(isset($_GET['ativos'])){
            $whereAll .= " AND totime>=".date('Ymd');
        }else if(isset($_GET['inativos'])){
            $whereAll .= " AND totime<".date('Ymd');
        }
        
        if(isset($_GET['categoria'])){
            $whereAll .= " AND categoria='".$_GET['categoria']."'";
        }
     
        
        $return = SSP::complex( $_POST, $sql_details, $table, $primaryKey, $columns, $whereResult= null, $whereAll);
        
        echo json_encode($return);
 
    }



