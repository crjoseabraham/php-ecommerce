<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login &mdash; PHP MVC Shopping cart</title>
	<link rel="stylesheet" href="<?= URLROOT; ?>/css/style.css">
	<style>
		.login__form,
		.form__signup {
			display: flex;
			flex-direction: column;
			align-items: center;
		}
	</style>
</head>

<body>
	<br>
	<br>
	<br>
	<div class="login__form">
		<h1>Login</h1> <br>
		<form action="<?= URLROOT; ?>/index/login" method="post">
			<label for="login_email"> <h3>Email:</h3> </label>
			<input type="email" name="login_email" id="login_email">
			<br>
			<label for="login_password"> <h3> Password:</h3> </label>
			<input type="password" name="login_password" id="login_password">
			<br>
			<button type="submit">Login</button>
		</form>
	</div>
	<br>
	<br>
	<br>

	<hr>

	<br>
	<br>
	<br>
	<div class="form__signup">
		<h1>Sign Up</h1> <br>
		<form action="<?= URLROOT; ?>/index/signup" method="post">
			<label for="signup_email"> <h3>Email:</h3> </label>
			<input type="email" name="signup_email" id="signup_email">
			<br>
			<label for="signup_password"> <h3> Password:</h3> </label>
			<input type="password" name="signup_password" id="signup_password">
			<br>
			<label for="signup_confirm_password"> <h3> Confirm Password:</h3> </label>
			<input type="password" name="signup_confirm_password" id="signup_confirm_password">
			<br>
			<button type="submit">Login</button>
		</form>
	</div>
</body>
</html>