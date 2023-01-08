<?php
$dirname=dirname(__FILE__);
require_once $dirname."/../application/libraries/APPAddOns.php";
error_reporting(0);
register_shutdown_function('error_handler');
if(empty($_GET['p'])) {
    $response=new stdClass();
    $response->status=true;
    $response->msg="No file found";
    $response->more_info=null;
    die(json_encode($response));
}
$file = $_GET['p'];
$file=$dirname."/../addons/{$file}";
$file=realpath($file);
if(!is_dir($file) && file_exists($file)){
    require $file;
    $response=new stdClass();
    $response->status=true;
    $response->msg="No Syntext Error Found";
    $response->more_info=null;
    die(json_encode($response));
}else{
    $response=new stdClass();
    $response->status=true;
    $response->msg="No file found";
    $response->more_info=null;
    die(json_encode($response));
}
function error_handler(){
    $res=error_get_last();   
    if(!empty($res['type'])){
        $response=new stdClass();
        $response->status=false;
        $response->msg=!empty($res['message'])?$res['message']:"There is syntax error";
        $response->more_info=$res;
        die(json_encode($response));
    }    
}