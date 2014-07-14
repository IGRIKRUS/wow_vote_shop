<?php
namespace libs\install;
if(!defined('DOST')){ die(header("HTTP/1.x 404 Not Found"));}

class InstallConf 
{
    private $conf_default = array('ecod'=>'utf8','base'=>'vote_shop','prefix'=>'vote_');

    public $process;
    public $conf;
    public $def_conf = array('lang'=>'ru_RU','style'=>'default');

    public function __get($key) {
        return $this->def_conf[$key];
    }

    public function FormDB($post, $land, $installDB, $fileManager) {
        $msg = '';
        if (isset($post['load'])) {
            if ($post['host'] != '' and $post['user'] != '' and $post['pass'] != '' and $post['port'] != '') {
                $con = $installDB->testConnection($post);
                if ($con === true) {
                    $msg .= $land->get('confDB_connect');
                    
                    $post['ecoding'] = ($post['ecoding'] != '') ? $post['ecoding'] : $this->conf_default['ecod'];
                    $post['base'] = ($post['base'] != '') ? $post['base'] : $this->conf_default['base'];
                    $post['prefix'] = ($post['prefix'] != '') ? $post['prefix'] : $this->conf_default['prefix'];
                    
                    unset($post['load']);
                    
                    $createDB = $installDB->CreateDB($post);
                    if ($createDB === true) {
                        $msg .= $land->get('confDB_createDB');
                        $path = SYS_PATH . 'config' . DS . 'conf_db.php';
                        
                        foreach ($post as $key => $val) {
                            $post[$key] = "'$val'";
                        }

                        if ($fileManager->CreateConf($path, $post) === true) {
                            $msg .= $land->get('confDB_file');
                            $this->process = true;
                        } else {
                            $msg .= $land->get('confDB_file_false');
                            $this->process = false;
                        }
                    } else {
                        $msg .= '<font color="red">' . $createDB . "</font>\n";
                        $msg .= $land->get('confDB_createDB_false');
                        $this->process = false;
                    }
                } else {
                    $msg .= '<font color="red">' . $con . "</font>\n";
                    $msg .= $land->get('confDB_connect_error');
                    $this->process = false;
                }
            } else {
                $msg = $land->get('confDB_input');
                $this->process = false;
            }
        }
        return $msg;
    }
    
    public function FormServ($post, $land, $installDB, $fileManager) {
        $list = $this->Conf_list();
        $msg = '';
        $msg .= $list;
        $base = $fileManager->scan_upload_items();
        if (isset($post['load'])) {
            unset($post['load']);
            if($this->post_null($post) === false){
                $msg .=$land->get('formSV_input');
            }else{
                $serv = $installDB->SelectServ($post);
                if(is_array($serv)){
                    if(array_search($serv['gamebuild'], $base) === false){
                        $msg .=$land->get('formSV_build').' '.$serv['name'].' - build('.$serv['gamebuild'].')';
                    }else{
                        $post['version'] = $serv['gamebuild'];
                        $post['server_name'] = $serv['name'];
                        
                        foreach ($post as $key => $val) {
                            $post[$key] = "'$val'";
                        }
                        
                        $post['soap_log'] = 'true';
                        unset($post['id']);
                        
                        $num = ($this->conf !== false) ? count($this->conf) + 1 : 1;
                        $path = SYS_PATH . 'config' . DS . 'conf_server_'.$num.'.php';
                        
                        if ($fileManager->CreateConf($path, $post) === true) {
                            $msg .= $land->get('formSV_file').' '.$serv['name'].' - build('.$serv['gamebuild'].')';
                            header("Refresh: 1;");
                        } else {
                            $msg .= $land->get('formSV_file_false').' '.$serv['name'].' - build('.$serv['gamebuild'].')';
                        }
                        
                    }
                }else{
                    $msg .= '<font color="red">' . $serv . '</font></br>';
                    $msg .=$land->get('formSV_select');
                }
            }
        }
        return $msg;
    }

    private function post_null($post){
        if(array_search(false, $post)){
            return false;
        }else{
            return true;
        }
    }

    private function Conf_list() {
        $model = new \libs\parents\Model();
        $conf = $model->ServerConfig();
        if (is_array($conf)) {
            $txt = '';
            $this->conf = $conf;
            foreach ($conf as $key => $value) {
                $name = $value['server_name'];
                $txt .= "<font color='green'>$key:$name config : Complete</font></br>";
            }
            return $txt;
        } else {
            $this->conf = false;
            return '';
        }
    }
    
    public function select_serv(){
        $login = new \app\controller\common\login($this);
        return $login->SelectServer();
    }
}

