<div id="del-users-page">
	<?php 
		if(isset($_GET['err_msg'])) {
			echo '
					<div id="view-user-error" class="alert">
						'. $_GET['err_msg'] .'
					</div>
				';
		}
	?>

	<table>

		<tr>
			<th>
				<a class="add-btn" id="new-user">New</a>
				<a class="add-btn" id="del-all">Delete Selected</a>
			</th>
		<!--	
			<th>
				<a class="add-btn" id="del-all">Delete Selected</a>
			</th>
		</tr>
		-->
		<tr>
			<th><input type="checkbox" class="selectall" /></th>
			<th> Username </th>
			<th> Full Name </th>
			<th> Actions </th>
		</tr>
		<?php
			if(empty($data))
				echo '<tr><td>No User found</td></tr>';
			foreach($data as $user){
				$user_details = User::get_user_details($user['id']);
				echo '<tr>
						<td><input type="checkbox" class="indv-check-box" value=' . $user_details['id'] . ' /></td>
						<td>' . $user_details['user_name'] . '</td>
						<td>' . $user_details['name'] . '</td>
						<td><a  class="edit-user" data-id=' . $user_details['id'] . '> Edit </a>|<a class="del-user" data-id=' . $user_details['id'] . ' > Delete </a></td>
					  </tr>';
			}
		?>		
	</table>

</div>


