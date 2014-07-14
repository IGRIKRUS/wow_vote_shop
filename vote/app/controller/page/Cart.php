<?php
namespace app\controller\page;
if(!defined('DOST')){ die(header("HTTP/1.x 404 Not Found"));}

class Cart extends \libs\parents\Controller
{
    public function ActionIndex(){
        if($this->session->user){
        $cart = $this->app_model_user_cart;
        $chars_list = $cart->select_characters($this->session->user['id'], $this->session->user['realm_id']);
        $item_list = $cart->select_list_cart($this->session->getId,$this->session->user['id']);
        $this->leng->load('cart');
        $this->data['cart_title'] = $this->leng->get('cart_title');
        $this->data['cart_item'] = $this->leng->get('cart_item');
        $this->data['cart_price_count'] = $this->leng->get('cart_price_count');
        $this->data['cart_item_count'] = $this->leng->get('cart_item_count');
        $this->data['cart_total'] = $this->leng->get('cart_total');
        $this->data['cart_chars'] = $this->leng->get('cart_chars');
        $this->data['cart_botton'] = $this->leng->get('cart_botton');
        $this->data['char_list'] = $chars_list;
        $this->data['cart_item_list'] = $item_list;
        $this->data['cart_types'] = $this->leng->get('cart_types');
        $this->data['count_total'] = (isset($cart->total_count)) ? array_sum($cart->total_count) : '';
        $this->data['total'] = $cart->getTotal();
        $this->data['message_char_null'] = Message('warning',$this->leng->get('message_char_null'));
        $this->data['message_cart_null'] = Message('info',$this->leng->get('message_cart_null'));
        $this->getHeader('Cart','Cart Vote Shop','',$cart->Soap_send_item($this->Post($_POST),$chars_list,$item_list,$this->session->user,$this->leng));
        $this->getFooter();
        
        $this->render('cart', 'page');
        
        }else{
            $this->NotFound();
        }
    }
    
    public function ActionDelet(){
        if (isset($this->get) and filter_var($this->get[0], FILTER_VALIDATE_INT)) {
            if ($this->session->user) {
                $cart = $this->app_model_user_cart;
                $cart->delete_item($this->get[0], $this->session->user['id']);
                $this->redirect('cart');
            } else {
                $this->redirect('cart');
            }
        } else {
            $this->redirect('cart');
        }
    }
}