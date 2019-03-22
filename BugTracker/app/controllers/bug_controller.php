<?php

class BugController extends Controller{
	private $model_name = 'Bug';
	private $view_name = 'Bug';
	private $layout = 'main';
	private $model_obj;

	public function __construct(){}

	public function index($project_id = 0, $user_id = 0, $status_id = 0){
		$data['project_id'] = $project_id;
		$data['user_id'] = $user_id;
		$data['status_id'] = $status_id;
		$this->render_view($this->layout, $this->view_name,'index', $data);
	}

	public function ajax_index($project_id = 0, $user_id = 0, $status_id = 0){
		$data['project_id'] = $project_id;
		$data['user_id'] = $user_id;
		$data['status_id'] = $status_id;		
		include 'BugTracker/app/views/Bug/index.php';
	}

	public function show($project_id = 0, $user_id = 0, $bug_id = 0){
		$data = array("project_id" => $project_id, "user_id" => $user_id, "bug_id" => $bug_id);

		$this->render_view($this->layout, $this->view_name,'show', $data);
	}

	public function update($project_id, $user_id, $bug_id, $bug_status){
		if(isset($_POST['bug'])){
			$Bug_obj = $this->get_model($this->model_name);
			$filter = "id = {$bug_id}";
			$Bug_obj->update($_POST['bug'], 'bugs', $filter);
		}
		//header("Location: /bug/show/{$project_id}/{$user_id}/{$bug_id}");
		header("Location: /bug/index/{$project_id}/{$user_id}/{$bug_status}");
	}

	public function ajax_update($bug_id){
		if(isset($_POST['bug'])){
			$Bug_obj = $this->get_model($this->model_name);
			$filter = "id = {$bug_id}";
			$Bug_obj->update($_POST['bug'], 'bugs', $filter);
		}
	}	

	public function new($project_id){
		$data['project_id'] = $project_id;

		$this->render_view($this->layout, $this->view_name, 'new', $data);
	}

	public function create(){
		$data['status_id'] = $_POST['bug']['status_id'];
		$data['project_id'] = $_POST['bug']['project_id'];
		$data['user_id'] = $_POST['bug']['assigned_to'];
		if(isset($_POST['bug'])){
			$Bug_obj = $this->get_model($this->model_name);
			$Bug_obj->create($_POST['bug'], 'bugs');
		}

		//$this->render_view($this->layout, $this->view_name, 'show', $data);
		header("Location: /bug/index/{$data['project_id']}/{$data['user_id']}/{$data['status_id']}");
	}

	public function ajax_new($project_id){
		$data['project_id'] = $project_id;
		
		include 'BugTracker/app/views/Bug/new.php';
	}

	public function delete($project_id = 0, $user_id = 0, $status_id=0, $bug_id = 0){
		$Bug_obj = $this->get_model($this->model_name);
		$filter = "id = {$bug_id}";
		$query = $Bug_obj->delete('bugs', $filter);

		$data['project_id'] = $project_id;
		$data['user_id'] = $user_id;
		$data['status_id'] = $status_id;

		$this->render_view($this->layout, $this->view_name,'index', $data);
	}

	public function ajax_update_position(){
		//$conn = new mysqli("localhost","root","","test");

		if(isset($_POST['update'])){
			$Bug_obj = $this->get_model($this->model_name);

			foreach($_POST['positions'] as $position){
				$index = $position[0];
				$newpos = $position[1];
				$filter = "id = {$index}";

				//$conn->query("UPDATE bugs SET position = $newpos WHERE id = $index");
				$Bug_obj->update(['position' => $newpos], 'bugs', $filter);
			}
			exit('success');
		}
	}

	public function ajax_custom_sort(){
		$data['project_id'] = $_GET['project_id'];
		$data['user_id'] = $_GET['user_id'];
		$data['status_id'] = $_GET['status_id'];		
		
		include 'BugTracker/app/views/Bug/custom_sort.php';		
	}

}