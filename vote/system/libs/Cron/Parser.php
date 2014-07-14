<?php
namespace libs\Cron;
if(!defined('DOST')){ die(header("HTTP/1.x 404 Not Found"));}

class Parser extends \libs\parents\Model
{
    private $config_server;
    private $data_parse = array();
    private $data_char = array();
    private $reault = array();
    public static $logs;

    public function Load(){
        self::$logs .='--Start the process parser['.site_date().']--'.PHP_EOL; 
        $this->config_server = $this->ServerConfig();
        foreach ($this->config_server as $key => $val) {
            $this->data_parse[$key] = $this->fileManager->parser_file_mmotop($val['mmotop_file']);
            $this->data_char[$key]['vote'] = $this->parse_logs($key,1);
            $this->data_char[$key]['sms'] = $this->parse_logs($key,2);
            
            if(isset($this->data_char[$key]['vote']) and isset($this->data_parse[$key]['vote'])){
                $this->reault[$key]['vote'] = $this->sort_parse($this->data_char[$key]['vote'], $this->data_parse[$key]['vote']);
                self::$logs .= "[new characters list vote realm:$key ] ".$this->char_list($this->reault[$key]['vote']).PHP_EOL;
            }elseif(isset($this->data_parse[$key]['vote'])){
                $this->reault[$key]['vote'] = $this->data_parse[$key]['vote'];
                self::$logs .= "[new characters list vote realm:$key ] ".$this->char_list($this->reault[$key]['vote']).PHP_EOL;
            }
            
            if(isset($this->reault[$key]['vote'])){
               $vote[$key] = $this->add_parse_logs($this->reault[$key]['vote'], 1, $key);
               if($vote[$key] === true){
                   self::$logs .='*-add characters list vote realm:'.$key.'-*'.PHP_EOL;
               }
            }
            
            if(isset($this->data_char[$key]['sms']) and isset($this->data_parse[$key]['sms'])){
                $this->reault[$key]['sms'] = $this->sort_parse($this->data_char[$key]['sms'], $this->data_parse[$key]['sms']);
                self::$logs .= "[new characters list sms realm:$key ] ".$this->char_list($this->reault[$key]['sms']).PHP_EOL;
            }elseif(isset($this->data_parse[$key]['sms'])){
                $this->reault[$key]['sms'] = $this->data_parse[$key]['sms'];
                self::$logs .= "[new characters list sms realm:$key ] ".$this->char_list($this->reault[$key]['sms']).PHP_EOL;
            }       
            
            
            if(isset($this->reault[$key]['sms'])){
               $sms[$key] =  $this->add_parse_logs($this->reault[$key]['sms'], 2, $key);
               if($sms[$key] === true){
                   self::$logs .='*-add characters list sms realm:'.$key.'-*'.PHP_EOL;
               }
            }
        }
        self::$logs .='--End the process parser['.site_date().']--'.PHP_EOL;
        
        self::$logs .='--Start the process bonuses['.site_date().']--'.PHP_EOL;
        
        foreach ($this->config_server as $keys => $vals) {
           $result[$keys] = $this->list_parser($keys);
           if($result[$keys] === false){
               self::$logs .="*-no matches found realm:$keys-*".PHP_EOL;
           }else{
               self::$logs .="*-matches found (".count($result[$keys]).") realm:$keys -*".PHP_EOL;
               $this->update_Vp($result[$keys], $vals);
           }
        }
        
        self::$logs .='--End the process bonuses['.site_date().']--'.PHP_EOL.PHP_EOL;
        
        return $this->log_file(self::$logs);
    }
    
    
    private function parse_logs($realm,$type){
        $date = time() - 86400;
        $db = $this->connect->query('SELECT name,date FROM ^parse_logs WHERE type= ' . $type . ' AND realm = ' . $realm . ' AND date >= ' . $date);
        if ($db->num_rows > 0) {
            foreach ($db->rows as $key => $val) {
                $name[$key] = $val['name'].':'.$val['date'];
            }
            return $name;
        }
    }
    
    private function sort_parse($db_list,$parse_list){
        $arr = array_diff($parse_list, $db_list);       
        return $arr;        
    }
    
    private function add_parse_logs($parse,$type,$realm){
        $sql = '';
        if ($parse) {
            $sql .= 'VALUES';
            foreach ($parse as $val) {
                $column = explode(':', $val);
                $sql .='("' . $column[0] . '",' . $column[1] . ',' . $type . ',' . $realm . ',0),';
            }

            $zap = substr($sql, 0, strlen($sql) - 1);
            $this->connect->query('INSERT INTO ^parse_logs (name,date,type,realm,status) ' . $zap . ';');
            if ($this->connect->getLastId()) {
                return true;
            } else {
                return false;
            }
        }
    }
    
    public function char_list($arr = ''){
        if($arr){
            $msg = implode(",\n",$arr);
        }else{
            $msg = 'null';
        }
        return $msg;
    }
    
    public function list_parser($realm){
        $db = $this->connect->query('SELECT name,realm,type,id_user FROM ^parse_logs RIGHT JOIN ^users_char_info ON ^parse_logs.name=^users_char_info.char_name AND ^parse_logs.realm=^users_char_info.id_realm WHERE realm = '.$realm.' AND status = 0');
        if($db->num_rows > 0){
            return $db->rows;
        }else{
            return false;
        }
    }
    
    public function update_Vp($arr, $conf) {
        if ($arr) {
            foreach ($arr as $val) {
                if ($val['type'] == 1) {
                    $Vp = $conf['Vp_vote'];
                } elseif ($val['type'] == 2) {
                    $Vp = $conf['Vp_sms'];
                }
                $this->connect->query('UPDATE ^users SET Vp=Vp+' . $Vp . ' WHERE id = ' . $val['id_user']);
                if ($this->connect->countAffected()) {
                    self::$logs .="*|accrued Vp[$Vp] user id:".$val['id_user'].'|*'.PHP_EOL;
                    $this->connect->query('UPDATE ^parse_logs SET status=1 WHERE name = "'.$val['name'].'"');
                } else {
                    self::$logs .="*|Error! Not accrued Vp[$Vp] user id:".$val['id_user'].'|*'.PHP_EOL;
                }
            }
        }
    }
    
    public function log_file($line_text){
        $path_file = SYS_PATH . 'log' . DS . 'Cron.log';
        file_put_contents($path_file, $line_text,LOCK_EX | FILE_APPEND);
    }

}
