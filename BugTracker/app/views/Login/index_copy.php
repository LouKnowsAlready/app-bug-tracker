<?php
	
	session_start();

?>

<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>

	<link rel="stylesheet" href="/BugTracker/css/login-layout.css" />
</head>
	<body>

		<header>
			<nav>
				<div class="main-wrapper">
					<div class="nav-login">
						<form action="/login/start_session" method="POST">
							<input type="text" name="uid" placeholder="Username">
							<input type="password" name="pwd" placeholder="Password">
							<button type="submit" name="login">Login</button>
						</form>
					</div>
				</div>
			</nav>
		</header>

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

				<h2>SIGN UP</h2>
				<form class="signup-form" action="/login/register" method="POST">
					<div id="note">
						<small><em><b>Note:</b> All fields are required</em></small>
					</div>				
					<input type="text" name="user[user_name]" placeholder="Username" required>
					<input type="password" name="user[password]" placeholder="Password" required>
					<input type="text" name="user[first_name]" placeholder="First Name" required>
					<input type="text" name="user[last_name]" placeholder="Last Name" required>
					<button type="submit" name="register"> Register </button>
				</form>
			</div>
		</section>



	</body>
	<script src="/BugTracker/js/jquery-1.11.1.min.js"></script>
	<script src="/BugTracker/js/login.js"></script>
</html>
