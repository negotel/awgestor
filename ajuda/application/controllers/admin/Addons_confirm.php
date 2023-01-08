<?php 
/**
 * Version 1.0.0
 * Creation date: 03/Apr/2017
 * @Written By: S.M. Sarwar Hasan
 * Sarwar Hasan
 */
defined('BASEPATH') OR exit('No direct script access allowed');
 APP_Controller::LoadConfirmController();    
class Addons_confirm extends APP_ConfirmController
{
    function __construct()
    {
        parent::__construct();
    }


    function active_addon()
    {
        $file_path = GetValue("p");
        if(empty($file_path) || !file_exists(FCPATH."/addons/".$file_path)){
            $this->SetConfirmResponse(false, __("File doesn't exists"));
            return;
        }

        $file_ful_path=FCPATH."/addons/".$file_path;
        $fileErrorInfo=file_get_contents(base_url("check/index.php?p=".urlencode($file_path)));
        $fileErrorInfo=json_decode($fileErrorInfo);
        if(empty($fileErrorInfo->status)){
            $this->SetConfirmResponse(false, "Syntax error on the plugin file"."\n".(!empty($fileErrorInfo->msg) && !empty($fileErrorInfo->more_info->line) ?$fileErrorInfo->msg."\nIn Line : ".$fileErrorInfo->more_info->line:""), $fileErrorInfo);
            return;
        }
        $oldPluginData=AddOnManager::getAllActiveAddons();
        $classname=basename($file_path,'.php');
        if(isset($oldPluginData[$file_path])){
            unset($oldPluginData[$file_path]);
            //deactive
            if(class_exists($classname)){
                $obj=new $classname();
                if(method_exists($obj,"__OnDeactivate")) {
                    $obj->__OnDeactivate();
                }
            }
            AddOnManager::saveAllActiveAddons($oldPluginData);
            $this->SetConfirmResponse(true,__("Successfully deactivated"),'D');

            return;
        }else{
            $pluginData=AddOnManager::getPluginInfo(FCPATH."/addons/".$file_path);
            if(!empty($pluginData->name)){

                require_once FCPATH."/addons/".$file_path;
                if(!class_exists($classname)){
                    $this->SetConfirmResponse(false, __("Its not a valid plugin file"));
                    return;
                }
                $obj=new $classname();
                if(method_exists($obj,"__OnActivate")) {
                    $obj->__OnActivate();
                }
                $oldPluginData[$file_path]=$classname;
                AddOnManager::saveAllActiveAddons($oldPluginData);
                $this->SetConfirmResponse(true,__("Successfully activated"),'A');
                return;

            }else{
                $this->SetConfirmResponse(false, __("Its not a valid plugin file"));
                return;
            }

        }


        //$this->SetConfirmResponse(false, __("Successfully Updated"), "A");
        //$this->SetConfirmResponse(false, "Missing file path", $pluginData);

    }

}
