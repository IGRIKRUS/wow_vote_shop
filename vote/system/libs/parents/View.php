<?php
namespace libs\parents;
if(!defined('DOST')){ die(header("HTTP/1.x 404 Not Found"));}

class View 
{
    private $path_template;
    private $ext = '.php';
    protected $output;
    public function __construct($style_dir,$init = false) {
        if($init === false){
          $this->path_template = APP_PATH.'view'.DS.$style_dir.DS.'theme'.DS;
        }else{
          $this->path_template = SYS_PATH.'install'.DS.$style_dir.DS;  
        }
    }
    
    public function getTemplate($folder = '',$name = '', array $data){
        if(isset($folder) !== false and isset($name) !== false){
            $path = $this->path_template.$folder.DS.$name.$this->ext;
        }elseif(isset($folder) === false and isset($name) !== false){
            $path = $this->path_template.$name.$this->ext;
        }
        
        if(file_exists($path)){
            if($data){
               extract($data);
            }

            ob_start();

	    require $path;

	    $this->output = ob_get_contents();

	    ob_end_clean();

	    return $this->output;
            
        }else{
            throw new \libs\Exception\ExceptMsg('Could not load template. Try again later. :: Not found template ->'.$path);
        }
    }
}
