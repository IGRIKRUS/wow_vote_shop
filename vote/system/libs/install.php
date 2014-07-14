<?php
if (!defined('DOST')) {
    die(header("HTTP/1.0 404 Not Found"));
}

mb_internal_encoding("UTF-8");

$GLOBALS['display_error'] = 'Error_all';

if (!ini_get('date.timezone')) {
	date_default_timezone_set('UTC');
}

function site_date($time = '') {
    if($time != ''){
       return date("d-m-Y H:i:s" , $time);
    }
}

function dump($var){
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}

function reqest($prm = '') {
    if (isset($_SERVER['QUERY_STRING']) and $prm != '') {
        if (preg_match("/\.*($prm).*/", $_SERVER['QUERY_STRING'])) {
            return true;
        } else {
            return false;
        }
    }
}

function Message($type,$txt){
        $ms['error'] = 'alert-error';
        $ms['success'] = 'alert-success';
        $ms['info'] = 'alert-info';
        $ms['warning'] = 'alert-warning';
        if(isset($type) and isset($txt)){
            return '<div class="alert '.$ms[$type].' ">'.$txt.'</div>';
        }
}


if(file_exists(SYS_PATH.'libs'.DS.'load'.DS.'Autoload.php')){
    require_once SYS_PATH.'libs'.DS.'load'.DS.'Autoload.php';
    \libs\load\Autoload::Run();
    
     $install = new \libs\install\Installation();
     $install->Run();
     
}else{
    throw new \libs\Exception\ExceptMsg('Not Found File Autoload');
}
