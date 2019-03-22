$(document).ready(function() {  
	
	var user_cnt = 0;
	var tag_cnt = 0;
	var priority_cnt = 0;
	var stat_cnt = 0;

	// User New Form: Add and Remove Users
	$("#bug").on("click", "#add_user" , function() { 	
		$.ajax({
			type: "GET",
			url: "/user/ajax_get_users_roles",
			success: function(msg){
				$("#user_list").append(msg).enhanceWithin();
			}
		});	
	 });

	/*
	$("#bug").on("click", "a.remove", function() { 	
		$(this).parents('tr').remove();
	 });
	*/

	// end

	// User New Form: Add and Remove Tags
	$("#bug").on("click", "#add_tag" ,function() {
		var id = tag_cnt++;
		$("#tag_list").append("<div class='tag-div'><input type='text' name='tags[new][]' /><a id='tag-new-" + id + "' class='remove ui-btn ui-shadow ui-corner-all ui-icon-delete ui-btn-icon-notext' data-item='tag' data-rel='popup' data-position-to='window' data-transition='pop'  href='#popupDialog'>Remove</a></div>").enhanceWithin();
	});

	/*	
	$("#bug").on("click", "a.remove", function() { 	
		$(this).parent().remove();
	 });
	*/

	// end

	// User New Form: Add and Remove Priorities
	$("#bug").on("click", "#add_priority" , function() {
		var id = priority_cnt++;
		$("#priority_list").append("<tr><td><input type='text' name='priorities[priority_name][new][]' placeholder='Priority name' /></td><td><input type='number' name='priorities[priority_weight][new][]' placeholder='Priority Weight' /></td><td><input class='priority-color' type='color' name='priorities[priority_color][new][]' value='#ff0000' /></td><td><a id='priority-new-" + id + "' class='remove ui-btn ui-shadow ui-corner-all ui-icon-delete ui-btn-icon-notext' data-item='priority' data-rel='popup' data-position-to='window' data-transition='pop' href='#popupDialog'>Remove</a></td></tr>").enhanceWithin();
	});

	/*	
	$("#bug").on("click", "a.remove", function() { 	
		$(this).parents('tr').remove();
	 });
	*/

	//end

	// User New Form: Add and Remove Status
	$("#bug").on("click", "#add_status", function() {
		var id = stat_cnt++;
		$("#status_list").append("<div class='stat-div'><input type='text' name='status[new][]' /><a id='status-new-" + id + "' class='remove ui-btn ui-shadow ui-corner-all ui-icon-delete ui-btn-icon-notext' data-item='status' data-rel='popup' data-position-to='window' data-transition='pop' href='#popupDialog'>Remove</a></div>").enhanceWithin();
	});

	/*
	$("#bug").on("click", "a.remove", function() { 	
		$(this).parent().remove();
	 });
	*/

	// end	

	$(".new_bug").on("click", function(){
		var url = $(this).data("url");

		if($("#project-settings").length){
			$("#project-settings").remove();
		}

		$.ajax({
			type: "GET",
			url: url,
			success: function(msg){
				$("#bug").append(msg).enhanceWithin();
			}
		});
	});

	$(".bug_status").on("click", function(){
		var status_param = $(this).data("status");
		var project_param = $(this).data("project");
		var user_param = $(this).data("user");

		$("#bug").empty();
		$(".tab-content").empty();
		var bug_cont = $('#bug');
		var tab_cont = $('.tab-content');

		$.ajax({
			type: "GET",
			url: '/bug/ajax_index/' + project_param + '/' + user_param + '/' + status_param,
			success: function(msg){
				bug_cont.empty();
				tab_cont.empty();
				$("#bug").append(msg).enhanceWithin();
				$('.ui-filterable').prependTo('#bug-menu');

			}
		});
	});


	$('.ui-filterable').prependTo('#bug-menu');
		

	$("#edit").on("click", function(){
		$("#action").empty();
		$(".ui-state-disabled").removeClass("ui-state-disabled");
		$(".disabled").prop("disabled", false);
		$("#action").append("<a href='#' id='cancel'> Cancel </a>");
	});

	$("#action").on("click", "#cancel", function() {
		location.reload();
	});

	$(".edit-project").on("click", function(event, ui){
		var project_param = $(this).data("project");

		/*
		if($("#project-settings").length){
			$("#project-settings").remove();
		}

		$.ajax({
			type: "GET",
			url: '/project/edit/' + project_param,
			success: function(msg){
				$("#bug").append(msg).enhanceWithin();
			}
		});
		*/
		window.location.replace("/project/edit/" + project_param);

		return false;
	});

	/****************** Algo inside are used for sorting the bugs ******************/

	// Refer to FS.1 below for the functions being called inside thise algorithm.

	var asc = true;


	$('#bug').on('click', '#custom-sort',function(){
		$("#sort-list").remove();
		sortElementCustom();
	});

	$('#bug').on('click', '#alphabetical-sort', function(){
		$('#sort-list').sortable({disabled: true});
		if(asc)
			sortElementAsc();
		else
			sortElementDesc();
		asc = !asc;
	});

	$('#bug').on('click', '#priority-sort', function(){
		$('#sort-list').sortable({disabled: true});
		sortElementPriority();
	});

	/*******************************************************************************/

	// pop-up for delete project
	$("#del-project").on('click', function(){
		var data = $(this).attr("data-id");
		var header = "Delete Project?";
		var msg = "Are you sure you want to delete this project?";
		var popup_href = "/project/delete/" + data;

		$("#pop-up-header").text(header);
		$("#pop-up-msg").text(msg);
		$("#del-pop-up").attr("href", popup_href);

	});

	// update attributes of delete button of popup menu
	$("#bug").on("click", "a.remove", function() { 	
		var id = $(this).attr('id');
		var item = $(this).attr('data-item');
		var header = "";
		var msg = "Are you sure you want to delete this ";

		if(item == "user"){
			header = "Delete User?";
			msg = msg + "user?";
			$("#del-pop-up").attr("data-el", "tr");
		}else if(item == "tag"){
			header = "Delete Tag?";
			msg = msg + "tag?";
			$("#del-pop-up").attr("data-el", "div.tag-div");
		}else if(item == "priority"){
			header = "Delete Priority?";
			msg = msg + "priority?";
			$("#del-pop-up").attr("data-el", "tr");
		}else{
			header = "Delete Status?";
			msg = msg + "status?";
			$("#del-pop-up").attr("data-el", "div.stat-div");
		}

		$("#pop-up-header").text(header);
		$("#pop-up-msg").text(msg);
		$("#del-pop-up").attr("data-id", id);
		$("#del-pop-up").attr("data-hint", "1");		
		//$(this).parent().remove();
	 });

	// remove elements
	$("#del-pop-up").on("click", function(){
		var hint = $(this).attr('data-hint');
		var id = $(this).attr('data-id');
		id = '#' + id;
		var el = $(this).attr('data-el');

		if(hint == "1"){
			$('#popupDialog').popup("close");
			$(id).parents(el).remove();
		}
	});

	$("#bug").on("click",".pre-uncheck", function(){
		var status_id = $('#bug-info').attr('data-status');
		var comp_status_id = $('#bug-info').attr('data-status-comp');
		var comp_status = $('#bug-info').attr('data-status-desc');
		var header = "Update Status";
		var msg = "Set bug status to " + comp_status + "?";
		var id = $(this).attr('id');

		if(status_id != comp_status_id){
			$("#status-header").text(header);
			$("#status-msg").text(msg);
			$("#uncheck").attr("data-id", id);
			$("#status-dialog").popup("open");
			var el = document.getElementById("uncheck");
			el.addEventListener("click", setStatus, false);
		}		
	});

	/******* begin prompt user when leaving *******/

	var proj_form = $('.proj-form');
	var form_base_values = proj_form.serialize();

	/*
	proj_form.submit(function(){
		window.onbeforeunload = null;
	});
	*/
	$('#bug').on("submit",".proj-form",function(){
		window.onbeforeunload = null;
	});

	window.onbeforeunload = function(){
		var form = document.getElementsByClassName('proj-form');
		if(proj_form.serialize() != form_base_values){
			return 'There are unsaved changes on the form. Are you sure you want to leave?';
		}

		if(form[0].id == 'proj-new-form')
			return 'There are unsaved changes on the form. Are you sure you want to leave?';
	}

	/******* end   prompt user when leaving *******/

});




