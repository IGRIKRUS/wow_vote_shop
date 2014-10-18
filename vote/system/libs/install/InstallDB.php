<?php
namespace libs\install;
if(!defined('DOST')){ die(header("HTTP/1.x 404 Not Found"));}

class InstallDB 
{
    private $link;

    public function testConnection($conf) {
        $link = @mysqli_connect($conf['host'], $conf['user'], $conf['pass'],'',$conf['port']);

        if (!$link) {
            return mysqli_connect_error();
        }else{
            mysqli_close($link);
            return true;
        }
    }
    
    public function CreateDB($conf){
        $link = @mysqli_connect($conf['host'], $conf['user'], $conf['pass'],'',$conf['port']);
        if (mysqli_connect_errno()) {
            return mysqli_connect_error();
        } else {
            mysqli_set_charset($link, $conf['ecoding']);
            if (!mysqli_query($link, 'CREATE DATABASE  IF NOT EXISTS `' . $conf['base'] . '` CHARACTER SET ' . $conf['ecoding'] . ' COLLATE ' . $conf['ecoding'] . '_general_ci')) {
                mysqli_close($link);
                return @mysqli_error($link);
            }else{
                mysqli_close($link);
                return true;
            } 
        }  
    }
    
    public function SelectServ($conf){
        $link = @mysqli_connect($conf['host'], $conf['user'], $conf['pass'],$conf['auth'],$conf['port']);
        if (mysqli_connect_errno()) {
            return mysqli_connect_error();
        } else {
            mysqli_set_charset($link, $conf['ecoding']);
            if($result = mysqli_query($link,'SELECT name,gamebuild FROM realmlist WHERE id = '.$conf['id'])){
                $row = mysqli_fetch_assoc($result); 
                return $row;
            }else{
                return @mysqli_error($link);
            }
        }
        mysqli_close($link);
    }
    
    public function ShowTables($FileManager){
        $model = new \libs\parents\Model();
        $tables = '';
        $z = '';
        $base_items = $FileManager->scan_upload_items();
        if(is_array($base_items)){
            foreach ($base_items as $table) {
               $file = $FileManager->scan_upload_items_base($table);
               $name_table = array();
               if(is_array($file)){
                   foreach ($file as $name){
                       $name_table[] = "'".str_replace(array('insert','.sql'), array('^'.$table,''), $name)."'";
                   }
                   if($tables !== ''){
                       $z = ',';
                   }
                   $tables .= $z.implode(',',$name_table);
               }
            }
        }
        $site_conf = $model->SiteConfig();
        $db = $model->connect->query("SELECT  table_name,concat(round((data_length+index_length)/(1024*1024),2),'M') rows  FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".$site_conf['base']."'  AND table_name IN($tables) ORDER BY CREATE_TIME DESC");
        if($db->num_rows > 0){
            if(array_search('0.00M', $db->rows)){
                return false;
            }else{
                return true;
            }
        }else{
            return false;
        }
    }
    
    public function Inst_table_upload($lang,$FileManager){
        set_time_limit(0);
        $memory = ini_get("memory_limit");
        if($memory <= '128M'){
           ini_set("memory_limit", "256M");
        }

        $msg = '';
        $path = SYS_PATH.'install'.DS.'upload'.DS.'table'.DS.'vote'.DS.'vote_table.php';
        $base_vote =  $FileManager->open_file_tables($path);
        if($base_vote !== false and is_array($base_vote)){
            foreach ($base_vote as $table) {
                $this->query_table($table);
            }
            $msg .= $lang->get('CRtable_vote_table_create'); 
            $base_items = $FileManager->scan_upload_items();
            if(is_array($base_items)){
                foreach ($base_items as $table) {
                    $path_items = SYS_PATH.'install'.DS.'upload'.DS.'table'.DS.$table.DS;
                    $items = $FileManager->open_file_tables($path_items.'create_table.php');
                    if($items !== false and is_array($items)){
                        foreach ($items as $table_item) {
                            $this->query_table($table_item);                                                    
                        }
                        $msg .= $lang->get('CRtable_items_table_create').' : /'.$table.'/create_table.php </br>'; 
                        $files = $FileManager->scan_upload_items_base($table);
                        if(is_array($files)){
                            foreach ($files as $inc) {
                                $insert = $FileManager->open_file_insert($path_items.$inc);
                                if($insert !== false and is_array($insert)){
                                    foreach ($insert as $zap) {
                                        $this->query_table($zap);
                                    }
                                    $msg .= $lang->get('CRtable_insert_insert').' : /'.$table.'/'.$inc.' </br>';
                                }else{
                                    $msg .= $lang->get('CRtable_insert_null').' : /'.$table.'/'.$inc.' </br>'; 
                                }
                            }
                        }else{
                            $msg .= $lang->get('CRtable_items_table_files').' : /'.$table.'/ </br>'; 
                        }
                    }else{
                        $msg .= $lang->get('CRtable_items_table_false').' : /'.$table.'/create_table.php </br>';
                    }
                }
            }else{
                $msg .= $lang->get('CRtable_items_table');
            }
        }else{
           $msg = $lang->get('CRtable_vote_table');
        }
        return $msg;
    }
    
    
    public function query_table($query){
        $model = new \libs\parents\Model();
        $db = $model->connect->query($query);
        return $db;
    }
    
    public function select_account(){
        $model = new \libs\parents\Model();
        $db = $model->connect->query('SELECT ^users.id FROM ^users INNER JOIN ^admin ON ^users.id=^admin.id_account WHERE ^users.id = 1');
        if($db->num_rows > 0){
            return true;
        }else{
            return false;
        }
    }
}
