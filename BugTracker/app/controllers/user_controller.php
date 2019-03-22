<?php 

class UserController extends Controller{
	private $model_name = 'User';
	private $view_name = 'User';
	private $layout = 'main';

	public function __construct(){}

	public function ajax_get_users_roles(){
		//include dirname(__DIR__) . "/models/User.php";
		//include dirname(__DIR__) . "/models/Role.php";

		$users = User::get_all_users();
		$user_select = "<select name='users[new][]'>";
		$id = uniqid();


		foreach($users as $user){
			$user_select = $user_select . "<option value='" . $user['id'] . "'>" . $user['name'] .'</option>';
		}
		$user_select = $user_select . '</select>';

		$roles = Role::get_all_roles();
		$role_select = "<select name='roles[new][]'>";
		foreach($roles as $role){
			$role_select = $role_select . "<option value='" . $role['id'] . "'>" . $role['role_name'] . '</option>';
		}
		$role_select = $role_select . '</select>';
		$role_select = $role_select;

		echo '<tr><td>' . $user_select . '</td> <td>' . $role_select . "</td> <td> <a id='{$id}' class='remove ui-btn ui-shadow ui-corner-all ui-icon-delete ui-btn-icon-notext' data-item='user' data-rel='popup' data-position-to='window' data-transition='pop' href='#popupDialog'>Remove</a> </td> </tr> ";
	}

	public function delete($user_id){
		// set the assigned_to to -1 in bugs table
		$bug_list = [];
		$Bugs_obj = $this->get_model('Bug');
		$bugs = Bug::get_bugs_per_user($user_id);
		
		foreach($bugs as $bug)
			array_push($bug_list, $bug['id']);

		$filter = 'id IN(' . implode(',', $bug_list) . ')';

		$Bugs_obj->update(["assigned_to" => -1], 'bugs', $filter);

		// delete records from project_users table
		$ProjectUser_obj = $this->get_model('ProjectUser');
		$filter = 'user_id = ' . $user_id;
		$ProjectUser_obj->delete('project_users', $filter);

		// delete records from users table
		$User_obj = $this->get_model('User');
		$filter = 'id = ' . $user_id;
		$ProjectUser_obj->delete('users', $filter);


		//return to view all users page
		$users = User::get_all_users();
		$this->render_view('', 'SiteAdmin','view-users', $users);
	}

	public function delete_selected(){
		if(isset($_POST['users'])){
			$users_to_delete = $_POST['users'];
			foreach($users_to_delete as $user_id){
				$bug_list = [];
				$Bugs_obj = $this->get_model('Bug');
				$bugs = Bug::get_bugs_per_user($user_id);
				
				foreach($bugs as $bug)
					array_push($bug_list, $bug['id']);

				$filter = 'id IN(' . implode(',', $bug_list) . ')';

				$Bugs_obj->update(["assigned_to" => -1], 'bugs', $filter);

				// delete records from project_users table
				$ProjectUser_obj = $this->get_model('ProjectUser');
				$filter = 'user_id = ' . $user_id;
				$ProjectUser_obj->delete('project_users', $filter);

				// delete records from users table
				$User_obj = $this->get_model('User');
				$filter = 'id = ' . $user_id;
				$ProjectUser_obj->delete('users', $filter);
			}

			//return to view all users page
			$users = User::get_all_users();
			$this->render_view('', 'SiteAdmin','view-users', $users);
		}
	}

	public function add(){
		$username = $_POST['username'];
		$password = $_POST['password'];
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];

		$user = $this->get_model('User');

		$data = array('user_name' => $username, 'password' => $password, 'first_name' => $fname, 'last_name' => $lname);

		// validate inputs
		$is_exist = $this->is_user_exist($username);
		if(empty($username) || empty($password) || empty($fname) || empty($lname) || $is_exist){
			$user_info['error'] = "";
			$user_info['username'] = $username;
			$user_info['password'] = $password;
			$user_info['fname'] = $fname;
			$user_info['lname'] = $lname;
			if(empty($username) || empty($password) || empty($fname) || empty($lname))
				$user_info['error'] = $user_info['error'] . '<p>&#10033; All fields should not be empty</p>';
			if($is_exist)
				$user_info['error'] = $user_info['error'] . '<p>&#10033; Cannot add existing username</p>';
			$this->render_view('','User','new',$user_info);
		}else{
			$user->create($data,'users');
			$this->render_view('','User','new');
		}
	}

	public function new(){
		$this->render_view('','User','new');
	}

	public function edit(){
		$user_id = $_GET['user_id'];

		$user = User::get_user_details($user_id);
	
		$this->render_view('','User','edit',$user);
	}

	public function update(){
		$user_id = $_POST['user_id'];
		$username = $_POST['username'];
		$def_name = $_POST['def_name'];
		$password = $_POST['password'];
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];

		$user = $this->get_model('User');

		$data = array('user_name' => $username, 'password' => $password, 'first_name' => $fname, 'last_name' => $lname);
		
		$filter = "id = {$user_id}";

		// validate inputs
		$is_exist = 0;
		if($username != $def_name)
			$is_exist = $this->is_user_exist($username);
		if(empty($username) || empty($password) || empty($fname) || empty($lname) || $is_exist){
			$user = User::get_user_details($user_id);
			$user['error'] = "";
			if(empty($username) || empty($password) || empty($fname) || empty($lname))
				$user['error'] = $user['error'] . '<p>&#10033; All fields should not be empty </p>';
			if($is_exist)
				$user['error'] = $user['error'] . '<p>&#10033; Cannot use existing username </p>';
			$this->render_view('','User','edit',$user);
		}else{
			$user->update($data,'users',$filter);
			
			//$users = User::get_all_users();
			//$this->render_view('', 'SiteAdmin','view-users', $users);
			$user_info = User::get_user_details($user_id);
			$this->render_view('','User','edit',$user_info);
		}
	}

	private function is_user_exist($username){
		$user_obj = $this->get_model('User');

		return $user_obj->check_availability($username);		
	}
}