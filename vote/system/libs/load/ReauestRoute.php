<?php
namespace libs\load;
if(!defined('DOST')){ die(header("HTTP/1.x 404 Not Found"));}

class ReauestRoute {   
    protected static $_request = null; 
    protected static $_config;
    protected static $_session;
    protected $_get = array(0 => null);
    protected static $_path_app;
    public $ext = '.php';

    private function __construct() {        
    }

    public static function getInstance($config , $session) {
        if (self::$_request === null) {
            self::$_request = new self;
            self::$_config = $config;
            self::$_session = $session;
            self::$_path_app = APP_PATH;
        }
 
        return self::$_request;
    }
  
    private function __clone() {
    }

    private function __wakeup() {
    }
    
    public function Run(){
        if(isset($_GET['route'])){
            $this->_get = $this->getUrl();
        }
        return $this->getController();
    }
    
    public function getUrl(){
       $url = strstr($_GET['route'],'.html',true);
       if($url == true){
           $array_get = explode('/', $url);
       }else{
           $array_get = explode('/', $_GET['route']);
       }
       if(is_array($array_get)){
           foreach ($array_get as $key => $value) {
                      if($array_get[$key] == ''){
                          unset($array_get[$key]);
                      }
           }
       }       
       return $array_get;
    }
    
    public function getController(){
        if(($this->_get[0] === null || $this->_get[0] == 'index') and isset($this->_get[1]) === false){
            if($this->searchController(self::$_config->default_page) === true){
                $name_controller = 'app\\controller\\page\\'.ucfirst(self::$_config->default_page);
                $controller = new $name_controller(self::$_config,self::$_session);
                $this->searchMethod($controller, 'ActionIndex');
                return $controller;
            }else{
                $this->getNotFound();
            }
        }else{
            if($this->searchController($this->_get[0]) === true){
                $name_controller = 'app\\controller\\page\\'.ucfirst($this->_get[0]);
                $name_method = 'Action'.ucfirst((isset($this->_get[1]) ? ucfirst($this->_get[1]) : 'Index'));
                $controller = new $name_controller(self::$_config,self::$_session);
                $this->methodGet($controller);    
                $this->searchMethod($controller, $name_method);
                return $controller;
            }else{
                $this->getNotFound();
            }
        }
    }
    
    private function searchController($get){
        if(file_exists(self::$_path_app.'controller'.DS.'page'.DS.ucfirst($get).$this->ext)){
            return true;
        }else{
            return false;
        }
    }
    
    public function getNotFound(){
        require_once self::$_path_app.'view'.DS.'not_found.php';
    }
    
    private function searchMethod($controller,$method){
        if(method_exists($controller, $method)){
            $controller->$method();
        }else {
            $this->getNotFound();
        }
    }
    
    private function methodGet($controller){
           if(isset($this->_get[2]) !== false){
               unset($this->_get[0],$this->_get[1]);
               $controller->get = array_merge($this->_get);
           }else{
               $controller->get[0] = null;
           }        
    }
    
}

