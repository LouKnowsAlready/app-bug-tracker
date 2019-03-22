<?php

	if(isset($_SESSION['uid'])){
		$user_session_id = $_SESSION['uid'];
		$user_session = User::get_user_details($user_session_id);
	}else{
		header("Location: /login");
	}

	$roles = Role::get_all_roles();
	$uniq_id = uniqid();

?>

<div id="project-settings">
	<form class="proj-form" id="proj-new-form" action="/project/create" method="POST" data-ajax="false">
		<label>Project Name</label>
		<input type="text" data-clear-btn="true" name="project[project_name]" value="Project1" />
		<hr>
		<label> Project Settings </label>
		<div id='project-settings-panel'>

			<!-- DELETE popup message  -->
			<div data-role="popup" id="popupDialog" data-overlay-theme="b" data-theme="b" data-dismissible="false" style="max-width:400px;">
		        <div data-role="header" data-theme="a">
				    <h1 id="pop-up-header">Insert Popup Header Here</h1>
				</div>
			    <div role="main" class="ui-content">
			        <p id="pop-up-msg" class="ui-title"> Insert Popup Message Here</p>
			        <a href="#" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-b" data-rel="back">Cancel</a>
			        <a id="del-pop-up" data-hint="0" data-el="#" data-id="#" href="#" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-b" rel="external">Delete</a>
		        </div>
			</div>
			<!-- end -->

			<div id="user-panel" data-role="collapsible" data-collapsed="false">
				<h3> Users </h3>
				<small>List of users that can be selected within the project and their corresponding permissions.</small>
				<div>
					<table id="user_list">
						<tr>
							<td>
								<input type="hidden" name='users[new][]' <?php echo "value='{$user_session_id}'"; ?> />
								<select name='#' disabled>
									<option value='#'>
										<?php
											echo $user_session['name'];
										?>
									</option>
								</select>
							</td>
							<td>
								<select name='roles[new][]'>
									<?php
										foreach($roles as $role){
													echo "<option value='" . $role['id'] . "'>" . $role['role_name'] . '</option>';
												}										
									?>
								</select>
							</td>
							<td>
								<a id="<?php echo $uniq_id; ?>" class='ui-btn ui-shadow ui-corner-all ui-icon-delete ui-btn-icon-notext' data-item='user' data-rel='popup' data-position-to='window' data-transition='pop' href='#popupDialog' style="pointer-events: none;">Remove</a>
							</td>
					</table>
				</div>
				<input type="button" id="add_user" data-inline="true" value="Add User">
			</div>
			<div id="tag-panel" data-role="collapsible" data-collapsed="false">
				<h3> Tags </h3>
				<small>List of tags that can be use within the project.</small>
				<div id="tag_list"></div>
				<input type="button" id="add_tag" data-inline="true" value="Add Tag">
			</div>
			<div id="priority-panel" data-role="collapsible" data-collapsed="false">
				<h3>Priorities</h3>
				<small>List of priorities that can be use within the project.</small>
				<div>
					<table id="priority_list">
						<?php
							$critical = ['pname'=>'Critical','pweight'=>1,'pcolor'=>'#ff0000'];
							$high = ['pname'=>'High','pweight'=>2,'pcolor'=>'#ff6600'];
							$medium = ['pname'=>'Medium','pweight'=>3,'pcolor'=>'#ffff00'];
							$low = ['pname'=>'Low','pweight'=>4,'pcolor'=>'#008000'];
							$priorities = [];
							array_push($priorities,$critical,$high,$medium,$low);

							foreach ($priorities as $priority) {
								$id = uniqid();

								echo '
								<tr>
									<td>
										<input type="text" name="priorities[priority_name][new][]" value="' . $priority['pname'] . '" />
									</td>
									<td>
										<input type="number" name="priorities[priority_weight][new][]" value="' . $priority['pweight'] . '" />
									</td>
									<td>
										<input class="priority-color" type="color" name="priorities[priority_color][new][]" value="' . $priority['pcolor'] . '" />
									</td>
									<td>
										<a id="'. $id .'" class="remove ui-btn ui-shadow ui-corner-all ui-icon-delete ui-btn-icon-notext" data-item="priority" data-rel="popup" data-position-to="window" data-transition="pop"  href="#popupDialog">Remove</a>
									</td>
								</tr> ';
							}
						?>
					</table>
				</div>
				<input type="button" id="add_priority" data-inline="true" value="Add Priority">
			</div>
			<div data-role="collapsible" data-collapsed="false">
				<h3>Status</h3>
				<small>List of status that can be used within the project.</small> <br>
				<small>First entry is treated as first item. And last entry is treated as last item (done/completed).</small>
				<div id="status_list">
					<div class="stat-div">
						<input type='text' name='status[new][]' value="Not Started" /><a id="<?php echo uniqid(); ?>" class='remove  ui-btn ui-shadow ui-corner-all ui-icon-delete ui-btn-icon-notext' data-item='status' data-rel='popup' data-position-to='window' data-transition='pop' href='#popupDialog'>Remove</a>
					</div>
					<div class="stat-div">
						<input type='text' name='status[new][]' value="In Progress" /><a id="<?php echo uniqid(); ?>" class='remove  ui-btn ui-shadow ui-corner-all ui-icon-delete ui-btn-icon-notext' data-item='status' data-rel='popup' data-position-to='window' data-transition='pop' href='#popupDialog'>Remove</a>
					</div>
					<div class="stat-div">
						<input type='text' name='status[new][]' value="Completed" /><a id="<?php echo uniqid(); ?>" class='remove  ui-btn ui-shadow ui-corner-all ui-icon-delete ui-btn-icon-notext' data-item='status' data-rel='popup' data-position-to='window' data-transition='pop' href='#popupDialog'>Remove</a>
					</div>										
				</div>
				<input type="button" id="add_status" data-inline="true" value="Add Status">
			</div>
		</div>
		<input type="submit" name="submit" value="Submit" />
	</form>
</div>
