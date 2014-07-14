<?php
namespace libs\Exception;
if(!defined('DOST')){ die(header("HTTP/1.x 404 Not Found"));}

class ExceptMsg extends \Exception {
    
    private $MessageData = array();

    public function array_msg(){
        if(isset($this->code)){
            $this->MessageData['code'] = $this->code;
        }
        if(strpos($this->getMessage(),'::') !== false){
           $message = explode('::', $this->getMessage());
           $this->MessageData['Message'] = $message[0];
           $this->MessageData['Comment'] = $message[1];
        }else{
           $this->MessageData['Message'] = $this->getMessage();
        }
        $this->MessageData['File'] = $this->getFile();
        $this->MessageData['Line'] = $this->getLine();
        $this->MessageData['Trace'] = nl2br($this->getTraceAsString());       
    }

    public function getMsg(){
        $this->array_msg();
        if($this->MessageData['Message']){
            return 'Message: '.$this->MessageData['Message'].'<br />';
        }
    }
    
    public function getMsgAdmin(){
        $this->array_msg();
        $display = '';
        if(is_array($this->MessageData)){
            $display .= (isset($this->MessageData['Comment'])) ? 'Comment:'.$this->MessageData['Comment'] .'<br />': '';
            $display .= 'Error file: '.$this->MessageData['File'].' line: '.$this->MessageData['Line'].'<br />';
            if(isset($this->MessageData['code']) and $this->MessageData['code'] != 0){
               $display .= 'Trace:<br />'.$this->MessageData['Trace'];
            }
        }
        return $display;   
    }
    
    public function getLogMsg(){
        $this->array_msg();
        $display = '';
        if(is_array($this->MessageData)){
            $display .= (isset($this->MessageData['Comment'])) ? 'Comment:'.$this->MessageData['Comment'] .'<br />': '';
            $display .= 'Error file: '.$this->MessageData['File'].' line: '.$this->MessageData['Line'].'<br />';
            $display .= 'Trace:<br />'.$this->MessageData['Trace'];
        }
        return $display; 
    }

    public function Message(){
        if (isset($GLOBALS['log_error']) and $GLOBALS['log_error'] === true) {
            $this->logError();
        }
        $GLOBALS['display_error'] = 'Error_all';
        $msg = '';
        
        if(isset($GLOBALS['display_error_user']) and $GLOBALS['display_error_user'] === true and $GLOBALS['display_error'] === null){
            $msg .= $this->getMsg();
        }
        
        if(isset($GLOBALS['display_error']) and $GLOBALS['display_error'] == 'Error_all'){
            $msg .= $this->getMsgAdmin();
        }       
        
        return $msg;
    }

    private function logError() {
            $line_text = '';
            $path_file = SYS_PATH . 'log' . DS . 'error.log';
            $error_text = str_replace('<br />', PHP_EOL, $this->getLogMsg());
            $line_text .= '-[start]['.date("d-m-Y H:i:s").']---------------'.PHP_EOL;
            $line_text .= $error_text.PHP_EOL;
            $line_text .= '-[end]--------------------------------------'.PHP_EOL.PHP_EOL;
            file_put_contents($path_file, $line_text,LOCK_EX | FILE_APPEND);
    }

}
