<?php

class LoginController extends Controller{
	private $view_name = 'Login';

	public function index(){
		$this->render_view('',$this->view_name,'index');
	}

	public function register(){
		session_start();

		if(isset($_POST['register'])){
			$login_obj = $this->get_model('Login');
			$new_user = $_POST['user'];
			if(!$this->is_user_exist($new_user['user_name'])){		
				$user_id = $login_obj->create($new_user,'users');
				$_SESSION['uid'] = $user_id;
				header('Location: /');
			}else{
				header('Location: /login?error=Username\'s already taken');
			}
		}
	}

	public function start_session(){
		session_start();

		$user_name = $_POST['uid'];
		$password = $_POST['pwd'];

		$Login_obj = $this->get_model('Login');
		$is_exist = $Login_obj->check_availability($user_name);

		if($is_exist){
			$uid = $Login_obj->verify_credentials($user_name, $password);
			if($uid['id']){
				$_SESSION['uid'] = $uid['id'];
				header('Location: /');
			}else{
				header('Location: /login?error=Invalid password');
			}
		}else{
			header("Location: /login?error=User not found");
		}
	}

	public function destroy_session(){
		session_start();
		/*
		session_unset();
		session_destroy();
		*/
		unset($_SESSION['uid']);
		header('Location: /');
	}

	private function is_user_exist($username){
		$login_obj = $this->get_model('Login');

		return $login_obj->check_availability($username);		
	}

}