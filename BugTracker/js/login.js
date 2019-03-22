$(document).ready(function() {
	$(".closebtn").on("click",function(){
		//this.parentElement.style.opacity = 0;
		var parent = $(this).parent();
		parent.fadeOut(500);
	});
})