<?php $user = $data; ?>

<?php 
	if(isset($user['error'])) {
		echo '
				<div id="error-msg" class="alert">
					'. $user['error'] .'
				</div>
			';
	}
?>

<h3>New User</h3>
<div>
	<input type="text" id="username" placeholder="Username" <?php echo (isset($user['username'])) ? "value='{$user['username']}'" : ""; ?> />
</div>
<div>
	<input type="password" id="password" placeholder="Password" <?php echo (isset($user['password'])) ? "value='{$user['password']}'" : ""; ?>>
</div>
<div>
	<input type="text" id="fname" placeholder="First Name" <?php echo (isset($user['fname'])) ? "value='{$user['fname']}'" : ""; ?> />
</div>
<div>
	<input type="text" id="lname" placeholder="Last Name" <?php echo (isset($user['lname'])) ? "value='{$user['lname']}'" : ""; ?> />
</div>
<div id="option">
	<div><a id="add-user" class="add">Add</a></div>
	<div><a class="add" href="#">Cancel</a></div>
</div>