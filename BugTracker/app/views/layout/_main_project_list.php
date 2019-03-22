<?php
	#echo dirname(dirname(__DIR__)).'\test\test_data.php';
	#include(dirname(dirname(__DIR__)).'\test\test_data.php');

	$projects = Project::get_all_projects($user_session_id);

	function expand($item1, $item2){
		return $item1 == $item2 ? "data-collapsed='false'" : "";
	}

	$data_project_id = isset($data['project_id']) ? $data['project_id'] : -1;
	$data_user_id = isset($data['project_id']) ? $data['user_id'] : -1;

?>

<?php foreach ($projects as $project) { ?>

	<div data-role="collapsible" class="project-block" <?php echo expand($data_project_id,$project['id']);  ?> >
		<h3 class="project-heading"> 
			<?php echo $project['project_name'];  ?>
			<img class="edit-project" <?php echo "data-project='{$project['id']}'" ?> src="/BugTracker/Icons/settings.png" />
		</h3>
		<?php 
			$users = ProjectUser::get_project_users_with_bugs($project['id']);
			foreach ($users as $user) {
		?>
			<div data-role="collapsibleset" class="users-block">
				<div data-role="collapsible" <?php echo expand($data_user_id,$user['id']);  ?> >
					<h3 class="user-heading"> <?php echo $user['first_name'];  ?> </h3>
					<ul data-role="listview">
						<?php
							$user_bugs = Bug::get_user_distinct_bug_status($project['id'], $user['id']); 
							foreach($user_bugs as $user_bug) {
								$bug_status = $user_bug['status_name'];
								$status_id = $user_bug['id'];
								$project_id = $project['id'];
								$user_id = $user['id'];
								echo "<li><a href='#' class='bug_status' data-project='{$project_id}' data-user='{$user_id}' data-status='{$status_id}'> {$bug_status} </a></li>";
							}
						?>
					</ul>
				</div>
			</div>
		<?php }   ?>
		<div class="add_bug"> <a href="#" rel="external" data-url="/bug/ajax_new/<?php echo $project['id'] ?>" class="ui-btn ui-btn-icon-left ui-icon-plus new_bug"> New Bug </a> </div>	
	</div> 

<?php }  ?>
