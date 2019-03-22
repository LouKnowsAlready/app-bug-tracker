$(document).ready(function() { 

	$("#view-users").on("click", function() { 	
		var action_name = $("#view-users p").text();

		$.ajax({
			type: "GET",
			url: "/site-admin/view_users",
			success: function(msg){
				$("#cont-header strong").text(action_name);
				$("#cont-body").empty();
				$("#cont-body").append(msg);
			}
		});	
	 });

	$("#manage-account").on("click", function() { 	
		var action_name = $("#manage-account p").text();

		$.ajax({
			type: "GET",
			url: "/site-admin/edit",
			success: function(msg){
				$("#cont-header strong").text(action_name);
				$("#cont-body").empty();
				$("#cont-body").append(msg);
			}
		});	
	 });	


	 $("#cont-body").on("submit","form",function(event){
	 	event.preventDefault();
	 	var user = $("#admin_user").val();
	 	var new_pw = $("#new_pw").val();
	 	var confirm_pw = $("#confirm_pw").val();
	 	var submit = $("#admin-update").val();

	 	$(".admin-msg").load("/site-admin/update",{
	 		user: user,
	 		new_pw: new_pw,
	 		confirm_pw: confirm_pw,
	 		submit: submit
	 	}, function(){
	 		$("#msg-container").css("display","block");
	 		setTimeout(function(){
	 			$("#msg-container").fadeOut(500);
	 		},2000);
	 	});
	 });

	 $("#cont-body").on("click",".closebtn",function(){
		//this.parentElement.style.opacity = 0;
		var parent = $(this).parent();
		parent.fadeOut(500);
	});

	 $("#cont-body").on("click","#del-yes",function(){
		$("#delete-app-lightbox").css({"opacity": 0, "visibility": "hidden"});
	});

	 $("#user-info").on("click","#add-user",function(){

	 	var action_name = $("#view-users p").text();

	 	var username = $("#username").val();
	 	var password = $("#password").val();
	 	var fname = $("#fname").val();
	 	var lname = $("#lname").val();

		
	 	$("#user-form").load('/user/add',{
	 		username: username,
	 		password: password,
	 		fname: fname,
	 		lname: lname,
	 	}, function(){
	 		var err = $("#error-msg").text();
	 		err = $.trim(err);

	 		if(err.length == 0){
		 		$("#cont-header strong").text(action_name);
				$("#cont-body").empty();
				$("#cont-body").load('/site-admin/view_users');
				location.hash = "#";
			}else{
				setTimeout(function(){
	 				$("#error-msg").fadeOut(500);
	 			},2000);
			}
	 	});


	 });

	 $("#user-info").on("click","#update-user",function(){

	 	var action_name = $("#view-users p").text();

	 	var username = $("#username").val();
	 	var def_name = $("#def-name").val();
	 	var password = $("#password").val();
	 	var fname = $("#fname").val();
	 	var lname = $("#lname").val();
	 	var user_id = $(this).attr('data-id');

	 	$("#user-form").load('/user/update',{
	 		username: username,
	 		def_name: def_name,
	 		password: password,
	 		fname: fname,
	 		lname: lname,
	 		user_id: user_id
	 	}, function(){
	 		var err = $("#error-msg").text();
	 		err = $.trim(err);
	 		
	 		if(err.length == 0){
		 		$("#cont-header strong").text(action_name);
				$("#cont-body").empty();
				$("#cont-body").load('/site-admin/view_users');
				location.hash = "#";
			}else{
				setTimeout(function(){
	 				$("#error-msg").fadeOut(500);
	 			},2000);
			}
	 	});

	 });	 

	 $("#cont-body").on("click","#new-user",function(){
	 	var user_detail_container = $("#user-form");

	 	$.ajax({
	 		type: "GET",
	 		url: "/user/new",
	 		success: function(msg){
	 			user_detail_container.empty();
	 			user_detail_container.append(msg);
	 			location.hash = "#user-info";
	 		}
	 	});
	 });

	 $("#cont-body").on("click",".edit-user",function(){
	 	var user_id = $(this).attr("data-id");
	 	var user_detail_container = $("#user-form");

	 	$.ajax({
	 		type: "GET",
	 		url: "/user/edit",
	 		data: {user_id: user_id},
	 		success: function(msg){
	 			user_detail_container.empty();
	 			user_detail_container.append(msg);
	 			location.hash = "#user-info";
	 		}
	 	});
	 });


	 $("#delete-user-content").on("click","#delete-yes",function(){
	 	var url = "#";
	 	var user_list = [];
	 	var action_name = $("#view-users p").text();
	 	var type = $(this).attr('data-type');
	 	
	 	if(type == "single"){
	 		var user_id = $("#single-user").val();
	 		url = "/user/delete/" + user_id;
	 	}else{
	 		url = "/user/delete_selected";
	 		
	 		$(".indv-check-box:checked").each(function(){
				user_list.push($(this).val());
				//console.log($(this).val());
			}); 
	 	}

		$.ajax({
			type: "POST",
			url: url,
			data: {
				users: user_list
			},
			success: function(msg){
				$("#cont-header strong").text(action_name);
				$("#cont-body").empty();
				$("#cont-body").append(msg);
				location.hash = "#";
			}
		});	
	 });

	 $("#cont-body").on("click",".selectall",function(){
		if ($(this).is(':checked')) {
        	$('.indv-check-box').prop('checked', true);
    	} else {
        	$('.indv-check-box').prop('checked', false);
    	}
	});

	 $("#cont-body").on("click","#del-all",function(){
		/*
		$(".indv-check-box:checked").each(function(){
			console.log($(this).val());
		});
		*/

		var checked_ctr = 0

		$(".indv-check-box:checked").each(function(){
			checked_ctr++;
		});

		if(checked_ctr > 0){
			var alert_header = "Delete Selected User?";
			var alert_content = "Are you sure you want to delete the selected users?";
			var user_detail_container = $("#delete-user-content");
			var del_type = "multiple";

			$.ajax({
		 		type: "GET",
		 		url: "/site-admin/show_alert_window",
		 		data: {
		 			header: alert_header,
		 			content: alert_content,
		 			del_type: del_type
		 		},
		 		success: function(msg){
		 			user_detail_container.empty();
		 			user_detail_container.append(msg);
		 			location.hash = "#delete-user";
		 		}
		 	});
		}else{
			var err_msg = "Please select at least one user";
			var action_name = $("#view-users p").text();
			$.ajax({
				type: "GET",
				url: "/site-admin/view_users",
				data: {
					err_msg: err_msg
				},
				success: function(msg){
					$("#cont-header strong").text(action_name);
					$("#cont-body").empty();
					$("#cont-body").append(msg);

					setTimeout(function(){
	 					$("#view-user-error").fadeOut(500);
	 				},1500);
				}
			});	
		}

	});


	 $("#cont-body").on("click",".del-user",function(){
	 	var user_id = $(this).attr("data-id");
	 	var alert_header = "Delete User?";
	 	var alert_content = "Are you sure you want to delete this user?";
	 	var user_detail_container = $("#delete-user-content");
	 	var del_type = "single";

	 	$.ajax({
	 		type: "GET",
	 		url: "/site-admin/show_alert_window",
	 		data: {
	 			user_id: user_id,
	 			header: alert_header,
	 			content: alert_content,
	 			del_type: del_type
	 		},
	 		success: function(msg){
	 			user_detail_container.empty();
	 			user_detail_container.append(msg);
	 			location.hash = "#delete-user";
	 		}
	 	});
	 });

})

