<?php

$data = file_get_contents('BugTracker/app/conf/config.json');
$conf = json_decode($data, true);

// if setup is not 0, then launch setup app
if($conf['setup']){
	require $_SERVER["DOCUMENT_ROOT"] . "/installation/core/install-app.php";

	// autoload model classes
	spl_autoload_register(function($class){
		require_once $_SERVER["DOCUMENT_ROOT"] . "/installation/models/$class.php";
	});

	$var = new InstallApp;
}
//else launch the bugtracker
else{
	require_once 'BugTracker/app/init.php';

	$app = new App;
}


