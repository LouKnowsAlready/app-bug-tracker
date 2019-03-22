<?php

class ProjectUser extends Model{

	public static function get_project_users($project_id){
		//include dirname(__DIR__) . '/core/dbconnect.php';
		//include 'User.php';
		$db = new DbConnect();
		$conn = $db->connect();

		$sql = "SELECT pu.id as pid, u.id, u.first_name, u.last_name, CONCAT(first_name, ' ', last_name) as name, pu.role_id, r.role_name FROM project_users pu LEFT JOIN users u ON u.id = pu.user_id LEFT JOIN roles r on r.id = pu.role_id WHERE project_id = " . $project_id . " ORDER BY first_name";
		
		$result = mysqli_query($conn, $sql);
		$data = mysqli_fetch_all($result,MYSQLI_ASSOC);
		mysqli_free_result($result);
		mysqli_close($conn);
		
		return $data;		
	}

	public static function get_project_users_with_bugs($project_id){
		//include dirname(__DIR__) . '/core/dbconnect.php';
		//include 'User.php';
		$db = new DbConnect();
		$conn = $db->connect();

		$sql = "SELECT pu.id as pid, u.id, u.first_name, u.last_name, CONCAT(first_name, ' ', last_name) as name, pu.role_id, r.role_name FROM project_users pu JOIN bugs b on b.assigned_to = pu.user_id AND b.project_id = pu.project_id LEFT JOIN users u ON u.id = pu.user_id LEFT JOIN roles r on r.id = pu.role_id WHERE pu.project_id = " . $project_id . " UNION SELECT -1, -1, 'Unassigned', 'Unassigned', 'Unassigned', -1, 'None' FROM bugs b WHERE b.project_id = " . $project_id . " AND b.assigned_to = -1 ORDER BY first_name";
		
		$result = mysqli_query($conn, $sql);
		$data = mysqli_fetch_all($result,MYSQLI_ASSOC);
		mysqli_free_result($result);
		mysqli_close($conn);
		
		return $data;		
	}

	public static function get_user_id($id){
		$db = new DbConnect();
		$conn = $db->connect();

		$sql = "SELECT user_id FROM project_users WHERE id = {$id}";

		$result = mysqli_query($conn, $sql);
		$data = mysqli_fetch_assoc($result);	
		mysqli_free_result($result);

		//for testing only
		$sql = "INSERT INTO test(value) VALUES({$data[0]['user_id']})";
		$result = mysqli_query($conn, $sql);
		mysqli_free_result($result);

		mysqli_close($conn);

		return $data;
	}
	
}