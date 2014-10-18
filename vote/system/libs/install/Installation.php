<?php
namespace libs\install;
if(!defined('DOST')){ die(header("HTTP/1.x 404 Not Found"));}

class Installation extends \libs\install\parentInstall
{    
    public function Run(){
       $this->route();
       if($this->get !== false){
           if($this->searchMethod($this->get[0]) !== false){
               $method = $this->get[0];
               return $this->$method();
           }else{
               $this->not_found();
           }
       }else{
           $this->redirect('start');
       }
    }

    private function searchMethod($method){
        if(method_exists('libs\install\Installation', $method)){
            return true;
        }else {
            return false;
        }
    }
    
    public function start(){
       $this->data['end'] = 0; 
       $this->lang->load('install');
       $mod = $this->fileManager->DirVote('/system');
       $this->data['start_title'] = $this->lang->get('start_title');
       $this->data['btn_continue'] = $this->lang->get('btn_continue');
       $this->data['log'] = ($mod['log'] === true) ? $this->lang->get('chmod_log_true') : $this->lang->get('chmod_log_false');
       $this->data['cache'] = ($mod['cache'] === true) ? $this->lang->get('chmod_cache_true') : $this->lang->get('chmod_cache_false');
       $this->data['conf'] = ($mod['conf'] === true) ? $this->lang->get('chmod_conf_true') : $this->lang->get('chmod_conf_false');

       if($mod['log'] !== false || $mod['log'] !== false || $mod['conf'] !== false){
           $this->data['continue'] = true;
           $this->data['end'] = 5; 
       }elseif(PHP_OS == 'Linux'){
           $this->data['continue'] = $this->lang->get('chmod_error').$this->lang->get('os_linux');
       }else{
           $this->data['continue'] = $this->lang->get('chmod_error');
       }
       return $this->render('start', 'page');
    }
    
    public function ConfSite(){       
        $this->data['end'] = 5;       
        
        $this->lang->load('adm_config');
        $this->data['title_cfg_site'] = $this->lang->get('title_cfg_site');
        $this->data['lang'] = $this->lang->get('lang');
        $this->data['cache'] = $this->lang->get('cache');
        $this->data['cache_time'] = $this->lang->get('cache_time');
        $this->data['session_time'] = $this->lang->get('session_time');
        $this->data['default_page'] = $this->lang->get('default_page');
        $this->data['ecoding_html'] = $this->lang->get('ecoding_html');
        $this->data['style'] = $this->lang->get('style');
        $this->data['display_error'] = $this->lang->get('display_error');
        $this->data['log_error'] = $this->lang->get('log_error');
        $this->data['time_print'] = $this->lang->get('time_print');
        $this->data['lang_dir'] = $this->scan('lang');
        $this->data['page_dir'] = $this->scan('page');
        $this->data['style_theme'] = $this->scan('style');
  
        $this->lang->load('install');
        $this->data['button_edit'] = $this->lang->get('btn_load');
        $this->data['conf_site_title'] = $this->lang->get('conf_site_title');
        $this->data['btn_continue'] = $this->lang->get('btn_continue');
        $this->data['btn_back'] = $this->lang->get('btn_back');
  
        $this->data['file'] = $this->scan_conf('/system/config', 'conf_web.php');
        if($this->data['file'] === true){
            $this->data['end'] = 25;  
        }
        $this->create_conf($_POST,(object) $this->def_conf);
        return $this->render('ConfSite', 'page');
    }
    
    public function ConfDBSite(){
        $this->lang->load('install');
        $this->data['end'] = 25; 
        $this->data['conf_siteDB_title'] = $this->lang->get('conf_siteDB_title');
        $this->data['confDB_host'] = $this->lang->get('confDB_host');
        $this->data['confDB_user'] = $this->lang->get('confDB_user');
        $this->data['confDB_pass'] = $this->lang->get('confDB_pass');
        $this->data['confDB_port'] = $this->lang->get('confDB_port');
        $this->data['confDB_base'] = $this->lang->get('confDB_base');
        $this->data['confDB_driver'] = $this->lang->get('confDB_driver');
        $this->data['confDB_ecod'] = $this->lang->get('confDB_ecod');
        $this->data['confDB_pref'] = $this->lang->get('confDB_pref');
        $this->data['confDB_info'] = $this->lang->get('confDB_info');
        $this->data['btn_load'] = $this->lang->get('btn_load');
        $this->data['btn_continue'] = $this->lang->get('btn_continue');
        $this->data['btn_back'] = $this->lang->get('btn_back');
        $this->data['btn_update'] = $this->lang->get('btn_update');

        $form = $this->installConf->FormDB($_POST,$this->lang,$this->installDB,$this->fileManager);
        $this->data['process'] = $this->installConf->process;
        $this->data['form'] = $form;
        $this->data['driver'] = array_diff($this->fileManager->Scandir('/system/libs/Driver'),array('.','..'));
        
        $this->data['file'] = $this->scan_conf('/system/config', 'conf_db.php');
        if($this->data['file'] === true){
            $this->data['end'] = 40;  
        }
        
        return $this->render('ConfDBSite', 'page');
    }
    
