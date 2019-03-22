<?php	

class TempProject{
	public $id;
	public $name;

	public function __construct($id, $name){
		$this->id = $id;
		$this->name = $name;
	}

}

class TempUser{
	public $id;
	public $name;

	public function __construct($id, $name){
		$this->id = $id;
		$this->name = $name;
	}

}

class TempBug{
	public $id;
	public $name;
	public $assigned_to;
	public $project_id;
	public $status;

	public function __construct($id, $name, $assigned_to, $project_id, $status){
		$this->id = $id;
		$this->name = $name;
		$this->assigned_to = $assigned_to;
		$this->project_id = $project_id;
		$this->status = $status;
	}
}

// Create test projects
$projects = [];
$cube_castle = new TempProject(1,"Cube Castle");
$coaster_town = new TempProject(2,"Coaster Town");
array_push($projects, $cube_castle, $coaster_town);

// Create test users
$users = [];
$steve = new TempUser(1,"Steve");
$mav = new TempUser(2,"Mav");
$pooch = new TempUser(3,"Pooch");
array_push($users, $steve, $mav, $pooch);

// Create test bugs

// assigned to steve
$bugs = [];
$cc_bug1 = new TempBug(1,"Low Light1",1,1,"Not Started");
$cc_bug2 = new TempBug(2,"Low Light2",1,1,"In Progress");
$cc_bug3 = new TempBug(3,"Low Light3",1,1,"Done");
array_push($bugs, $cc_bug1, $cc_bug2, $cc_bug3);


// functions to be used in query.
function get_users_per_project($project_id, $bugs){
	$users_project = [];
	foreach ($bugs as $bug) {
		if($bug->project_id == $project_id){
			array_push($users_project, $bug->assigned_to);
		}
	}

	return array_unique($users_project);
}

function get_username($user_id, $users){
	foreach ($users as $user) {
		if($user->id == $user_id){
			return $user->name;
		}
	}
	return '';
}

function get_bugs($project_id, $user_id, $bugs){
	$user_bugs = [];
	foreach ($bugs as $bug) {
		if($bug->project_id == $project_id){
			if($bug->assigned_to == $user_id){
				array_push($user_bugs,$bug->status);
			}
		}
	}
	return array_unique($user_bugs);
}