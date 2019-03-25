<?php

class User extends Model{
	public $id;
	public $first_name;
	public $last_name;

	public function __construct($id=0, $first_name='', $last_name=''){
		$this->id = $id;
		$this->first_name = $first_name;
		$this->last_name = $last_name;
	}

	public static function get_all_users(){
		//include dirname(__DIR__) . '/core/dbconnect.php';
		$db = new DbConnect();
		$conn = $db->connect();

		$sql = "SELECT id, CONCAT(first_name, ' ', last_name) as name FROM users";
		$result = mysqli_query($conn, $sql);
		$data = mysqli_fetch_all($result,MYSQLI_ASSOC);
		mysqli_free_result($result);

		mysqli_close($conn);
		return $data;
	}

	public static function get_user_details($user_id){
		$db = new DbConnect();
		$conn = $db->connect();

		$sql = "SELECT id, user_name, password, first_name, last_name, CONCAT(first_name, ' ', last_name) as name FROM users WHERE id = {$user_id}";
		$result = mysqli_query($conn, $sql);
		$data = mysqli_fetch_assoc($result);
		mysqli_free_result($result);

		mysqli_close($conn);
		return $data;
	}

	public function check_availability($username){
		$db = new DbConnect();
		$conn = $db->connect();

		$is_exist = 0;

		$sql = "SELECT 1 FROM users WHERE user_name = '{$username}'";
		$result = mysqli_query($conn, $sql);
		$data = mysqli_fetch_assoc($result);
		if(mysqli_num_rows($result))
			$is_exist = 1;

		mysqli_free_result($result);

		mysqli_close($conn);
		return $is_exist;		
	}

	public static function user_role($user_id, $project_id){
		$db = new DbConnect();
		$conn = $db->connect();

		$sql = "SELECT r.id, r.role_name FROM project_users pu LEFT JOIN roles r on r.id = pu.role_id WHERE pu.user_id = {$user_id} AND pu.project_id = {$project_id} ORDER BY r.id desc LIMIT 1";

		$result = mysqli_query($conn, $sql);
		$data = mysqli_fetch_assoc($result);
		mysqli_free_result($result);

		mysqli_close($conn);
		return $data;
	}
		
}
