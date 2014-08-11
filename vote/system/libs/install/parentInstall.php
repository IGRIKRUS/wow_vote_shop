<?php
namespace libs\install;
if(!defined('DOST')){ die(header("HTTP/1.x 404 Not Found"));}

class parentInstall 
{    
    public $get = array();
    protected $data = array();
    protected $lang;
    protected $view;
    protected $def_conf = array();
    protected $fileManager;
    protected $config = false;
    protected $installConf;
    protected $installDB;

    public function __construct(){
        $this->lang = new \libs\Lang\Language('ru_RU');
        $this->view = new \libs\parents\View('theme_install',true);
        $this->fileManager = new \libs\File\FileManager();
        $this->installConf = new \libs\install\InstallConf();
        $this->installDB = new \libs\install\InstallDB();
        $this->def_conf['lang'] = 'ru_RU';
        $this->def_conf["cache_time"] = 86400;
        $this->def_conf["session_time"] = 300;
        $this->def_conf["default_page"] = 'Home';
        $this->def_conf["ecoding_html"] = 'UTF-8';
        $this->def_conf["style"] = 'default';
        $this->file_cfg();
        $this->data['folder'] = folder();
        $this->data['header'] = $this->header();
        $this->data['footer'] = $this->footer();
    }
    
    public function __get($key){
        return $this->def_conf[$key];
    }

    protected function header(){
       $this->data['title'] = 'Install Vote Shop'; 
       $this->data['ecoding'] = 'UTF-8';
       $this->data['style'] = 'admin';
       return $this->view->getTemplate('common', 'header' ,$this->data);    
    }
    
    protected function footer(){
       return $this->view->getTemplate('common', 'footer' ,$this->data);    
    }

    protected function file_cfg(){
        $path = SYS_PATH.'config'.DS;
        $conf_web = $path.'conf_web.php';
        $conf_db = $path.'conf_db.php';
        if(file_exists($conf_web) and file_exists($conf_db)){
             new \libs\config\Config();
             $this->config = true;
        }
    }

    protected function not_found(){
        require_once APP_PATH.'view'.DS.'not_found.php';
    }

    protected function refresh($sec = 0,$url = ''){
        if($url == ''){
          header("Refresh: $sec;");
        }else{
          header('Refresh: '.$sec.'; URL='.URL_PATH.folder().'/' .$url);
        }
        
    }
    
    protected function redirect($url = '', $status = 302) {
		header('Location: /'.folder().'/' .$url);
    }
    
    protected function route(){
        if(isset($_GET['route'])){
            $this->get = $this->getUrl();
        }else{
            $this->get = false;
        }
    }
    
    protected function getUrl(){
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

    protected function Post($post){
        if(is_array($post)){
            foreach ($post as $key => $value) {
                $post[$key] = strip_tags($value);
                $post[$key] = htmlspecialchars($post[$key],ENT_QUOTES);
                $post[$key] = filter_var($post[$key], FILTER_SANITIZE_STRING);
            }
            return $post;
        }
    }
    
    protected function render($name , $folder = ''){
        echo $this->view->getTemplate($folder, $name ,$this->data);
    }
    
    protected function scan($params){
        return \app\model\admin\conf::scan_dirs($params);
    }
    
    protected function scan_conf($path,$file){
        $result = $this->fileManager->Scandir($path);
        if(array_search($file, $result) !== false){
            return true;
        }else{
            return false;
        }
    }
    
    protected function create_conf($post,$conf){
        return \app\model\admin\conf::Conf($this->Post($post), $conf);
    }
}
