<?php
namespace app\model\user;
if(!defined('DOST')){ die(header("HTTP/1.x 404 Not Found"));}

class account extends \libs\parents\Model
{
    public $params;

    public function Authentication($login, $pass, $realm_id, $session,$type = '') {
        $msg = '';
        $account = $this->accounts($login, $realm_id);
        if ($account['online'] == 0) {
            if ($account !== false) {
                $pass_db = $this->un_pass($account['pass']);
                $repass = $this->un_pass($this->compiled_passhash($this->PassServer($login, $pass), $pass_db['salt']));
                if ($pass_db['pass'] == $repass['pass']) {
                    $this->updateDate($account['id'], $session);
                    $this->params['id'] = $account['id'];
                    $this->params['name'] = $account['name'];
                    $msg = 'true';
                } else {
                    $msg = 'Pass';
                }
            } else {
                $server = new \app\model\server\server_db();
                $account_server = $server->Authentication($login, $realm_id);
                if ($account_server === null) {
                    $msg = 'null';
                } elseif ($account_server === false) {
                    $msg = 'false';
                } else {
                    if ($account_server['sha_pass_hash'] == $this->PassServer($login, $pass)) {
                        $id = $this->create_account($account_server['id'], $account_server['username'], $account_server['sha_pass_hash'], $realm_id, $session,$type);
                        if ($id) {
                            $this->params['id'] = $id;
                            $this->params['name'] = $account_server['username'];
                            $chars = $server->searchCharacters($account_server['id'], $realm_id);
                            if ($chars) {
                                $this->create_characters($id, $realm_id, $chars);
                            }
                            $msg = 'true';
                        }
                    } else {
                        $msg = 'Pass';
                    }
                }
            }
        } else {
            $msg = 'online';
        }
        return $msg;
    }

    private function updateDate($id,$session){
        $this->connect->query('UPDATE ^users SET last_date=NOW(),id_session = "'.$session.'",online= 1 WHERE id = '.$id);
    }

    private function accounts($login,$realm){
        $db = $this->connect->query('SELECT id,name,pass,Vp,id_acc,online FROM ^users WHERE id_realm = "'.  $this->connect->escape($realm).'" AND name = "'.$this->connect->escape($login).'"');
        if($db->num_rows > 0){
            return $db->row;
        }else{
            return false;
        }
    }
    
    private function update_pass_account($id,$pass){
        $this->connect->query("UPDATE ^users SET pass='$pass'  WHERE id = $id ");
        if($this->connect->countAffected()){
            return true;
        }else{
            return false;
        }
    }

    private function create_account($id_acc,$name,$pass,$realm_id,$session,$type){
        if($type === ''){
            $type = 1;
        }
        $password = $this->compiled_passhash($pass);
        $this->connect->query("INSERT INTO ^users (name,pass,date,last_date,id_realm,id_acc,id_session,online) VALUES('$name','$password',NOW(),NOW(),$realm_id,$id_acc,'$session','$type')");
        if($this->connect->getLastId()){
            return $this->connect->getLastId();
        }else{
            return false;
        }
    }
    
    public function selectVP($id){       
          $db = $this->connect->query('SELECT Vp FROM ^users WHERE id = '.$id);
          if($db->num_rows > 0){
              return $db->row['Vp'];
          }else{
              return 0;
          }
    }
    
    public function updateVP($Vp,$id){
        $this->connect->query("UPDATE ^users SET Vp='$Vp'  WHERE id = $id ");
        if($this->connect->countAffected()){
            return true;
        }else{
            return false;
        }
    }

    public function Admin($id, $login = '') {
        $db = $this->connect->query('SELECT id,pass,online FROM ^admin WHERE id_account = ' . $id);
        if ($db->num_rows > 0) {
            if ($login == '') {
                return true;
            }elseif($login === true){
                return $db->row;
            }
        } else {
            return false;
        }
    }

    public function AdminLogin($post,$session,$lang){
        if (isset($post['send'])) {
            if ($post['login'] != '' and $post['pass'] != '') {
                $id = $session->user['id'];                
                $result = $this->Admin($id, true);
                if ($result !== false) {
                    if ($post['login'] != strtolower($session->user['name'])) {
                        $msg = Message('info', $lang->get('msg_login'));
                    }elseif($result['online'] == 1){   
                        $msg = Message('info', $lang->get('msg_online'));
                    } else {
                        $pass_db = $this->un_pass($result['pass']);
                        $input_pass = $this->un_pass($this->compiled_passhash($this->PassServer($post['login'], $post['pass']), $pass_db['salt']));
                        if ($pass_db['pass'] == $input_pass['pass']) {
                            if ($this->AuthorizationAdmin($session) === false) {
                                $msg = Message('error', $lang->get('msg_error').'123');
                            } else {
                                $msg = Message('success', $lang->get('msg_success'));
                            }
                        } else {
                            $msg = Message('info', $lang->get('msg_pass'));
                        }
                    }
                } else {
                    $msg = Message('info', $lang->get('msg_error'));
                }
            } else {
                $msg = Message('info', $lang->get('msg_null'));
            }

            return $msg;
        }
    }
    
