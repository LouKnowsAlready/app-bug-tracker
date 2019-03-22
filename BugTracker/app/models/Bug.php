<?php

class Bug extends Model{
	public $id;
	public $project_id;
	public $bug_name;
	public $assigned_to;
	public $priority_id;
	public $status_id;
	public $details;

	public function __construct($id = 0)
	{
		$db = new DbConnect();
		$conn = $db->connect();

		$sql = "SELECT id, project_id, bug_name, assigned_to, priority_id, status_id, details FROM bugs WHERE id = {$id}";
		
		$result = mysqli_query($conn, $sql);
		$data = mysqli_fetch_assoc($result);
		mysqli_free_result($result);

		mysqli_close($conn);		

		$this->id = $data['id'];
		$this->project_id = $data['project_id'];
		$this->bug_name = $data['bug_name'];
		$this->assigned_to = $data['assigned_to'];
		$this->priority_id = $data['priority_id'];
		$this->status_id = $data['status_id'];
		$this->details = $data['details'];
	}

	public static function get_user_distinct_bug_status($project_id, $user_id){
		$db = new DbConnect();
		$conn = $db->connect();

		$sql = "SELECT DISTINCT bs.id, bs.status_name FROM bugs b LEFT JOIN bug_status bs on bs.id = b.status_id WHERE b.project_id = " . $project_id . " AND " . "b.assigned_to = " . $user_id . " ORDER BY bs.id";
		
		$result = mysqli_query($conn, $sql);
		$data = mysqli_fetch_all($result,MYSQLI_ASSOC);
		mysqli_free_result($result);

		mysqli_close($conn);
		return $data;
	}

	public static function get_users_bug_per_status($project_id, $user_id, $status_id){
		$db = new DbConnect();
		$conn = $db->connect();

		$sql = "SELECT b.id, b.project_id, b.bug_name, b.position, b.assigned_to, b.priority_id, p.priority_weight, b.status_id, b.details, p.priority_color FROM bugs b LEFT JOIN priorities p on p.id = b.priority_id WHERE b.project_id = {$project_id} AND b.assigned_to = {$user_id} AND b.status_id = {$status_id}";
		
		$result = mysqli_query($conn, $sql);
		$data = mysqli_fetch_all($result,MYSQLI_ASSOC);
		mysqli_free_result($result);

		mysqli_close($conn);
		return $data;
	}

	public static function get_bugs_per_project($project_id){
		$db = new DbConnect();
		$conn = $db->connect();

		$sql = "SELECT id, project_id, bug_name, assigned_to, priority_id, status_id, details FROM bugs WHERE project_id = {$project_id}";
		
		$result = mysqli_query($conn, $sql);
		$data = mysqli_fetch_all($result,MYSQLI_ASSOC);
		mysqli_free_result($result);

		mysqli_close($conn);
		return $data;
	}

	public static function custom_sort_bugs($project_id, $user_id, $status_id){
		$db = new DbConnect();
		$conn = $db->connect();

		$sql = "SELECT b.id, b.project_id, b.bug_name, b.position, b.assigned_to, b.priority_id, p.priority_weight, b.status_id, b.details, p.priority_color FROM bugs b LEFT JOIN priorities p on p.id = b.priority_id WHERE b.project_id = {$project_id} AND b.assigned_to = {$user_id} AND b.status_id = {$status_id} ORDER BY position";
		
		$result = mysqli_query($conn, $sql);
		$data = mysqli_fetch_all($result,MYSQLI_ASSOC);
		mysqli_free_result($result);

		mysqli_close($conn);
		return $data;
	}

	public static function get_bugs_per_user($user_id){
		$db = new DbConnect();
		$conn = $db->connect();

		$sql = "SELECT id FROM bugs WHERE assigned_to = {$user_id}";

		$result = mysqli_query($conn, $sql);
		$data = mysqli_fetch_all($result,MYSQLI_ASSOC);
		mysqli_free_result($result);

		mysqli_close($conn);
		return $data;
	}

	public static function get_bugs_per_user_project($user_id, $project_id){
		$db = new DbConnect();
		$conn = $db->connect();

		$sql = "SELECT id FROM bugs WHERE assigned_to = {$user_id} AND project_id = {$project_id}";

		$result = mysqli_query($conn, $sql);
		$data = mysqli_fetch_all($result,MYSQLI_ASSOC);
		mysqli_free_result($result);

		mysqli_close($conn);
		return $data;
	}

}
