<?php

class Login extends Model{

	public function check_availability($username){
		$db = new DbConnect();
		$conn = $db->connect();

		$is_exist = 0;

		$sql = "SELECT 1 FROM users WHERE user_name = '{$username}'";
		$result = mysqli_query($conn, $sql);
		if(mysqli_num_rows($result))
			$is_exist = 1;

		mysqli_free_result($result);

		mysqli_close($conn);
		return $is_exist;		
	}

	public function verify_credentials($user_name, $password){
		$db = new DbConnect();
		$conn = $db->connect();

		$sql = "SELECT id FROM users WHERE user_name = '{$user_name}' AND password = '{$password}'";
		$result = mysqli_query($conn, $sql);
		$data = mysqli_fetch_assoc($result);

		mysqli_free_result($result);

		mysqli_close($conn);
		return $data;		
	}
}