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
	$r = @mysql_query($sql);
	if($r != false){
		$result = array();
		while ($row = @mysql_fetch_array($r))
			$result[] = $row;
		@mysql_free_result($r);
		return $result;
	} else{ /* TODO: error handling */ print "db error" . mysql_error(); }
}

/**
 * Puts the data into a table
 * @param $table The table to put the data into
 * @param $data Array of data to insert or update
 */
function put_data($table, $data){
	if(!$data['id']){ // INSERT
		unset($data['id']);
		$sql = "INSERT INTO $table (" . implode(array_keys($data), ",") .
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
function get_data($table, $filters = array(), $start=-1, $end=-1){
	$sql = "SELECT * FROM $table";
	$en_filters = false;
	$i = 1;
	foreach($filters as $field => $filter){
		if($en_filters == false){
			$en_filters = true;
			$sql .= " WHERE ";
		}
		$sql .= "`".$field."`";
		if(is_object($filter))
			$sql .= $filter->sql();
		else 
			$sql .="='".e($filter)."'";
		if($i < count($filters))
			$sql .= " AND ";
		$i++;
	}
	if($start != -1){
		$sql .= " LIMIT $start,";
		if($end == -1)
			$end = $start + 10;
		$sql .= $end;
	}
	return query_database($sql);
}
