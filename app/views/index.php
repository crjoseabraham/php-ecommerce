<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login &mdash; PHP MVC Shopping cart</title>
	<link rel="stylesheet" href="<?= URLROOT; ?>/css/style.css">
	<style>
		.login__form {
			display: flex;
			justify-content: center;
		}
	</style>
</head>

<body>
	<div class="login__form">
		<form action="<?= URLROOT; ?>/index/login" method="post">
			<label for="login_email"> <h1>Email:</h1> </label>
			<input type="email" name="login_email" id="login_email">
			<br>
			<label for="login_password"> <h1> Password:</h1> </label>
			<input type="password" name="login_password" id="login_password">

			<button type="submit">Login</button>
		</form>
	</div>
</body>
</html>