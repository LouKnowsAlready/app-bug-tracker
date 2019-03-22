<?php

class Install{

	public function create_db($username, $password, $db_name){
		$conn = $this->get_credentials($username, $password);

		// create the database
		$sql = "CREATE DATABASE {$db_name}";
		mysqli_query($conn, $sql);

		// select the newly created database
		mysqli_select_db($conn, $db_name);

		// import the tables on the created database
		$this->import_tables($conn);
		
		mysqli_close($conn);
	}

	public function create_admin($username, $password){
		$data = file_get_contents('BugTracker/app/conf/config.json');
		$conf = json_decode($data, true);	
		$conn = mysqli_connect($conf['db_host'], $conf['db_user'], $conf['db_password'], $conf['db_name']);

		$sql = "INSERT INTO admin (user_name,password) VALUES ('{$username}','{$password}')";
		mysqli_query($conn, $sql);

		mysqli_close($conn);
	}

	private function get_credentials($username='', $password=''){
		$server_name = 'localhost';		
		$su = $username;
		$supw = $password;
		$db = 'mysql';

		$conn = mysqli_connect($server_name, $su, $supw, $db);
	
		return $conn;
	}

	private function import_tables($conn){
		$filename = 'installation/db/db-setup.sql';
		$sql = '';

		// read entire file
		$lines = file($filename);

		// loop through each line
		foreach($lines as $line){
			// skip the comments
			if(substr($line, 0, 2) == '--' || $line == '')
				continue;

			// store the query
			$sql = $sql . $line;

			// if it ends with the semi-colon, then execute the query and reset it.
			if(substr(trim($line), -1, 1) == ';'){
				mysqli_query($conn, $sql);
				$sql = '';
			}
		}

	}
}