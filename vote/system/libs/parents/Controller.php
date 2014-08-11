<?php
namespace libs\parents;
if(!defined('DOST')){ die(header("HTTP/1.x 404 Not Found"));}

class Controller{
    public $get = array();
    protected $app_path;
    protected $sys_path;
    protected $config;
    protected $session;
    protected $style;
    protected $leng;
    protected $view;
    protected $data = array();

    public function __construct($config = '', $session = '') {
        $this->app_path = stristr(APP_PATH,DS.'app',true);
        $this->sys_path = SYS_PATH;
        $this->config = $config;  
        $this->session = $session;
        $this->style = (reqest('=admin') === true) ? 'admin' : $this->config->style;
        $this->leng = new \libs\Lang\Language($this->config->lang);
        $this->view = new \libs\parents\View($this->style);
        $this->data['folder'] = folder();
    }

    public function __get($name) {
        if (strpos($name, '_') !== false) {
            $name = explode('_', $name);
            $str = '';
            $ph = '';
            if (is_array($name)) {
                foreach ($name as $names) {
                    $str .= '\\' . $names;
                    $ph .= DS. $names;
                }
                $path = $this->app_path . $ph.'.php';
            }
            
            if (file_exists($path)) {
                return new $str($this->config,  $this->session);
            } else {
                throw new \libs\Exception\ExceptMsg('An error occurred ! Try again later. :: Not found File ->' . $path . ' !!!');
            }
        }
    }

    protected function unsetSession(){
        $this->session->unsetSession(); 
        $this->refresh();
    }

    protected function getHeader($title = '',$desc = '',$keyw = '',$mess = ''){       
        $head = $this->app_controller_common_head;
        $head->title = $title;
        $head->description = $desc;
        $head->keywords = $keyw;
        $header =  $this->app_controller_common_header;
        $header->message = $mess;
        $this->data['head'] = $head->head();
        $this->data['header'] = $header->header();
        return $this->data;
    }
    
    protected function getHeaderAdmin($title = '',$desc = '',$keyw = '',$mess = ''){       
        $head = $this->app_controller_admin_head;
        $head->title = $title;
        $head->description = $desc;
        $head->keywords = $keyw;
        $header =  $this->app_controller_admin_header;
        $header->message = $mess;
        $this->data['head'] = $head->head();
        $this->data['header'] = $header->header();
        return $this->data;
    }
    
    protected function getFooter(){
        $footer = $this->app_controller_common_footer;
        $this->data['footer'] = $footer->footer();
    }
    
    protected function getFooterAdmin(){
        $footer = $this->app_controller_admin_footer;
        $this->data['footer'] = $footer->footer();
    }

    protected function refresh($sec = 0,$url = ''){
        if($url == ''){
          header("Refresh: $sec;");
        }else{
          header('Refresh: '.$sec.'; URL='.URL_PATH.folder().'/' .$url);
        }
        
    }
    
    protected function redirect($url = '', $status = 302) {
		//header('Status: ' . $status);
		header('Location: /'.folder().'/' .$url);
    }

    protected function render($name , $folder = ''){
        echo $this->view->getTemplate($folder, $name ,$this->data);
    }
    
    protected function refer(){
        if(isset($_SERVER['HTTP_REFERER'])){
            $url = $_SERVER['HTTP_REFERER'];
        }else{
            $url = '/'.$this->data['folder'].'/';
        }
        $this->redirect($url);
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
    
    protected function NotFound(){
        require_once $this->app_path.DS.'app'.DS.'view'.DS.'not_found.php';
    }
}
