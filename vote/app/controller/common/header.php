<?php
namespace app\controller\common;
if(!defined('DOST')){ die(header("HTTP/1.x 404 Not Found"));}

class header extends \libs\parents\Controller{  
    
    public $message;
    
    public function header(){
        $login = $this->app_controller_common_login;

        $this->leng->load('header');
        $this->data['info'] = $this->leng->get('info');
        $this->data['forum'] = $this->leng->get('forum');
        $this->data['site'] = $this->leng->get('site');
        $this->data['input_name'] = $this->leng->get('input_name');
        $this->data['input_pass'] = $this->leng->get('input_pass');
        $this->data['select_serv'] = $this->leng->get('select_serv');
        $this->data['button_text'] = $this->leng->get('button_text');   
        $this->data['active_user'] = $this->session->user;
        if(is_array($login->SelectServer()) and count($login->SelectServer()) > 1){
            $this->data['select_servers'] = $login->SelectServer();
        }else{
             $this->data['select_servers'] = false;
        }
        if($this->session->user === false){
           $this->data['message'] = $login->LoginForm($_POST);
        }else{
           $this->data['message'] = (isset($this->message) and $this->message != '') ? $this->message :'';          
           $this->data['Menu_account'] = $login->MenuList();
        }
        return $this->view->getTemplate('common', 'header' ,$this->data);
    }
}
