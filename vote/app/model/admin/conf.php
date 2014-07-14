<?php
namespace app\model\admin;
if(!defined('DOST')){ die(header("HTTP/1.x 404 Not Found"));}

class conf extends \libs\parents\Model
{   
    public function getConfSite($conf){
        return $conf;
    }

    public function scan_dir($params = ''){
        return self::scan_dirs($params);
    }
    
    public static function FileMenager($path){
        $scan = new \libs\File\FileManager();
        return $scan->Scandir($path);
    }
    
    public static function CreateFile($conf){
        $scan = new \libs\File\FileManager();
        return $scan->updateConfSite($conf);
    }

    public static function scan_dirs($params = '') {
        $mass = '';
        if ($params == 'style') {
            $mass = self::FileMenager('/app/view/');
        } elseif ($params == 'lang') {
            $mass = self::FileMenager('/system/Lang/');
        } elseif ($params == 'page') {
            $mass = self::FileMenager('/app/controller/page/');
        }

        $PrivateFiles = array('admin', 'Admin.php', 'Ajax.php', 'Cart.php', 'Item.php', 'Account.php');

        $list = '';
        if (is_array($mass)) {
            foreach ($mass as $val) {
                if (strpos($val, '.') === false) {
                    if (!in_array($val, $PrivateFiles, true)) {
                        $list[] = $val;
                    }
                } elseif ($params == 'page') {
                    if ($val !== '.' and $val !== '..') {
                        if (!in_array($val, $PrivateFiles, true)) {
                            $list[] = $val;
                        }
                    }
                }
            }
        } else {
            return false;
        }
        return $list;
    }

    public function editConf($post,$config){
        return self::Conf($post, $config);
    }

    public static function Conf($post,$config){
        $conf = array();
        if(isset($post['edit_conf'])){
            $conf['lang'] = (isset($post['lang']) and $post['lang'] != '') ? "'".$post['lang']."'" : "'".$config->lang."'";
            $conf['cache'] = (isset($post['cache']) and $post['cache'] == 'on') ? 'true' : 'false';
            $conf['cache_time'] = (isset($post['cache_time']) and $post['cache_time'] != '') ? $post['cache_time'] : $config->cache_time;
            $conf['session_time'] = (isset($post['session_time']) and $post['session_time'] != '') ? $post['session_time'] : $config->cache_time;
            $conf['default_page'] = (isset($post['default_page']) and $post['default_page'] != '') ? "'".$post['default_page']."'" : "'".$config->default_page."'";
            $conf['ecoding_html'] = (isset($post['ecoding_html']) and $post['ecoding_html'] != '') ? "'".$post['ecoding_html']."'" : "'".$config->ecoding_html."'";
            $conf['style'] = (isset($post['style']) and $post['style'] != '') ? "'".$post['style']."'" : "'".$config->style."'";
            $conf['display_error'] = (isset($post['display_error']) and $post['display_error'] == 'on') ? 'true' : 'false';
            $conf['log_error'] = (isset($post['log_error']) and $post['log_error'] == 'on') ? 'true' : 'false';
            $conf['time_print'] = (isset($post['time_print']) and $post['time_print'] == 'on') ? 'true' : 'false';
            self::CreateFile($conf);
            header("Refresh: 1;");
        }
    }
    
    public function ListAdm(){
        $db = $this->connect->query('SELECT ^users.id AS acc_id,^users.name,^admin.id FROM ^admin INNER JOIN ^users ON ^admin.id_account=^users.id ORDER BY ^users.date DESC');
        if($db->num_rows > 0){
            return $db->rows;
        }else{
            return false;
        }
    }
    
    public function deleteAdm($id,$list,$lang){
        $msg = '';
        if(count($list) > 1){
            $this->connect->query('DELETE FROM ^admin WHERE id = '.$id);
            if ($this->connect->countAffected()) {
                $msg = Message('success', $lang->get('msg_del_success'));
            } else {
                $msg = Message('error', $lang->get('msg_del_error'));
            }
        }else{
            $msg = Message('warning', $lang->get('msg_del_warning'));
        }
        return $msg;
    }

    public function addAdm($post,$list,$lang){
        $msg = '';
        if (isset($post['addAdm'])) {
            $id = (int) $post['id'];
            if ($this->searchIdList($list, $id) !== false) {
                if ($post['pass'] != $post['repass']) {
                    $msg = Message('warning', $lang->get('msg_add_pass'));
                } else {
                    $acc = $this->selectAccount($id);
                    if ($acc === false) {
                        $msg = Message('info', $lang->get('msg_add_acc'));
                    } else {
                        $create = $this->createAdm($acc,$post['repass']);
                        if($create === true){
                            $msg = Message('success', $lang->get('msg_add_create'));
                            $this->refresh(1);
                        }else{
                            $msg = Message('error', $lang->get('msg_add_error'));
                        }
                    }
                }
            }else{
                $msg = Message('info', $lang->get('msg_add_there'));
            }
        }
        return $msg;
    }
    
    private function searchIdList($list,$id){
        if(is_array($list)){
            foreach ($list as $val) {
                if($val['acc_id'] == $id){
                    return false;
                }
            }
        }
    }


    public function createAdm($account,$pass){
        $password = \app\model\user\account::GeneratePassword($account['name'], $pass);
        $id = $account['id'];
        $this->connect->query("INSERT INTO ^admin (id_account,pass) VALUES('$id','$password')");
        if($this->connect->getLastId()){
            return true;
        }else{
            return false;
        }
    }

    private function selectAccount($id){
        $db = $this->connect->query('SELECT id,name FROM ^users WHERE id = '.$id);
        if($db->num_rows > 0){
            return $db->row;
        }else{
            return false;
        }
    }
}
