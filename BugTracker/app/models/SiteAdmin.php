<?php

class SiteAdmin extends Model{

	public function check_availability($username){
		$db = new DbConnect();
		$conn = $db->connect();

		$is_exist = 0;

		$sql = "SELECT 1 FROM admin WHERE user_name = '{$username}'";
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

		$sql = "SELECT id FROM admin WHERE user_name = '{$user_name}' AND password = '{$password}'";
		$result = mysqli_query($conn, $sql);
		$data = mysqli_fetch_assoc($result);

		mysqli_free_result($result);

		mysqli_close($conn);
		return $data;		
	}

	public static function get_admin(){
		$db = new DbConnect();
		$conn = $db->connect();

		$sql = "SELECT id, user_name, password FROM admin";
		$result=mysqli_query($conn,$sql);
		$data = mysqli_fetch_array($result,MYSQLI_ASSOC);

		mysqli_free_result($result);

		mysqli_close($conn);
		return $data;
	}

	public function delete_app(){
		// database connect
		$data = file_get_contents('BugTracker/app/conf/config.json');
		$conf = json_decode($data, true);	
		$conn = mysqli_connect($conf['db_host'], $conf['db_user'], $conf['db_password'], $conf['db_name']);

		// delete the database
		$sql = "DROP DATABASE {$conf['db_name']}";
		mysqli_query($conn,$sql);
		mysqli_close($conn);

		// reverse back to setup mode
		$conf['setup'] = "1";
		$conf_setup = json_encode($conf);
		file_put_contents('BugTracker/app/conf/config.json', $conf_setup);
	}

	public function update_admin($username, $password){
		$db = new DbConnect();
		$conn = $db->connect();
		$err = true;

		$sql = "UPDATE admin SET user_name = '{$username}', password = '{$password}'";
		
		if(!mysqli_query($conn,$sql)){
			$err = false;
		}

		mysqli_close($conn);
		return $err;
	}
}