<?php
namespace app\controller\common;
if(!defined('DOST')){ die(header("HTTP/1.x 404 Not Found"));}

class footer extends \libs\parents\Controller{
    public function footer()
    {     
        return $this->view->getTemplate('common', 'footer' ,$this->data);
    }
}
