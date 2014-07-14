<?php
namespace app\model\item;
if(!defined('DOST')){ die(header("HTTP/1.x 404 Not Found"));}

class item_db extends \libs\parents\Model
{   
    private $table = array(
        0=>'_gem_properties',
        1=>'_item_enchantment',
        2=>'_item_icon',
        3=>'_item_set',
        4=>'_skill_line',
        5=>'_spell',
        6=>'_spell_duration',
        7=>'_spell_radius',
        8=>'item_lot');

    private function getConfigParams($key){
        $conf = $this->ServerConfig();
        return $conf[$key];
    }

    public function item_lot(){
        $count_servers = count($this->ServerConfig());
        $item_lot = array();
        if($count_servers > 0){
            for($i = 1; $i <= $count_servers;$i++){
                $conf = $this->getConfigParams($i);
                $item_lot[$i] = $this->cache->get('item.lot.' . $i);   
                if(!$item_lot[$i]){
                    $db = $this->connect->query('SELECT id_lot,realm_id,price_Vp,price_count,Locked,entry,class,subclass,name,name_ru_ru,displayid,Quality,stackable,date_create FROM ^'.$this->table[8].' WHERE realm_id = '.$i.' AND WDBVerified = '.$conf['version'].'  ORDER BY date_create DESC');
                    if($db->num_rows > 0){
                        foreach($db->rows as $item) {
                            $item['icon'] = $this->item_icon($item['displayid'], $i);
                            $item['server_name'] = $conf['server_name'];
                            $items[$i][] = $item;
                        }
                        $item_lot[$i] = $items[$i];
                        $this->cache->set('item.lot.' . $i, $items[$i]);
                        
                    }else{
                        $item_lot[$i] = false;
                    }		
                }
            }           
            return $item_lot;
        }else{
            return false;
        }
    }
    
    public function item_lot_info($id = ''){
        $count_servers = count($this->ServerConfig());
        $item_lot = null;
        if($count_servers > 0 and $id != ''){
            if($this->cache->params === true){
                 for($i = 1; $i <= $count_servers;$i++){
                    $item_lot[$i] = $this->cache->get('item.lot.' . $i);
                    if(is_null($item_lot[$i])){
                        $item_lot[$i] = false;
                    }
                 }
                 
                 
                 if (is_array($item_lot) and isset($item_lot)) {
                    foreach ($item_lot as $items) {
                        if ($items !== false) {
                            foreach ($items as $key => $val) {
                                if ($val['id_lot'] == $id) {
                                    $item_lot = $items[$key];
                                    break;
                                } else {
                                    $item_lot = false;
                                }
                            }
                        } else {
                            $item_lot = false;
                        }
                    }
                }
            }

            if($item_lot === false || $item_lot == ''){
                $db = $this->connect->query('SELECT id_lot,realm_id,price_Vp,price_count,Locked,entry,class,subclass,name,name_ru_ru,displayid,Quality,stackable,date_create FROM ^'.$this->table[8].' WHERE id_lot ='.$id);
                if($db->num_rows > 0){
                    $item_lot = $db->row;
                    $conf = $this->getConfigParams($item_lot['realm_id']);
                    $item_lot['server_name'] = $conf['server_name'];
                }else{
                    $item_lot = false;
                }
            }
            
            if($item_lot['Locked'] > 0){
                $item_lot = false;
            }
        }
        return $item_lot;
    }

    public function item_icon($displayID,$id_realm){
        $build = $this->getConfigParams($id_realm);
        $db = $this->connect->query('SELECT name FROM ^'.$build['version'].$this->table[2].' WHERE id = '.$displayID);
        if($db->num_rows > 0){
            $icon = str_replace("\n", '', strtolower($db->row['name']));
            return $icon;
        }else{
            return false;
        }
    }
    
    
    public function select_item_tooltip_local($realm,$id){
        if($this->cache->params === true){
            $sql = 'SELECT * FROM ^'.$this->table[8];
        }else{
            $sql = 'SELECT * FROM ^'.$this->table[8].' WHERE realm_id = '.$realm.' AND entry = '.$id;
        }
        
        $db = $this->connect->query($sql);

        if($db->num_rows > 0){
            return $db->rows;
        }
    }

