<p>
	Fill up each field. All fields are <strong>required</strong>. Take note on the naming condition to avoid errors.
</p>
<br>
<form action="/install/create_admin" method="POST">
	<div class="form-items">
		<label><strong> Site Admin Username </strong></label>
		<div class="field-form">
			<input name="admin-usr" type="text" required />
			<p> <small> Should contain alphabets only (a-z, A-Z) and no spaces in between. </small> </p>
		</div>
	</div>

	<div class="form-items">
		<label><strong> Site Admin Password </strong></label>
		<div class="field-form">
			<input name="admin-pw" type="password" required />
			<p> <small> Make it easy to remember but hard to guess. </small> </p>
		</div>
	</div>

	<div>
		<p class="info">
			<label style="color: #db1e1e;">Note:</label> This credential is for site administrator only. You cannot use this credential in signing in on the <label style="color: #008CBA;">BugTracker</label> app. You only use this in managing the app itself.
		</p>
	</div>

	<div>
		<input type="submit" class="button" value="Submit" name="Submit" />
	</div>

</form>
		