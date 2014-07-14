<?php
namespace app\model\admin;
if(!defined('DOST')){ die(header("HTTP/1.x 404 Not Found"));}

class item extends \libs\parents\Model
{   
    public function edit($post,$lang){
        $msg = '';
        if (isset($post['edit'])) {
            foreach ($post as $key => $value) {
                if ($value == '') {
                    unset($post[$key]);
                }
            }
           
            $arr= array();
            $id = explode('_',$post['edit']);
            
            $arr['Vp'] = (isset($post['Vp_'.$id[0]])) ? (int) $post['Vp_'.$id[0]] : '';
            $arr['count'] = (isset($post['Cn_'.$id[0]])) ? (int) $post['Cn_'.$id[0]] : '';
            $arr['locked'] = (isset($post['Lc_'.$id[0]])) ? (int) $post['Lc_'.$id[0]] : '';
            $edit = $this->editItem($id, $arr);
            if($edit === true){               
                if ($this->cache->params === true) {
                    $this->cache->delete('item.lot.' . $id[1]);
                }
                $msg = Message('success', $lang->get('msg_success'));
                $this->refresh(1);
            }elseif($edit == 'null'){
                $msg = Message('warning', $lang->get('msg_null_zap'));
            }else{
                $msg = Message('error', $lang->get('msg_error'));
            }
        }

        if(isset($post['delete'])){
            $id_del = explode('_',$post['delete']);
            $delet = $this->delete_item($id_del);
            if($delet === true){
                 if ($this->cache->params === true) {
                     $this->cache->delete('item.lot.' . $id_del[1]);
                     $this->cache->delete('item.tooltip');
                 }
               $msg = Message('success', $lang->get('msg_success_del'));
               $this->refresh(1);
            }else{
               $msg = Message('error', $lang->get('msg_error'));
            }
        }
        return $msg;
    }
    
    private function editItem($id, $arr) {
        $zap = '';
        $id_lot = (int) $id[0];
        if ($arr['Vp'] != '' and $arr['Vp'] !== 0) {
            $Vp = $arr['Vp'];
            $zap .= " price_Vp = '$Vp',";
        }
        if ($arr['count'] != '' and $arr['count'] !== 0) {
            $count = $arr['count'];
            $zap .= " price_count = '$count',";
        }
        if ($arr['locked'] !== '') {
            $locked = $arr['locked'];
            $zap .= " Locked = '$locked',";
        }

        if ($zap != '') {
            $zap = substr($zap, 0, strlen($zap) - 1);
            $this->connect->query("UPDATE ^item_lot SET $zap  WHERE id_lot = '$id_lot' ");
            if ($this->connect->countAffected()) {
                return true;
            } else {
                return false;
            }
        } else {
            return 'null';
        }
    }
    
    private function delete_item($prm) {
        $id = (int) $prm[0];
        if ($id != 0) {
            $this->connect->query("DELETE FROM ^item_lot WHERE id_lot = '$id'");
            if ($this->connect->countAffected()) {
                return true;
            } else {
                return false;
            }
        }
    }
    
    public function list_servers(){
        if(is_array($this->ServerConfig())){
            $serv = array();
            foreach ($this->ServerConfig() as $key => $val) {
                $serv[$key]['name'] = $val['server_name'];
            }
            return $serv;
        }else{
            return false;
        }
    }

    public function searchItem($post, $lang) {
        $server = new \app\model\server\server_db;
        $msg = '';
        if (isset($post['send_search'])) {
            if ($post['name'] == '') {
                $msg = Message('info', $lang->get('msg_null'));
            } else {               
                $list_item = $server->searchItems($post['name'], $post['count'], $post['serv']);
                if(is_array($list_item)){
                    return $list_item;  
                }elseif($list_item === false){
                    $msg = Message('info', $lang->get('msg_false'));
                }elseif($list_item == 'connect'){
                    $msg = Message('info', $lang->get('msg_connect'));
                }elseif($list_item == 'zap'){
                    $msg = Message('error', $lang->get('msg_zap'));
                }                
            }
            
        }
        
        if(isset($post['create'])){
            foreach ($post as $key => $value) {
                if ($value == '') {
                    unset($post[$key]);
                }
            }
            
            $id = explode('_', $post['create']);
            $item = $server->selectItemServ($id[0], $id[1]);
            $Vp = (isset($post['Vp_'.$id[0]])) ? $post['Vp_'.$id[0]] : '';
            $count = (isset($post['Cn_'.$id[0]])) ? $post['Cn_'.$id[0]] : '';
            
            $add = $this->addItem($item, $id[1], $Vp,$count);
            if($add == 'null'){
                $msg = Message('error', $lang->get('msg_add_null'));  
            }elseif($add !== false){
                 if ($this->cache->params === true) {
                     $this->cache->delete('item.lot.' . $id[1]);
                     $this->cache->delete('item.tooltip');
                 }
                $msg = Message('success', $lang->get('msg_add_success'));
                $this->refresh(1);
            }else{
                $msg = Message('error', $lang->get('msg_add_error'));
            }
        }
        return $msg;
    }
    
    private function addItem($mass,$realm,$Vp = '',$count = ''){
        if(is_array($mass) and $realm != 0){
            if($Vp == ''){
                $Vp = 0;
            }
            if($count == ''){
                $count = 0;
            }
            $mass['price_Vp'] = $Vp;
            $mass['price_count'] =$count;
            $mass['realm_id'] = $realm;
            $mass['date_create'] = time();
            $mass['Locked'] = 1;
            $mass['name_ru_ru'] = '"'.htmlspecialchars($mass['name_loc8'], ENT_QUOTES).'"';
            $mass['description_ru_ru'] = '"'.htmlspecialchars($mass['description_loc8'], ENT_QUOTES).'"';
            $mass['ScriptName'] = '"'.htmlspecialchars($mass['ScriptName'], ENT_QUOTES).'"';
            $mass['name'] = '"'.htmlspecialchars($mass['name'], ENT_QUOTES).'"';
            $mass['description'] = '"'.htmlspecialchars($mass['description'], ENT_QUOTES).'"';
            unset($mass['name_loc8'],$mass['description_loc8']);
            $key = array_keys($mass);
            $value = array_values($mass);
            $column = implode(',', $key);
            $vals = implode(',', $value);             
            $this->connect->query("INSERT INTO ^item_lot ($column) VALUES ($vals)");
            if ($this->connect->getLastId()) {
                return $this->connect->getLastId();
            } else {
                return false;
            }
        }else{
            return 'null';
        }
    }
}

