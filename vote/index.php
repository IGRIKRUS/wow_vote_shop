<?php
 /**
 * Vote Panel Beta v1.0 Install
 * @copyright Copyright (c) 2014 
 * @author IGRIKRUS
 */

ini_set('display_errors', 1);

header('Content-Type: text/html; charset=UTF-8');
error_reporting(E_ALL|E_NOTICE|E_STRICT);

define('DOST', true);
define('DS', DIRECTORY_SEPARATOR);
define('ROOT_PATH', __DIR__.DS);
define('SYS_PATH', ROOT_PATH.'system'.DS);
define('APP_PATH', ROOT_PATH.'app'.DS);
define('URL_PATH','http://'.$_SERVER['SERVER_NAME'].'/');

if(version_compare(PHP_VERSION,'5.3.0','<') == true){die('<font color="red">Your version php less than 5.3.0 site to work not will!</font>');}

function folder(){
    $folder = explode(DS, __DIR__);
    if(!is_dir($_SERVER['DOCUMENT_ROOT'].DS.end($folder))){
        return false;
    }
    return end($folder);
}

if(file_exists(SYS_PATH.'libs'.DS.'Exception'.DS.'ExceptMsg.php')){
    require_once SYS_PATH.'libs'.DS.'Exception'.DS.'ExceptMsg.php';
}else{
    trigger_error('Not found file ExceptMsg');
}

try {
    if(file_exists(SYS_PATH.'libs'.DS.'install.php')){        
        require_once SYS_PATH.'libs'.DS.'install.php';        
    }else{
        throw new \libs\Exception\ExceptMsg('Not found file Install');
    }
} catch (\libs\Exception\ExceptMsg $msg) {
    require_once APP_PATH.'view'.DS.'error.php';
}
?>