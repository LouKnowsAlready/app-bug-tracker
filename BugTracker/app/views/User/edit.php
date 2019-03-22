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


<h3>Edit User</h3>
<!-- hidden field to check if username has not been changed. -->
<input type="hidden" id="def-name" value="<?php echo $user['user_name']; ?>" />
<!-- end-->
<div>
	<label> Username </label>
	<input type="text" id="username" value="<?php echo $user['user_name']; ?>" />
</div>
<div>
	<label> Password </label>
	<input type="password" id="password" value="<?php echo $user['password']; ?>" />
</div>
<div>
	<label> First Name </label>
	<input type="text" id="fname" value="<?php echo $user['first_name']; ?>" />
</div>
<div>
	<label> Last Name </label>
	<input type="text" id="lname" value="<?php echo $user['last_name']; ?>" />
</div>
<div id="option">
	<div><a id="update-user" class="update" data-id="<?php echo $user['id']; ?>">Update</a></div>
	<div><a class="update" href="#">Cancel</a></div>
</div>

