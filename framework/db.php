<?php
// Database functions!
// In the future this could be easily extended to allow
// multiple database backends!

/**
 * Shorthand for mysql_real_escape_string
 * @param $i
 */
function e($i){ return @mysql_real_escape_string($i); }

/***
 * Uses e($i) for an array
 */
function ae($i){
	$r = array();
	foreach($i as $k => $v)
		$r[e($k)] = "'" . e($v) . "'";
	return $r;
}

/**
 * Query the database and return the array as a result!
 * @param string $sql
 */
function query_database($sql){
	global $settings;
	if($_GET['debug'] == "true" && $settings->debug == true)
		echo $sql;
	$r = @mysql_query($sql);
	if($r != false){
		$result = array();
		while ($row = @mysql_fetch_array($r))
			$result[] = $row;
		@mysql_free_result($r);
		return $result;
	} else{ myErrorHandler(-3, mysql_error(), "DB", -1); }
}

/**
 * Puts the data into a table
 * @param $table The table to put the data into
 * @param $data Array of data to insert or update
 */
function put_data($table, $data){
	if(!$data['id']){ // INSERT
		unset($data['id']);
		$key = array_keys($data);
		$keys = "";
		foreach($key as $k){
			$keys .= "`$k`,";
		}
		$keys = substr($keys, 0, -1);
		$sql = "INSERT INTO $table (" . $keys .
			") VALUES( ". implode( ae( array_values($data) ), "," ) ." )";
	} else{ // UPDATE 
		$sql = "UPDATE $table SET";
		foreach($data as $k => $v){
			$sql .= " `$k`='".e($v)."'";
			if(end(array_keys($data)) != $k)
				$sql .= ", ";
		}
		$sql .= " WHERE `id`=" . e($data['id']);
	}
	return query_database($sql);
}

/**
 * Gets the data from the database
 * @param string $table table name
 * @param array $filters filters to apply
 * @param integer $start number to start
 * @param integer $end number to end with
 */
function get_data($table, $filters = array()){
	$sql = "SELECT * FROM $table";
	$en_filters = false;
	$i = 1;
	$whereFilters = array();
	$endFilters = array();
	foreach($filters as $field => $filter){ // Sort the filters
		if(is_object($filter) && $filter->atEnd == true)
			$endFilters[] = $filter;
		else
			$whereFilters[$field] = $filter;
	}
	if(!empty($whereFilters)){
		$sql .= " WHERE ";
		$i = 1;
		foreach($whereFilters as $field => $filter){
			if(is_string($field))
				$sql .= "`".$field."`";
			if(is_object($filter))
				$sql .= $filter->sql();
			else
				$sql .="='".e($filter)."'";
			if($i < count($whereFilters))
				$sql .= " AND ";
			$i++;
		}
	}
	foreach($endFilters as $filter){
		$sql .= $filter->sql();
	}
	$sql .= $end;
	return query_database($sql);
}

/**
 * Base class for filters
 * @author kennydude
 *
 */
class DatabaseFilter{
	public $atEnd = true;
	/**
	 * Returns the sql to add (mysql)
	 */
	public function sql(){}
}

class LessThanFilter extends DatabaseFilter{
	public $atEnd = false;
	function __construct($by) {
		$this->_by = $by;
	}
	public function sql(){
		return "< '" . $this->_by ."'";
	}
}

/**
 * GROUP BY ($by)
 * @author kennydude
 *
 */
class GroupByFilter extends DatabaseFilter{
	public $atEnd = true;
	function __construct($by) {
		$this->_by = array();
		foreach($by as $k => $v){
			$this->_by[$k] = "`$v`";
		}
	}
	public function sql(){
		return " GROUP BY ".implode($this->_by, ",");
	}
}

/**
 * LIMIT $begin, $end
 * @author kennydude
 *
 */
class LimitFilter extends DatabaseFilter{
	public $atEnd = true;
	public function __construct($begin, $end){
		$this->_begin = $begin;
		$this->_end = $end;
	}
	public function sql(){
		return " LIMIT " . $this->_begin . ", " . $this->_end;
	}
}