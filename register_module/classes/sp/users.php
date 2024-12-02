<?php defined('BASEPATH') OR exit('No direct script access allowed');
class users extends utils {
    public $DBCon; 
    public function __construct($param){
        $this->DBCon = $param;
    }

    public function gender($param, $all = null){
        $call = $this->newsp("sp_web_get_gender");
		$call->action = "get";
        $call->all = isset($all) ? true : null;
        $call->field[] = ["id", isset($param["id"]) ? (int)$param["id"] : 0];

        # field data decleration
        $output = $this->DBCon->call($call);
        return $output;
    }

    public function add_update_member($param, $all = null){
        $call = $this->newsp("sp_web_new_registration");
		$call->action = "get";
        $call->all = isset($all) ? true : null;
        $call->field[] = ["id", isset($param["id"]) ? (int)$param["id"] : 0];
        $call->field[] = ["first_name", isset($param["first_name"]) ? $param["first_name"] : ""];
        $call->field[] = ["last_name", isset($param["last_name"]) ? $param["last_name"] : ""];
        $call->field[] = ["middle_name", isset($param["middle_name"]) ? $param["middle_name"] : ""];
        $call->field[] = ["email_address", isset($param["email_address"]) ? $param["email_address"] : ""];
        $call->field[] = ["mobile_no", isset($param["mobile_no"]) ? $param["mobile_no"] : ""];
        $call->field[] = ["birth_date", isset($param["birth_date"]) ? $param["birth_date"] : ""];
        $call->field[] = ["gender_id", isset($param["gender_id"]) ? (int)$param["gender_id"] : 0];

        # field data decleration
        $output = $this->DBCon->call($call);
        return $output;
    }

    public function new_registration($param, $all = null){
        $call = $this->newsp("sp_web_new_registration");
		$call->action = "get";
        $call->all = isset($all) ? true : null;
        $call->field[] = ["last_name", isset($param["last_name"]) ? $param["last_name"] : ""];
        $call->field[] = ["first_name", isset($param["first_name"]) ? $param["first_name"] : ""];
        $call->field[] = ["middle_name", isset($param["middle_name"]) ? $param["middle_name"] : ""];
        $call->field[] = ["gender_id", isset($param["gender_id"]) ? (int)$param["gender_id"] : 0];
        $call->field[] = ["birth_date", isset($param["birth_date"]) ? $param["birth_date"] : ""];
        $call->field[] = ["birth_place", isset($param["birth_place"]) ? $param["birth_place"] : ""];
        $call->field[] = ["present_address", isset($param["present_address"]) ? $param["present_address"] : ""];
        $call->field[] = ["province_id", isset($param["province_id"]) ? (int)$param["province_id"] : 0];
        $call->field[] = ["city_id", isset($param["city_id"]) ? (int)$param["city_id"] : 0];
        $call->field[] = ["barangay_id", isset($param["barangay_id"]) ? (int)$param["barangay_id"] : 0];
        $call->field[] = ["mobile_no", isset($param["mobile_no"]) ? $param["mobile_no"] : ""];
        $call->field[] = ["user_id", isset($param["user_id"]) ? (int)$param["user_id"] : 1];
        $call->field[] = ["email_address", isset($param["email_address"]) ? $param["email_address"] : ""];
        

        # field data decleration
        $output = $this->DBCon->call($call);
        return $output;
    }

    public function getUser($param, $all = null){
        $call = $this->newsp("sp_web_get_users");
		$call->action = "get";
        $call->all = isset($all) ? true : null;
        $call->field[] = ["id", isset($param["id"]) ? (int)$param["id"] : 0];
        $call->field[] = ["username", isset($param["username"]) ? $param["username"] : ""];

        # field data decleration
        $output = $this->DBCon->call($call);
        return $output;
    }

    public function getMember($param, $all = null){
        $call = $this->newsp("sp_web_get_members");
		$call->action = "get";
        $call->all = isset($all) ? true : null;
        $call->field[] = ["id", isset($param["id"]) ? (int)$param["id"] : 0];
        $call->field[] = ["code", isset($param["code"]) ? $param["code"] : ""];

        # field data decleration
        $output = $this->DBCon->call($call);
        return $output;
    }

    public function getRegistrationInfo($param, $all = null){
        $call = $this->newsp("sp_web_get_registration_info");
		$call->action = "get";
        $call->all = isset($all) ? true : null;
        $call->field[] = ["registration_id", isset($param["registration_id"]) ? $param["registration_id"] : ''];

        # field data decleration
        $output = $this->DBCon->call($call);
        return $output;
    }
    

}
?>