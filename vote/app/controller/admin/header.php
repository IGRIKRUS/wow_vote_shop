<?php
namespace app\controller\admin;
if(!defined('DOST')){ die(header("HTTP/1.x 404 Not Found"));}

class header extends \libs\parents\Controller{
    public $message;
    
    public function header(){       
        $this->data['message'] = (isset($this->message) and $this->message != '') ? $this->message :'';         
        $this->leng->load('adm_header');
        $this->data['exit'] = $this->leng->get('exit');
        $this->data['site'] = $this->leng->get('site');
        
        $this->data['item_list_act'] = (reqest('Itemlist') == true) ? true : false;
        $this->data['item_create_act'] = (reqest('ItemCreate') == true) ? true : false;
        
        $this->data['item_title'] = $this->leng->get('item_title');
        $this->data['item_list'] = $this->leng->get('item_list');
        $this->data['item_create'] = $this->leng->get('item_create');  
        
        $this->data['ConfigSite'] = (reqest('ConfigSite') == true) ? true : false;
        $this->data['ConfigServer'] = (reqest('ConfigServer') == true) ? true : false;
        $this->data['AddAdm'] = (reqest('AddAdm') == true) ? true : false;
        $this->data['Cache'] = (reqest('Cache') == true) ? true : false;
        
        $this->data['adm_config'] = $this->leng->get('adm_config');
        $this->data['adm_cfg_serv'] = $this->leng->get('adm_cfg_serv');
        $this->data['adm_create'] = $this->leng->get('adm_create');
        $this->data['adm_cfg_site'] = $this->leng->get('adm_cfg_site');
        $this->data['adm_cfg_cache'] = $this->leng->get('adm_cfg_cache');
        return $this->view->getTemplate('admin', 'header' ,$this->data);
    }
}