    public function getSpellInfo($id = '', $type = '', $int = 1 , $build) {
        if ($int == '')
            $int = '1';

        $getParam = '';

        if ($type == "s" || $type == "m") {
            $spell = $this->select_spell($id,$build);
            $getParam = abs($spell['EffectBasePoints_' . $int] + $spell['EffectBaseDice_' . $int]) + 1;
            if ($spell['EffectDieSides_' . $int] > $spell['EffectBaseDice_' . $int] && ($spell['EffectDieSides_' . $int] - $spell['EffectBaseDice_' . $int] != 1)) {
                $getParam .= ' - ' . abs($spell['EffectBasePoints_' . $int] + $spell['EffectDieSides_' . $int]);
            }
        }

        if ($type == "d") {
            $spell = $this->select_spell($id,$build);
            $result = $this->select_duration($spell['DurationIndex'],$build);
            $seconds = $result['duration_1'] / 1000;
            $time_text = '';
            if ($seconds >= 24 * 3600) {
                $time_text.= intval($seconds / (24 * 3600)) . " д";
                if ($seconds%=24 * 3600)
                    $time_text.=" ";
            } elseif ($seconds >= 3600) {
                $time_text.= intval($seconds / 3600) . " ч";
                if ($seconds%=3600)
                    $time_text.=" ";
            } elseif ($seconds >= 60) {
                $time_text.= intval($seconds / 60) . " мин";
                if ($seconds%=60)
                    $time_text.=" ";
            } elseif ($seconds > 0) {
                $time_text .= "$seconds сек";
            }
            $getParam = $time_text;
        }

        if ($type == "t") {
            $spell = $this->select_spell($id,$build);
            $getParam = $spell['EffectAmplitude_1'] ? $spell['EffectAmplitude_' . $int] / 1000 : 5;
        }

        if ($type == "o") {
            $spell = $this->select_spell($id,$build);
            $duration = $this->select_duration($spell['DurationIndex'],$build);

            $d = $duration['duration_1'] / 1000;
            $t = $spell['EffectAmplitude_1'] ? $spell['EffectAmplitude_' . $int] / 1000 : 5;
            $s = abs($spell['EffectBasePoints_' . $int] + $spell['EffectBaseDice_' . $int]);
            if ($spell['EffectDieSides_' . $int] > $spell['EffectBaseDice_' . $int] && ($spell['EffectDieSides_' . $int] - $spell['EffectBaseDice_' . $int] != 1)) {
                $s .= ' - ' . abs($spell['EffectBasePoints_' . $int] + $spell['EffectDieSides_' . $int]);
            }
            $getParam = @intval($s * $d / $t);
        }

        if ($type == "x") {
            $spell = $this->select_spell($id,$build);
            $getParam = $spell['EffectChainTarget_' . $int];
        }

        if ($type == "v") {
            $spell = $this->select_spell($id,$build);
            $getParam = $spell['AffectedTargetLevel'];
        }

        if ($type == "b") {
            $spell = $this->select_spell($id,$build);
            $getParam = $spell['EffectPointsPerComboPoint_' . $int];
        }

        if ($type == "e") {
            $spell = $this->select_spell($id,$build);
            $getParam = $spell['EffectMultipleValue_' . $int];
        }

        if ($type == "i") {
            $spell = $this->select_spell($id,$build);
            $getParam = $spell['MaxAffectedTargets'];
        }

        if ($type == "f") {
            $spell = $this->select_spell($id,$build);
            $getParam = $spell['DmgMultiplier_' . $int];
        }

        if ($type == "q") {
            $spell = $this->select_spell($id,$build);
            $getParam = $spell['EffectMiscValue_' . $int];
        }

        if ($type == "h") {
            $spell = $this->select_spell($id,$build);
            $getParam = $spell['procChance'];
        }

        if ($type == "n") {
            $spell = $this->select_spell($id,$build);
            $getParam = $spell['procCharges'];
        }

        if ($type == "u") {
            $spell = $this->select_spell($id,$build);
            $getParam = $spell['StackAmount'];
        }

        if ($type == "a") {
            $spell = $this->select_spell($id,$build);
            $radius = $this->select_radius($spell['EffectRadiusIndex_' . $int],$build);
            if ($radius['radius_1'] == 0 || $radius['radius_1'] == $radius['radius_3']) {
                $getParam = $radius['radius_3'];
            } else {
                $getParam = $radius['radius_1'] - $radius['radius_3'];
            }
        }

        return $getParam;
    }

    public function search_spell($discription, $id, $type, $build) {
        if ($discription != '') {
            $text = str_replace(array('${', '}'), array('[', ']'), $discription);
            preg_match_all("/([$][0-9]{0,10}[a-z]{1}[0-9]{0,1})/", $text, $result);
            foreach ($result[0] as $key => $val) {
                preg_match("/^[$]([0-9]{0,10})([a-z]{1})([0-9]{0,1})/", $val, $str);               
                if ($str[1]) {
                    $getParam[$key][$val] = $this->getSpellInfo($str[1], $str[2], $str[3],$build);
                } else {
                    $getParam[$key][$val] = $this->getSpellInfo($id, $str[2], $str[3],$build);
                }
                $text = str_replace($val, $getParam[$key][$val], $text);
            }

            preg_match_all("/[[]([\S]{1,500})[]]/", $text, $results);
            for ($i = 0; $i < count($results[0]); $i++) {
                $var[$i]['name'] = $results[0][$i];
                $var[$i]['val'] = abs(round($results[1][$i]));
                $text = str_replace($var[$i]['name'], $var[$i]['val'], $text);
            }

            $strs = $type . $text . '<br>';
        } else {
            $strs = '';
        }
        return $strs;
    }
    
