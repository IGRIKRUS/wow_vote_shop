<?php
namespace app\model\item;
if(!defined('DOST')){ die(header("HTTP/1.x 404 Not Found"));}

class item_mediator extends \libs\parents\Model
{
    protected $item_db;
    protected $item_string;
    protected $items;
    protected $Lang;
    


    public function __construct() {
        $this->item_db = new \app\model\item\item_db;
       
        $this->item_string = new \app\model\item\item_string;
        $this->Lang = '_'.strtolower($this->item_db->Lang);
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
}
