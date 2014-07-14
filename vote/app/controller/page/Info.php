<?php
namespace app\controller\page;
if(!defined('DOST')){ die(header("HTTP/1.x 404 Not Found"));}

class Info extends \libs\parents\Controller{
    
    public function ActionIndex(){
        $this->getHeader('Info','Info Vote Shop');
        $this->getFooter();       
        $serv = $this->app_model_server_serversInfo;
        
        $this->leng->load('info');
        $this->data['title_info'] = $this->leng->get('title_info');
        $this->data['price_vote'] = $this->leng->get('price_vote');
        $this->data['price_sms_vote'] = $this->leng->get('price_sms_vote');
        $this->data['price_date'] = $this->leng->get('price_date');
        $this->data['server_list'] = $serv->info_price_serv();
        $this->data['message_null'] = Message('info', $this->leng->get('message_null'));
        $this->render('info', 'page');
    }
}
