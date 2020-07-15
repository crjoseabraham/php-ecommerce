<div class="popup_login">
    <div class="greeting">
        <h3>Welcome back</h3>
        <p class="mt-2">Become a Member — you'll enjoy exclusive deals, offers, invites and rewards.</p>
        <img class="mt-2" src="./dist/img/login.svg" alt="Secure login">
    </div>

    <form action="login" method="post" id="login_form">
        <label for="login_email">Email</label>
        <input type="email" name="login_email" id="login_email">

        <label for="login_pass">Password</label>
        <input type="password" name="login_password" id="login_pass">

        <div class="inline-sb mt-2">
            <div class="inline-group">
                <input type="checkbox" name="remember_me" id="checkbox">
                <label for="checkbox">Keep me signed in</label>
            </div>
            <div class="inline">
                <a href="#" class="simple">I forgot my password</a>
            </div>
        </div>

        <div class="form-buttons mt-2">
            <button type="submit" class="btn btn--primary">
                Log In
            </button>
            <a href="#" class="btn btn--blank" data-popup="signup">
                Sign Up
            </a>
        </div>
    </form>
</div><?php /**PATH C:\xampp\htdocs\shoppingcart\resources\views/components/login_form.blade.php ENDPATH**/ ?>