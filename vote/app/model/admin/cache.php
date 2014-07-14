<?php
namespace app\model\admin;
if(!defined('DOST')){ die(header("HTTP/1.x 404 Not Found"));}

class cache extends \libs\parents\Model{
    
    public function cache_list() {
        $list = $this->fileManager->Scandir('system/cache');
        if ($list) {
            $cache = array();
            foreach ($list as $val) {
                if ($val !== '.' and $val !== '..' and $val !== 'index.html') {
                    $cache[] = $val;
                }
            }
            if ($cache) {
                unset($list);
                foreach ($cache as $key => $val) {
                    $arr = explode('.', $val);
                    if ($arr) { 
                        $col = ((int) $arr[2] > 0) ? ' ' : '.'.$arr[2];
                        $realm = (isset($arr[3]) and (int) $arr[3] < 100) ? '.'.$arr[3] : ' ';
                        $list[$key+1]['name'] = $arr[1].$col.$realm;
                        $list[$key+1]['time'] = date('d-m-Y H:i:s',array_pop($arr));
                    }
                }
                return $list;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    public function delete_cache($name){
        $this->cache->delete($name);
    }

}
