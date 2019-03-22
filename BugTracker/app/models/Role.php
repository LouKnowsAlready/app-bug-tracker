<?php

class Role extends Model{

	public static function get_all_roles(){
		//include dirname(__DIR__) . '/core/dbconnect.php';
		$db = new DbConnect();
		$conn = $db->connect();

		$sql = "SELECT id, role_name FROM roles";
		$result = mysqli_query($conn, $sql);
		$data = mysqli_fetch_all($result,MYSQLI_ASSOC);
		mysqli_free_result($result);

		mysqli_close($conn);
		return $data;
	}
}
