	<div id="msg-container" >
		<span class="closebtn">&times;</span>
		<p class="admin-msg"></p>
	</div>	
<div id="admin-form-container">
	<h1> Admin Account </h1>
	<form id="admin-form" action="/site-admin/update" method="POST">
		<div>
			<label>Username</label>
			<input type="text" id="admin_user" name="admin_user" value="<?php echo $data['user_name']; ?>" />
		</div>
		<div>
			<label>New Password</label>
			<input type="password" id="new_pw" name="new_pw" />
		</div>
		<div>
			<label>Confirm New Password</label>
			<input type="password" id="confirm_pw" name="confirm_pw" />
		</div>
		<div>
			<input type="submit" id="admin-update" class="button" value="Submit" name="Submit" />
		</div>
	</form>
</div>