<?php


require 'BugTracker/app/core/App.php';
require 'BugTracker/app/core/Controller.php';
require 'BugTracker/app/core/Model.php';



// autoload models classes
spl_autoload_register(function($class){
	require_once "BugTracker/app/models/$class.php";;
});

