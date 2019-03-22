<?php
	session_start();

	$user_session_id = 0;
	$user_session = [];

	if(isset($_SESSION['uid'])){
		$user_session_id = $_SESSION['uid'];
		$user_session = User::get_user_details($user_session_id);
	}else{
		header("Location: /login");
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Bug Tracker</title>

		<link rel="stylesheet" href="/BugTracker/css/jquery.mobile-1.4.5.min.css" />
		<link rel="stylesheet" href= '/BugTracker/css/style.css' /> 
		
		<script src="/BugTracker/js/jquery-1.11.1.min.js"></script>
		<script src="/BugTracker/js/jquery-ui.min.js"></script>
		<script src="/BugTracker/js/jquery.mobile-1.4.5.min.js"></script>
		<script src="/BugTracker/js/main.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1">


	</head>
	<body>
		<section data-role="page">
			<div class="main-container">
				<div class="ui-grid-a" >
					<div class="ui-block-a left-content">
					<!-- Insert code here -->
						<div data-role="collapsibleset" class="side-bar">
							<?php include('_main_project_list.php'); ?>
							<div class="project-block">
							    <a href="/project/new" rel="external" class="ui-btn">New Project</a>
							</div>    					    		    
						</div>
					<!-- End of block -->						
					</div>
					<!-- Tab navbar  -->
					<div class="ui-block-b right-content">
						<div class="top-nav">
							<a href="#bug" class="active ui-btn ui-btn-inline ui-btn-icon-left ui-icon-bug"> Bugs </a>
							<a href="#checklister" class="ui-btn ui-btn-inline ui-btn-icon-left ui-icon-checklister"> Checklister </a>
							<?php 
								if(isset($_SESSION['uid'])){
									echo '<div id="logout">
											<small> Hi ' . $user_session['first_name'] . '</small> | 
											<a rel="external" href="/login/destroy_session"><small>Log Out</small> </a>
										  </div>';
								}
							?>
						</div>
						<!-- Tab contents  -->
						<div class="tab-container">
							<div id="bug" class="tab-content">
								<?php include('BugTracker/app/views/'. $view_name . '/' . $method_name . '.php') ?>
							</div>
							<div id="checklister" class="tab-content" style="display: none;">
								test 2
							</div>
						</div>
						<!-- Tab contents end  -->
					</div>
					<!-- Tab navbar end  -->
				</div>
			</div>
		</section>
	</body>
</html>