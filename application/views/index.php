<?php $this->load->view('/partials/head') ?>
	<h1>Welcome</h1>
	<div id="register">
		<h3>Register</h3>
		<form method="post" action="/users/register">
			<label>First name: <input type="text" name="first_name"></label>
			<label>Last name: <input type="text" name="last_name"></label>
			<label>Email: <input type="text" name="email"></label>
			<label>Password: <input type="password" name="password"></label>
			<label>Confirm password: <input type="password" name="password_conf"></label>
			<label >Date of birth: <input type="date" name="dob"></label>
			<input class="btn-primary btn-sm" type="submit" value="Register">
		</form>
	</div>
	<div id="login">
		<h3>Login</h3>
		<form method="post" action="/users/login">
			<label>Email: <input type="email" name="email"></label>
			<label>Password: <input type="password" name="password"></label>
			<input class="btn-primary btn-sm" type="submit" value="Login">
		</form>
	</div>
	<div id="errors">
		<?php
			if ($this->session->flashdata('errors')){
				echo $this->session->flashdata('errors');
			}
		?>
	</div>
	<div id="success">
		<?php
			if ($this->session->flashdata('success')){
				echo $this->session->flashdata('success');
			}
		?>
	</div>
</body>
</html>