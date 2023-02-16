<?php
class db {
 	private $host = DB_HOST;
	private $user = DB_USER;
	private $pass = DB_PASS;
	private $dbname = DB_NAME;
	private $port = DB_PORT;

	private $dbh;
	private $error;

	private $stmt;

	public function __construct() {
		$dsn = 'mysql:host='.$this->host.';dbname='.$this->dbname.';port='.$this->port;
		$options = array(PDO::ATTR_PERSISTENT => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_EMULATE_PREPARES => false, PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => false);
		try {
		  $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
		} catch(PDOException $e) {
		  $this->error = $e->getMessage();
		}
	}

	// GENERAL

	public function q($query){
		$this->stmt = $this->dbh->prepare($query);
	}

	public function b($param, $value, $type = null) {
	  if (is_null($type)) {
      switch (true) {
	      case is_int($value):
          $type = PDO::PARAM_INT;
          break;
	      case is_bool($value):
          $type = PDO::PARAM_BOOL;
          break;
	      case is_null($value):
          $type = PDO::PARAM_NULL;
          break;
	      default:
	        $type = PDO::PARAM_STR;
      }
	  }
	  $this->stmt->bindValue($param, $value, $type);
	}

	public function x(){
    return $this->stmt->execute();
	}

	public function s(){
    $this->x();
    return $this->stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function m(){
    $this->x();
    return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	//

	public function cq(){
		$this->x();
    return $this->stmt->rowCount();
	}

	public function lid(){
    return $this->dbh->lastInsertId();
	}

	public function et() {
    return $this->dbh->commit();
	}

	public function rc() {
    return $this->dbh = null;
	}


}


// SUPER USER CLASS // // SUPER USER CLASS // // SUPER USER CLASS // // SUPER USER CLASS //

class _SU {

	static function single_result($query) {
		try {
			$db = new db();
			$db->q($query);
			$ret = $db->s();
			$db->rc();
			$db = null;
			return $ret;
		} catch (PDOException $e) {
	    // print "Error!: " . $e->getMessage() . "<br/>";
	    die();
	    // return null;
		}
	}

	static function array_result($query) {
		try {
			$db = new db();
			$db->q($query);
			$ret = $db->m();
			$db->rc();
			$db = null;
			return $ret;
		} catch (PDOException $e) {
	    // print "Error!: " . $e->getMessage() . "<br/>";
	    die();
	    // return null;
		}
	}


	static function get_by($table, $flag_single=null, $field=null, $value=null) {
		if (!empty($field)) {
			try {
				$db = new db();
				$db->q("SELECT * FROM ".$table." WHERE ".$field." = :".$field);
				$db->b(':'.$field, $value);
				if (!empty($flag_single)) {
					$ret = $db->s();
				} else {
					$ret = $db->m();
				}
				$db->rc();
				$db = null;
				return $ret;
			} catch (PDOException $e) {
		    // print "Error!: " . $e->getMessage() . "<br/>";
		    die();
		    // return null;
			}
		} else {
			try {
				$db = new db();
				$db->q("SELECT * FROM ".$table);
				$ret = $db->m();
				$db->rc();
				$db = null;
				return $ret;
			} catch (PDOException $e) {
		    // print "Error!: " . $e->getMessage() . "<br/>";
		    die();
		    // return null;
			}
		}
	}


	static function get_by_id($table, $id) {
		try {
			$db = new db();
			$db->q("SELECT * FROM ".$table." where ID = :id");
			$db->b(':id', $id);
			$ret = $db->s();
			$db->rc();
			$db = null;
			return $ret;
		} catch (PDOException $e) {
	    // print "Error!: " . $e->getMessage() . "<br/>";
	    die();
	    // return null;
		}
	}

	static function update_field($table, $id, $field, $value) {
		try {
			$db = new db();
			$db->q('UPDATE '.$table.' SET '.$field.' = :'.$field.' WHERE ID = :id');
			$db->b(':'.$field, $value);
			$db->b(':id', $id);
			$ret = $db->x();
			$db->rc();
			$db = null;
			return $ret;
		} catch (PDOException $e) {
	    // print "Error!: " . $e->getMessage() . "<br/>";
	    die();
	    // return null;
		}
	}

	static function delete_by_id($table, $id) {
	try {
		$db = new db();
		$db->q("DELETE FROM ".$table." WHERE ID = :id");
		$db->b(':id', $id);
		$ret = $db->x();
		$db->rc();
		$db = null;
		return $ret;
	} catch (PDOException $e) {
	    // print "Error!: " . $e->getMessage() . "<br/>";
	    die();
	    // return null;
		}
	}

	static function update_row ($table, $where_field_arr, $update_field_arr) {

		$db = new db();
		
		$fields_array = array();
		foreach ($update_field_arr as $col => $val){
			array_push($fields_array, $col.' = "' . $val . '"');
		}
		$fields_join = join(', ', $fields_array);

		$where = array();
		foreach ($where_field_arr as $field_name => $field_val){
			array_push($where, $field_name . ' = "' . $field_val . '"');
		}
		$where_join = join(' AND ', $where);

		$query = 'UPDATE ' . $table . ' SET ' . $fields_join . ' WHERE ' . $where_join;
		// return $query;

		$db->q($query);
		$response = $db->x();
		$db->rc();
		$db = null;
		return $response;

	}

	static function insert_row($table, $fields){
		
		$db = new db();
		$cols = array();
		$vals = array();

		foreach ($fields as $col => $val){
			array_push($cols, $col);
			array_push($vals, '"'.$val.'"');
		}

		$cols_join = join(', ', $cols);
		$vals_join = join(', ', $vals);

		$query = 'INSERT INTO ' . $table . ' (' . $cols_join . ') VALUES (' . $vals_join . ')';
		// return $query;
 		$db->q($query);
		$response = $db->x();
		$db->rc();
		$db = null;
		return $response;
	}


	static function delete_where($table, $ports){

		$db = new db();

		$where = array();
		foreach ($ports as $field_name => $field_val){
			array_push($where, $field_name . ' = "' . $field_val . '"');
		}
		$where_join = join(' AND ', $where);

		$query = 'DELETE FROM ' . $table . ' WHERE ' . $where_join;
	
		$db->q($query);
		$response = $db->x();
		$db->rc();
		$db = null;
		return $response;
	}

}
?>