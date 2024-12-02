<?php defined('BASEPATH') OR exit('No direct script access allowed');
class misc extends utils {
    public $DBCon; 
    public function __construct($param){
        $this->DBCon = $param;
    }

}
?>