/****** Called functions from JQUERY ready function ***********/

// FS.1 start

function saveNewPosition(){
	var positions = [];

	$('.updated').each(function(){
		positions.push([$(this).attr('data-index'), $(this).attr('data-position')]);
		$(this).removeClass('updated');
	});

	$.ajax({
		url: '/bug/ajax_update_position',
		method: 'POST',
		dataType: 'text',
		data: {
			update: 1,
			positions: positions
		},
		success: function(response){
			console.log(response);
		}
	});
}

function sortElementAsc(){
	var $list = $("#sort-list");

	$list.children().detach().sort(function(a, b) {
	return $(a).text().localeCompare($(b).text());
	}).appendTo($list);
}

function sortElementDesc(){
	var $list = $("#sort-list");

	$list.children().detach().sort(function(a, b) {
	return $(b).text().localeCompare($(a).text());
	}).appendTo($list);
}

function sortElementPriority(){
	var $list = $("#sort-list");

	/*
	$list.children().detach().sort(function(a, b) {
	return ($(b).data('priority')) < ($(a).data('priority')) ? 1 : -1;
	}).appendTo($list);
	*/

	$list.children().detach().sort(function(a, b) {
		if(($(b).data('priority')) < ($(a).data('priority'))){
			return 1;
		}
		else if(($(b).data('priority')) == ($(a).data('priority'))){
			return $(a).text().localeCompare($(b).text());
		}
		else
			return -1;
	//return ($(b).data('priority')) < ($(a).data('priority')) ? 1 : -1;
	}).appendTo($list);
}

