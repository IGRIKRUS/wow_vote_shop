<?php
namespace libs\File;
if(!defined('DOST')){ die(header("HTTP/1.x 404 Not Found"));}

class FileManager 
{
    private $app_path;
    private $sys_path;

    public function __construct() {
        $this->app_path = stristr(APP_PATH,DS.'app',true);
        $this->sys_path = stristr(SYS_PATH,DS.'system',true);
    }
    
    public function Scandir($path_prm = '') {
        if ($path_prm != '') {
            if (strpos($path_prm, '/') !== false) {
                $path_prm = explode('/', $path_prm);
                $folder = $path_prm[1];
                $path_prm = implode(DS, $path_prm);
            }
            
            $path = $this->pathDir($folder);
            
            $array = scandir($path . $path_prm);
            return $array; 
        }
    }

    private function pathDir($folder = '') {
        if ($folder == 'app') {
            return $this->app_path;
        } elseif ($folder == 'system') {
            return $this->sys_path;
        }
    }

    public function updateConfSite($conf = '') {
        if (is_array($conf)) {
            
            $file = ROOT_PATH.DS.'system'.DS.'config'.DS.'conf_web.php';
            $handle = fopen($file, 'w');

            fwrite($handle, '<?php if(!defined("DOST")){ die(header("HTTP/1.x 404 Not Found"));}'."\n");
            foreach ($conf as $key => $val) {
                fwrite($handle, '$conf["'.$key.'"] = '.$val.";\n");
            }

            fclose($handle);
        }
    }
    
    public function CreateConf($path, $conf) {
        if (is_array($conf)) {

            $handle = fopen($path, 'w');

            fwrite($handle, '<?php if(!defined("DOST")){ die(header("HTTP/1.x 404 Not Found"));}' . "\n");
            foreach ($conf as $key => $val) {
                fwrite($handle, '$conf["' . $key . '"] = ' . $val . ";\n");
            }
            fclose($handle);
            
            if(file_exists($path)){
                return true;
            }else{
                return false;
            }
        }
    }

    public function parser_file_mmotop($file) {
        $date = time() - 86400;
        $name = array();
        if ($data = @file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)) {
            foreach ($data as $key => $value) {
                $vals = preg_replace("|\s+|i", " ", $value);
            
                $val[$key] = explode(" ", $vals);
                $val[$key]['date'] = strtotime($val[$key][1] . ' ' . $val[$key][2]);
            
                if ($date > $val[$key]['date']) {
                    unset($val[$key]);
                }else{
                    if($val[$key][5] == '2'){
                        $name['sms'][$key] = $val[$key][4].':'.$val[$key]['date'];
                    }
                    if($val[$key][5] == '1'){
                        $name['vote'][$key] = $val[$key][4].':'.$val[$key]['date'];
                    }
                }
            }
            return $name;
        }
    }
    
    public function DirVote($folder = ''){      
        $folder = substr($folder, 1);
        $path = $this->pathDir($folder).DS.$folder.DS;
        $mod['log'] = $this->chmod_dir($path.'log'.DS);
        $mod['cache'] = $this->chmod_dir($path.'cache'.DS);
        $mod['conf'] = $this->chmod_dir($path.'config'.DS);
        if($mod['log'] >= 777){
            $mod['log'] = true;
        }else{
            $mod['log'] = false;
        }
        
        if($mod['cache'] >= 777){
            $mod['cache'] = true;
        }else{
            $mod['cache'] = false;
        }
        
        if($mod['conf'] >= 777){
            $mod['conf'] = true;
        }else{
            $mod['conf'] = false;
        }
        
        return $mod;
    }
    
    public function chmod_dir($path){
        return substr(decoct(fileperms($path)), -3);
    }

    public function scan_upload_items(){
        return array_diff($this->Scandir('/system/install/upload/table'),array('.','..','vote'));
    }
    
    public function scan_upload_items_base($build){
        return array_diff($this->Scandir('/system/install/upload/table/'.$build),array('.','..','create_table.php'));
    }
    
    public function open_file_tables($path){
        if(file_exists($path)){
            require_once $path;
            return $table;
        }else{
            return false;
        }
    }
    
    public function open_file_insert($path){
        $file = file_get_contents($path);
        if($file !== false){
            $data = explode(');', $file);
            if(is_array($data)){
                $zap = array();  
                array_pop($data);
                foreach ($data as $key => $val) {
                    if($data[$key] != ''){
                    $zap[$key] = $val.')';
                    }else{
                        $zap = false;
                    }
                }
                return $zap;
            }
        }else{
            return false;
        }
    }
    
    public function editIndex($file){
        $path = SYS_PATH.'install'.DS.'upload'.DS.'file'.DS.$file;
        $edit = $this->sys_path.DS.'index.php';
        if(file_exists($path)){
            if(copy($path, $edit)){
                return true;
            }else{
                return false;
            }
        }
    }






    /* public function array_dirs($path) {
        $dir = array();
        $arr = opendir($path);
        while ($v = readdir($arr)) {
            if ($v == '.' or $v == '..')
                continue;

            if (!is_dir($path . DS . $v) and $v != '.htaccess' and $v != 'index.html') {
                $dir[] = $v;
            }

            if (is_dir($path . DS . $v)) {
                $dir[$v] = $this->type($path . DS . $v);
            }
        }
        return $dir;
    }*/

}
