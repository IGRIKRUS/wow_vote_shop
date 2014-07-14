<?php
namespace app\model\item;
if(!defined('DOST')){ die(header("HTTP/1.x 404 Not Found"));}

class Items extends \libs\parents\Model
{
    protected $item_db;
    protected $item_string;
    protected $Lang;
    protected $mass;


    public function __construct() {
        $this->item_db = new \app\model\item\item_db;
        $this->Lang = '_'.strtolower($this->item_db->Lang);
        $this->item_string = new \app\model\item\item_string;
        $this->cache = new \libs\Cache\CacheDB();
    }
    
    public function BuildVersion($build){
        if ($build <= '6005') {
            $varsion = 1;
        } else
        if ($build <= '8606') {
            $varsion = 2;
        } else
        if ($build <= '12340') {
            $varsion = 3;
        } else
        if ($build <= '15595') {
            $varsion = 4;
        } else
        if ($build <= '18019') {
            $varsion = 5;
        }
        return $varsion;
    }

    public function item_lot() {
        $item_array = array();
        $item = $this->item_db->item_lot();
        if (is_array($item)) {
            foreach ($item as $key => $val) {
                $build = $this->getConfigParams($key);
                $item_array[$key]['server_name'] = $build['server_name'];
                $this->item_string->getVersion = $build['version'];
                $item_array[$key]['build'] = $this->BuildVersion($build['version']);
                
                if ($val !== false) {
                    foreach ($val as $keys => $vals) {
                        $vals['server_name'] = (strlen($vals['server_name']) >= 7) ? mb_substr($vals['server_name'], 0, 7) . '...' : $vals['server_name'];
                        $vals['item_name'] = $this->item_string->Quality($vals['Quality'], $this->textItem($vals, 'name'));
                        if ($vals['class'] == 2 and $vals['realm_id'] == $key and $vals['Locked'] == 0) {
                            $item_array['weapon'][$key][$keys] = $vals;
                        }

                        if ($vals['class'] == 4 and $vals['realm_id'] == $key and $vals['Locked'] == 0) {
                            $item_array['armor'][$key][$keys] = $vals;
                        }

                        if ($vals['class'] == 15 and $vals['subclass'] == 5 and $vals['realm_id'] == $key and $vals['Locked'] == 0) {
                            $item_array['mount'][$key][$keys] = $vals;
                        }

                        if ($vals['class'] != 15 and $vals['class'] != 2 and $vals['class'] != 4 and $vals['realm_id'] == $key and $vals['Locked'] == 0) {
                            $item_array['different'][$key][$keys] = $vals;
                        }

                        if ($vals['class'] == 15 and $vals['subclass'] != 5 and $vals['realm_id'] == $key and $vals['Locked'] == 0) {
                            $item_array['different'][$key][$keys] = $vals;
                        }
                        $time_news = (int) $vals['date_create'] + 604800; //+ неделя
                        if ($time_news >= time() and $vals['realm_id'] == $key and $vals['Locked'] == 0) {
                            $item_array['news'][$key][$keys] = $vals;
                        }
                    }
                }
            }        
            return $item_array;
        } else {
            return false;
        }
    }

    public function item_list() {
        $item_array = array();
        $item = $this->item_db->item_lot();        
        if (is_array($item)) {
            foreach ($item as $key => $val) {
                $build = $this->getConfigParams($key);
                $this->item_string->getVersion = $build['version'];
               // $item_array[$key]['build'] = $this->BuildVersion($build['version']);
                if ($val !== false) {
                    foreach ($val as $keys => $vals) {
                        $vals['server_name'] = (strlen($vals['server_name']) >= 20) ? mb_substr($vals['server_name'], 0, 20) . '...' : $vals['server_name'];
                        $vals['item_name'] = $this->item_string->Quality($vals['Quality'], $this->textItemADM($vals, 'name'));
                        $item_array[$key][$keys] = $vals;
                    }
                    
                }
            }           
            return $item_array;
        } else {
            return false;
        }
    }

    private function textItemADM($obj,$key){
        if(isset($obj[$key.$this->Lang]) !== false and $obj[$key.$this->Lang] != ''){
            $name = (strlen($obj[$key.$this->Lang]) >= 30) ? mb_substr($obj[$key.$this->Lang], 0, 30).'...' :  $obj[$key.$this->Lang];
            return $name;
        }elseif(isset($obj[$key]) !== false and $obj[$key] != ''){
            $name = (strlen($obj[$key]) >= 30) ? mb_substr($obj[$key], 0, 30).'...' :  $obj[$key];
            return $name;
        }else{
            return '';
        }
    }
    
