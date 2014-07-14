<?php
namespace app\controller\admin;
if(!defined('DOST')){ die(header("HTTP/1.x 404 Not Found"));}

class footer extends \libs\parents\Controller{
    public function footer()
    {  
        return $this->view->getTemplate('admin', 'footer' ,$this->data);
    }
}
