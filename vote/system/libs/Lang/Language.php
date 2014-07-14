<?php
namespace libs\Lang;
if(!defined('DOST')){ die(header("HTTP/1.x 404 Not Found"));}

class Language 
{
    private $default_leng;
    private $path_leng;
    private $data = array();


    public function __construct($lang = '') {
        $this->default_leng = $lang;
        if(is_dir(SYS_PATH.'Lang'.DS.$this->default_leng.DS)){
            $this->path_leng = SYS_PATH.'Lang'.DS.$this->default_leng.DS;
        }else{
            throw new \libs\Exception\ExceptMsg('An error occurred ! Try again later. :: Not found folder Lang -> '.SYS_PATH.'Lang'.DS.$this->default_leng.DS);
        }
       
    }
    
    public function load($filename){
       $file = $this->path_leng.$filename.'.php';
       if(file_exists($file)){
           $_ = array();

	   require($file);

	   $this->data = array_merge($this->data, $_);

	   return $this->data;
       }else{
           throw new \libs\Exception\ExceptMsg('Could not load language. Try again later. :: Not found file Lang -> '.$file);
       }
    }
    
    public function get($key) {
        return (isset($this->data[$key]) ? $this->data[$key] : $key);
    }
}
