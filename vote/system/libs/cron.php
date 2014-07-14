<?php
 /**
 * Cron Parser 
 * @copyright Copyright (c) 2014 
 * @author IGRIKRUS
 */

header('Content-Type: text/html; charset=UTF-8');
error_reporting(E_ALL|E_NOTICE|E_STRICT);

set_time_limit(0);

if (!ini_get('date.timezone')) {
	date_default_timezone_set('UTC');
}

$GLOBALS['display_error'] = 'Error_all';

function site_date($time = '') {
    if($time != ''){
       return date("d-m-Y H:i:s" , $time);
    }else{
       return date("d.m.Y H:i:s");
    }
}

define('DOST', true);
define('DS', DIRECTORY_SEPARATOR);
define('ROOT_PATH', substr(__DIR__, 0, strpos(__DIR__, 'system')));
define('SYS_PATH', ROOT_PATH.'system'.DS);
define('APP_PATH', ROOT_PATH.'app'.DS);

try {
    if (file_exists(SYS_PATH . 'libs' . DS . 'load' . DS . 'Autoload.php')) {
        require_once SYS_PATH . 'libs' . DS . 'load' . DS . 'Autoload.php';
        \libs\load\Autoload::Run();

        new libs\config\Config();

        $cron = new libs\Cron\Parser();
        $cron->Load();
    } else {
        throw new \libs\Exception\ExceptMsg('Not Found File Autoload');
    }
} catch (\libs\Exception\ExceptMsg $msg) {
     $msg->Message();
}