    public function select_skill_line($id,$build) {
            if($id){
                $db = $this->connect->query('SELECT * FROM ^'.$build.$this->table[4].' WHERE id = '.$id);
                
                if($db->num_rows > 0){
                    return $db->row;
                }else{
                    return false;
                }
            }      
    }

    public function spell_info_dbc($id_spell, $type = '' ,$build = '') {
        $spell = $this->select_spell($id_spell,$build);
        $lang = '_'.strtolower($this->Lang);
        if($lang == '_ru_ru'){
            $lg = $lang;
        }
        
        $description = isset($spell['Description'.$lg]) ? $spell['Description'.$lg] : $spell['Description_en_gb'];        
        if ($spell != false) {
            return $this->search_spell($description, $spell['id'], $type ,$build);
        }
    }

    
    public function select_Gem_prop($id,$build) {
        if($id){
            $db = $this->connect->query('SELECT * FROM ^'.$build.$this->table[0].' WHERE id = '.$id);
                
                if($db->num_rows > 0){
                    return $this->socket_bonus($db->row['spell_enchantement'],$build);
                }else{
                    return false;
                }
        }
    }

    public function item_set_info($id,$build) {
        $set = $this->select_set_item($id,$build);
        $sets = '';
        if ($set == true) {
            $sets .= '<br><font color="yellow">' . $set['Name_set_ru_ru'] . ' (0/' . count($set['set_item']) . ')</font><br>';
            for ($i = 1; $i < 9; $i++) {
                if (isset($set['set_item'][$i]) and $set['set_item'][$i] != '') {
                    $sets .= '<font color="gray" style="margin-left:10px;">' . $set['set_item'][$i] . '</font><br>';
                }
            }
            $sets .='<br>';
            if (is_array($set['spell_id'])) {
                natsort($set['spell_id']);
                foreach ($set['spell_id'] as $spell) {
                    if ($spell != '') {
                        $sets .= '<font color="gray">' . $spell . '</font><br>';
                    }
                }
            }
        }

        return $sets;
    }
    
    public function select_set_item($id, $build) {
        if ($id) {
            $db = $this->connect->query('SELECT * FROM ^' . $build . $this->table[3] . ' WHERE id_set = ' . $id);

            if ($db->num_rows > 0) {
                for ($i = 1; $i < 9; $i++) {
                    if ($db->row['item_set_name_' . $i] == true) {
                        $db->row['set_item'][$i] = $db->row['item_set_name_' . $i];
                    }
                }

                for ($i = 1; $i < 9; $i++) {
                    if ($db->row['spell_set_id_' . $i] == true) {
                        $s = abs($i - 1);
                        if (array_key_exists('amount_item_set__' . $s, $db->row) === true) {
                            $db->row['spell_id'][$i] = 'Комплект (' . $db->row['amount_item_set__' . $s] . ' предмета):' . $this->spell_info_dbc($db->row['spell_set_id_' . $i],'',$build);
                        }
                    }
                }
                return $db->row;
            }else{
                return false;
            }
        }   
    }

    public function select_spell($id = '',$build) {
        if($id){
            $db = $this->connect->query('SELECT * FROM ^'.$build.$this->table[5].' WHERE id = '.$id);
                
                if($db->num_rows > 0){
                    return $db->row;
                }else{
                    return false;
                }
        }
    }

    public function select_duration($id,$build) {
         if($id){
            $db = $this->connect->query('SELECT * FROM ^'.$build.$this->table[6].' WHERE id = '.$id);
                
                if($db->num_rows > 0){
                    return $db->row;
                }else{
                    return false;
                }
        }
    }

    public function select_radius($id,$build) {
        if($id){
            $db = $this->connect->query('SELECT * FROM ^'.$build.$this->table[7].' WHERE id = '.$id);
                
                if($db->num_rows > 0){
                    return $db->row;
                }else{
                    return false;
                }
        }
    }

    public function socket_bonus($id_socket, $build) {
        if ($id_socket) {
            $db = $this->connect->query('SELECT description FROM ^' . $build . $this->table[1] . ' WHERE id = ' . $id_socket);

            if ($db->num_rows > 0) {
                return $db->row['description'];
            }
        }
    }

}
