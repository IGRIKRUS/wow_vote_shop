<?php
namespace app\model\admin;
if(!defined('DOST')){ die(header("HTTP/1.x 404 Not Found"));}

class home extends \libs\parents\Model {

    public function Statistic() {
        $statistic = $this->cache->get('statistic');
        if (!$statistic) {
            $statistic['votes'] = $this->DBVote();
            $statistic['servers'] = $this->Servers();
            $this->cache->set('statistic', $statistic);
        }
        return $statistic;
    }

    private function DBVote() {
        $sort = array();
        $serv = $this->ServerConfig();
        $db = $this->connect->query('SELECT type,realm,status FROM ^parse_logs');
        if ($db->num_rows > 0) {
            foreach ($db->rows as $val) {
                if ($val['status'] == 0) {
                    $sort[$val['realm']]['null'][] = $val['type'];
                }

                if ($val['type'] == 1 and $val['status'] == 1) {
                    $sort[$val['realm']]['vote'][] = $val['type'];
                }

                if ($val['type'] == 2 and $val['status'] == 1) {
                    $sort[$val['realm']]['sms'][] = $val['type'];
                }
            }

            for ($i = 1; $i <= count($serv); $i++) {
                $sort[$i]['name'] = $serv[$i]['server_name'];
                $sort[$i]['_null'] = isset($sort[$i]['null']) ? count($sort[$i]['null']) : 0;
                $sort[$i]['_vote'] = isset($sort[$i]['vote']) ? count($sort[$i]['vote']) : 0;
                $sort[$i]['_sms'] = isset($sort[$i]['sms']) ? count($sort[$i]['sms']) : 0;
                $sort[$i]['account'] = $this->account($i);
                $sort[$i]['characters'] = $this->characters($i);
            }

            return $sort;
        } else {
            return false;
        }
    }
    
    private function account($realm){
        $db = $this->connect->query('SELECT COUNT(id) FROM ^users WHERE id_realm = '.$realm);
        if($db->num_rows > 0){
            return $db->row['COUNT(id)'];
        }else{
            return false;
        }
    }
    
    private function characters($realm){
        $db = $this->connect->query('SELECT COUNT(id) FROM ^users_char_info WHERE id_realm = '.$realm);
        if($db->num_rows > 0){
            return $db->row['COUNT(id)'];
        }else{
            return false;
        }
    }
    
    private function Servers(){
        $sort = array();
        $serv = $this->ServerConfig();
        $serv_db = new \app\model\server\server_db();
        for($i = 1;$i <= count($serv);$i++){
            $sort[$i]['name'] = $serv[$i]['server_name'];
            $sort[$i]['account'] = $serv_db->count_account($i);
            $sort[$i]['characters'] = $serv_db->count_characters($i);
        }        
        return $sort;
    }

}