    private function textItem($obj,$key){
        if(isset($obj[$key.$this->Lang]) !== false and $obj[$key.$this->Lang] != ''){
            $name = (strlen($obj[$key.$this->Lang]) >= 15) ? mb_substr($obj[$key.$this->Lang], 0, 14).'...' :  $obj[$key.$this->Lang];
            return $name;
        }elseif(isset($obj[$key]) !== false and $obj[$key] != ''){
            $name = (strlen($obj[$key]) >= 15) ? mb_substr($obj[$key], 0, 14).'...' :  $obj[$key];
            return $name;
        }else{
            return '';
        }
    }
    
    public function getItemLot($id = '') {
        $item = $this->item_db->item_lot_info($id);
        if ($item !== false) {
            $build = $this->getConfigParams($item['realm_id']);
            $this->item_string->getVersion = $build['version'];
            $item['item_name'] = $this->item_string->Quality($item['Quality'], $this->textItemTooltip($item, 'name'));
            return $item;
        } else {
            return false;
        }
    }

    private function textItemTooltip($obj,$key){
        if(isset($obj[$key.$this->Lang]) !== false and $obj[$key.$this->Lang] != ''){
            $name = $obj[$key.$this->Lang];
            return $name;
        }elseif(isset($obj[$key]) !== false and $obj[$key] != ''){
            $name = $obj[$key];
            return $name;
        }else{
            return false;
        }
    }

    private function getConfigParams($key){
        $conf = $this->ServerConfig();
        return $conf[$key];
    }
    
    public function item_tooltip($post){
         if(strpos($post, '_')){
            $item_id = explode('_', $post);
            if($item_id[0] == 'item' and isset($item_id[1]) and isset($item_id[2])){
               return $this->tooltip($item_id[1],$item_id[2]);
            }elseif($item_id[0] == 'items' and isset($item_id[1]) and isset($item_id[2])){
               return $this->serv_tooltip($item_id[1],$item_id[2]); 
            }         
        }
    }
    private function serv_tooltip($id_realm,$id_item){
        $server = new \app\model\server\server_db;
        $this->mass = $server->selectItemServ($id_item, $id_realm);
        if(isset($this->mass['name_loc8'])){
            $this->mass['name'] = $this->mass['name_loc8'];
        }
        if(isset($this->mass['description_loc8'])){
            $this->mass['description'] = $this->mass['description_loc8'];
        }
        $build = $this->getConfigParams($this->mass['realm_id']);
        $this->mass['build'] = $build['version'];
        return $this->item_info();
    }


    private function tooltip($id_realm,$id_item){
        if(is_numeric($id_realm) and is_numeric($id_item)){           
           if($this->cache->params === false){
               $item_lot = $this->item_db->select_item_tooltip_local($id_realm, $id_item);
               $this->mass = $item_lot[0];
               $build = $this->getConfigParams($this->mass['realm_id']);
               $this->mass['build'] = $build['version'];
               return $this->item_info();
           }else{
               $item = $this->cache->get('item.tooltip');
               if(!$item){
                   $item_lot = $this->item_db->select_item_tooltip_local($id_realm, $id_item);
                   foreach ($item_lot as $key => $val) {
                       $this->mass = $val;
                       $build = $this->getConfigParams($this->mass['realm_id']);
                       $this->mass['build'] = $build['version'];
                            $item[$this->mass['entry']] = $this->item_info();
                       }
                       $this->cache->set('item.tooltip',$item);
               }
               return $item[$id_item];
           }           
        }
    }
    
    
    private function item_info() {
        $item = '';
        if (is_array($this->mass)) {
            $item .='<div class="item_box">';
            $item .= $this->icon_item();
            $item .='<div class="state_item_info">';
            $item .=$this->name();
            $item .=$this->items_type();
            $item .=$this->items_lvl();
            $item .=$this->skill_line();
            $item .=$this->items_bonding();
            $item .=$this->items_inventory_type();
            $item .=$this->items_state();
            $item .=$this->items_res();
            $item .=$this->items_socket();
            $item .=$this->socketBonus();
            $item .=$this->items_durability();
            $item .=$this->items_char_classes();
            $item .=$this->spell_info();
            /*$item .= $this->items_char_race();*/
            $item .=$this->items_char_lvl();
            $item .=$this->char_requiredspell();
            $item .=$this->set_items();
            $item .=$this->description();
            $item .=$this->items_money();
            $item .='</div></div>';
            return $item;
        }
    }