function sortElementCustom(){
	var project_id = $("#bug-info").data("project");
	var user_id = $("#bug-info").data("user");
	var status_id = $("#bug-info").data("status");

	$.ajax({
			url: '/bug/ajax_custom_sort',
			method: "GET",
			dataType: 'text',
			data: {
				project_id: project_id,
				user_id: user_id,
				status_id: status_id
			},
			success: function(msg){
				$("#bug-list").append(msg).enhanceWithin();

				$('#sort-list').sortable({
				update: function(event, ui){
							$(this).children().each(function(index){ // 'this' pertains to tbody because it has the class ui-sortable
								if($(this).attr('data-position') !=  (index+1)){
									$(this).attr('data-position', (index+1)).addClass('updated');
								}
							});

							saveNewPosition();
						}
				});

				$('.ui-filterable').prependTo('#bug-menu');
			}
		});
}

// FS.1 end


function setStatus(){
	var project_id = $('#bug-info').attr('data-project');		
	var user_id = $('#bug-info').attr('data-user');
	var status_id = $('#bug-info').attr('data-status');
	var comp_status = $('#bug-info').attr('data-status-comp');		
	var url = '/bug/index/' + project_id + '/' + user_id + '/' + status_id;
	var bug = {status_id: comp_status};

	var bug_id = $(this).attr('data-id');
	var elem = "#" + bug_id;

	if(status_id != comp_status){
		$.ajax({
			url: '/bug/ajax_update/' + bug_id,
			method: "POST",
			dataType: 'text',
			data: {
				bug: bug
			},		
			success: function(msg){
				$('#popupDialog').popup("close");
				window.location.href = url;
			}
		});
	}
}