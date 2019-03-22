<?php 

class ProjectController extends Controller{
	private $model_name = 'Project';
	private $view_name = 'Project';
	private $layout = 'main';

	public function __construct(){}

	public function index(){		
		$this->render_view($this->layout, $this->view_name,'index');
	}

	public function new(){
		$this->render_view($this->layout, $this->view_name,'new');
	}

	public function edit($project_id){
		//include '../app/views/Project/edit.php';
		$this->render_view($this->layout, $this->view_name,'edit',$project_id);
	}

	public function delete($project_id){
		$Project_obj = $this->get_model('Project');
		$ProjectUser_obj = $this->get_model('ProjectUser');
		$Tag_obj = $this->get_model('Tag');
		$Priority_obj = $this->get_model('Priority');
		$Status_obj = $this->get_model('Status');
		$Bug_obj = $this->get_model('Bug');

		$project_filter = "id = {$project_id}";
		$filter = "project_id = {$project_id}";
		
		$Project_obj->delete('projects', $project_filter);
		$ProjectUser_obj->delete('project_users', $filter);
		$Tag_obj->delete('tags', $filter);		
		$Priority_obj->delete('priorities', $filter);
		$Status_obj->delete('bug_status', $filter);

		$bugs = Bug::get_bugs_per_project($project_id);
		if(!empty($bugs)){
			$bug_filter = "id IN(" . implode(',',$bugs) . ')';
			$Bug_obj->delete('bug_tags', $bug_filter);
		}
		$Bug_obj->delete('bugs', $filter);

		header('Location: /');
	}

	public function create(){
	
		if(isset($_POST['project'])){
			$Project_obj = $this->get_model($this->model_name);
			$id = $Project_obj->create($_POST['project'], 'projects');

			if(isset($_POST['users']['new'])){
				$ProjectUser_obj = $this->get_model('ProjectUser');
				$users = $_POST['users']['new'];
				$roles = $_POST['roles']['new'];

				foreach($users as $index => $user){
					$ProjectUser_obj->create(array('project_id' => $id, 'user_id' => $user, 'role_id' => $roles[$index]), 'project_users');
				}
			}

			if(isset($_POST['tags']['new'])){
				$ProjectTag_obj = $this->get_model('Tag');
				$tags = $_POST['tags']['new'];

				foreach($tags as $tag){
					$ProjectTag_obj->create(array('project_id' => $id, 'tag_name' => $tag), 'tags');
				}
			}

			if(isset($_POST['priorities'])){
				$ProjectPriority_obj = $this->get_model('Priority');
				$priorities = $_POST['priorities'];
				$priority_name = $priorities['priority_name']['new'];
				$priority_weight = $priorities['priority_weight']['new'];
				$priority_color = $priorities['priority_color']['new'];
				$priority_size = count($priority_name);


				for($index = 0; $index < $priority_size; $index++){
					$ProjectPriority_obj->create(array('project_id' => $id, 'priority_name' => $priority_name[$index], 'priority_weight' => $priority_weight[$index], 'priority_color' => $priority_color[$index]), 'priorities');
				}
			}

			if(isset($_POST['status']['new'])){
				$ProjectStatus_obj = $this->get_model('Status');
				$status = $_POST['status']['new'];

				foreach($status as $stat){
					$ProjectStatus_obj->create(array('project_id' => $id, 'status_name' => $stat), 'bug_status');
				}
			}			
		}

		//$this->render_view($this->layout, $this->view_name,'create');
		header('Location: /');
	}

	public function update(){
		$Project_obj = $this->get_model('Project');
		$project_record = array('project_name'=>$_POST['project']['project_name']);
		$filter = "id = {$_POST['project_id']}";
		$Project_obj->update($project_record, 'projects', $filter);
		$this->update_users($_POST);
		$this->update_tags($_POST);
		$this->update_priorities($_POST);
		$this->update_status($_POST);
		//$this->render_view($this->layout, $this->view_name,'edit',$_POST['project_id']);
		header("Location: /project/edit/{$_POST['project_id']}");
	}

	private function update_users($data){
		$ProjectUser_obj = $this->get_model('ProjectUser');
		if(isset($data['users'])){
			$users = $data['users'];
			if(isset($users['new']))
				unset($users['new']); // do not include newly inserted users
		}
		else
			$users = [];
		if(isset($data['roles'])){
			$roles = $data['roles'];
			if(isset($roles['new']))
				unset($roles['new']); // do not include newly inserted roles
		}
		else
			$roles = [];		
		
		$project = $data['project_id'];

		// get current records
		$filter = "project_id = {$project}";
		// this will be used to compare which rows are to be deleted.
		$proj_users_records = ProjectUser::get_records('project_users','id',$filter);

		// get updated records
		if(!empty($users)){
			foreach($users as $index => $user){
	   			$role = $roles[$index];
	   			$proj_user = array("id"=>$index, "project_id"=>$project, "user_id"=>$user, "role_id"=>$role);
	   			$filter = "id = {$index}";
	   			$ProjectUser_obj->update($proj_user, 'project_users', $filter);
			}
		}

		// get  newly inserted users
		if(isset($data['users']['new'])){
			$new_users = $data['users']['new'];
			$new_roles = $data['roles']['new'];
			foreach($new_users as $index => $user){
				$role = $new_roles[$index];
				$proj_user = array("project_id"=>$project, "user_id"=> $user, "role_id"=> $role);
				$ProjectUser_obj->create($proj_user, 'project_users');
			}
		}

		// get deleted users
		$del_users = $this->get_deleted_records($proj_users_records, $users);
		if(!empty($del_users)){
			//reassign bugs assigned to deleted users
			foreach($del_users as $del_user){
				$user_id = ProjectUser::get_user_id($del_user);
				$bug_list = [];
				$Bugs_obj = $this->get_model('Bug');
				$bugs = Bug::get_bugs_per_user_project($user_id['user_id'], $project);

				foreach($bugs as $bug)
					array_push($bug_list, $bug['id']);

				$filter = 'id IN(' . implode(',', $bug_list) . ')';
				$Bugs_obj->update(["assigned_to" => -1], 'bugs', $filter);
			}


			$filter = "id IN(" . implode(',',$del_users) . ')';
			$ProjectUser_obj->delete('project_users', $filter);
		}
	}

