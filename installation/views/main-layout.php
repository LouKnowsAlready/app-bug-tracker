<html>
<head>
	<title> BugTracker Setup </title>
	<link rel="stylesheet" type="text/css" href="/installation/css/installation-style.css" />
</head>
<body>
	<div class="wrapper">
		<div id="bug-logo"><img src="/installation/images/bug-logo.png" /></div>
		<div id="setup-content">
			<?php  
				include "installation/views/{$method_name}.php";
			?>
		</div>
	</div>
	<script src="/installation/js/jquery-1.11.1.min.js"></script>
	<script src="/installation/js/installation-main.js"></script>
</body>
</html>