    private function icon_item() {
        $build = $this->getConfigParams($this->mass['realm_id']);
        $this->item_string->getVersion = $build['version'];
        if ($build['version'] != '') {
            $icon = $this->item_db->item_icon($this->mass['displayid'], $this->mass['realm_id']);
            if ($icon != false) {
                return '<div class="icon_box" style="background-image: url(http://wow.zamimg.com/images/wow/icons/large/' . $icon . '.jpg); no-repeat"></div>';
            }
        }
    }

    private function name() {
        $name = $this->textItemTooltip($this->mass, 'name');
        if ($name != false) {
            return $this->item_string->Quality($this->mass['Quality'], $name) . '<br>';
        }
    }
    
    private function description() {
        $text = $this->textItemTooltip($this->mass, 'description');       
        if ($text != false) {
            return '<font color="yellow">"' . $text . '"</font><br>';
        }
    }

    private static function Quality_color($type,$name){
        return self::Quality_name($type, $name);
    }

    private function items_type() {
        $str = '';
        if ($this->item_string->flags($this->mass['Flags']) == true) {
            $str .= $this->item_string->flags($this->mass['Flags']) . '<br>';
        }
        if ($this->item_string->unique($this->mass['maxcount']) == true) {
            $str .= $this->item_string->unique($this->mass['maxcount']) . '<br>';
        }
        return $str;
    }

    private function items_lvl() {
        if ($this->mass['ItemLevel'] > 0) {
            return '<font color="yellow"> Уровень предмета: ' . $this->mass['ItemLevel'] . '</font><br>';
        }
    }

    private function skill_line() {
        if ($this->mass['RequiredSkill'] > 0) {
            $skill = $this->item_db->select_skill_line($this->mass['RequiredSkill'],$this->mass['build']);
            if ($skill) {
                return '<font color="#fff">Требует ' . $skill['Name'] . ' (' . $this->mass['RequiredSkillRank'] . ')</font><br>';
            }
        }
    }

    private function items_bonding() {
        if ($this->mass['bonding']) {
            return $this->item_string->bonding($this->mass['bonding']) . '<br>';
        }
    }

