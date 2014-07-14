<?php
namespace libs\parents;
if(!defined('DOST')){ die(header("HTTP/1.x 404 Not Found"));}

class Model extends \libs\config\Config
{
    protected $db;
    protected $driver;
    public $connect;
    protected $Lang;
    protected $cache;
    protected $fileManager;

    public function __construct() {
        $this->cache = new \libs\Cache\CacheDB();
        $this->fileManager = new \libs\File\FileManager();
        self::openConfigOther();
        $this->Lang = $GLOBALS['Lang'];
        $this->db = $this->SiteConfig();
        $this->driver = $this->db['driver'];
        $this->connect = $this->getConnectionSite();        
    }
    
    public function connect($config,$key_base){
        $name_driver = '\\libs\\Driver\\'.$this->driver;
        $ObjDB = new $name_driver($config['host'], $config['user'], $config['pass'], $config[$key_base],$config['port'], (isset($config['prefix']) ? $config['prefix'] : ''), $config['ecoding']);
        return $ObjDB;
    }
    
    public function SoapConnect($config,$params,$char){
        $log['log'] = $config['soap_log'];
        $log['name']= $config['server_name'];
        $soap = new \libs\Soap\SoapSend($config['soap_host'], $config['soap_port'], $config['soap_login'], $config['soap_pass'], $config['soap_title'], $config['soap_text'], $params,$char,$log);
        return $soap;
    } 

    private function getConfig($key){
        if($key == 'config_db'){
            return self::$_config_db;
        }elseif($key == 'config_server'){
            return self::$_server_config;
        }
    }
    
    public function ServerConfig(){
        return $this->getConfig('config_server');
    }
    
    public function SiteConfig(){
        return $this->getConfig('config_db');
    }
    
    public function getConnectionSite(){
        return $this->connect($this->SiteConfig(), 'base');
    }
    
    public function getConnectionServer($key = '',$base = ''){
        $conf = $this->ServerConfig();
        return $this->connect($conf[$key], $base);
    }
    
    protected function refresh($sec = 0){
        header("Refresh: $sec;");
    }
    
    protected function BuildVersion($build){
        if ($build <= '6005') {
            $varsion = 1;
        } else
        if ($build <= '8606') {
            $varsion = 2;
        } else
        if ($build <= '12340') {
            $varsion = 3;
        } else
        if ($build <= '15595') {
            $varsion = 4;
        } else
        if ($build <= '18019') {
            $varsion = 5;
        }
        return $varsion;
    }
    
}
