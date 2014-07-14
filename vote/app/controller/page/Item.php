<?php
namespace app\controller\page;
if(!defined('DOST')){ die(header("HTTP/1.x 404 Not Found"));}

class Item extends \libs\parents\Controller{
    
    private $items = '';

    public function ActionLot() {
        if (isset($this->get) and filter_var($this->get[0], FILTER_VALIDATE_INT)) {
            $session = $this->session->user;
            $item = $this->app_controller_item_item;
            $item_info = $item->item_lot_info($this->get[0]);
            if($session !== false){
                $this->items = ($session['realm_id'] == $item_info['realm_id']) ? true : false;
            }

            if ($item_info !== false and $this->items !== false) {
                $this->leng->load('item');
                $this->data['realm_item'] = $this->leng->get('realm_item');
                $this->data['price_item'] = $this->leng->get('price_item');
                $this->data['count_item'] = $this->leng->get('count_item');
                $this->data['input_count'] = $this->leng->get('input_count');
                $this->data['botton_item_cart'] = $this->leng->get('botton_item_cart');
                $this->data['item_name'] = $item_info['item_name'];
                $this->data['realm'] = $item_info['server_name'];
                $this->data['price'] = $item_info['price_Vp'];
                $this->data['count'] = $item_info['price_count'];
                $this->data['session'] = $session;
                $this->data['message_session'] = Message('info',$this->leng->get('message_session'));
                
                $item_tooltip = $item->tooltip_info_item($item_info['realm_id'], $item_info['entry']);
                
                $this->data['tooltip'] =  $item_tooltip;
                
                $session['session_id'] = $this->session->getId;
                
                $this->getHeader('Item '.strip_tags($item_info['item_name']), strip_tags($item_info['item_name']),'',$item->item_add_cart($_POST,$item_info,$session,$this->items));
                $this->getFooter();
                
                $this->render('item', 'page');
            } else {
                $this->redirect();
            }
        } else {
            $this->redirect();
        }
    }
}

