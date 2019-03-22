$(document).ready(function(){
	$("#setup-content").on("click","#setup-form",function(){
		var container = $("#setup-content");

		$.ajax({
			type: "GET",
			url: "/install/setup_form",
			success: function(msg){
				container.empty();
				container.append(msg);
			}
		});
		
	});

	$("#setup-content").on("click","#admin-form",function(){
		var container = $("#setup-content");

		$.ajax({
			type: "GET",
			url: "/install/admin_form",
			success: function(msg){
				container.empty();
				container.append(msg);
			}
		});

	});


});