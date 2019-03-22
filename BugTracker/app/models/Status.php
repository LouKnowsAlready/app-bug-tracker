<?php

class Status extends Model{

	public static function get_project_status($project_id){
		$db = new DbConnect();
		$conn = $db->connect();

		$sql = "SELECT id, project_id, status_name FROM bug_status where project_id = {$project_id}";
		$result = mysqli_query($conn, $sql);
		$data = mysqli_fetch_all($result,MYSQLI_ASSOC);
		mysqli_free_result($result);

		mysqli_close($conn);
		return $data;		
	}

	public static function get_status_details($status_id){
		$db = new DbConnect();
		$conn = $db->connect();

		$sql = "SELECT id, project_id, status_name FROM bug_status WHERE id = {$status_id}";
		$result = mysqli_query($conn, $sql);
		$data = mysqli_fetch_assoc($result);
		mysqli_free_result($result);

		mysqli_close($conn);
		return $data;
	}

	public static function get_last_status_per_project($project_id){
		$db = new DbConnect();
		$conn = $db->connect();

		$sql = "SELECT id, status_name FROM bug_status WHERE project_id = {$project_id} ORDER BY id desc LIMIT 1";
		$result = mysqli_query($conn, $sql);
		$data = mysqli_fetch_assoc($result);
		mysqli_free_result($result);

		mysqli_close($conn);
		return $data;		
	}

}