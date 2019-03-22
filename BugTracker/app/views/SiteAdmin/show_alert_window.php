<?php $user = $data; ?>

<div class="top">
	<span> <strong><?php echo $user['header']; ?></strong> </span>
</div>
<div class="content-alert">
	<p> <?php echo $user['content']; ?> </p>
	<?php
		if(isset($user['user_id']))
			echo "<input type='hidden' id='single-user' value='{$user['user_id']}'>";
	?>
	<div class="alert-opt">
		<a class="button" data-type="<?php echo $user['del_type']; ?>" id="delete-yes"> Yes </a>
		<a href="#" class="button"> No </a>
	</div>
</div>