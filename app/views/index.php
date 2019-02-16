<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login &mdash; PHP MVC Shopping cart</title>
	<link rel="stylesheet" href="<?= URLROOT; ?>/css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400" rel="stylesheet"> 
</head>

<body>
	<section class="index__about">
		<h1>Shopping cart with PHP & MVC</h1>
		<h2>Without frameworks or libraries</h2>

		<div class="index__about-info">
			<div class="about-info__details">
				<table>
					<tbody>
						<tr>
							<td>🗹 MVC</td>
							<td>🗹 User registration</td>
						</tr>
						<tr>
							<td>🗹 PHP Sessions</td>
							<td>🗹 PDF Reports</td>							
						</tr>
						<tr>
							<td>🗹 PDO</td>
						</tr>
					</tbody>
				</table>
			
				<p class="about-info__account">
					Test account: <br>
					<span> User: test@gmail.com</span> <br>
					<span> Password: 123Abc</span> <br>
				</p>
			</div>

			<p class="about-info__password">
				If you're creating a new account, <u>your password must have:</u> <br>
					→ At least 1 capital letter.<br>
					→ At least 1 number.
			</p>
			<p class="about-info__rules">
				The idea for this project came from an assignment for a job interview and I decided to do it again to teach myself some modern concepts. But, it still has some of the rules I followed to fulfill the interview requirements:
				<br><br>
				→ You have <span>$100</span> available to buy items. This value will be restored every new session. <br>
				→ You can rate an item only once per session. <br>
			</p>
			<p class="about-info__repo">
				<a href="https://github.com/crjoseabraham/shoppingcart"> Go to project source code on GitHub </a>
			</p>
		</div>
	</section>

	<section class="index__forms">		
		<input type="checkbox" id="toggle-1">
		<label for="toggle-1" class="form__toggle"> </label>

		<div class="index__form--login">
			<h1>Login to your account</h1>

			<form action="<?= URLROOT; ?>/index/login" method="post" class="form__login">
				<label for="login_email"> Email: </label>
				<input type="email" name="login_email" id="login_email" placeholder="Example: you@mail.com" value="test@gmail.com">
				<br>
				<label for="login_password"> Password: </label>
				<input type="password" name="login_password" id="login_password" placeholder="••••••••••••" value="123Abc">
				<br>
				<button type="submit">Sign In</button>
			</form>
		</div>

		<div class="index__form--signup">
			<h1>Create an account</h1>

			<form action="<?= URLROOT; ?>/index/signup" method="post" class="form__signup">
				<label for="signup_email"> Email: </label>
				<input type="email" name="signup_email" id="signup_email" placeholder="Example: you@mail.com">
				<br>
				<label for="signup_password"> Password: </label>
				<input type="password" name="signup_password" id="signup_password" placeholder="••••••••••••">
				<br>
				<label for="signup_confirm_password"> Confirm Password: </label>
				<input type="password" name="signup_confirm_password" id="signup_confirm_password" placeholder="••••••••••••">
				<br>
				<button type="submit">Sign Up</button>
			</form>
		</div>
	</section>
</body>
</html>