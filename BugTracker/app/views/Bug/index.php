<?php
	$bugs = Bug::get_users_bug_per_status($data['project_id'], $data['user_id'], $data['status_id']);
	$user = User::get_user_details($data['user_id']);
	$status = Status::get_status_details($data['status_id']);
	$completed_status = Status::get_last_status_per_project($data['project_id']);
	$check_icon = 'uncheck.png';
	if($data['status_id'] == $completed_status['id'])
		$check_icon = 'checked.png';
?>

<div id="project-settings">
	<h4><?php echo $user['name']; ?></h4>
	<h5><?php echo $status['status_name']; ?></h5>
	<input type="hidden" id="bug-info" data-user="<?php echo $data['user_id']; ?>" data-status="<?php echo $data['status_id']; ?>" data-status-comp="<?php echo $completed_status['id']; ?>" data-status-desc="<?php echo $completed_status['status_name']; ?>" data-project="<?php echo $data['project_id']; ?>" />
	<hr>
	<div id="bug-list">
		<div id="bug-menu">
			<div id="sort-buttons">
				<label>Sort By:</label>
				<input type="button" id="alphabetical-sort" value="Name" />
				<input type="button" id="priority-sort" value="Priority" />
				<input type="button" id="custom-sort" value="Custom" />
			</div>
		</div>

		<!-- DELETE popup message  -->
		<div data-role="popup" id="status-dialog" data-overlay-theme="b" data-theme="b" data-dismissible="false" style="max-width:400px;">
	        <div data-role="header" data-theme="a">
			    <h1 id="status-header">Insert Popup Header Here</h1>
			</div>
		    <div role="main" class="ui-content">
		        <p id="status-msg" class="ui-title"> Insert Popup Message Here</p>
		        <a href="#" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-b" data-rel="back">No</a>
		        <a id="uncheck" data-hint="0" data-el="#" data-id="#" href="#" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-b" rel="external">Yes</a>
	        </div>
		</div>
		<!-- end -->

		<ul id="sort-list" data-role="listview" data-split-icon="three-dots" data-filter="true" data-filter-placeholder="Search bugs..." data-inset="true">
		    <?php
		    	foreach($bugs as $bug){

		    		echo '
		    				<li class="bug-check-container" data-index="' . $bug['id'] . '" data-position="' . $bug['position'] . '" data-priority="' . $bug['priority_weight'] . '" data-icon="false">
		    					<a href="#">
        							<img id="'. $bug['id'] .'" src="/BugTracker/Icons/' . $check_icon . '" data-id="' . $bug['id'] . '" class="pre-uncheck ui-li-icon ui-corner-none">
    								<h2 class="bug-label">' . $bug['bug_name'] . '</h2>
    								<span class="bug-priority-color" style="background-color: ' . $bug['priority_color'] . ';">&nbsp;</span>
 								</a>
        						<a rel="external" href="/bug/show/' . $data['project_id'] . '/' . $data['user_id'] . '/' . $bug['id'] . '">Click for details</a>
    						</li>
		    			 ';

		    		
		    	}
		   	?>
		</ul>
	</div>
</div>

