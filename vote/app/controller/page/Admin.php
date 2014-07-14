<?php
namespace app\controller\page;
if(!defined('DOST')){ die(header("HTTP/1.x 404 Not Found"));}

class Admin extends \libs\parents\Controller
{
    public function ActionIndex(){
        if($this->session->admin === true){   
            $account = $this->app_model_user_account;           
            $this->getHeaderAdmin('Admin');
            $this->leng->load('adm_login');
            $this->data['input_login'] = $this->leng->get('input_login');
            $this->data['input_pass'] = $this->leng->get('input_pass');
            $this->data['button_text'] = $this->leng->get('button_text');
            $this->data['message'] = $account->AdminLogin($this->Post($_POST),$this->session,$this->leng);
            $this->render('login', 'admin');
        }elseif(is_numeric($this->session->admin)){    
            $home = $this->app_model_admin_home;
            $this->getHeaderAdmin('Admin','','',  '');
            $this->leng->load('adm_home');
            $this->data['style'] = $this->style;
            $this->data['statistic'] = $home->Statistic();
            
            $this->data['stat_title'] = $this->leng->get('stat_title');
            $this->data['stat_unit'] = $this->leng->get('stat_unit');
            $this->data['stat_site'] = $this->leng->get('stat_site');
            $this->data['stat_vote'] = $this->leng->get('stat_vote');
            $this->data['stat_vote_sms'] = $this->leng->get('stat_vote_sms');
            $this->data['stat_null'] = $this->leng->get('stat_null');
            $this->data['stat_account'] = $this->leng->get('stat_account');
            $this->data['stat_characters'] = $this->leng->get('stat_characters');
            $this->data['stat_servers'] = $this->leng->get('stat_servers');
            $this->data['stat_error'] = $this->leng->get('stat_error');
            
            $this->getFooterAdmin();
            $this->render('admin', 'page');
        }else{
            $this->redirect();
        }
    }

    public function ActionQuit(){
         $account = $this->app_model_user_account; 
         $account->updateAccountOnline($_SESSION['admin'], 'admin', 0);
         $_SESSION['admin'] = true;
         $this->redirect();
    }
    
    public function ActionItemlist(){
        if(is_numeric($this->session->admin)){
            $item = $this->app_controller_item_item;
            $adm_item = $this->app_model_admin_item;
            $this->leng->load('item'); 
            $this->data['title_list'] = $this->leng->get('title_list');
            $this->getHeaderAdmin('Admin','Item list','',$adm_item->edit($this->Post($_POST),  $this->leng));
            $this->getFooterAdmin();            
            $this->data['item'] = $item->AdminItemList();
            $this->data['Locked_true'] = $this->leng->get('Locked_true');
            $this->data['Locked_false'] = $this->leng->get('Locked_false');
            $this->data['msg_null'] = Message('info',$this->leng->get('msg_null'));
            $this->render('item_list', 'page');
        }else{
             $this->redirect();
        }
    }
    
    public function ActionItemCreate(){
        if(is_numeric($this->session->admin)){
            $adm_item = $this->app_model_admin_item;
            $this->leng->load('adm_create_item');
            $this->data['title_create'] = $this->leng->get('title_create');
            $this->data['server_list'] =  $adm_item->list_servers();
            $this->data['msg_serv_list'] = Message('warning',$this->leng->get('msg_serv_list'));
            $this->getHeaderAdmin('Admin','add item');
            $this->data['item_search_list'] = $adm_item->searchItem($this->Post($_POST),$this->leng);
            $this->getFooterAdmin();            
            $this->render('item_create', 'page');
        }else{
            $this->redirect();
        }
    }
    
    public function ActionConfigSite(){
        if (is_numeric($this->session->admin)) {
            $adm_conf = $this->app_model_admin_conf;
            $this->leng->load('adm_config');
            $this->data['title_cfg_site'] = $this->leng->get('title_cfg_site');
            $this->data['lang'] = $this->leng->get('lang');
            $this->data['cache'] = $this->leng->get('cache');
            $this->data['cache_time'] = $this->leng->get('cache_time');
            $this->data['session_time'] = $this->leng->get('session_time');
            $this->data['default_page'] = $this->leng->get('default_page');
            $this->data['ecoding_html'] = $this->leng->get('ecoding_html');
            $this->data['style'] = $this->leng->get('style');
            $this->data['display_error'] = $this->leng->get('display_error');
            $this->data['log_error'] = $this->leng->get('log_error');
            $this->data['time_print'] = $this->leng->get('time_print');
            $this->data['button_edit'] = $this->leng->get('button_edit');
            $conf = $adm_conf->getConfSite($this->config);
            $this->data['conf'] = $conf;
            $this->data['style_theme'] = $adm_conf->scan_dir('style');
            $this->data['lang_dir'] = $adm_conf->scan_dir('lang');
            $this->data['page_dir'] = $adm_conf->scan_dir('page');
            $this->getHeaderAdmin('Admin','edit config','',$adm_conf->editConf($this->Post($_POST),$conf));
            $this->getFooterAdmin();   
            $this->render('cfg_site', 'page');
        } else {
            $this->redirect();
        }
    }
    
    public function ActionAddAdm(){
        if (is_numeric($this->session->admin)) {
             $message = '';
             $adm_conf = $this->app_model_admin_conf;
             $this->leng->load('adm_config');
             $this->data['title_adm_add'] = $this->leng->get('title_adm_add');
             $this->data['list_adm'] = $this->leng->get('list_adm');
             $this->data['create_adm'] = $this->leng->get('create_adm');
             $this->data['input_id'] = $this->leng->get('input_id');
             $this->data['input_pass'] = $this->leng->get('input_pass');
             $this->data['input_repass'] = $this->leng->get('input_repass');
             $this->data['button_create'] = $this->leng->get('button_create');
             $this->data['list'] = $adm_conf->ListAdm();
             $message = $adm_conf->addAdm($this->Post($_POST),$this->data['list'],$this->leng);
             if(isset($this->get) and $this->get[0] == 'del' and filter_var($this->get[1], FILTER_VALIDATE_INT)){
                $message = $adm_conf->deleteAdm($this->get[1],$this->data['list'],$this->leng);
                $this->refresh(2,'admin/AddAdm');
             }
             $this->getHeaderAdmin('Admin','','',$message);
             $this->getFooterAdmin();   
             $this->render('adm_add', 'page');
        } else {
             $this->redirect();
        }
    }
    
    public function ActionCache() {
        if (is_numeric($this->session->admin)) {
            $cache = $this->app_model_admin_cache;
            $this->leng->load('adm_cache');
            $this->data['cache_title'] = $this->leng->get('cache_title');
            $this->data['cache_tab'] = $this->leng->get('cache_tab');
            $this->data['cache_name'] = $this->leng->get('cache_name');
            $this->data['cache_date'] = $this->leng->get('cache_date');
            $this->data['cache_null'] = $this->leng->get('cache_null');
            $this->data['cache_list'] = $cache->cache_list();
            if (isset($this->get) and $this->get[0] == 'del' and filter_var($this->get[1], FILTER_VALIDATE_INT)) {
                if (isset($this->data['cache_list'][$this->get[1]]['name'])) {
                    $cache->delete_cache($this->data['cache_list'][$this->get[1]]['name']);
                    $this->refresh(0, 'admin/Cache');
                }
            }
            $this->getHeaderAdmin('Admin');
            $this->getFooterAdmin();
            $this->render('cache', 'page');
        } else {
            $this->redirect();
        }
    }

}
