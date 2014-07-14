<?php
namespace app\controller\item;
if(!defined('DOST')){ die(header("HTTP/1.x 404 Not Found"));}

class item extends \libs\parents\Controller{
    
    public function itemList($key, $realm_id = '') {
        $view = '';
        $this->leng->load('item');
        $item = $this->app_model_item_items;
        $item_list = $item->item_lot();
        
        if (isset($item_list[$key]) and is_array($item_list[$key])) {
            $count = count($item_list[$key]);
            $num = 1;
            if ($realm_id != '') {
                $count = (int) $realm_id;
                $num = $realm_id;
            }
            for ($i = $num; $i <= $count; $i++) {
                $view .= '<blockquote><p>' . $item_list[$i]['server_name'] . '  <i class="vs-icon-' . $item_list[$i]['build'] . '"></i></p></blockquote>';
                if (isset($item_list[$key][$i])) {
                    foreach ($item_list[$key][$i] as $keys => $val) {
                        $this->data['id'] = $val['id_lot'];
                        $this->data['realm_id'] = $val['realm_id'];
                        $this->data['entry'] = $val['entry'];
                        $this->data['icon'] = $val['icon'];
                        $this->data['item_name'] = $val['item_name'];
                        $this->data['price_count'] = $val['price_count'];
                        $this->data['server_name'] = $val['server_name'];
                        $this->data['price_Vp'] = $val['price_Vp'];
                        $this->data['count'] = $this->leng->get('count');
                        $this->data['realm'] = $this->leng->get('realm');
                        $view .= $this->view->getTemplate('item', 'item_lot', $this->data);
                    }
                } else {
                    return false;
                }
            }
            return $view;
        } else {
            return false;
        }
    }

    public function tooltip_item($post) {
        $item = $this->app_model_item_items;
        if (@AJAX === true) {
            $post = $this->Post($post);
            if ($post['ajax'] !== false) {
                echo $item->item_tooltip($post['ajax']);
            }
        }
    }
    
    public function tooltip_info_item($realm_id,$entry){
        $item = $this->app_model_item_items;
        return $item->item_tooltip('item_'.$realm_id.'_'.$entry);
    }

    public function item_lot_info($id = ''){
         $item = $this->app_model_item_items;
         return $item->getItemLot($id);
    }
    
    public function item_add_cart($post,$item,$session,$prm){
        if($prm !== false || $prm != ''){
            $this->leng->load('cart');
            if(isset($post['send_item']) and $session !== false){
              $cart = $this->app_model_user_cart;
              $post = $this->Post($post);
              $msg = $cart->add_item($item,$session,(int) $post['count']);
              if($msg === false){
                  $msg = Message('error', $this->leng->get('add_error'));
              }else{
                  $msg = Message('success', 'Item('.$item['item_name'].') '.$this->leng->get('add_success'));
                  $this->refresh(1);
              }
              return $msg;
            }
        }
    }
    
    public function AdminItemList(){
        $item = $this->app_model_item_items;
        $item_list = $item->item_list();
        return $item_list;
    }

}
