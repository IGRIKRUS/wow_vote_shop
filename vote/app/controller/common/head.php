<?php
namespace app\controller\common;
if(!defined('DOST')){ die(header("HTTP/1.x 404 Not Found"));}

class head extends \libs\parents\Controller{
    
    public $title;
    public $description;
    public $keywords;

    public function head(){
        $this->data['ecoding'] = $this->config->ecoding_html;
        $this->data['style'] = $this->config->style;
        $this->data['title'] = (isset($this->title) and $this->title != '') ? 'Vote Shop | '.$this->title : 'Vote Shop';
        $this->data['description'] = (isset($this->description) and $this->description != '') ? $this->description : 'Vote Shop';
        $this->data['keywords'] = (isset($this->keywords) and $this->keywords != '') ? $this->keywords : ' ';
        return $this->view->getTemplate('common', 'head' ,$this->data);
    }
}
