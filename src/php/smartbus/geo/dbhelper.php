<?php
class DataBase {
	
	var $con;
	
	var $queryCount = 0;
	
	var $queries = array();
	
	static private $instance;
	
private $mysql_server ="aa1k0mfivovxj1v.csowqwfczvsc.ap-southeast-1.rds.amazonaws.com";
private $mysql_dbname="smartbus";
private $mysql_username = "smartbus";
private $mysql_password="smartbus";

	
	function DataBase(){
		$this->con = mysql_connect($mysql_server, $mysql_username, $mysql_username);
		mysql_select_db($mysql_dbname);
		mysql_set_charset('utf8');
	}
	
	static public function getInstance() {
		if (!isset(self::$instance)) {
			$name = __CLASS__;
			self::$instance = new $name;
		}
		return self::$instance;
	}
	
	function esc($str) {   return mysql_real_escape_string($str); }
	function escape($str){ return mysql_real_escape_string($str); } 
	
	function escapeArray($arr){
		foreach($arr as $k => $v){
			$arr[$k] = $this->escape($v);
		}
		return $arr;
	}
	
	function query($query){
		$this->queryCount++;
		$this->queries[] = $query;
		
		$result = mysql_query($query, $this->con);
		
		if($result === false){
			$this->debug($query);
		}
		
		if(mysql_num_rows($result) == 0){
			return array();
		}
		
		$salida = array();
		while ($row = mysql_fetch_assoc($result)) {
			$salida[] = $row;
		}
		mysql_free_result($result);
		
		return $salida;
	}
	
	function count($table, $opts = array()){
		$where = "";
		
		if(!empty($opts['where'])){
			$where = $this->where($opts['where']);
		}
		
		$query = "SELECT COUNT(*) AS CONTEO FROM $table $where";
		
		$row = $this->queryOne($query);
		
		return $row['CONTEO'];
	}
	
	function lastId(){
		return mysql_insert_id($this->con);
	}
	
	function debug($query){
		echo "<br>Error en la sentencia: ". $query . "<br>";
		echo mysql_error();
		$e = new Exception();
		pr($e->getTraceAsString());
	}
	
	function insert($table, $data){
		$this->queryCount++;
		
		$fields = $this->escapeArray(array_keys($data));
		$values = $this->escapeArray(array_values($data));
		
		foreach($values as $k => $val){
			if(is_null($val) || empty($val)){
				$values[$k] = 'NULL';
			} else {
				$values[$k] = "'$val'";
			}
		}
		
		$query = "INSERT INTO $table(".join(",",$fields).") VALUES(".join(",", $values).")";
		
		$this->queries[] = $query;
		
		return mysql_query($query, $this->con);
	}
	
	function execute($query){
		$this->queryCount++;
		$this->queries[] = $query;
		
		return mysql_query($query, $this->con);
	}
	
	function getAffectedRows(){
		return mysql_affected_rows($this->con);
	}
	
	function select($tabla, $opts = array()){
		$fields = "*";
		$where = "";
		$order = "";
		
		if(!empty($opts['fields'])){
			if(is_array($opts['fields'])){
				$fields = join(",", $opts['fields']);
			} else {
				$fields = $opts['fields'];
			}
		}
		
		if(!empty($opts['where'])){
			$where = $this->where($opts['where']);
		}
		
		if(!empty($opts['order'])){
			$order = "ORDER BY " . $opts['order'];
		}
		
		$query = "SELECT $fields FROM $tabla $where $order";
		
		if(!empty($opts['limit'])){
			if($opts['limit'] == 1){
				return $this->queryOne($query." LIMIT 1");
			}
			
			$query .= " LIMIT ".$opts['limit'];
		}
		
		return $this->query($query);
		
	}
	
	
	
	function selectOne($tabla, $opts = array()){
		$opts['limit'] = 1;
		return $this->select($tabla, $opts);
	}
	
	function update($table, $data, $opts = array()){
		$where = "";
		if(!empty($opts['where'])){
			$where = $this->where($opts['where']);
		}
		
		$update = array();
		foreach($data as $field => $value){
			if(is_null($value)){
				$update[] = "`$field` = NULL";
			} else {
				$update[] = "`$field` = '".$this->esc($value)."'";
			}
		}
		
		$query = "UPDATE $table SET ".join(" , ", $update)." $where";
		
		return $this->execute($query);
	}
	
	function where($conditions){
	
		$where = "";
		if(!empty($conditions) && is_array($conditions)){
			$where = array();
			foreach($conditions as $field => $value){
				if(is_numeric($field) || empty($field)){
					$where[] = "  $value ";
				} else if(is_null($value)) {
					$where[] = "  $field is null ";
				} else {
					$where[] = " $field = '".$this->escape($value)."' ";
				}
			}
			if(!empty($where)){
				$where = " WHERE " . join(" AND ", $where);
			}
		} else if(!empty($conditions)){
			$where = " WHERE " . $conditions;
		}
		return $where;
	}
	
	function getById($table, $id, $fields = null){
	
		if(!empty($fields)){
			$query = "SELECT $fields FROM $table WHERE ID = '".(int)$id."'";
		} else {
			$query = "SELECT * FROM $table WHERE ID = '".(int)$id."'";
		}
		return $this->queryOne($query);
	}
	
	function queryOne($query){
		$this->queryCount++;
		$this->queries[] = $query;
		
		$result = mysql_query($query, $this->con);
		if(!$result){
			return false;
		}
		
		if(mysql_num_rows($result) == 0){
			return false;
		}
		
		$row = mysql_fetch_assoc($result);
		
		mysql_free_result($result);
		
		return $row;
	}
	
	function begin(){ return $this->execute("START TRANSACTION;"); }
	function rollback(){ return $this->execute("ROLLBACK;"); }
	function commit(){ return $this->execute("COMMIT;"); }
	
	
}