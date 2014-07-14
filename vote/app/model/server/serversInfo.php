<?php
namespace app\model\server;
if(!defined('DOST')){ die(header("HTTP/1.x 404 Not Found"));}

class serversInfo extends \libs\parents\Model{
    
    private function getConfigParams($key){
        $conf = $this->ServerConfig();
        return $conf[$key];
    }
    
    public function info_price_serv(){
        $count = count($this->ServerConfig());
        $price = '';
        if($count > 0){
            for($i = 1;$i <= $count ;$i++){
                $params = $this->getConfigParams($i);
                $price[$i]['name'] = $params['server_name'];
                $price[$i]['icon'] = $this->BuildVersion($params['version']);
                $price[$i]['vote'] = $params['Vp_vote'];
                $price[$i]['vote_sms'] = $params['Vp_sms']; 
                $price[$i]['date'] = $this->date_parse($i);
            }           
        }
        return $price;
    }   
    
    private function date_parse($realm){
        $db = $this->connect->query('SELECT MAX(date) FROM ^parse_logs WHERE realm = '.$realm);
        if($db->num_rows > 0){
            return date('d-m-Y H:i:s',$db->row['MAX(date)']);
        }else{
            return false;
        }
    }
}

