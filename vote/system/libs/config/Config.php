<?php
namespace libs\config;
if(!defined('DOST')){ die(header("HTTP/1.x 404 Not Found"));}

class Config 
{
    private $path_conf;
    private static $_path;
    private $prefix_file = 'conf_';
    private static $_prefix_file = 'server_';
    private $config = array();
    protected static $_server_config;
    protected static $_config_db;
    protected static $_config;   
    protected static $_Lang;

    public function __construct() {
        $this->path_conf = SYS_PATH.'config'.DS;
        self::$_path = SYS_PATH.'config'.DS;
        $this->searchConf();
        $this->openConfigsite();
    }

    private function searchConf() {
        if ($this->path_conf) {
            $file_conf = scandir($this->path_conf);
            if (is_array($file_conf)) {
                foreach ($file_conf as $name_file) {
                    if (strstr($name_file, $this->prefix_file)) {
                        $name = str_replace('.php', '', $name_file);
                        if($name == 'conf_web'){
                           $this->config[$name] = $name_file;
                        }else{
                            self::$_config[$name] = $name_file;
                        }
                    }
                }
            }
        }
    }

    private function openConfigSite() {
        if (isset($this->config)) {
            $conf_web = (array_key_exists('conf_web', $this->config) === true) ? $this->config['conf_web'] : false;
            if ($conf_web !== false) {
                require_once $this->path_conf . $conf_web;
                unset($this->config['conf_web']);
                if (isset($conf) and is_array($conf)) {
                    foreach ($conf as $key => $val) {
                        $this->config['conf_web'][$key] = $val;
                    }
                }
                $GLOBALS['Lang'] = $this->config['conf_web']['lang'];
                $GLOBALS['cache_params'] = $this->config['conf_web']['cache'];
                $GLOBALS['cache'] = $this->config['conf_web']['cache_time'];
                $GLOBALS['display_error_user'] = $this->config['conf_web']['display_error'];
                $GLOBALS['log_error'] = $this->config['conf_web']['log_error'];
            }
        }
    }
    
    public function __set($key, $value) {
        $this->config['conf_web'][$key] = $value;
    }
    
    public function __get($key){
        return $this->config['conf_web'][$key];
    }
    
    public static function openConfigOther(){
        $int = '';
        if(isset(self::$_config) and is_array(self::$_config)){
            foreach (self::$_config as $key => $val) {
                 if(strpos($key, self::$_prefix_file)){
                     $num = explode('_', $key);
                     $int = $num[2];
                 } 
                 require_once self::$_path.$val;
                 unset(self::$_config[$key]); 
                 if (isset($conf) and is_array($conf)) {  
                     self::configDistribution($conf, $key,$int);
                 }  
                 unset($conf);               
            }
        }
    }
    
    private static function configDistribution($arrayConf, $keys ,$i) {
        if (strstr($keys, self::$_prefix_file)) {
            self::$_server_config[$i] = $arrayConf;
        } elseif(strstr($keys, '_db')){
            self::$_config_db = $arrayConf;
        }
    }

}
