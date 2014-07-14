<?php
namespace app\model\user;
if(!defined('DOST')){ die(header("HTTP/1.x 404 Not Found"));}

class cart extends \libs\parents\Model
{
    private $total;
    public $total_count;

    public function add_item($item,$session,$count = ''){
        if($count == ''){
            $count = 1;
        }
        
        $id = $item['id_lot'];
        $entry = $item['entry'];
        $session_id = $session['session_id'];
        $Vp = $item['price_Vp'];
        $price_count = $item['price_count'];
        $stackable = $item['stackable'];
        $id_user = $session['id'];
        $status = 1;
        
        $this->connect->query("INSERT INTO ^cart (id_lot,entry,price_count,count,stackable,session_id,price_vp,id_user,status) VALUES('$id','$entry','$price_count','$count','$stackable','$session_id','$Vp','$id_user','$status')");
        if($this->connect->getLastId()){
            return true;
        }else{
            return false;
        }
    }
    
    public function select_status_cart($id_user,$id_session){
        $status = array();
        $db = $this->connect->query('SELECT id_lot,count,price_vp FROM ^cart WHERE session_id = "'.$id_session.'"  AND id_user = '.$id_user.' AND status = 1');
        if($db->num_rows > 0){
            return $this->status_cart($db->rows);
        }else{
            return false;
        }
    }
    
    public function status_cart($cart){
        if (!is_null($cart)) {
            $status['count'] = count($cart);
            for ($i = 0; $i < $status['count']; $i++) {
                $vp[$i] = $cart[$i]['price_vp'] * $cart[$i]['count'];
            }
            $status['sum'] = array_sum($vp);
            return $status;
        }
    }
    
    public function select_list_cart($id_session,$id_user){
        $params = array();
        $item = new \app\model\item\item_mediator();
        $db = $this->connect->query('SELECT id,id_lot,count,price_vp,price_count FROM ^cart WHERE session_id = "'.$id_session.'"  AND id_user = '.$id_user.' AND status = 1');
        if($db->num_rows > 0){
            $this->total = $db->rows;
            for($i=0;$i < count($db->rows);$i++){
                $params[$i]['item'] = $item->getItemLot($db->rows[$i]['id_lot']);
                $params[$i]['price_count'] = $db->rows[$i]['price_count'];
                $params[$i]['count'] = $db->rows[$i]['count'];
                $params[$i]['Vp'] = $db->rows[$i]['price_vp'] * $db->rows[$i]['count'];
                $params[$i]['Vp_start'] = $db->rows[$i]['price_vp'];
                $params[$i]['id'] = $db->rows[$i]['id'];
                $this->total_count[] = $params[$i]['count'] + (((int) $params[$i]['price_count'] > 1) ? $params[$i]['price_count']: 0);
            }
            return $params;
        }else{
            return false;
        }
    }
    
    public function getTotal(){
        return $this->status_cart($this->total);    
    }

    public function select_characters($id, $realm_id){
        $characters = new \app\model\user\account();
        return $characters->select_characters($id, $realm_id);
    }
    
    public function delete_item($id,$id_user){
         $this->connect->query("DELETE FROM ^cart WHERE id_user = '$id_user' AND id= '$id'");
    }
    
    private function getConfigParams($key){
        $conf = $this->ServerConfig();
        return $conf[$key];
    }
    
    public function Soap_send_item($post, $char, $items, $session, $lang) {
        if (isset($post['send_soap'])) {
            if (is_numeric($post['char'])) {
                $account = new \app\model\user\account();
                $Vp = $account->selectVP($session['id']);
                $total = $this->getTotal();
                $msg = '';
                $characters = $char[$post['char']]['char_name'];
                $server = new \app\model\server\server_db;
                $chars = $server->select_characters($characters, $session['realm_id']);
                if ($Vp >= $total['sum']) {
                    if ($chars === true) {
                        $soap = $this->SoapConnect($this->getConfigParams($session['realm_id']), $items, $characters);
                        
                        if (@in_array('true', $soap->send)) {
                            $this->cart_send($session['id'],$Vp,$total['sum'],$account);
                            $msg = Message('success', $lang->get('message_send_success'));
                            $this->refresh(1);
                        } elseif (@in_array('connect', $soap->send)) {
                            $msg = Message('info', $lang->get('message_send_server'));
                        } else {
                            $msg = Message('error', $lang->get('meesage_send_error'));
                        }
                    } elseif ($chars === false) {
                        $msg = Message('info', $lang->get('message_send_null'));
                    } elseif ($chars == 'connect') {
                        $msg = Message('info', $lang->get('message_send_server'));
                    }
                } else {
                    $msg = Message('warning', $lang->get('message_send_vp'));
                }
            } else {
                $msg = Message('info', $lang->get('message_send_char'));
            }
            return $msg;
        }
    }

    private function cart_send($id,$Vp,$total,$account){ 
         $Vp_sum = $Vp - $total;
         if($account->updateVP($Vp_sum,$id)){
             $this->delete_cart($id);
         }
    }
    
    private function delete_cart($id){
        $this->connect->query("DELETE FROM ^cart WHERE id_user = '$id' ");
    }

}