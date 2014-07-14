<?php
namespace libs\Driver;
if(!defined('DOST')){ die(header("HTTP/1.x 404 Not Found"));}

final class Mysqli { 

    private $link;
    private $prefix = '';

    public function __construct($hostname, $username, $password, $database,$port = '',$prefix = '',$ecoding = '') {
        $this->link = @new \mysqli($hostname, $username, $password, $database , $port);
        $this->prefix = $prefix;
        if (mysqli_connect_error()) {
            throw new \libs\Exception\ExceptMsg('No connection to server ! Try again later. ::  Error: Could not make a database link (' . mysqli_connect_errno() . ') ' . mysqli_connect_error(),0);
        }
        if(isset($ecoding)){
            $this->link->set_charset($ecoding);
        }else{
            $this->link->set_charset("utf8");
        }
    }

    public function query($sql) {
        $sql = $this->prefix($sql);
        $query = $this->link->query($sql);

        if (!$this->link->errno) {
            if (isset($query->num_rows)) {
                $data = array();

                while ($row = $query->fetch_assoc()) {
                    $data[] = $row;
                }

                $result = new \stdClass();
                $result->num_rows = $query->num_rows;
                $result->row = isset($data[0]) ? $data[0] : array();
                $result->rows = $data;

                unset($data);

                $query->close();

                return $result;
            } else {
                return true;
            }
        } else {
            throw new \libs\Exception\ExceptMsg('No connection to server ! Try again later. :: Error: ' . $this->link->error . '<br />Error No: ' . $this->link->errno . '<br />' . $sql);
        }
    }

    public function prefix($sql){
        if(isset($this->prefix)){
            $pr = $this->prefix;
        }else{
            $pr = '';
        }
        $sql  = str_replace('^', $pr, $sql);
        return $sql;      
    }

    public function escape($value) {
        return $this->link->real_escape_string($value);
    }

    public function countAffected() {
        return $this->link->affected_rows;
    }

    public function getLastId() {
        return $this->link->insert_id;
    }

    public function __destruct() {
        $this->link->close();
    }

}

