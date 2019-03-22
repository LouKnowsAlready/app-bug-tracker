<?php

class SiteAdminController extends Controller{

	private $view_name = 'SiteAdmin';

	public function index(){
		session_start();

		if(isset($_SESSION['admin_uid']))
			$this->render_view('', $this->view_name,'index');
		else
			header("Location: /site-admin/login");
	}

	public function view_users(){
		$users = User::get_all_users();
		$this->render_view('', $this->view_name,'view-users', $users);
	}

	public function login(){
		$this->render_view('', $this->view_name,'login');
	}

	public function start_session(){
		session_start();

		$admin = $_POST['admin'];

		$user = $admin['user_name'];
		$pw = $admin['password'];

		$SiteAdmin_obj = $this->get_model('SiteAdmin');
		$is_exist = $SiteAdmin_obj->check_availability($user);

		if($is_exist){
			$uid = $SiteAdmin_obj->verify_credentials($user, $pw);
			if($uid['id']){
				$_SESSION['admin_uid'] = $uid['id'];
				header('Location: /site-admin');
			}else{
				header('Location: /site-admin/login?error=Invalid password');
			}
		}else{
			header("Location: /site-admin/login?error=Admin not found");
		}
	}

	public function destroy_session(){
		session_start();
		unset($_SESSION['admin_uid']);
		header('Location: /site-admin');
	}

	public function edit(){
		$admin = SiteAdmin::get_admin();
		$this->render_view('', $this->view_name,'edit', $admin);
	}

	public function update(){
		$user = $_POST['user'];
		$new_pw = $_POST['new_pw'];
		$confirm_pw = $_POST['confirm_pw'];

		if($new_pw != $confirm_pw){
			echo "Your new password and confirm password does not match";
			echo "<script> var el = document.getElementById('msg-container'); el.classList.add('alert');</script>";
		}elseif(empty($new_pw)){
			echo "Empty password is not allowed";
			echo "<script> var el = document.getElementById('msg-container'); el.classList.add('alert');</script>";
		}else{
			$SiteAdmin_obj = new SiteAdmin;
			if($SiteAdmin_obj->update_admin($user, $new_pw)){
				echo "Updated record successfully";
				echo "<script> var el = document.getElementById('msg-container'); el.classList.add('success');</script>";
			}
			else{
				echo "Something wrong when updating the record";
				echo "<script> var el = document.getElementById('msg-container'); el.classList.add('alert');</script>";
			}
		}
	}

	public function delete(){
		$SiteAdmin_obj = new SiteAdmin;
		$SiteAdmin_obj->delete_app();
		header('Location: /');
	}

	public function show_alert_window(){
		$header = $_GET['header'];
		$content = $_GET['content'];
		$del_type = $_GET['del_type'];

		$data['header'] = $header;
		$data['content'] = $content;
		$data['del_type'] = $del_type;
		if($del_type == "single"){
			$data['user_id'] = $_GET['user_id'];
		}		

		$this->render_view('', $this->view_name,'show_alert_window', $data);
	}

}