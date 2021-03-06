<?php

class Project extends Model{
	public $id;
	public $project_name;

	public function __construct($project_id=0){
		$this->id = $project_id;
		$this->project_name = $this->get_project_name($project_id);
	}

	public static function get_all_projects($user_id){
		$db = new DbConnect();
		$conn = $db->connect();

		$sql = "SELECT DISTINCT p.id, p.project_name FROM projects p LEFT JOIN project_users pu on pu.project_id = p.id WHERE (pu.user_id = {$user_id} OR {$user_id} = 0)";
		$result = mysqli_query($conn, $sql);
		$data = mysqli_fetch_all($result,MYSQLI_ASSOC);
		mysqli_free_result($result);

		mysqli_close($conn);
		return $data;
	}

	public static function has_project_func_access($role_name){
		$has_access = 0;

		if($role_name == "Project Manager" || $role_name == 'Admin')
			$has_access = 1;

		return $has_access;
	}

	private function get_project_name($project_id){
		$db = new DbConnect();
		$conn = $db->connect();

		$sql = "SELECT project_name from projects WHERE id = {$project_id}";
		$result = mysqli_query($conn, $sql);

		$project = mysqli_fetch_assoc($result);
		mysqli_free_result($result);

		mysqli_close($conn);

		return $project['project_name'];
	}

}