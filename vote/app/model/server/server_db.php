<?php
namespace app\model\server;
if(!defined('DOST')){ die(header("HTTP/1.x 404 Not Found"));}

class server_db extends \libs\parents\Model
{
    public function Authentication($login, $realm_id) {
        $test = $this->testConnection($this->getConfigParams($realm_id));
        $msg = '';
        if ($test) {
            $db = $this->getConnectionServer($realm_id, 'auth');
            $result = $db->query('SELECT id,username,sha_pass_hash FROM account WHERE username = "' . $db->escape($login) . '"');
            if ($result->num_rows > 0) {
                $msg = $result->row;
            } else {
                $msg = null;
            }
        } else {
            $msg = false;
        }
        return $msg;
    }
    
    public function searchCharacters($id,$realm_id){
        $db = $this->getConnectionServer($realm_id, 'characters');
        $result = $db->query('SELECT name FROM characters WHERE account = '.$id);
        if($result->num_rows > 0){
            return $result->rows;
        }else{
            return false;
        }
    }
    
    public function select_characters($name,$id_realm){
        $test = $this->testConnection($this->getConfigParams($id_realm));
        if($test){
            $db = $this->getConnectionServer($id_realm, 'characters');
            $result = $db->query("SELECT name FROM characters WHERE name = '$name'");
            if ($result->num_rows > 0) {
                return true;
            } else {
                return false;
            }
        }else{
            return 'connect';
        }
    }

    public function searchCharactersUpdate($id, $realm_id, $char_list) {
        $test = $this->testConnection($this->getConfigParams($realm_id));
        if ($test) {
            $zap = '';
            if (is_array($char_list)) {
                $zap .='AND name NOT IN(';
                foreach ($char_list as $val) {
                    $zap .= "'".$val['char_name'] ."',";
                }
                $zap = substr($zap, 0, strlen($zap) - 1) . ')';
            }

            $db = $this->getConnectionServer($realm_id, 'characters');
            $result = $db->query('SELECT name FROM characters WHERE account = ' . $id.' '.$zap);
            if ($result->num_rows > 0) {
                return $result->rows;
            } else {
                return false;
            }
        } else {
            return 'error';
        }
    }

    public function testConnection($conf){
        $fp = @fsockopen($conf['host'], $conf['port'], $errno, $errstr, 5);
        if($fp){
            return true;
        }else{
            return false;
        }
    }
    
    private function getConfigParams($key){
        $conf = $this->ServerConfig();
        return $conf[$key];
    }
    
    public function selectItemServ($entry, $id_realm) {
        $test = $this->testConnection($this->getConfigParams($id_realm));
        if ($test) {
            $db = $this->getConnectionServer($id_realm, 'world');
            $result = $db->query('SELECT item_template.*,name_loc8,description_loc8 FROM item_template LEFT JOIN locales_item ON item_template.entry=locales_item.entry WHERE item_template.entry = "'.$entry.'" LIMIT 1');
            if ($result->num_rows > 0) {
                $result->row['realm_id'] = $id_realm;
                return $result->row;
            } else {
                return false;
            }
        }
    }

    public function searchItems($name, $count, $id_realm) {
        $quality = new \app\model\item\item_string();
        $test = $this->testConnection($this->getConfigParams($id_realm));
        if ($test) {
            $zap = '';
            if (is_numeric($name) and $count !== 0) {
                $zap = "item_template.entry LIKE '%$name%' LIMIT $count";
            } elseif (preg_match("/^[a-zA-Z ]+$/iu", $name)) {
                $zap = "name LIKE '%$name%' LIMIT $count";
            } elseif (preg_match("/^[а-яА-Я ]+$/iu", $name)) {
                $zap = "name_loc8 LIKE '%$name%' LIMIT $count";
            } else {
                $zap = false;
            }
            $version = $this->getConfigParams($id_realm);
            $build = $version['version'];
            $quality->getVersion = $build;
            if ($zap !== false) {
                $db = $this->getConnectionServer($id_realm, 'world');
                $result = $db->query('SELECT item_template.entry,Quality,name_loc8,name FROM'
                        . ' item_template LEFT JOIN locales_item ON item_template.entry=locales_item.entry WHERE'
                        . " WDBVerified <=$build AND $zap");
                if ($result->num_rows > 0) {
                    foreach ($result->rows as $key => $val) {
                        if(!empty($val['name_loc8'])){
                            $result->rows[$key]['item_name'] = $quality->Quality($val['Quality'], $val['name_loc8']);
                        }elseif(!empty($val['name'])){
                            $result->rows[$key]['item_name'] = $quality->Quality($val['Quality'], $val['name']);
                        }
                            $result->rows[$key]['id_realm'] = $id_realm;
                    }
                    return $result->rows;
                } else {
                    return false;
                }
            }else{
                return 'zap';
            }
        }else{
            return 'connect';
        }
    }
    
    
    public function count_account($realm) {
        $test = $this->testConnection($this->getConfigParams($realm));
        if ($test) {
            $db = $this->getConnectionServer($realm, 'auth');
            $result = $db->query('SELECT COUNT(id) FROM account');
            if ($result->num_rows > 0) {
                return $result->row['COUNT(id)'];
            } else {
                return 0;
            }
        }else{
             return 0;
        }
    }

    public function count_characters($realm){
        $test = $this->testConnection($this->getConfigParams($realm));
        if ($test) {
            $db = $this->getConnectionServer($realm, 'characters');
            $result = $db->query('SELECT COUNT(guid) FROM characters');
            if ($result->num_rows > 0) {
                return $result->row['COUNT(guid)'];
            } else {
                return 0;
            }
        }else{
             return 0;
        }
    }
}
