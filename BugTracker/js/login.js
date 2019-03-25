$(document).ready(function() {
	$( "#user-form" ).submit(function( event ) {
		var username = $("#uid").val();
		var password = $("#pwd").val();
		
  		$("#error-msg").load("/login/start_session",{
  			uid: username,
  			pwd: password
  		}, function(){
  			var msg = $("#error-msg").text();
  			msg = msg.trim();
  			var form = document.getElementById('login');

  			if(msg == "Success"){
  				window.location.href = "/";
  			}else if(msg == "User not found"){
  				form.classList.add('error_1');
  				setTimeout(function () {
    			form.classList.remove('error_1');
  				}, 3000);
  			}else{ // invalid password
  				form.classList.add('error_2');
  				setTimeout(function () {
    			form.classList.remove('error_2');
  				}, 3000);
  			}
  		});




  		event.preventDefault();
	});
});