    public function ConfServer(){
        $this->lang->load('install');
        $this->data['end'] = 40;
        $this->data['conf_server_title'] = $this->lang->get('conf_server_title');
        $this->data['conf_server_name'] = $this->lang->get('conf_server_name');
        $this->data['conf_server_DB'] = $this->lang->get('conf_server_DB');
        $this->data['conf_server_vote'] = $this->lang->get('conf_server_vote');
        $this->data['conf_server_soap'] = $this->lang->get('conf_server_soap');
        
        $this->data['btn_load'] = $this->lang->get('btn_load');
        $this->data['btn_continue'] = $this->lang->get('btn_continue');
        $this->data['btn_back'] = $this->lang->get('btn_back');

        $this->data['confSV_ID'] = $this->lang->get('confSV_ID');
        $this->data['confDB_host'] = $this->lang->get('confDB_host');
        $this->data['confDB_user'] = $this->lang->get('confDB_user');
        $this->data['confDB_pass'] = $this->lang->get('confDB_pass');
        $this->data['confDB_port'] = $this->lang->get('confDB_port');
        $this->data['confDB_ecod'] = $this->lang->get('confDB_ecod');
        $this->data['confSV_auth'] = $this->lang->get('confSV_auth');
        $this->data['confSV_characters'] = $this->lang->get('confSV_characters');
        $this->data['confSV_world'] = $this->lang->get('confSV_world');
        $this->data['confSV_vote'] = $this->lang->get('confSV_vote');
        $this->data['confSV_sms'] = $this->lang->get('confSV_sms');
        $this->data['confSV_file'] = $this->lang->get('confSV_file');
        $this->data['confSV_soap_host'] = $this->lang->get('confSV_soap_host');
        $this->data['confSV_soap_port'] = $this->lang->get('confSV_soap_port');
        $this->data['confSV_soap_login'] = $this->lang->get('confSV_soap_login');
        $this->data['confSV_soap_pass'] = $this->lang->get('confSV_soap_pass');
        $this->data['confSV_soap_send_title'] = $this->lang->get('confSV_soap_send_title');
        $this->data['confSV_soap_send_text'] = $this->lang->get('confSV_soap_send_text');
        $this->data['confSV_message'] = $this->lang->get('confSV_message');
        $this->data['msg'] = $this->installConf->FormServ($_POST, $this->lang, $this->installDB, $this->fileManager);
        if(is_array($this->installConf->conf)){
            $this->data['end'] = 60;
        }
        return $this->render('ConfServer', 'page');
    }
    
    public function CreateTable() {
        $this->data['end'] = 60;
        $this->lang->load('install');
        $this->data['CRtable_title'] = $this->lang->get('CRtable_title');
        $this->data['btn_continue'] = $this->lang->get('btn_continue');
        $this->data['btn_back'] = $this->lang->get('btn_back');
        $this->data['tables'] = $this->installDB->ShowTables($this->fileManager);
        if ($this->data['tables'] === false) {
            $this->data['msg'] = $this->installDB->Inst_table_upload($this->lang,$this->fileManager);
            $this->refresh(1);
        } else {
            $this->data['msg'] = $this->lang->get('CRtable_Complete');
            $this->data['end'] = 80;
        }
        return $this->render('CreateTable', 'page');
    }
    
    public function CreateAccount(){
        $this->data['end'] = 80;
        $this->lang->load('install');
        $this->data['CAcc_title'] = $this->lang->get('CAcc_title');
        $this->data['CAcc_admin'] = $this->lang->get('CAcc_admin');
        $this->data['btn_continue'] = $this->lang->get('btn_continue');
        $this->data['btn_back'] = $this->lang->get('btn_back');
        $this->data['btn_load'] = $this->lang->get('btn_load');
        $this->data['btn_update'] = $this->lang->get('btn_update');
        $this->data['ACcc_msg_txt'] = $this->lang->get('ACcc_msg_txt');
        $this->lang->load('header');
        $this->data['input_name'] = $this->lang->get('input_name');
        $this->data['input_pass'] = $this->lang->get('input_pass');
        $this->data['select_serv'] = $this->lang->get('select_serv');
        $this->data['account'] = $this->installDB->select_account();
        $this->data['select_servers'] = $this->installConf->select_serv();
        if ($this->data['account'] === false) {
            $login = new \app\controller\common\login($this);
            if(isset($_POST['send'])){
            if (isset($_POST['adm_pass']) and $_POST['adm_pass'] != '') {
                $this->data['message'] = $login->LoginForm($_POST, 0);
                if ($login->process === true) {
                    $conf = new \app\model\admin\conf();
                    $adm = array('id'=>1,'name'=>$_POST['login']);
                    $conf->createAdm($adm, $_POST['adm_pass']);
                }
            } else {
                $this->data['message'] = Message('warning',$this->lang->get('CAcc_input_adm'));
            }
            }
        } else {
            $this->data['end'] = 95;
            $this->data['msg'] = $this->lang->get('ACcc_success');
        }
        return $this->render('CreateAccount', 'page');
    }

    public function EndInstall(){
        $this->data['end'] = 95;
        $this->lang->load('install');
        $this->data['btn_back'] = $this->lang->get('btn_back');
        $this->data['btn_load'] = $this->lang->get('btn_load');
        $edit = $this->fileManager->editIndex('index.php');
        $this->data['edit']  = $edit;
        if($edit === true){
            $this->data['end'] = 100;
            $this->data['msg'] = $this->lang->get('End_continue');
        }else{
            $this->data['msg'] = $this->lang->get('End_error');
        }
        $this->data['End_title'] = $this->lang->get('End_title');
        return $this->render('EndInstall', 'page');
    }
}
