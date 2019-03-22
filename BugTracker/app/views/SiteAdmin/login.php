<?php
	
	session_start();

?>

<!DOCTYPE html>
<html>
<head>
	<title>Site Admin:Login Page</title>

	<link rel="stylesheet" href="/BugTracker/css/login-layout.css" />
</head>
	<body>

		<section class="main-container">
			<div class="main-wrapper">

				<?php
					if(isset($_GET['error'])) {
				?>

					<div class="alert">
					  <span class="closebtn">&times;</span>
					  <?php echo $_GET['error']; ?>
					</div>

				<?php
					}
				?>

				<h2>SITE ADMIN</h2>
				<form class="signup-form" action="/site-admin/start_session" method="POST">				
					<input type="text" name="admin[user_name]" placeholder="Username" required>
					<input type="password" name="admin[password]" placeholder="Password" required>
					<button type="submit" name="Login"> Log In </button>
				</form>
			</div>
		</section>



	</body>
	<script src="/BugTracker/js/jquery-1.11.1.min.js"></script>
	<script src="/BugTracker/js/login.js"></script>
</html>