    private function AuthorizationAdmin($session){
        $id = $session->user['id'];
        $auth = $this->updateAccountOnline($id, 'admin', 1);
        if($auth !== false){
            $session->admin = $id;
            $this->refresh(1);
        }else{
            return false;
        }       
    }
    
    public function updateAccountOnline($id,$table,$type){
        if($table == 'admin'){
            $column = 'id_account';
        }elseif($table == 'users'){
            $column = 'id';
        }
        $this->connect->query("UPDATE ^$table SET online='$type' WHERE $column = '$id' ");        
        if($this->connect->countAffected()){
            return true;
        }else{
            return false;
        }
    }
    
    public function TimeUpdateAccount($session_time){
        $db = $this->connect->query('SELECT ^users.id,^admin.online FROM ^admin RIGHT JOIN  ^users ON ^users.id=^admin.id_account WHERE last_date < NOW() -  INTERVAL '.$session_time.' SECOND AND ^users.online = 1');
        if($db->num_rows  > 0){
            return $db->rows;
        }else{
            return false;
        }
    }

    private function create_characters($id_account,$id_realm,$chars){
        $zap = '';
        
        if(isset($chars) and is_array($chars)){
            $zap .= 'VALUES';
            foreach ($chars as $characters) {
                $name = $characters['name'];
                $zap .= "('$id_account','$id_realm','$name'),";
            }
            $sql = substr($zap, 0, strlen($zap)-1);
            $this->connect->query('INSERT INTO ^users_char_info (id_user,id_realm,char_name) '.$sql.';');
            if($this->connect->getLastId()){
                return true;
            }else{
                return false;
            }
        }
    }
    
    public function select_characters($id,$realm_id){
        $db = $this->connect->query('SELECT id,char_name FROM ^users_char_info WHERE id_user = '.$id.' AND id_realm = '.$realm_id);
        if($db->num_rows > 0){
             return $db->rows;
        }else{
             return false;
        }
    }
    
    public function delete_characters($id,$id_user){
         $this->connect->query("DELETE FROM ^users_char_info WHERE id_user = '$id_user' AND id= '$id'");
    }

    public function countServers(){
        return $count = count($this->ServerConfig());
    }
    
    public function Servers(){
        return $this->ServerConfig();
    }

    private function PassServer($login,$pass){
        return sha1(strtoupper($login).':'.strtoupper($pass));
    }

    private static function generate_pass_salt($len = 5) {
        $salt = '';
        for ($i = 0; $i < $len; $i++) {
            $num = rand(33, 126);

            if ($num == '92' || $num == '39') {
                $num = 93;
            }

            $salt .= chr($num);
        }
        $salts = str_replace(array('"','?'), '', $salt);
        return $salts;
    }
    
    private static function compiled_passhash($password,$salt = '') {
        if ($salt == '') {
            $salts = self::generate_pass_salt();
        } else {
            $salts = $salt;
        }
        $pass = md5(md5($salts . $password));
        $ser = array('pass'=>$pass,'salt'=>$salts);
        return serialize($ser);
    }
    
    private static function un_pass($serialize){
        return unserialize($serialize);
    }
    
    public static function GeneratePassword($login,$pass){
        return self::compiled_passhash(strtoupper(sha1(strtoupper($login).':'.strtoupper($pass))));
    }


    public function account_settings($post,$session,$lang){
       $msg = '';
       if(isset($post['editpass'])){
           if($post['pass'] == '' || $post['newpass'] == '' || $post['renewpass'] == ''){
                $msg = Message('info', $lang->get('message_null'));
           }else{
               $account = $this->accounts($session['name'], $session['realm_id']);
               $pass = $this->un_pass($account['pass']);
            
               $pass_input = $this->un_pass($this->compiled_passhash($this->PassServer($session['name'],$post['pass']),$pass['salt']));
               if($pass_input['pass'] != $pass['pass']){
                   $msg = Message('info', $lang->get('message_pass'));
               }else{
                   if($post['newpass'] != $post['renewpass']){
                       $msg = Message('info', $lang->get('message_newpass'));
                   }elseif($post['newpass'] == $post['pass']){
                       $msg = Message('info', $lang->get('message_old_password'));
                   }else{
                       $new_pass = $this->compiled_passhash($this->PassServer($session['name'],$post['renewpass']));
                       if($this->update_pass_account($session['id'], $new_pass)){
                           $msg = Message('success', $lang->get('message_success'));
                           $this->refresh(1);
                       }
                   }
               }
           }
       }

       if(isset($post['update'])){
          $server = new \app\model\server\server_db(); 
          $acc = $this->accounts($session['name'],$session['realm_id']);
          $char = $this->select_characters($session['id'], $session['realm_id']);
          $char_list = $server->searchCharactersUpdate($acc['id_acc'], $session['realm_id'], $char);
          if($char_list == 'error'){
              $msg = Message('info', $lang->get('message_server'));
          }elseif($char_list !== false){
              $update = $this->create_characters($session['id'], $session['realm_id'], $char_list);
              if($update === true){
                  $msg = Message('success', $lang->get('update_secces'));
                  $this->refresh(1);
              }else{
                  $msg = Message('error', $lang->get('error_message'));
              }
          }else{
              $msg = Message('info', $lang->get('message_char_null'));
          }
          
       }
       
       return $msg;
    }
}
