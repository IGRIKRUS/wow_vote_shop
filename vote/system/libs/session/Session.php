<?php
namespace libs\session;
if(!defined('DOST')){ die(header("HTTP/1.x 404 Not Found"));}

class Session 
{
    protected $data = array();
    private   $sesion_time;

    public function __construct($config) {
        if (!session_id()) {
            session_start();
        }
        
        $this->sesion_time = $config;
        $this->data =& $_SESSION;
        
        if(isset($this->data['admin']) and $this->data['admin'] === true){
           $GLOBALS['display_error'] = 'Error_all';
        }else{
           $GLOBALS['display_error'] = null; 
        }
        
        $this->data['active'] = $this->activeSession();
        $this->data['getId'] = $this->getId();
        $this->data['activeAdmin'] = $this->getSessionAdmin();
        $this->data['timeSession'] = $this->timeSession();
    }
    
    public function __get($key) {
        return (isset($this->data[$key]) ? $this->data[$key] : null);
    }
    
    public function __set($name, $value) {
        $this->data[$name] = $value;
    }

    protected function getId(){
        return  session_id();
    }
    
    protected function activeSession() {
        if (!isset($this->data['user'])) {
            $this->data['user'] = false;
        }
        return $this->data['user'];
    }

    protected function getSessionAdmin() {
        if (!isset($this->data['admin'])) {
            $this->data['admin'] = false;
        }
        return $this->data['admin'];
    }

    protected function timeSession($user_active = true) {
        $time = time();
        $account = new \app\model\user\account();
        $prm = $account->TimeUpdateAccount($this->sesion_time);
        if ($prm !== false) {
            foreach ($prm as $val) {
                $account->updateAccountOnline($val['id'], 'users', 0);
                if ($val['online'] == 1) {
                    $account->updateAccountOnline($val['id'], 'admin', 0);
                }
            }
        }
        if ($this->sesion_time and $this->activeSession() == true) {

            if (isset($this->data['session_time_user']) && $time - $this->data['session_time_user'] >= $this->sesion_time) {
                $this->unsetSession();
                return false;
            } else {
                if ($user_active) {
                    $this->data['session_time_user'] = $time;
                }
            }
        }
        return true;
    }

    public function unsetSession() {
        if ($this->data['user'] !== false or $this->data['admin'] !== false) {
            $account = new \app\model\user\account();  
            unset($this->data['session_time_user']);            
            $account->updateAccountOnline($this->data['user']['id'], 'users', 0);
            
            if (isset($this->data['admin']) and is_numeric($this->data['admin'])) {
                $account->updateAccountOnline($this->data['admin'], 'admin', 0);
                unset($this->data['admin']);
            }
            session_unset();
            session_destroy();
            header("Refresh: 1;");
        }
    }
}