	private function update_tags($data){
		$Tag_obj = $this->get_model('Tag');
		if(isset($data['tags'])){
			$tags = $data['tags'];
			if(isset($tags['new']))
				unset($tags['new']); // do not include newly inserted tags
		}
		else
			$tags = [];

		$project = $data['project_id'];

		// get current records
		$filter = "project_id = {$project}";
		// this will be used to compare which rows are to be deleted.
		$tag_records = Tag::get_records('tags','id',$filter);

		// get updated records
		if(!empty($tags)){
			foreach($tags as $index => $tag){
	   			$filter = "id = {$index}";
	   			$tag_record = array("tag_name" => $tag);
	   			$Tag_obj->update($tag_record, 'tags', $filter);
			}
		}

		// get  newly inserted tags
		if(isset($data['tags']['new'])){
			$new_tags = $data['tags']['new'];
			foreach($new_tags as $index => $tag){
				$new_tag = array("project_id"=>$project, "tag_name"=> $tag);
				$Tag_obj->create($new_tag, 'tags');
			}
		}

		// get deleted tags
		$del_tags = $this->get_deleted_records($tag_records, $tags);
		if(!empty($del_tags)){
			$filter = "id IN(" . implode(',',$del_tags) . ')';
			$Tag_obj->delete('tags', $filter);
		}

	}

	private function update_priorities($data){
		$Priority_obj = $this->get_model('Priority');
		if(isset($data['priorities']['priority_name'])){
			$priorities = $data['priorities']['priority_name'];
			if(isset($priorities['new']))
				unset($priorities['new']); // do not include newly inserted users
		}
		else
			$priorities = [];
		
		if(isset($data['priorities']['priority_weight'])){
			$priority_weights = $data['priorities']['priority_weight'];
			if(isset($priority_weights['new']))
				unset($priority_weights['new']); // do not include newly inserted users
		}
		else
			$priority_weights = [];

		if(isset($data['priorities']['priority_color'])){
			$priority_colors = $data['priorities']['priority_color'];
			if(isset($priority_colors['new']))
				unset($priority_colors['new']); // do not include newly inserted users
		}
		else
			$priority_colors = [];		
		
		$project = $data['project_id'];

		// get current records
		$filter = "project_id = {$project}";
		// this will be used to compare which rows are to be deleted.
		$priorities_records = Priority::get_records('priorities','id',$filter);

		// get updated records
		if(!empty($priorities)){
			foreach($priorities as $index => $priority){
	   			$priority_weight = $priority_weights[$index];
	   			$priority_color = $priority_colors[$index];
	   			$priority_record = array("priority_name"=>$priority, "priority_weight"=>$priority_weight, "priority_color"=>$priority_color);
	   			$filter = "id = {$index}";
	   			$Priority_obj->update($priority_record, 'priorities', $filter);
			}
		}

		// get  newly inserted priorities
		if(isset($data['priorities']['priority_name']['new'])){
			$new_priorities = $data['priorities']['priority_name']['new'];
			$new_priority_weights = $data['priorities']['priority_weight']['new'];
			foreach($new_priorities as $index => $priority){
				$new_priority_weight = $new_priority_weights[$index];
				$priority_record = array("project_id"=>$project, "priority_name"=>$priority, "priority_weight"=>$new_priority_weight);
				$Priority_obj->create($priority_record, 'priorities');
			}
		}

		// get deleted users
		$del_priorities = $this->get_deleted_records($priorities_records, $priorities);
		if(!empty($del_priorities)){
			$filter = "id IN(" . implode(',',$del_priorities) . ')';
			$Priority_obj->delete('priorities', $filter);
		}
	}

	private function update_status($data){
		$Status_obj = $this->get_model('Status');
		if(isset($data['status'])){
			$status = $data['status'];
			if(isset($status['new']))
				unset($status['new']); // do not include newly inserted tags
		}
		else
			$status = [];

		$project = $data['project_id'];

		// get current records
		$filter = "project_id = {$project}";
		// this will be used to compare which rows are to be deleted.
		$status_records = Status::get_records('bug_status','id',$filter);

		// get updated records
		if(!empty($status)){
			foreach($status as $index => $stat){
	   			$filter = "id = {$index}";
	   			$stat_record = array("status_name" => $stat);
	   			$Status_obj->update($stat_record, 'bug_status', $filter);
			}
		}

		// get  newly inserted status
		if(isset($data['status']['new'])){
			$new_status = $data['status']['new'];
			foreach($new_status as $index => $stat){
				$new_stat = array("project_id"=>$project, "status_name"=> $stat);
				$Status_obj->create($new_stat, 'bug_status');
			}
		}

		// get deleted status
		$del_status = $this->get_deleted_records($status_records, $status);
		if(!empty($del_status)){
			$filter = "id IN(" . implode(',',$del_status) . ')';
			$Status_obj->delete('bug_status', $filter);
		}

	}
	
}