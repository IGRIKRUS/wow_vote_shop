<?php
namespace app\controller\page;
if(!defined('DOST')){ die(header("HTTP/1.x 404 Not Found"));}
//sleep(10);
class Ajax extends \libs\parents\Controller{
    public function ActionIndex(){
        $this->config->time_print = false;
        if(!isset($_POST['ajax']) and !isset($_POST['tooltip'])){
            include APP_PATH.'view'.DS.'not_found.php';
        }else{
            if($_POST['tooltip'] == 'true'){
             define('AJAX', true);
             $tooltip = $this->app_controller_item_item;
             echo $tooltip->tooltip_item($_POST);
            }
        }
    }
}
