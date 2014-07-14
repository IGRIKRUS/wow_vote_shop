<?php
if (!defined('DOST')) {
    die(header("HTTP/1.0 404 Not Found"));
}

mb_internal_encoding("UTF-8");

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

function RGBColor() {
    $a = rand(0, 255);
    $b = rand(0, 255);
    $c = rand(0, 255);
    return "rgb($a,$b,$c)";
}

if (ini_get('magic_quotes_gpc')) {

    function clean($data) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[clean($key)] = clean($value);
            }
        } else {
            $data = stripslashes($data);
        }

        return $data;
    }

    $_GET = clean($_GET);
    $_POST = clean($_POST);
    $_REQUEST = clean($_REQUEST);
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

function getIP() {
    $headers = array('HTTP_X_FORWARDED_FOR', 'HTTP_X_CLUSTER_CLIENT_IP',
        'HTTP_FORWARDED_FOR', 'HTTP_X_FORWARDED',
        'HTTP_FORWARDED', 'HTTP_VIA', 'HTTP_X_COMING_FROM',
        'HTTP_X_COMING_FROM', 'HTTP_COMING_FROM',
        'REMOTE_ADDR');
    foreach ($headers as $header) {
        if (isset($_SERVER[$header])) {
            return $_SERVER[$header];
        }
    }
}

if(file_exists(SYS_PATH.'libs'.DS.'load'.DS.'Autoload.php')){
    require_once SYS_PATH.'libs'.DS.'load'.DS.'Autoload.php';
    \libs\load\Autoload::Run();
    
     $config = new libs\config\Config();

     $session = new \libs\session\Session($config->session_time);
     
     \libs\load\ReauestRoute::getInstance($config,$session)->Run();
     
}else{
    throw new \libs\Exception\ExceptMsg('Not Found File Autoload');
}
