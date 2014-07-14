<?php
namespace app\controller\common;
if(!defined('DOST')){ die(header("HTTP/1.x 404 Not Found"));}

class login extends \libs\parents\Controller
{
    public $count;
    public $process = false;

    public function LoginForm($post,$type = ''){
        $account = $this->app_model_user_account;
        $this->leng->load('login');
        $this->count = (int)$account->countServers();
        $form_post = $this->Post($post);
        $msg = '';
        if(isset($form_post['send'])){
            if(!empty($form_post['login']) and !empty($form_post['pass'])){
                if($this->count > 1 and !empty($form_post['serv']) and is_numeric($form_post['serv'])){
                   $msg = $account->Authentication($form_post['login'],$form_post['pass'],$form_post['serv'], $this->session_id_ac($type),$type);
                   if($msg == 'true'){
                       if($type === ''){
                            $this->Authorization($account->params,$form_post['serv']);
                       }
                   }
                }else{                  
                   $msg = Message('warning', $this->leng->get('server_message'));
                }
                
                if($this->count == 1){
                    $msg = $account->Authentication($form_post['login'],$form_post['pass'],1,  $this->session_id_ac($type),$type);
                    if($msg == 'true'){
                        if($type === ''){
                           $this->Authorization($account->params,1);
                        }
                    }
                }
                if($msg == 'true' and $type !== ''){
                    $msg = Message('success', $this->leng->get('success_message_inst'));
                    $this->process = true;
                }elseif($msg == 'true'){
                    $msg = Message('success', $this->leng->get('success_message'));
                }elseif($msg == 'Pass'){
                    $msg = Message('warning', $this->leng->get('pass_message'));
                }elseif($msg == 'null'){
                    $msg = Message('info', $this->leng->get('notfound_message'));
                }elseif($msg == 'false'){
                    $msg = Message('info', $this->leng->get('connect_server'));
                }elseif($msg == 'online'){
                    $msg = Message('warning', $this->leng->get('online_user'));    
                }elseif($msg == ''){
                    $msg = Message('error', $this->leng->get('error_message'));
                }
            }
        }
        return $msg;
    }
    
    public function SelectServer(){
        $account = $this->app_model_user_account;
        $serv = array();
        $realm = $account->Servers();
        if(is_array($realm)){
            foreach ($realm as $key => $value) {
                       $serv[$key]['name'] = $value['server_name'];
            }
        }
        return $serv;
    }
    
    private function session_id_ac($type){
        if($type === ''){
            return $this->session->getId;
        }else{
            return '';
        }
    }

    private function Authorization($params,$realm_id){
        if(is_array($params)){
            $account = $this->app_model_user_account;
            if($account->Admin($params['id']) === true){
                $this->session->admin = true;
            }
            $params['realm_id'] = $realm_id;
            $this->session->user = $params;
            $this->refresh(1);
        }
    }
    
    public function MenuList() {
        $account = $this->app_model_user_account;
        $cart = $this->app_model_user_cart;

        $this->leng->load('login');
        $user = $this->session->user;
        if ($this->session->user) {
            $this->data['Vp'] = $account->selectVP($user['id']);
            $this->data['name'] = $user['name'];
            $this->data['settings'] = $this->leng->get('settings');
            $this->data['cart'] = $this->leng->get('cart');
            $this->data['exit'] = $this->leng->get('exit');
            
            $params = $cart->select_status_cart($user['id'],$this->session->getId);
            if($params !== false){
                $this->data['count'] = $params['count'];
                $this->data['Vp_sum'] = $params['sum'];
            }else{
                $this->data['count'] = 0;
                $this->data['Vp_sum'] = 0;
            }
            
            $this->data['cart_staus'] = '';
            if ($this->session->admin === false) {
                $this->data['admin'] = '';
            } else {
                $this->data['admin'] = $this->leng->get('admin');
            }
            return $this->view->getTemplate('common', 'login', $this->data);
        }
    }

}
