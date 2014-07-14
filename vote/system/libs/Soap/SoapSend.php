<?php
namespace libs\Soap;
if(!defined('DOST')){ die(header("HTTP/1.x 404 Not Found"));}

class SoapSend {

    private $Connect_Soap;
    public $send = array();
    private $log = array();
    private $command = array();
    private $logs = array();

    public function __construct($host,$port,$login,$pass,$title,$text,$parametrs,$char,$log) { 
        $this->logs = $log;
        $test = $this->testConnection($host, $port);
        if($test === true){
            $this->Connect_Soap = @new \SoapClient(NULL, array('location' => 'http://' . $host . ':' . $port . '/',
                'uri' => 'urn:TC',
                'user_agent' => 'trinitycore',
                'style' => SOAP_RPC,
                'login' => $login,
                'password' => $pass,
                'trace' => 1,
                'exceptions' => 0
            ));
            
            return $this->compileCommand($title, $text, $parametrs,$char);
        }else{
            $this->send = 'connect';
            return $this->send;
        }
    }

    private function testConnection($host,$port){
        $fp = @fsockopen($host, $port, $errno, $errstr, 10);
        if($fp){
            return true;
        }else{
            return false;
        }
    }
    
    private function send_command($command) {
        $this->command[] = $command;
        $send = $this->Connect_Soap->executeCommand(new \SoapParam($command, "command"));
        if (is_soap_fault($send)){
            $this->log[] = $send->faultstring;
            return 'false';
        }else{
             $this->log[] = $send;
            return 'true';
        }
    }

    public function compileCommand($title,$text,$item,$char){
         $command = $this->sort_command($item);
         
         for($i=0;$i <= count($command) - 1;$i++){
             $this->send[] = $this->string_format($title, $text, $command[$i], $char);
         }         
         $this->send = array_unique($this->send);
         $this->logSoap($this->command, $this->log);
         return $this->send;
    }
    
    private function string_format($title,$text,$command,$char){       
        $cmd = '.send items '.$char.' "'.$title.'" "'.$text.'" '.implode(" ", $command);
        return $this->send_command($cmd);
    }
    
    private function sort_command($item) {
        $cmd = '';
        if (is_array($item)) {
            for ($i = 0; $i < count($item); $i++) {
                $sum[$i] = $item[$i]['price_count'] * $item[$i]['count'];
                if ($item[$i]['item']['stackable'] == 1) {
                    for ($s = 1; $s <= $sum[$i]; $s++) {
                        $cmd .= $item[$i]['item']['entry'] . ':' . 1 . ' ';
                    }
                } elseif ($sum[$i] > $item[$i]['item']['stackable']) {
                    $stackable[$i] = $item[$i]['item']['stackable'];
                    $num[$i] = $sum[$i] / $stackable[$i];
                    if (is_float($num[$i])) {
                        for ($r = 1; $r <= floor($num[$i]); $r++) {
                            $cmd .= $item[$i]['item']['entry'] . ':' . $item[$i]['item']['stackable'] . ' ';
                        }
                        $cmd .= $item[$i]['item']['entry'] . ':' . abs((floor($num[$i]) - $num[$i]) * $item[$i]['item']['stackable']) . ' ';
                    } else {
                        for ($z = 1; $z <= $num[$i]; $z++) {
                            $cmd .= $item[$i]['item']['entry'] . ':' . $item[$i]['item']['stackable'] . ' ';
                        }
                    }
                } elseif ($sum[$i] <= $item[$i]['item']['stackable']) {
                    $cmd .= $item[$i]['item']['entry'] . ':' . $sum[$i] . ' ';
                }
            }
            $items = explode(' ', $cmd);
            $items = array_filter($items);
            $items = array_chunk($items, 12);
        }
        return $items;
    }
    
    private function logSoap($msg, $status) {
        if ($this->logs['log'] !== false) {
            $line_text = '';
            $path_file = SYS_PATH . 'log' . DS . $this->logs['name'].'.Soap.log';
            $line_text .= '-[start][' . date("d-m-Y H:i:s") . ']---------------' . PHP_EOL;
            if (is_array($msg) and is_array($status)) {
                foreach ($msg as $key => $val) {
                    $line_text .= 'Запрос[' . $key . ']: ' . $val . PHP_EOL;
                }
                foreach ($status as $keys => $vals) {
                    $line_text .= 'Ответ[' . $keys . ']: ' . $vals . PHP_EOL;
                }
            }
            $line_text .= '-[end]--------------------------------------' . PHP_EOL;
            file_put_contents($path_file, $line_text, LOCK_EX | FILE_APPEND);
        }
        unset($this->log, $this->command);
    }

}