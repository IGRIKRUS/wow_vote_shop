<?php
namespace app\controller\page;
if(!defined('DOST')){ die(header("HTTP/1.x 404 Not Found"));}

class Home extends \libs\parents\Controller
{
    public function ActionIndex() {
        $this->getHeader('Home','Home Vote Shop','asdf');
        $this->getFooter();
        $item = $this->app_controller_item_item;
        if($this->session->user){
            $user = $this->session->user;
        }else{
            $user['realm_id'] = '';
        }
        
        $this->leng->load('item');
        $this->data['news'] = $this->leng->get('news');
        $this->data['weapon'] = $this->leng->get('weapon');
        $this->data['armor'] = $this->leng->get('armor');
        $this->data['mounts'] = $this->leng->get('mounts');
        $this->data['defold'] = $this->leng->get('defold');
        $this->data['msg_news'] =  Message('info', $this->leng->get('msg_news'));
        $this->data['msg_all'] = Message('info', $this->leng->get('msg_all'));
        $this->data['server_name'] = $item->itemList('server_name',$user['realm_id']);
        $this->data['item_news'] = $item->itemList('news',$user['realm_id']);
        $this->data['item_weapon'] = $item->itemList('weapon',$user['realm_id']);
        $this->data['item_armor'] = $item->itemList('armor',$user['realm_id']);
        $this->data['item_mount'] = $item->itemList('mount',$user['realm_id']);
        $this->data['item_different'] = $item->itemList('different',$user['realm_id']);
        $this->render('home', 'page');
    }
    
    public function ActionQuit(){
        $this->session->unsetSession();
        $this->redirect();
    }
}
