<?php defined('BASEPATH') OR exit('No direct script access allowed');
class appointment extends utils {
    public $DBCon; 
    public function __construct($param){
        $this->DBCon = $param;
    }

    public function getAppointmentDaily($param, $all = null){
        $call = $this->newsp("sp_web_get_daily_appointment_list");
		$call->action = "get";
        $call->all = isset($all) ? true : null;
        $call->field[] = ["date", isset($param["date"]) ? $param["date"] : ""];

        # field data decleration
        $output = $this->DBCon->call($call);
        return $output;
    }

    public function getAppointment($param, $all = null){
        $call = $this->newsp("sp_web_get_appointment_info");
		$call->action = "get";
        $call->all = isset($all) ? true : null;
        $call->field[] = ["id", isset($param["id"]) ? (int)$param["id"] : 0];

        # field data decleration
        $output = $this->DBCon->call($call);
        return $output;
    }
}
?>