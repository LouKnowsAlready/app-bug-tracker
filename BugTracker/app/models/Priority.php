<?php

class Priority extends Model{
	
	public static function get_project_priorities($project_id){
		$db = new DbConnect();
		$conn = $db->connect();

		$sql = "SELECT id, priority_name, priority_weight, priority_color FROM priorities where project_id = {$project_id}";
		$result = mysqli_query($conn, $sql);
		$data = mysqli_fetch_all($result,MYSQLI_ASSOC);
		mysqli_free_result($result);

		mysqli_close($conn);
		return $data;		
	}
}