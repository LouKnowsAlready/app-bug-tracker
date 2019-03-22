<p>
	Fill up each field. All fields are <strong>required</strong>. Take note on the naming condition to avoid errors.
</p>
<br>
<form id="db-form" action="/install/create" method="POST">
	<div class="form-items">
		<label><strong> Database Name </strong></label>
		<div class="field-form">
			<input type="text" id="db_name" name="db[db_name]" required />
			<p> <small> Should contain alphabets only (a-z, A-Z) and no spaces in between. </small> </p>
		</div>
	</div>

	<div class="form-items">
		<label><strong> Database Username </strong></label>
		<div class="field-form">
			<input type="text" id="user_name" name="db[db_user]" required />
			<p> <small> Should contain alphabets only (a-z, A-Z) and no spaces in between. </small> </p>
		</div>
	</div>

	<div class="form-items">
		<label><strong> Database Password </strong></label>
		<div class="field-form">
			<input type="password" id="password" name="db[db_pw]" />
		</div>
	</div>
	<br>
	<br>
	<div>
		<input type="submit" class="button" value="Submit" name="Submit" />
	</div>

</form>