    private function items_inventory_type() {
        $item = '';
        if ($this->mass['class'] >= 0 and $this->mass['class'] != 2 and $this->mass['class'] != 4 and $this->mass['class'] != 3 and $this->mass['class'] != 1 and $this->mass['class'] != 16) {
            if ($this->item_string->class_subclass($this->mass['class'], $this->mass['subclass']) != '') {
                $item .= $this->item_string->InventoryType($this->mass['InventoryType']) . ' ' . $this->item_string->class_subclass($this->mass['class'], $this->mass['subclass']) . "<br>";
            }
            if ($this->mass['stackable'] != '0') {
                $item .= 'max кол. [' . $this->mass['stackable'] . ']<br>';
            }
        } elseif ($this->mass['class'] == 1) {
            if ($this->mass['ContainerSlots'] != '0') {
                $Container = '(ячеек:' . $this->mass['ContainerSlots'] . ')';
            } else {
                $Container = '';
            }
            if ($this->item_string->class_subclass($this->mass['class'], $this->mass['subclass']) != '') {
                $item .= $this->item_string->class_subclass($this->mass['class'], $this->mass['subclass']) . ' ' . $Container . "<br>";
            }
            if ($this->mass['stackable'] > 0) {
                $item .= 'max кол. [' . $this->mass['stackable'] . ']<br>';
            }
        } elseif ($this->mass['class'] == 2) {
            $item .= ' <b style="float: left;">' . $this->item_string->InventoryType($this->mass['InventoryType']) . '</b>';
            $item .= ' <b style="float: right;margin-right: 5px;">' . $this->item_string->class_subclass($this->mass['class'], $this->mass['subclass']) . "</b><br>";
            $item .= ' <b style="float: left;">Урон: ' . $this->mass['dmg_min1'] . '-' . $this->mass['dmg_max1'] . '</b>' . $this->item_string->dmg_type($this->mass['dmg_type1']);
            $item .= ' <b style="float: right;margin-right: 5px;">Скорость ' . $this->item_string->speed($this->mass['delay']) . "</b><br>";
            if ($this->mass['dmg_min2'] != 0 and $this->mass['dmg_max2'] != 0) {
                $item .='<b> +' . $this->mass['dmg_min2'] . '-' . $this->mass['dmg_max2'] . ' ед.урона ' . $this->item_string->dmg_type($this->mass['dmg_type2']) . "</b><br>";
            }
            $dmg1 = $this->item_string->dmg_sec($this->mass['dmg_min1'], $this->mass['dmg_max1'], $this->mass['delay']);
            $dmg2 = $this->item_string->dmg_sec($this->mass['dmg_min2'], $this->mass['dmg_max2'], $this->mass['delay']);
            $dmg = ($dmg2 != 0) ? $dmg1 + $dmg2 : $dmg1;
            $item .= '<b>  (' . $dmg . ' ед. урона в секунду) </b><br>';
            if ($this->mass['armor']) {
                $item .= ' <font color="#1eff00">Браня: ' . $this->mass['armor'] . '</font><br>';
            }
        } elseif ($this->mass['class'] == 3) {
            if ($this->item_string->class_subclass($this->mass['class'], $this->mass['subclass']) != '') {
                $item .= $this->item_string->InventoryType($this->mass['InventoryType']) . ' ' . $this->item_string->class_subclass($this->mass['class'], $this->mass['subclass']) . "<br>";
            }
            if ($this->mass['stackable'] > 0) {
                $item .= 'max кол. [' . $this->mass['stackable'] . ']<br>';
            }
            if ($this->mass['GemProperties'] != '0') {
                $item .= $this->item_db->select_Gem_prop($this->mass['GemProperties'],  $this->mass['build']) . '<br>';
            }
        } elseif ($this->mass['class'] == 4) {
            $item .= ' <b style="float: left;">' . $this->item_string->InventoryType($this->mass['InventoryType']) . '</b>';
            $item .= ' <b style="float: right;margin-right: 5px;">' . $this->item_string->class_subclass($this->mass['class'], $this->mass['subclass']) . "</b><br>";
            if ($this->mass['armor']) {
                $item .= ' <b>Браня: ' . $this->mass['armor'] . '</b><br>';
            }
        }
        return $item;
    }

    private function items_state() {
        $mass = array();
        if ($this->mass['stat_type1'] == true)
            $mass[1] = $this->mass['stat_type1'];
        if ($this->mass['stat_type2'] == true)
            $mass[2] = $this->mass['stat_type2'];
        if ($this->mass['stat_type3'] == true)
            $mass[3] = $this->mass['stat_type3'];
        if ($this->mass['stat_type4'] == true)
            $mass[4] = $this->mass['stat_type4'];
        if ($this->mass['stat_type5'] == true)
            $mass[5] = $this->mass['stat_type5'];
        if ($this->mass['stat_type6'] == true)
            $mass[6] = $this->mass['stat_type6'];
        if ($this->mass['stat_type7'] == true)
            $mass[7] = $this->mass['stat_type7'];
        if ($this->mass['stat_type8'] == true)
            $mass[8] = $this->mass['stat_type8'];
        if ($this->mass['stat_type9'] == true)
            $mass[9] = $this->mass['stat_type9'];
        if ($this->mass['stat_type10'] == true)
            $mass[10] = $this->mass['stat_type10'];

        $stat = '';
        asort($mass);
        if (is_array($mass)) {
            foreach ($mass as $key => $val) {
                if ($val <= 7) {
                    $stat .= '<font color="#fff"> + ' . $this->mass['stat_value' . $key] . ' ' . $this->item_string->stat_type($this->mass['stat_type' . $key]) . '</font><br>';
                } elseif ($val > 7) {
                    $stat .= '<font color="#1eff00"> + ' . $this->mass['stat_value' . $key] . ' ' . $this->item_string->stat_type($this->mass['stat_type' . $key]) . '</font><br>';
                }
            }
        }
        return $stat;
    }

