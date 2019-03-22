<?php

class DbConnect{

	public function connect(){

		$data = file_get_contents('BugTracker/app/conf/config.json');

		$conf = json_decode($data, true);
		
		$conn = mysqli_connect($conf['db_host'], $conf['db_user'], $conf['db_password'], $conf['db_name']);

		return $conn;
	}

}
