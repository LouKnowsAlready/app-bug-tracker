<?php

class Tag extends Model{

	public static function get_project_tags($project_id){
		$db = new DbConnect();
		$conn = $db->connect();

		$sql = "SELECT id, project_id, tag_name FROM tags WHERE project_id = {$project_id}";
		$result = mysqli_query($conn, $sql);
		$data = mysqli_fetch_all($result,MYSQLI_ASSOC);
		mysqli_free_result($result);

		mysqli_close($conn);
		return $data;
	}

}