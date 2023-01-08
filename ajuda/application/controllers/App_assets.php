<?php
class App_assets extends CI_Controller{
    
    function index(){
        echo "yes";
    }
    
    function js($param=""){
        header('Content-Type: text/javascript; charset=utf-8');
        if(!empty($param)){ 
            $filename=basename($param);
            if(file_exists(APPPATH."/cache/js/{$param}")){           
               die(file_get_contents(APPPATH."/cache/js/{$param}"));
            }
        }else{
            echo "console.log(".current_url()." \nRequest file not found in cache);";
        }
    }

    function css($param=""){
        header('Content-Type: text/css; charset=utf-8');
        if(!empty($param)){
            $filename=basename($param);
            if(file_exists(APPPATH."/cache/css/{$param}")){
                die(file_get_contents(APPPATH."/cache/css/{$param}"));
            }
        }else{
            echo "console.log(".current_url()." \nRequest file not found in cache);";
        }
    }
    
    function chat_css(){
    
    }
	function chat_js(){
		header('Content-Type: text/javascript; charset=utf-8');
		echo file_get_contents(FCPATH."/plugins/apsbd-chat/js/appsbd-chat.min.js")."\n\n";
		get_default_chat_script();
	}
}