    private function items_res() {
        $res = '';
        if ($this->mass['holy_res'] != '0')
            $res .= '<font color="#fff">' . $this->item_string->res($this->mass['holy_res'], 0) . '<font><br>';
        if ($this->mass['fire_res'] != '0')
            $res .= '<font color="#fff">' . $this->item_string->res($this->mass['fire_res'], 1) . '<font><br>';;
        if ($this->mass['nature_res'] != '0')
            $res .= '<font color="#fff">' . $this->item_string->res($this->mass['nature_res'], 2) . '<font><br>';;
        if ($this->mass['frost_res'] != '0')
            $res .= '<font color="#fff">' . $this->item_string->res($this->mass['frost_res'], 3) . '<font><br>';;
        if ($this->mass['shadow_res'] != '0')
            $res .= '<font color="#fff">' . $this->item_string->res($this->mass['shadow_res'], 4) . '<font><br>';;
        if ($this->mass['arcane_res'] != '0')
            $res .= '<font color="#fff">' . $this->item_string->res($this->mass['arcane_res'], 5) . '<font><br>';;
        return $res;
    }

    private function items_socket() {
        $socket = '';
        $socket .= $this->item_string->item_soket($this->mass['socketColor_1']);
        $socket .= $this->item_string->item_soket($this->mass['socketColor_2']);
        $socket .= $this->item_string->item_soket($this->mass['socketColor_3']);
        return $socket;
    }

    private function socketBonus() {
        if ($this->mass['socketBonus'] > 1) {
            return '<font color="#9d9d9d">При соответствии цвета: ' . $this->item_db->socket_bonus($this->mass['socketBonus'],  $this->mass['build']) . '</font><br>';
        }
    }

    private function items_durability() {
        if ($this->mass['MaxDurability'] != '0') {
            return '<font color="#fff">Прочность: ' . $this->mass['MaxDurability'] . ' / ' . $this->mass['MaxDurability'] . '<br>';
        }
    }

    private function items_char_classes() {
        if ($this->item_string->AllowableClass($this->mass['AllowableClass']) != '') {
            return '<font color="#fff">' . $this->item_string->AllowableClass($this->mass['AllowableClass']) . '<font><br>';
        }
    }

    private function spell_info() {
        $spell[0] = '<div style="color:#1eff00;">';
        if ($this->mass['spellid_1'] == true) {
            $spell[1] = $this->item_db->spell_info_dbc($this->mass['spellid_1'], $this->item_string->spelltrigger($this->mass['spelltrigger_1']), $this->mass['build']);
        }
        if ($this->mass['spellid_2'] == true) {
            $spell[2] = $this->item_db->spell_info_dbc($this->mass['spellid_2'], $this->item_string->spelltrigger($this->mass['spelltrigger_2']), $this->mass['build']);
        }
        if ($this->mass['spellid_3'] == true) {
            $spell[3] = $this->item_db->spell_info_dbc($this->mass['spellid_3'], $this->item_string->spelltrigger($this->mass['spelltrigger_3']), $this->mass['build']);
        }
        if ($this->mass['spellid_4'] == true) {
            $spell[4] = $this->item_db->spell_info_dbc($this->mass['spellid_4'], $this->item_string->spelltrigger($this->mass['spelltrigger_4']), $this->mass['build']);
        }
        if ($this->mass['spellid_5'] == true) {
            $spell[5] = $this->item_db->spell_info_dbc($this->mass['spellid_5'], $this->item_string->spelltrigger($this->mass['spelltrigger_5']), $this->mass['build']);
        }
        $spell[6] = '</div>';
        $spl = implode(' ', $spell);
        return $spl;
    }

    private function items_char_race() {
        if ($this->item_string->AllowableRace($this->mass['AllowableClass']) != '') {
            return '<font color="#fff">' . $this->item_string->AllowableRace($this->mass['AllowableClass']) . '<font><br>';
        }
    }

    private function items_char_lvl() {
        if ($this->mass['RequiredLevel'] != '0') {
            return '<font color="#fff">Требуется уровень:' . $this->mass['RequiredLevel'] . '<font><br>';
        }
    }

    private function char_requiredspell() {
        if ($this->mass['requiredspell']) {
            $spell = $this->item_db->select_spell($this->mass['requiredspell'],$this->mass['build']);
            if ($spell) {
                return '<font color="#fff">Требуется: ' . $spell['SpellName_ru_ru'] . '<font><br>';
            }
        }
    }

    private function set_items() {
        if ($this->mass['itemset']) {
            return $this->item_db->item_set_info($this->mass['itemset'],  $this->mass['build']);
        }
    }

    private function items_money() {
        if ($this->mass['SellPrice'] != '0') {
            return '<font color="#fff">Цена продажи:' . $this->item_string->item_money($this->mass['SellPrice']) . '<font><br>';
        }
    }
    
    
}


