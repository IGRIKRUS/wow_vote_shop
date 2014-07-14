<?php
namespace app\controller\page;
if(!defined('DOST')){ die(header("HTTP/1.x 404 Not Found"));}

class Account extends \libs\parents\Controller
{
    
    public function ActionSettings(){
        if($this->session->user){
        $settings = $this->app_model_user_account;
        $this->leng->load('account');    
        $characters = $settings->select_characters($this->session->user['id'],$this->session->user['realm_id']);
        $this->data['settings_name'] = $this->leng->get('settings_name');
        $this->data['new_password'] = $this->leng->get('new_password');
        $this->data['input_password'] = $this->leng->get('input_password');
        $this->data['input_newpassword'] = $this->leng->get('input_newpassword');
        $this->data['input_renewpassword'] = $this->leng->get('input_renewpassword');
        $this->data['warning_message'] = $this->leng->get('warning_message');
        $this->data['button_edit'] = $this->leng->get('button_edit');
        $this->data['characters'] = $this->leng->get('characters');
        $this->data['characters_null'] = $this->leng->get('characters_notFound');
        $this->data['characters_list'] = ($characters !== false) ? $characters : '';
        $this->data['update_characters_botton'] = $this->leng->get('update_characters_botton');
        $this->getHeader('Account','Account Settings','',$settings->account_settings($this->Post($_POST),$this->session->user,  $this->leng));
        $this->getFooter();
        
        $this->render('account', 'page');
        }else{
             $this->NotFound();
        }
    }
    
    public function ActionDelet(){
        if (isset($this->get) and filter_var($this->get[0], FILTER_VALIDATE_INT)) {
            if ($this->session->user) {
                $settings = $this->app_model_user_account;
                $settings->delete_characters($this->get[0],$this->session->user['id']);
                $this->redirect('account/settings');
            } else {
                $this->redirect('account/settings');
            }
        } else {
            $this->redirect('account/settings');
        }
    }
}

