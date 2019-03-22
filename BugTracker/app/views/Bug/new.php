<?php

$project = new Project($data['project_id']);
$users = ProjectUser::get_project_users($project->id);
$priorities = Priority::get_project_priorities($project->id);
$status = Status::get_project_status($project->id);

?>


<div id="project-settings">
<h3> <?php echo $project->project_name ?> </h3>
<hr>
<h4> New Issue </h4>
	<form class="proj-form" id="proj-new-form" action="/bug/create" method="POST" data-ajax="false">
		<div>
			<input type="hidden" name="bug[project_id]" value="<?php echo $project->id ?>" />
		</div>
		<div class="form-items">
			<div class="label">Issue Name</div>
			<div class="option"> 
				<input type="text" data-clear-btn="true" name="bug[bug_name]" />
			</div>
		</div>
		<div class="selection-form">
			<div class="form-items">
				<div class="label"> Assigned To </div>
				<div class="option">
					<select name="bug[assigned_to]">
						<option value="-1"> Unassigned </option>
						<?php 
							foreach($users as $user)
								echo "<option value='" . $user['id'] . "'>" . $user['first_name'] . "</option>";
						?>
					</select>
				</div>
			</div>
			<div class="form-items">
				<div class="label"> Priority </div>
				<div class="option">
					<select name="bug[priority_id]">
						<?php 
							foreach($priorities as $priority)
								echo "<option value='" . $priority['id'] . "'>" . $priority['priority_name'] . "</option>";
						?>
					</select>
				</div>
			</div>
			<div class="form-items">
				<div class="label"> Status </div>
				<div class="option">
					<select name="bug[status_id]">
						<?php 
							foreach($status as $stat)
								echo "<option value='" . $stat['id'] . "'>" . $stat['status_name'] . "</option>";
						?>
					</select>
				</div>
			</div>			
		</div>	
		<div>
			<div class="label">Details</div>
			<div class="detail">
				<textarea rows="6" name="bug[details]"></textarea>
			</div>
		</div>		
		

		
		<div id="save">
			<input type="submit" name="save" value="Save" />
		</div>
	</form>
</div>