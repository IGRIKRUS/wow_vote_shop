<?php
namespace libs\load;
if(!defined('DOST')){ die(header("HTTP/1.x 404 Not Found"));}

class Autoload 
{
    public static $ext = '.php';
    private static $app_path;
    private static $sys_path;

    public static function Run() {
        self::$app_path = stristr(APP_PATH,'app',true);
        self::$sys_path = SYS_PATH;
        spl_autoload_register(array('libs\\load\\Autoload','loadClass'));
    }
    
    public static function loadClass($class){
        if(strpos($class, '\\') !== false){
            $class = str_replace('\\', DS, $class);
            $sub_name = explode(DS, $class);
            if($sub_name[0] !== 'app'){
                $file = self::$sys_path.$class.self::$ext;
            }else{
                $file = self::$app_path.$class.self::$ext;
            }

            if(file_exists($file)){
                require_once $file;
            }else{
                throw new \libs\Exception\ExceptMsg('An error occurred ! Try again later. :: File -> '.$file.' Not found !');
            }
        }
    }

}
