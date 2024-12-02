<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Connection extends mysqli {
    public $MySQL;
    Public $DBS;
    public $DBSCON;
    
    public function __construct($param, $dbhost, $dbuser, $dbpass, $dbname, $dbport){
        $this->DBS = new stdClass();
        $this->MySQL = new stdClass();
        $this->DBSCON = new stdClass();
        $this->DBSCON->DB_HOST = $dbhost;
        $this->DBSCON->DB_USER = $dbuser;
        $this->DBSCON->DB_PASS = $dbpass;
        $this->DBSCON->DB_NAME = $dbname;
        $this->DBSCON->DB_PORT = $dbport;
        $this->connectDB($param);
    }

	public function initMySql() 
	{
        $this->MySQL->Connection = null;
        $this->MySQL->TotalQuery = 0;
        $this->MySQL->Configurations = null;
		$this->MySQL->Error = null;
        $this->MySQL->Con = null;
        $this->MySQL->PDOCon = null;
        $this->MySQL->Type = "OOP";
    }
    public function estCon($name){
        if(!isset($this->DBS->$name)){
            $this->DBS->$name = new stdClass();
        }
        try {
            $this->DBS->$name->Con = new PDO('mysql:host='.$this->DBSCON->DB_HOST.';dbname='.$this->DBSCON->DB_NAME, $this->DBSCON->DB_USER, $this->DBSCON->DB_PASS);
            $this->DBS->$name->Connection = true;
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            $this->SystemExit("Error: [" . $e->getMessage() ."] ". $e->getMessage(), __LINE__, __FILE__);
            $this->DBS->$name->Connection = false;
            $this->DBS->$name->Error = "$e->getMessage() . $e->getMessage()";
        }
    }
	private function connectDB($type = "OOP") {
		$this->initMySql();
        if(isset($type)){
            if(strtoupper($type) === ' OOP'){
                $this->MySQL->Con = parent::__construct($this->DBSCON->DB_HOST, $this->DBSCON->DB_USER, $this->DBSCON->DB_PASS, $this->DBSCON->DB_NAME);
                if (mysqli_connect_error()){
                    $this->SystemExit("Error: [" . mysqli_connect_errno() ."] ". mysqli_connect_error(), __LINE__, __FILE__);
                    $this->MySQL->Connection = false;
                    $this->MySQL->Error = "mysqli_connect_errno() . mysqli_connect_error()";
                }else{
                    $this->MySQL->Connection = true;
                }
            }else if(strtoupper($type) === 'PDO'){
                try {
                    $this->MySQL->Con = new PDO('mysql:host='.$this->DBSCON->DB_HOST.';dbname='.$this->DBSCON->DB_NAME, $this->DBSCON->DB_USER, $this->DBSCON->DB_PASS);
                    $this->MySQL->Connection = true;
                } catch(PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                    $this->SystemExit("Error: [" . $e->getMessage() ."] ". $e->getMessage(), __LINE__, __FILE__);
                    $this->MySQL->Connection = false;
                    $this->MySQL->Error = "$e->getMessage() . $e->getMessage()";
                }
            }
        }else{
            $this->SystemExit("Connection not define!");
        }
    }
	
	private function DBase($type, $params) {
        $output = new stdClass(); 
        if (!$this->MySQL->Connection)
        $this->SystemExit('No available MySQLi connection', __LINE__, __FILE__);
        
        switch (strtolower($type)) {
        case 'query':
            if ($Query = parent::query($params)) {
                $this->MySQL->TotalQuery++;
                return $Query;
            } else
            $this->SystemExit('MySQLi failed to query: ' . $params, __LINE__, __FILE__);
            break;
        case 'prepare':
            if ($Query = parent::prepare($params)) {
                $this->MySQL->TotalQuery++;
                return $Query;
            } else
            $this->SystemExit('MySQLi failed to prepare: ' . $params, __LINE__, __FILE__);
            break;
        case 'escapestring':                
            if ($Escape = parent::real_escape_string($params))
            return $Escape;
            else
            $this->SystemExit('MySQLi failed to escape: ' . $params, __LINE__, __FILE__);                
            break;
        }
    }
	
    public function Exec($type, $data, $fetchAll = null){
        $this->connectDB();
        $output = new stdClass();
        $output->status = false;
        $output->message = "";
        if(isset($type)){
            switch($type){
                case 'fetch':
                    $query = $this->DBase('query', $data);
                    if($fetchAll){
                        $output->data = $query->fetch_all(MYSQLI_ASSOC);
                        $output->status = true;
                    }else{
                        $output->data = $query->fetch_object();
                        if($output->data){
                            $output->status = true;
                        }
                    }
                break;
                case 'update':
                    try {
                        $query = $this->DBase('prepare', $data);
                        if ($query->execute()) { 
                            $output->status = true;
                        } else {
                            $output->status = false;
                        }
                    } catch(PDOException $e){
                        $output->message = $e->getMessage();
                    }
                break;
                case 'insert':
                    try {
                        $query = $this->DBase('query', $data);
                        $output->status = true;
                        $output->data = $query;
                    } catch(PDOException $e){
                        $output->message = $e->getMessage();
                    }
                break;
                case 'delete':
                    $query = $this->DBase('prepare', $data);
                    if ($query->execute()) { 
                        $output->status = true;
                    }
                break;
                default:
                    $output->status = false;
                    $output->message = "No query parameter";
                break;
            }
        }else{
            $output->status = false;
            $output->message = "No query parameter";
        }
        return $output;
    }

    public function get($query, $all = false){
        if(isset($all)){
             return $this->Exec("fetch", $query, true);
        }else{
             return $this->Exec("fetch", $query);
        }
    }

    public function add($query){
        return $this->Exec("insert", $query);
    }

    public function update($query){
        return $this->Exec("update", $query);
    }

    public function delete($query){
        return $this->Exec("delete", $query);
    }

    public function call($param, $conp = null){
        $connection = $this->MySQL->Con;
        $output = new stdClass();
        $output->status = false;
        $output->data = "";
        $output->query = "";
        $output->code = "";
        $counter = new stdClass();
        $counter->call = 0;
        $counter->field = 0;
        $fieldString = "";
        $reserveString = "";
        $queryString = "";
        if(isset($conp)){
            if(isset($this->MySQL->$conp)){
                $connection = $this->MySQL->$conp;
            }
        }
        if(isset($param->call)){
            $queryString = $queryString . "CALL ".$param->call;
            $counter->call++;
        }
        if(isset($param->field)){
            $output->field = $param->field;
            $type = gettype($param->field);
            if($type == 'array' || $type == 'object'){
                $count = count((array)$param->field);
                if($count){
                    for($a = 0; $a < $count; $a++){
                        $fvalue = $param->field[$a][1];
                        if($a == ($count - 1)){
                            if(gettype($fvalue) === 'string'){
                                $fieldString = $fieldString . '"'.$fvalue.'"';
                            }else{
                                $fieldString = $fieldString . $fvalue;
                            }
                        }else{
                            if(gettype($fvalue) === 'string'){
                                $fieldString = $fieldString . '"'.$fvalue.'", ';
                            }else{
                                $fieldString = $fieldString . $fvalue.", ";
                            }
                            // $fieldString = $fieldString . "?,";
                        }
                        $counter->field++;
                    }
                }
            }
        }
        $queryString = $queryString . '('.$fieldString.')';
        try{
            $stmt = $connection->prepare($queryString);
            // for($a = 0, $count = count((array)$param->field); $a < $count; $a++){
            //     $local = $param->field[$a];
            //     $b = $a + 1;
            //     if($a == ($count - 1)){
            //         $stmt->bindParam($b, $local[1]);
            //     }else{
            //         $stmt->bindParam($b, $local[1]);
            //     }
            // }
            if(isset($param->action)){
                $stmt->execute();
                
                switch(strtolower($param->action)){
                    case "get":
                        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        if(count((array)$results) > 0){
                            $output->data = isset($param->all) && $param->all ? $results : $results[0];
                            $output->status = true;
                            $output->message = "Fetch OK";
                        }else{
                            $output->status = true;
                            $output->data = [];
                            $output->code = 'empty';
                        }
                        $output->query = $queryString;
                        $output->queryString = $queryString;
                    break;
                    case "add":
                        $data = $stmt->fetch();
                        $output->data = isset($data) ? $data : [];
                        $output->status = true;
                        $output->message = "Add or update OK";
                        $output->query = $connection->lastInsertId();
                        $output->queryString = $queryString;
                    break;
                }
            }else{
               $output->message = "Action Query not set!";
            }
        } catch(PDOException $e) {
          $output->message = $e->getMessage();
          $output->status = false;
          $output->code = "SQLERROR";
          $output->error = $e;
        }
        return $output;
    }

	public function SystemExit($text) {
        if (ob_get_level()) ob_end_clean();
        header('Content-Type: text/plain');
        print ("$text");
        print ("Dated: " . date("F j, Y - g:i a"));
        //print ("\nLocation: $file ($line)");
        exit(1);
    }
}
?>