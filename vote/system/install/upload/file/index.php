<?php 
 /**
 * Vote Panel Beta v1.0
 * @copyright Copyright (c) 2014 
 * @author IGRIKRUS
 */


header('Content-Type: text/html; charset=UTF-8');
error_reporting(E_ALL|E_NOTICE|E_STRICT);

define('DOST', true);
define('DS', DIRECTORY_SEPARATOR);
define('ROOT_PATH', __DIR__.DS);
define('SYS_PATH', ROOT_PATH.'system'.DS);
define('APP_PATH', ROOT_PATH.'app'.DS);
define('URL_PATH','http://'.$_SERVER['SERVER_NAME'].'/');


$start_time = microtime(true);

function folder(){
    if(isset($_SERVER['REQUEST_URI'])){
        $folder = explode('/', $_SERVER['REQUEST_URI']);
        return $folder[1];
    }
}

if(file_exists(SYS_PATH.'libs'.DS.'Exception'.DS.'ExceptMsg.php')){
    require_once SYS_PATH.'libs'.DS.'Exception'.DS.'ExceptMsg.php';
}else{
    trigger_error('Not found file ExceptMsg');
}

try {
    if(file_exists(SYS_PATH.'libs'.DS.'load.php')){
        require_once SYS_PATH.'libs'.DS.'load.php';
    }else{
        throw new \libs\Exception\ExceptMsg('Not found file load');
    }
} catch (\libs\Exception\ExceptMsg $msg) {
    require_once APP_PATH.'view'.DS.'error.php';
}

$end_time = microtime(true) - $start_time;

if($config->time_print === true)
{
    echo '<!-- Time generate page '.round($end_time, 4).' sec. -->';
}
?>

