<?php

class Model{

	public function create($data, $table){
		//include 'dbconnect.php';
		$db = new DbConnect();
		$conn = $db->connect();

		$keys = $this->get_keys($data);
		$values = $this->get_values($data);
		$sql = "INSERT INTO " . $table . " (". $keys . ") VALUES (". $values .")";
		if(isset($conn)){
			mysqli_query($conn, $sql);
			$last_id = mysqli_insert_id($conn);
			mysqli_close($conn);
		}

		return $last_id;

	}

	public function update($data, $table, $filter){
		//include 'dbconnect.php';
		$db = new DbConnect();
		$conn = $db->connect();

		$sql = "UPDATE {$table} SET ";
		foreach($data as $key => $value){
			$sql = $sql . "{$key} = '{$value}', ";
		}
		$sql = rtrim($sql,', ');
		$sql = $sql . " WHERE {$filter}"; 
		$sql = preg_replace("/'(\d+)'/", '$1', $sql);

		if(isset($conn)){
			mysqli_query($conn, $sql);
			mysqli_close($conn);
		}
	}

	public function delete($table, $filter='1=1'){
		$db = new DbConnect();
		$conn = $db->connect();

		$sql = "DELETE FROM {$table} WHERE $filter";

		if(isset($conn)){
			mysqli_query($conn, $sql);
			mysqli_close($conn);
		}
	}

	public static function get_records($table_name, $requested_columns='1', $filter='1=1'){
		$db = new DbConnect();
		$conn = $db->connect();

		$sql = "SELECT {$requested_columns} from {$table_name} WHERE {$filter}";

		$result = mysqli_query($conn, $sql);
		$data = mysqli_fetch_all($result,MYSQLI_ASSOC);

		mysqli_free_result($result);
		mysqli_close($conn);

		return $data;
	}


################## CLASS METHODS ############################

	private function get_keys($data){
		return implode(',', array_keys($data));
	}

	private function get_values($data){
		$data = implode("','", array_values($data));
		$data = str_replace($data, "'".$data."'", $data);
		$data = preg_replace("/'(\d+)'/", '$1', $data);

		return $data;
	}	

}