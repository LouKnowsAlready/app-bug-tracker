<!DOCTYPE html>
<html>
<head>
	<title>Site Admin</title>
	<link rel="stylesheet" href="/BugTracker/css/site-admin.css"> 

	<script src="/BugTracker/js/jquery-1.11.1.min.js"></script>
	<script src="/BugTracker/js/site-admin.js"></script>
</head>
<body>
	<section data-role="page">
		<div class="site-container">
			<div id="intro">
				<h1> Welcome Site Admin</h1>
				<p> What would you like to do? </p>
			</div>
			<div id="menu">
				<div class="admin-options">
					<a href="#" id="manage-account">
						<img src="/BugTracker/Icons/manage_account.png" />
						<p>Manage Account</p>
					</a>
				</div>
				<div class="admin-options">
					<a href="#" id="view-users">
						<img src="/BugTracker/Icons/delete-users.png" />
						<p>View Users</p>
					</a>
				</div>
				<div class="admin-options">
					<a href="/" id="app-site" target="_blank">
						<img src="/BugTracker/Icons/ladybug.jpg" />
						<p>BugTracker</p>
					</a>
				</div>

				<div class="admin-options">
					<a href="#delete-app-lightbox">
						<img src="/BugTracker/Icons/delete_app.jpg" />
						<p>Delete App</p>
					</a>
				</div>
		

				<div class="admin-options">
					<a href="/login/destroy_session" id="admin-logout">
						<img src="/BugTracker/Icons/logout.jpg" />
						<p>Log Out</p>
					</a>
				</div>
			</div>
			<div id="option-content">
				<div id="cont-header"> <strong>Action Details</strong> </div>
				<div id="cont-body">
					<p> No selected actions. </p>
				</div>
			</div>
		</div>
	</section>
	<!-- delete app lightbox ---->
	<div id="delete-app-lightbox">
		<div id="delete-app-lightbox-content"> 
			<div class="top">
				<span> <strong>Delete Application</strong> </span>
			</div>
			<div class="content-alert">
				<p> Are you sure you want to delete this app? </p>
				<div class="alert-opt">
					<a href="/site-admin/delete" class="button" id="del-yes"> Yes </a>
					<a href="#" class="button"> No </a>
				</div>
			</div>
		</div>
	</div>	
	<!-- end -->

	<!-- User info form -->
	<div id="user-info">
		<div id="user-info-content">
			<div id="user-form">

			</div>
		</div>
	</div>
	<!-- end -->

	<!-- delete user ---->
	<div id="delete-user">
		<div id="delete-user-content"> 
			
		</div>
	</div>	
	<!-- end -->

</body>
</html>