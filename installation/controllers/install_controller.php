<?php

class InstallController{
	public function index(){
		$this->render_view('main-layout','index');
	}

	public function setup_form(){
		$this->render_view('','setup-form');
	}

	public function admin_form(){
		$this->render_view('','site-admin-form');
	}

	public function create(){
		$dbinfo = $_POST['db'];
		$username = $dbinfo['db_user'];
		$password = $dbinfo['db_pw'];
		$db_name = $dbinfo['db_name'];
		
		$install = new Install;
		$install->create_db($username, $password, $db_name);

		// update config file
		$this->update_json_config_file($username, $password, $db_name);

		header("Location: /install/confirm/{$db_name}");
	}

	public function create_admin(){
		$username = $_POST['admin-usr'];
		$password = $_POST['admin-pw'];

		$install = new Install;
		$install->create_admin($username, $password);

		header("Location: /install/complete");
	}	

	public function confirm($db){
		$this->render_view('main-layout','db-confirm',$db);
	}

	public function complete(){
		// deactivate installation mode
		$data = file_get_contents('BugTracker/app/conf/config.json');
		$conf = json_decode($data, true);
		$conf['setup'] = '0';
		$setup = json_encode($conf);
		file_put_contents('BugTracker/app/conf/config.json', $setup);

		// show confirmation page
		$this->render_view('main-layout','setup-confirm');
	}


	private function render_view($layout='', $method_name, $data = []){
		if($layout == '')
			include "installation/views/{$method_name}.php";
		else
			include 'installation/views/'. $layout . '.php';
	}

	private function update_json_config_file($username, $password, $db_name){
		$data = file_get_contents('BugTracker/app/conf/config.json');

		$conf = json_decode($data, true);

		// save new db credentials
		$conf['db_user'] = $username;
		$conf['db_password'] = $password;
		$conf['db_name'] = $db_name;

		// write the new db credentials back to json file
		$db_credentials = json_encode($conf);
		file_put_contents('BugTracker/app/conf/config.json', $db_credentials);

	}
}