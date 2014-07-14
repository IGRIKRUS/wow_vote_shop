<?php
namespace libs\Cache;
if(!defined('DOST')){ die(header("HTTP/1.x 404 Not Found"));}

class CacheDB{

    private $cache_path;
    public $params;

    public function __construct() {
        $this->cache_path = SYS_PATH.'cache'.DS;
        if(isset($GLOBALS['cache']) and !empty($GLOBALS['cache'])){
            $this->time_cache = $GLOBALS['cache'];
        }else{
            $this->time_cache = 3600;
        }
        
        if(isset($GLOBALS['cache_params']) and !empty($GLOBALS['cache_params'])){
            $this->params = $GLOBALS['cache_params'];
        }else{
            $this->params = false;
        }
    }

    public function get($key) {
        $files = glob($this->cache_path . 'cache.' . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '.*');

        if ($files and $this->params === true) {
            $cache = file_get_contents($files[0]);

            $data = unserialize($cache);

            foreach ($files as $file) {
                $time = substr(strrchr($file, '.'), 1);

                if ($time < time()) {
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
            }

            return $data;
        }
    }

    public function set($key, $value) {
        if($this->params === true){
        $this->delete($key);

        $file = $this->cache_path . 'cache.' . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '.' . (time() + $this->time_cache);

        $handle = fopen($file, 'w');

        fwrite($handle, serialize($value));

        fclose($handle);
        }
    }

    public function delete($key) {
        $files = glob($this->cache_path . 'cache.' . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '.*');

        if ($files) {
            foreach ($files as $file) {
                if (file_exists($file)) {
                    unlink($file)or die('error');
                }
            }
        }
    }

}
