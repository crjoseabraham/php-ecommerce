<div class="popup_signup">
    <h3>Become a Member</h3>

    <form action="signup" method="post" id="register_form" class="mt-2">
        <!-- Name -->
        <div class="form-group">
            <label for="signup_name">What's your name?</label>
            <div class="input-group">
                <input type="text" name="name" id="signup_name" placeholder="Monica Hall">
                <i class="validation-status fas fa-times-circle"></i>
            </div>
            <ul class="input-errors">
                <li>This field is required</li>
                <li>Name can only contain letters</li>
            </ul>
        </div>

        <!-- Email -->
        <div class="form-group">
            <label for="signup_email">Email address</label>
            <div class="input-group">
                <input type="email" name="email" id="signup_email" placeholder="monicahall@piedpiper.com">
                <i class="validation-status fas fa-times-circle"></i>
            </div>
            <ul class="input-errors"></ul>
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="pass">Create your password</label>
            <div class="input-group">
                <input type="password" name="password" id="pass">
                <i class="validation-status fas fa-times-circle"></i>
            </div>
            <ul class="input-errors"></ul>
        </div>

        <!-- Password Confirmation -->
        <div class="form-group">
            <label for="passconf">Confirm password</label>
            <div class="input-group">
                <input type="password" name="passwordConfirmation" id="passconf">
                <i class="validation-status fas fa-times-circle"></i>
            </div>
            <ul class="input-errors"></ul>
        </div>

        <!-- Buttons -->
        <button type="button" class="btn btn--blank" data-popup="login">
            <i class="fas fa-long-arrow-alt-left"></i> Go Back
        </button>
        <button type="submit" class="btn btn--primary">
            Sign Up
        </button>
    </form>
</div><?php /**PATH C:\xampp\htdocs\shoppingcart\resources\views/components/register_form.blade.php ENDPATH**/ ?>