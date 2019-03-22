<?php

$project = new Project($data['project_id']);
$users = ProjectUser::get_project_users($project->id);
$priorities = Priority::get_project_priorities($project->id);
$status = Status::get_project_status($project->id);

$bug = new Bug($data['bug_id']);

function selected($item1, $item2){
	return $item1 == $item2 ? "selected='selected'" : "";
}

?>


<div id="project-settings">
<div id="action">
	<a rel="external" href="<?php echo "/bug/index/{$bug->project_id}/$bug->assigned_to/$bug->status_id"; ?>"> Back </a> |
	<a href="#" id="edit"> Edit </a> |
	<a rel="external" href="<?php echo "/bug/delete/{$bug->project_id}/{$bug->assigned_to}/{$bug->status_id}/{$bug->id}"; ?>"> Delete </a>
</div>
<h3> Project Name: <?php echo $project->project_name ?> </h3>
<hr>
	<form action="/bug/update/<?php echo "$bug->project_id/$bug->assigned_to/$bug->id/$bug->status_id" ?>" method="POST" data-ajax="false">
		<div>
			<input type="hidden" name="bug[project_id]" value="<?php echo $project->id ?>" class="disabled" disabled />
		</div>
		<div class="form-items">
			<div class="label">Issue Name</div>
			<div class="option"> 
				<input type="text" data-clear-btn="true" name="bug[bug_name]" value="<?php echo $bug->bug_name ?>" class="disabled" disabled />
			</div>
		</div>
		<div class="selection-form">
			<div class="form-items">
				<div class="label"> Assigned To </div>
				<div class="option">
					<select name="bug[assigned_to]" class="disabled" disabled>
						<option value="-1"> Unassigned </option>
						<?php 
							foreach($users as $user){
								$selected_option = selected($user['id'],$bug->assigned_to);
								echo "<option value='{$user['id']}' {$selected_option} > {$user['first_name']} </option>";
							}
						?>
					</select>
				</div>
			</div>

			<div class="form-items">
				<div class="label"> Priority </div>
				<div class="option">
					<select name="bug[priority_id]" class="disabled" disabled>
						<?php 
							foreach($priorities as $priority){
								$selected_option = selected($priority['id'],$bug->priority_id);
								echo "<option value='{$priority['id']}' {$selected_option} > {$priority['priority_name']} </option>";
							}
						?>
					</select>
				</div>
			</div>

			<div class="form-items">
				<div class="label"> Status </div>
				<div class="option">
					<select name="bug[status_id]" class="disabled" disabled>
						<?php 
							foreach($status as $stat){
								$selected_option = selected($stat['id'],$bug->status_id);
								echo "<option value='{$stat['id']}' {$selected_option} > {$stat['status_name']} </option>";
							}
						?>
					</select>
				</div>
			</div>
		</div>
		<div>
			<div class="label">Details</div>
			<div class="detail">
				<textarea name="bug[details]" class="disabled" disabled> <?php echo $bug->details ?> </textarea>
			</div>
		</div>

		<div id="save">
			<input type="submit" name="save" value="Save" class="disabled" disabled />
		</div>

	</form>
</div>