<div class="popup_signup">
    <h3>Become a Member</h3>

    <form action="signup" method="post" id="register_form" class="mt-2 two-col-form">
        <!-- Name -->
        <div class="form-group">
            <label for="signup_name">What's your name?</label>
            <div class="input-group">
                <input type="text" name="name" id="signup_name" placeholder="Monica Hall" autofocus>
                <i class="validation-status fas fa-times-circle"></i>
            </div>
            <p class="input-errors">
                Name can only contain letters and must be at least 2 characters long
            </p>
        </div>

        <!-- Email -->
        <div class="form-group">
            <label for="signup_email">Email address</label>
            <div class="input-group">
                <input type="email" name="email" id="signup_email" placeholder="monicahall@piedpiper.com">
                <i class="validation-status fas fa-times-circle"></i>
            </div>
            <p class="input-errors"> Invalid email address </p>
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="pass">Create your password</label>
            <div class="input-group">
                <input type="password" name="password" id="pass">
                <i class="validation-status fas fa-times-circle"></i>
            </div>
            <p class="input-errors">
                Password needs at least: 4 characters, 1 uppercase letter, 1 lowercase letter, 1 number
            </p>
        </div>

        <!-- Password Confirmation -->
        <div class="form-group">
            <label for="passconf">Confirm password</label>
            <div class="input-group">
                <input type="password" name="passwordConfirmation" id="passconf">
                <i class="validation-status fas fa-times-circle"></i>
            </div>
            <p class="input-errors">Password and confirmation don't match</p>
        </div>

        <!-- Buttons -->
        <button type="button" class="btn btn--blank" data-action="login">
            <i class="fas fa-long-arrow-alt-left"></i> Go Back
        </button>
        <button type="submit" class="btn btn--primary">
            Sign Up
        </button>
    </form>
</div>